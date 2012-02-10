<div class="row">
		<?php echo $form->labelEx($model,'style'); ?>
		<?php $this->widget('ext.JSONInput.JSONInput',array('model'=>$model,'attribute'=>'style'));?>
		<?php echo $form->error($model,'style'); ?>
</div>