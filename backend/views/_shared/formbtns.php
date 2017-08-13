<?php

use yii\helpers\Html;
if (isset($sas)) {
    $sasbtn=$sas;
} else {
    $sasbtn=true;
}

?>
<div class="form-group text-right">
    <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if (Yii::$app->controller->action->id != 'create' AND $sasbtn!==false): ?>
        <?= Html::submitButton(Yii::t('backend', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
    <?= Html::a(Yii::t('backend', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
</div>