<?php
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/vendors/phamlp/haml/HamlHelpers.php';
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/helper/Helpers.php';
?><?php $this->beginContent('/layouts/admin-base'); ?><?php $sidebar = $this->menu!=null && count($this->menu)>0;; ?><div class="container"><div class="span-18" id="content"><?php echo $content; ?></div><?php if($sidebar) { ?><div class="span-6 last" id="sidebar"><?php $this->widget('ext.sidemenu.sidemenu',array('items'=>$this->menu));; ?></div><?php } ?></div><?php $this->endContent(); ?>