<?php
use \app\backend\widgets\BackendWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $form \app\backend\components\ActiveForm
 * @var $twitterCard \DotPlant\OpenGraph\models\ObjectOpenGraph
 */

?>
<div class="row">
    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <?php BackendWidget::begin(
            ['title' => Yii::t('app', 'Twitter cart'), 'footer' => $this->blocks['submit']]
        ); ?>

        <?= $form->field(
            $twitterCard,
            'title',
            [
                'copyFrom' => [
                    "#".Html::getInputId($model, 'name'),
                    "#".Html::getInputId($model, 'title'),
                ]
            ]
        ) ?>
        <?= $form->field(
            $twitterCard,
            'image',
            [
                'copyFrom' => [
                    '[name="file[]"]'
                ]

            ]
        ) ?>
        <?= $form->field(
            $twitterCard,
            'description',
            [
                'copyFrom' => [
                    "#".Html::getInputId($model, 'content'),
                    "#".Html::getInputId($model, 'annonce'),
                ]
            ]
        )->textarea() ?>

        <?php BackendWidget::end(); ?>
    </article>
</div>
<div class="clearfix"></div>
