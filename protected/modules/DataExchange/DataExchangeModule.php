<?php

class DataExchangeModule extends CWebModule
{

    /**
     * @property string the base url to Rights. Override when module is nested.
     */
    public $baseUrl = '/dataexchange';

    public $formatsAlias = 'DataExchange.formats';

    public $formats = array();

    private $_dataSources = array();

    public function init()
    {
        $formats = array();
        foreach ($this->formats as $format)
        {
            $formats[] = 'DataExchange.formats.' . $format . '.DE' . $format;
        }
        $this->setImport(CMap::mergeArray($formats,
                        array(
                    'DataExchange.models.*',
                    'DataExchange.components.*',
                )));
    }

    public function save(DataSource $dataSource, array $data)
    {
        if (!$dataSource->pending)
        {
            foreach ($data['routes'] as $route)
            {
                $this->saveObject($dataSource, $route);
            }
        }
        else
        {
            foreach ($data['routes'] as $route)
            {
                $this->saveObjectPending($dataSource, $route);
            }
        }
    }

    public function getDataSource($format)
    {
        if (!isset($this->_dataSources[$format]))
        {
            $class = 'DE' . $format;
            $this->_dataSources[$format] = new $class();
        }
        return $this->_dataSources[$format];
    }

    private function saveObject(DataSource $dataSource, $object)
    {
        $object->save();
    }

    private function saveObjectPending(DataSource $dataSource, $object)
    {
        
        $class = get_class($object);
        if (strpos($class, 'Pending') === false)
        {
            $class.='Pending';
        }
        $pendingObject = new $class;
        $pendingObject->unsetAttributes();
        $pendingObject->cloneObject($object);
        $pendingObject->save();
    }

}
