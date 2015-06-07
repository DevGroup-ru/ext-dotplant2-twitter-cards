<?php

namespace DotPlant\TwitterCards;

use app;
use app\components\ExtensionModule;
use app\backend\components\BackendController;
use app\backend\events\BackendEntityEditFormEvent;
use DotPlant\TwitterCards\models\ObjectTwitterCard;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\ViewEvent;
use yii\db\ActiveRecord;
use app\backend\events\BackendEntityEditEvent;
use app\modules\page\models\Page;
use yii\helpers\ArrayHelper;
use yii\web\View;

/**
 * Class Module represents twitter cards module for DotPlant2 CMS
 *
 * @package DotPlant\TwitterCards
 */
class Module extends ExtensionModule implements BootstrapInterface
{
    public static $moduleId = 'twitterCards';


    public $twitter_acount = '@DotPlant';

    public $jsonProductData = '{"product_field_1":{"type":"field","key":"price"},"product_field_2":{"type":"field","key":"sku"}}';



    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'configurableModule' => [
                'class' => 'app\modules\config\behaviors\ConfigurableModuleBehavior',
                'configurationView' => '@twitterCards/views/configurable/_config',
                'configurableModel' => 'DotPlant\TwitterCards\components\ConfigurationModel',
            ]
        ];
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->on(
            Application::EVENT_BEFORE_ACTION,
            function () use ($app) {

                if ($app->requestedAction->controller instanceof \app\backend\components\BackendController) {
                    if ($app->requestedAction->controller instanceof app\modules\page\backend\PageController) {
                        BackendEntityEditEvent::on(
                            app\modules\page\backend\PageController::className(),
                            app\modules\page\backend\PageController::BACKEND_PAGE_EDIT_SAVE,
                            [$this, 'saveHandler']
                        );
                        BackendEntityEditFormEvent::on(
                            View::className(),
                            app\modules\page\backend\PageController::BACKEND_PAGE_EDIT_FORM,
                            [$this, 'renderEditForm']);
                    } elseif ($app->requestedAction->controller instanceof app\modules\shop\controllers\BackendProductController) {
                        BackendEntityEditEvent::on(
                            app\modules\shop\controllers\BackendProductController::className(),
                            app\modules\shop\controllers\BackendProductController::EVENT_BACKEND_PRODUCT_EDIT_SAVE,
                            [$this, 'saveHandler']
                        );
                        BackendEntityEditFormEvent::on(
                            View::className(),
                            app\modules\shop\controllers\BackendProductController::EVENT_BACKEND_PRODUCT_EDIT_FORM,
                            [$this, 'renderEditForm']);
                    } elseif ($app->requestedAction->controller instanceof app\modules\shop\controllers\BackendCategoryController) {
                        BackendEntityEditEvent::on(
                            app\modules\shop\controllers\BackendCategoryController::className(),
                            app\modules\shop\controllers\BackendCategoryController::BACKEND_CATEGORY_EDIT_SAVE,
                            [$this, 'saveHandler']
                        );
                        BackendEntityEditFormEvent::on(
                            View::className(),
                            app\modules\shop\controllers\BackendCategoryController::BACKEND_CATEGORY_EDIT_FORM,
                            [$this, 'renderEditForm']);
                    }
                } else {
                    if (
                        $app->requestedAction->controller instanceof app\modules\shop\controllers\ProductController &&
                        ($app->requestedAction->id == 'show' || $app->requestedAction->id == 'list' )
                    ) {
                        ViewEvent::on(
                            app\modules\shop\controllers\ProductController::className(),
                            app\modules\shop\controllers\ProductController::EVENT_PRE_DECORATOR,
                            [$this, 'registerMeta']
                        );
                    } elseif (
                        $app->requestedAction->controller instanceof app\modules\page\controllers\PageController &&
                        $app->requestedAction->id == 'show'
                    ) {
                        ViewEvent::on(
                            app\modules\page\controllers\PageController::className(),
                            app\modules\page\controllers\PageController::EVENT_PRE_DECORATOR,
                            [$this, 'registerMeta']
                        );
                    }
                }


            }
        );


    }

    public function saveHandler($event)
    {
        if (!isset($event->model)) {
            return null;
        }

        $model = $event->model;
        $twitterCard = static::loadModel($model);

        if ($twitterCard->save()) {
            Yii::$app->session->setFlash('info', 'Twitter card Save');
        }


    }

    public function renderEditForm(BackendEntityEditFormEvent $event)
    {
        if (!isset($event->model)) {
            return null;
        }
        /** @var \yii\web\View $view */
        $view = $event->sender;

        $model = $event->model;

        $twitterCard = static::loadModel($model);

        echo $view->render('@twitterCards/views/_edit', [
            'form' => $event->form,
            'model' => $event->model,
            'twitterCard' => $twitterCard
        ]);
    }

    public function registerMeta(ViewEvent $event)
    {
        if (empty($event->params['model'])) {
            return null;
        }

        $model = $event->params['model'];
        if ($twitterCard = static::loadModel($model, false)) {
            app\modules\seo\helpers\HtmlTagHelper::registerTwitterSummary(
                $this->twitter_acount,
                $twitterCard->title,
                $twitterCard->description,
                Yii::$app->request->hostInfo . $twitterCard->image
            );
        }
    }


    public static function loadModel($model, $createNew = true)
    {

        $object = app\models\Object::getForClass($model::className());

        if (!$object) {
            return null;
        }

        $twitterCard = ObjectTwitterCard::find()
            ->where(
                [
                    'object_id' => $object->id,
                    'object_model_id' => $model->id
                ]
            )
            ->one();
        if ($createNew) {
            if (!$twitterCard) {
                $twitterCard = new ObjectTwitterCard();
                $twitterCard->object_id = $model->object->id;
                $twitterCard->object_model_id = $model->id;
            }

            $twitterCard->load(Yii::$app->request->post());
        }

        return $twitterCard;
    }
}