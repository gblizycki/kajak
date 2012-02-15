<?php

/**
 * Description of DEXML_kajak_org_pl
 *
 * @name DEXML_kajak_org_pl
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package dataexchange
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
            $model = new Route;
            $model->category = DataExchange::module()->getCategoryRoute('Kajak')->id;
            $model->info->name = $szlak['nazwa'];
            $model->info->description = $szlak->opis;
            $index = 0;
            foreach ($szlak->odcinek as $odcinek)
            {
                $section = new Section();
                $section->order = $index++;
                if ($odcinek['uciazliwosc'] != null)
                    $section->info->data['inconvenience'] = (int) str_replace('U',
                                    '', $odcinek['uciazliwosc']);

                $section->info->data['id'] = (string) $odcinek['id'];
                $section->info->data['hardness'] = (string) $odcinek['trudnosc'];
                $section->info->data['beauty'] = (string) $odcinek['malowniczosc'];
                $section->info->data['clarity'] = (string) $odcinek['czystosc'];
                $section->info->data['type'] = (string) $odcinek['typ'];
                $section->info->data['uid'] = (int)$odcinek['id'];
                
                foreach ($odcinek->punkt as $order => $punkt)
                {
                    if((float)$punkt['we']==0 && (float)$punkt['ns']==0)
                        continue;
                    $point = new Point();
                    $point->location = array((float)$punkt['we'], (float)$punkt['ns']);
                    $point->order = (int) $punkt['kolejnosc'];
                    $point->info->description = $punkt->opispunktu;
                    $point->info->data = array(
                        'city' => (string) $punkt['miejscowosc'],
                        'distance' => (float) $punkt['km'],
                        'id' => (string) $punkt['id'],
                    );
                    $section->points[] = $point;
                }
                $model->sections[] = $section;
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

