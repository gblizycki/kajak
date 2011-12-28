
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'photos'); ?>
		<?php $this->widget('ext.JSONInput.JSONInput',array('model'=>$model,'attribute'=>'photos'));?>
		<?php echo $form->error($model,'photos'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php $this->widget('ext.JSONInput.JSONInput',array('model'=>$model,'attribute'=>'data'));?>
		<?php echo $form->error($model,'data'); ?>
	</div>