<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Filial */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Filial',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Filials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filial-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
