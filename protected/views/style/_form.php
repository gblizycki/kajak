<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'area-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'color'); ?>
		<?php echo $form->textField($model,'color'); ?>
		<?php echo $form->error($model,'color'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'marker'); ?>
		<?php echo $form->textField($model,'marker'); ?>
		<?php echo $form->error($model,'marker'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thickness'); ?>
		<?php echo $form->textField($model,'thickness'); ?>
		<?php echo $form->error($model,'thickness'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->