<?php
//A2D2EF12-55DEEB2A-0B731DA2-41C23146-1CA3A2D7-E3066221-0FD587D3-C7F030FD
/**
 * Description of DEXML_kajak_org_pl
 *
 * @name DEXML_kajak_org_pl
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
class DEwikimapia extends DEDataSourceWebService implements DEImporter
{
    public $apikey = 'A2D2EF12-55DEEB2A-0B731DA2-41C23146-1CA3A2D7-E3066221-0FD587D3-C7F030FD';
    public function init()
    {
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
        return $routes;
    }

    public function importPlaces($newOnly = false)
    {
        return array();
    }

    public function importAreas($newOnly = false)
    {
        $areas = array();
        $id = '17276965';
        $data = Yii::app()->CURL->run('http://api.wikimapia.org/?function=object&key='.$this->apikey.'&id='.$id);
        $xml = simplexml_load_string($data);
        $model = new Area();
        $model->info->name = (string)$xml['title'];
        $model->info->description = (string)$xml->description;
        $model->info->data['id'] = (int)$xml->id;
        $model->info->data['url'] = (string)$xml->url;
        $model->info->data['wikipedia'] = (string)$xml->wikipedia;
        var_dump($xml);
        $index = 0;
        foreach($xml->polygon->point as $Point)
        {
            $model->points[$index] = new Point();
            $model->points[$index]->location = array((float)$Point['x'],(float)$Point['y']);
            $model->points[$index]->order = (int)$index;
            $index++;
        }
        $areas[] = $model;
        return $areas;
    }
}

