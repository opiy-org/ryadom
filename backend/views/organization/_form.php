<?php

use common\models\base\Organization;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\Organization */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="organization-form">
    <?php $form = ActiveForm::begin(); ?>
    <?=
    $this->render('../_shared/formbtns', [
        'model' => $model,
        'sas' => false,
    ]);
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-2">


            <?php echo $form->field($model, 'thumbnail')->widget(\trntv\filekit\widget\Upload::classname(),
                [
                    'url' => ['/file-storage/upload'],
                    'maxFileSize' => 5000000, // 5 MiB
                ]);
            ?>

        </div>
        <div class="col-md-10">
            <div class="row">
                <?= $form->field($model, 'title', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'alias', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'status', ['options' => ['class' => 'col-md-2 col-md-offset-3']])->dropDownList(Organization::getStatuses()) ?>
            </div>
            <div class="row">
                <?php echo $form->field($model, 'phone', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'email', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'site', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
            </div>

            <div class="row">
                <?php echo $form->field($model, 'inn', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'kpp', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'ogrn', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>

            </div>
            <div class="row">
                <?php echo $form->field($model, 'bank_props', ['options' => ['class' => 'col-md-12']])->textarea(['rows' => 6]) ?>
            </div>


            <div class="row">
                <?php echo $form->field($model, 'body', ['options' => ['class' => 'col-md-12']])->widget(
                    \yii\imperavi\Widget::className(),
                    [
                        'plugins' => ['fullscreen', 'fontcolor', 'video'],
                        'options' => [
                            'minHeight' => 200,
                            'maxHeight' => 400,
                            'buttonSource' => true,
                            'convertDivs' => false,
                            'removeEmptyTags' => false,
                            'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
                        ]
                    ]
                ) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
