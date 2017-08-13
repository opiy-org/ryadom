<?php


/* @var $this yii\web\View */
/* @var $model common\models\SeoFields */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="seo-fields-form">
    <?= $form->field($model->seoFields, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <div class="row">

        <?= $form->field($model->seoFields, 'h1', ['options' => ['class' => 'col-md-6']])->textInput(['placeholder' => Yii::t('backend','H1')]) ?>
        <?= $form->field($model->seoFields, 'title', ['options' => ['class' => 'col-md-6']])->textInput(['placeholder' => Yii::t('backend','Title')]) ?>
    </div>


    <?= $form->field($model->seoFields, 'keywords')->textInput(['placeholder' => Yii::t('backend','Keywords')]) ?>

    <?= $form->field($model->seoFields, 'description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model->seoFields, 'seo_text')->textarea(['rows' => 4]) ?>

    <!--    --><? //= $form->field($model->seoFields, 'image_path')->textInput(['placeholder' => 'Image Path']) ?>
    <!---->
    <!--    --><? //= $form->field($model->seoFields, 'image_base_url')->textInput(['placeholder' => 'Image Base Url']) ?>


</div>
