<!--  Form Buttons-->
<div class="step-controls">
    <a href="<?php echo Yii::app()->createUrl("migrate/step" . ($step->sorder-1)); ?>" class="btn btn-default"><span class="glyphicon glyphicon-backward"></span> <?php echo Yii::t('frontend', 'Back'); ?></a>
    <a title="<?php echo Yii::t('frontend', 'Restart this step'); ?>" href="<?php echo Yii::app()->createUrl("migrate/reset/step/" . $step->sorder); ?>" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> <?php echo Yii::t('frontend', 'Reset'); ?></a>
    <?php if ($step->status == MigrateSteps::STATUS_NOT_DONE || $step->status == MigrateSteps::STATUS_SKIPPING): ?>
        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-play-circle"></span> <?php echo Yii::t('frontend', 'Start'); ?></button>
    <?php else: ?>
        <?php if ($step->sorder <= 8): ?>
            <a href="<?php echo Yii::app()->createUrl("migrate/step" . ($step->sorder+1)); ?>" class="btn btn-primary"><span class="glyphicon glyphicon-forward"></span> <?php echo Yii::t('frontend', 'Next Step'); ?></a>
        <?php endif; ?>
    <?php endif; ?>
</div>
<!--// Form Buttons-->