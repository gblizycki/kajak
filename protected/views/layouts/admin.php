<?php $this->beginContent('//layouts/admin-base'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<?php $this->widget('ext.sidemenu.sidemenu',array('items'=>$this->menu)); ?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>