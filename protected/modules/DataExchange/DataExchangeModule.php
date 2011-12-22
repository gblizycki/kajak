<?php

class DataExchangeModule extends CWebModule
{

    public $formatsAlias = 'DataExchange.formats';

    public function init()
    {

        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'DataExchange.models.*',
            'DataExchange.components.*',
        ));
    }

}
