<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>

    <h3 class="timeline-header">
        <?php echo Yii::t('backend', 'New organization') ?>
    </h3>

    <div class="timeline-body">
        <?php echo Yii::t('backend', 'New organization ({title}) was added at {created_at}', [
            'title' => $model->data['public_identity'],
            'created_at' => Yii::$app->formatter->asDatetime($model->data['created_at'])
        ]) ?>
    </div>

    <div class="timeline-footer">
        <?php echo \yii\helpers\Html::a(
            Yii::t('backend', 'View organization'),
            ['/organization/update', 'id' => $model->data['organization_id']],
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>