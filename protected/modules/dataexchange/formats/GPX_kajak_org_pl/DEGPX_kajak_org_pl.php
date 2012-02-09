<?php

/**
 * Description of DEGPX
 *
 * @name DEGPX
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
class DEGPX_kajak_org_pl extends DEDataSourceFile implements DEImporter
{
    private $_xml = null;
    public function init()
    {
        parent::init();
        $this->_xml = simplexml_load_file($this->_file);
    }

    public function import()
    {
        $this->init();
        return array(
            'routes' => $this->importRoutes(),
            'places' => $this->importPlaces(),
            'areas' => $this->importAreas(),
        );
    }
    public function importRoutes($newOnly = false)
    {
        $routes = array();
        $model = new RoutePending;
        $model->info->data['version']=$this->_xml['version'];
        foreach($this->_xml->wpt as $point)
        {
            $mpoint = new Point();
            $mpoint->location = array($point['lon'],$point['lat']);
            $mpoint->info->name = $point->name;
            $mpoint->info->description = $point->desc;
            $mpoint->info->data = array('type'=>(string)$point->cmt);
            //add point to route
            $model->points[] = $mpoint;
        }
        unlink($this->_file);
        if(!$model->save())
        {
            throw new CException('Import failure. File: '.$this->uri);
        }
        $routes[]=$model;
        return $routes;
    }
    public function importPlaces($newOnly = false)
    {
        return array();
    }
    public function importAreas($newOnly = false)
    {
        return array();
    }
}

