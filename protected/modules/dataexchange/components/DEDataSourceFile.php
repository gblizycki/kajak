<?php

/**
 * Description of DEDataSourceFile
 *
 * @name DEDataSourceFile
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-22
 */
abstract class DEDataSourceFile extends DEAbstractDataSource
{

    /**
     * File localization
     * @var string
     */
    public $uri;

    public $tmpDirectory = 'DataExchange.runtime';

    protected $_file;

    /**
     * Initialize component
     * if file is remote copy to runtime directory
     */
    public function init()
    {
        $this->_file = $this->uri;
    }

}

