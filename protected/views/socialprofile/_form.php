<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'area-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Facebook'); ?>
		<?php echo $form->textField($model,'Facebook'); ?>
		<?php echo $form->error($model,'Facebook'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Twitter'); ?>
		<?php echo $form->textField($model,'Twitter'); ?>
		<?php echo $form->error($model,'Twitter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NK'); ?>
		<?php echo $form->textField($model,'NK'); ?>
		<?php echo $form->error($model,'NK'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Google'); ?>
		<?php echo $form->textField($model,'Google'); ?>
		<?php echo $form->error($model,'Google'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Yahoo'); ?>
		<?php echo $form->textField($model,'Yahoo'); ?>
		<?php echo $form->error($model,'Yahoo'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'MySpace'); ?>
		<?php echo $form->textField($model,'MySpace'); ?>
		<?php echo $form->error($model,'MySpace'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Amazon'); ?>
		<?php echo $form->textField($model,'Amazon'); ?>
		<?php echo $form->error($model,'Amazon'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'LinkedIn'); ?>
		<?php echo $form->textField($model,'LinkedIn'); ?>
		<?php echo $form->error($model,'LinkedIn'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'OpenID'); ?>
		<?php echo $form->textField($model,'OpenID'); ?>
		<?php echo $form->error($model,'OpenID'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Gravatar'); ?>
		<?php echo $form->textField($model,'Gravatar'); ?>
		<?php echo $form->error($model,'Gravatar'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'OAuthID'); ?>
		<?php echo $form->textField($model,'OAuthID'); ?>
		<?php echo $form->error($model,'OAuthID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->