<?php

/**
 * Description of DEXML_kajak_org_pl
 *
 * @name DEXML_kajak_org_pl
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
class DEkajakorgpl extends DEDataSourceDb implements DEImporter
{
    public $connectionString = 'mysql:host=localhost;dbname=kajak';
    
    public function init()
    {
        parent::init();
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
        $odcinki = $this->db->createCommand('SELECT * FROM szlak')->query();
        
        foreach($odcinki as $odcinek)
        {
            $model = new Route;
            $model->category = DataExchange::module()->getCategoryRoute('Kajak')->id;
            $model->info->name = (string)$odcinek['nazwasz'];
            $model->info->description = (string)$odcinek['opiso'];
            $model->info->data['id'] = (int) $odcinek['ido'];
            //select points
            $punkty = $this->db->createCommand('SELECT * FROM punktodcinka WHERE ido =:odcinekId')->bindParam('odcinekId',$odcinek['ido'])->query();
            foreach($punkty as $punkt)
            {
                $point = $this->db->createCommand('SELECT * FROM punkt WHERE idp=:punktId')->bindParam('punktId',$punkt['idp'])->queryRow();
                $p = new Point();
                $p->location = array((float)$point['we'],(float)$point['ns']);
                $model->points[] = $p;
                
            }
            $routes[] = $model;
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

