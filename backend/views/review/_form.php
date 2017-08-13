<?php

use common\models\base\Filial;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\Review */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="review-form">
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


            <?php echo $form->field($model, 'image')->widget(\trntv\filekit\widget\Upload::classname(),
                [
                    'url' => ['/file-storage/upload'],
                    'maxFileSize' => 5000000, // 5 MiB
                ]);
            ?>

        </div>
        <div class="col-md-10">
            <div class="row">
                <?= $form->field($model, 'title', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'user_name', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'rating', ['options' => ['class' => 'col-md-2 col-md-offset-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'filial_id', ['options' => ['class' => 'col-md-4']])->widget(\kartik\widgets\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map(Filial::find()->asArray()->all(), 'id', 'title'),
                    'options' => ['placeholder' => Yii::t('backend', 'Choose Filial')],
                    'pluginOptions' => [
                        'allowClear' => false
                    ],
                ]); ?>
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


    <?=
    $this->render('../_shared/formbtns', [
        'model' => $model,
        'sas' => false,
    ]);
    ?>
    <?php ActiveForm::end(); ?>

</div>
