<?php

/**
 * Description of DEXML_kajak_org_pl
 *
 * @name DEXML_kajak_org_pl
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
class DEXML_kajak_org_pl extends DEDataSourceFile implements DEImporter
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
        foreach ($this->_xml->szlak as $szlak)
        {
            foreach ($szlak->odcinek as $odcinek)
            {
                $model = new Route;
                $model->info->name = $odcinek['nazwa'];
                $model->info->description = $odcinek->opis;
                
                if ($odcinek['uciazliwosc'] != null)
                    $model->info->data['inconvenience'] = (int) str_replace('U',
                                    '', $odcinek['uciazliwosc']);

                $model->info->data['id'] = (string) $odcinek['id'];
                $model->info->data['hardness'] = (string) $odcinek['trudnosc'];
                $model->info->data['beauty'] = (string) $odcinek['malowniczosc'];
                $model->info->data['clarity'] = (string) $odcinek['czystosc'];
                $model->info->data['type'] = (string) $odcinek['typ'];
                $model->info->data['uid'] = (int)$odcinek['id'];
                
                foreach ($odcinek->punkt as $order => $punkt)
                {
                    $point = new Point();
                    $point->location = array((float)$punkt['we'], (float)$punkt['ns']);
                    $point->order = (int) $punkt['kolejnosc'];
                    $point->info->description = $punkt->opispunktu;
                    $point->info->data = array(
                        'city' => (string) $punkt['miejscowosc'],
                        'distance' => (float) $punkt['km'],
                        'id' => (string) $punkt['id'],
                    );
                    $model->points[] = $point;
                }
                $routes[] = $model;
            }
        }

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

    /**
     * Check if route is already in database
     * @param SimpleXML $odcinek 
     */
    protected function checkRoute($odcinek)
    {
        $criteria = new CMongoCriteria;
        $criteria->compare('info.data.uid',$odcinek['id'],'int');
        return Route::model()->find();
    }
}

