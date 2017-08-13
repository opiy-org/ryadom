<?php

use common\models\base\City;
use kdn\yii2\JsonEditor;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\City */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="city-form">
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
                <?= $form->field($model, 'alias', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'status', ['options' => ['class' => 'col-md-2 col-md-offset-3']])->dropDownList(City::getStatuses()) ?>
            </div>
            <div class="row">
                <?php echo $form->field($model, 'flamp', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'timezone', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?php echo $form->field($model, 'map_lat', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'map_lon', ['options' => ['class' => 'col-md-4']])->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'map_zoom', ['options' => ['class' => 'col-md-3']])->textInput(['maxlength' => true]) ?>
                <?php
                //               echo $form->field($model, 'map', ['options' => ['class' => 'col-md-6']])->widget(
                //                    'kolyunya\yii2\widgets\MapInputWidget',
                //                    [
                //                        'key' => env('GOOGLE_API_KEY'),
                //                        'latitude' => 55,
                //                        'longitude' => 88,
                //                        'zoom' => 6,
                //                        'height' => '420px',
                //                        'pattern' => '%longitude%-%latitude%',
                //                        'animateMarker' => true,
                //                        'enableSearchBar' => true,
                //
                //                    ]
                //                );
                ?>
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

    <?= $form->field($model, 'settings')->widget(
        JsonEditor::className(),
        [
            'clientOptions' => [
                'mode' => 'tree',
            ],
        ]
    );
    ?>


    <?=
    $this->render('../_shared/formbtns', [
        'model' => $model,
        'sas' => false,
    ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
