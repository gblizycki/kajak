<?php
require_once '/var/www/kajak/protected/extensions/phamlp/vendors/phamlp/haml/HamlHelpers.php';
require_once '/var/www/kajak/protected/extensions/phamlp/helper/Helpers.php';
?><ul><?php foreach($model as $source) { ?><div class="source"><?php echo CHtml::link($source->format,array('importer/select','id'=>$source->id)); ?><?php echo $source->version; ?></div><?php } ?></ul>