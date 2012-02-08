<?php $this->beginContent(Rights::module()->appLayout); ?>

<div id="rights" class="container">

    <div id="content">
        <?php $this->renderPartial('/_flash'); ?>
        <?php echo $content; ?>
    </div>
</div>

<?php $this->endContent(); ?>