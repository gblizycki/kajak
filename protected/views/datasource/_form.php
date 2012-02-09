<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'data-source-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'format'); ?>
		<?php echo $form->textField($model,'format'); ?>
		<?php echo $form->error($model,'format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'version'); ?>
		<?php echo $form->textField($model,'version'); ?>
		<?php echo $form->error($model,'version'); ?>
	</div>
                
        <div class="row">
		<?php echo $form->labelEx($model,'pending'); ?>
		<?php echo $form->checkBox($model,'pending'); ?>
		<?php echo $form->error($model,'pending'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'options'); ?>
		<?php $this->widget('ext.JSONInput.JSONInput',array('model'=>$model,'attribute'=>'options'));?>
		<?php echo $form->error($model,'options'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->