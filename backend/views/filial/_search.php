<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilialSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="filial-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'uuid') ?>

    <?php echo $form->field($model, 'organization_id') ?>

    <?php echo $form->field($model, 'city_id') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'map_lat') ?>

    <?php // echo $form->field($model, 'map_lon') ?>

    <?php // echo $form->field($model, 'map_zoom') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'flamp') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'settings') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'lock') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
