<?php

/** @var \app\modules\config\models\Configurable $configurable */
/** @var \app\backend\components\ActiveForm $form */
/** @var \app\modules\shop\models\ConfigConfigurableModel $model */

use app\backend\widgets\BackendWidget;
use app\backend\widgets\DataRelationsWidget;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;

?>


<div class="row">
    <div class="col-md-6 col-sm-12">
        <?php BackendWidget::begin([
            'title' => Yii::t('app', 'Main settings'),
            'options' => ['class' => 'visible-header']
        ]); ?>
        <?= $form->field($model, 'twitter_acount') ?>


        <?= DataRelationsWidget::widget(
            [
                'object' => \app\models\Object::getForClass(\app\modules\shop\models\Product::className()),
                'relations' => [
                    [
                        'class' => Category::className(),
                        'relationName' => 'getCategory()'
                    ]
                ],
                'fields' => [
                    [
                        'key' => 'product_field_1',
                        'label' => 'Product field 1',
                        'required' => true
                    ],
                    [
                        'key' => 'product_field_2',
                        'label' => 'Product field 2',
                        'required' => true
                    ]
                ],
                'data' => json_decode($model->jsonProductData)
            ]
        ) ?>

        <?php BackendWidget::end() ?>
    </div>
</div>