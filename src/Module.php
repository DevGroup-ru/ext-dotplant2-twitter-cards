<?php

namespace DotPlant\TwitterCards;

use app;
use app\components\ExtensionModule;
use app\backend\components\BackendController;
use app\backend\events\BackendEntityEditFormEvent;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class Module represents twitter cards module for DotPlant2 CMS
 *
 * @package DotPlant\TwitterCards
 */
class Module extends ExtensionModule implements BootstrapInterface
{
    public static $moduleId = 'twitterCards';

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
                if ($app->requestedAction->controller instanceof BackendController) {
                    BackendEntityEditFormEvent::on('yii\web\View', 'backend-page-edit-form', [$this, 'renderEditForm']);
                }
            }
        );


    }

    public function renderEditForm(BackendEntityEditFormEvent $event)
    {
        /** @var \yii\web\View $view */
        $view = $event->sender;
        echo $view->render('@twitterCards/views/_edit', [
            'form' => $event->form,
            'model' => $event->model,
        ]);
    }
}