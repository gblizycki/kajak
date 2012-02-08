<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'route-pending-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'authorId'); ?>
		<?php echo $form->textField($model,'authorId'); ?>
		<?php echo $form->error($model,'authorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category'); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'points'); ?>
		<?php echo $form->textField($model,'points'); ?>
		<?php echo $form->error($model,'points'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'objectId'); ?>
		<?php echo $form->textField($model,'objectId'); ?>
		<?php echo $form->error($model,'objectId'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'info'); ?>
		<?php $this->renderPartial('/info/_form',array('form'=>$form,'model'=>$model->info));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'style'); ?>
		<?php $this->renderPartial('/style/_form',array('form'=>$form,'model'=>$model));?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->