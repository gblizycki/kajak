<?php
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/vendors/phamlp/haml/HamlHelpers.php';
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/helper/Helpers.php';
?><ul><?php foreach($model as $source) { ?><div class="source"><?php echo CHtml::link($source->format,array('importer/select','id'=>$source->id)); ?><?php echo $source->version; ?></div><?php } ?></ul>