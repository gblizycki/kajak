<?php
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/vendors/phamlp/haml/HamlHelpers.php';
require_once '/Users/gblizycki/Sites/kajak2/protected/extensions/phamlp/helper/Helpers.php';
?><?php echo CHtml::beginForm('', 'post'); ?><?php echo CHtml::textArea('provider',''); ?><?php echo CHtml::submitButton(); ?><?php echo CHtml::endForm(); ?>