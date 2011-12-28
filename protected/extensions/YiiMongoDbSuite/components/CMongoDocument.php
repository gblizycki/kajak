<?php

abstract class CMongoDocument extends EMongoDocument
{
 /*protected $_useCursor = true;
 public function getUseCursor()
 {
  return $this->_useCursor;
 }
 public function setUseCursor($useCursor)
 {
  $this->_useCursor = $useCursor;
 }*/
    
    public function getId()
    {
        return (string)$this->_id;
    }
}
?>
