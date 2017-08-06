<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\City */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'map_lat')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'map_lon')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'map_zoom')->textInput() ?>

    <?php echo $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'settings')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'updated_by')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'lock')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
