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
class DEwikimapia extends DEDataSourceWebService implements DEImporter {

    public $apikey = 'A2D2EF12-55DEEB2A-0B731DA2-41C23146-1CA3A2D7-E3066221-0FD587D3-C7F030FD';

    public function init() {
        
    }

    public function import() {
        $this->init();
        return array(
            'routes' => $this->importRoutes(),
            'places' => $this->importPlaces(),
            'areas' => $this->importAreas(),
        );
    }

    public function importRoutes($newOnly = false) {
        $routes = array();
        return $routes;
    }

    public function importPlaces($newOnly = false) {
        return array();
    }

    public function importAreas($newOnly = false) {
        $areas = array();
        $id = substr($this->provider, strpos($this->provider, '&show=/') + 7); //,'/');
        $id = substr($id, 0, strpos($id, '/')); //,'/');
        //$data = Yii::app()->CURL->run('http://api.wikimapia.org/?language=pl&function=object&key='.$this->apikey.'&id='.$id);
        $data = Yii::app()->CURL->run('http://api.wikimapia.org/?language=pl&function=box&key=' . $this->apikey . '&count=100&bbox=14.3261719,49.3966751,24.1040039,54.6229781');
        $xml = simplexml_load_string($data);
        $un = 0;
        for ($i = 1; $i <= $xml['found'] / 100; $i++) {
            $realData = Yii::app()->CURL->run('http://api.wikimapia.org/?language=pl&function=box&key=' . $this->apikey . '&count=100&bbox=14.3261719,49.3966751,24.1040039,54.6229781&page='.$i);
            $xml = simplexml_load_string($realData);
            foreach ($xml->place as $xml) {
                if (!isset($xml->polygon)) {
                    $un++;
                    continue;
                }
                $model = new Area();
                $model->category = rand(0,1)?DataExchange::module()->getCategoryArea('Las')->id:DataExchange::module()->getCategoryArea('Pustynia')->id;
                $model->info->name = (string) $xml->title;
                if ($model->info->name == null)
                    $model->info->name = (string) $xml->name;
                if ($model->info->name == null)
                    $model->info->name = CHtml::decode(substr($xml->url, strrpos($xml->url, '/')));


                $model->info->description = (string) $xml->description;
                $model->info->data['id'] = (int) $xml->id;
                $model->info->data['url'] = (string) $xml->url;
                $model->info->data['wikipedia'] = (string) $xml->wikipedia;

                //var_dump($xml->title);die();
                //var_dump($xml);die();
                $index = 0;
                foreach ($xml->polygon->point as $Point) {
                    $model->points[$index] = new Point();
                    $model->points[$index]->location = array((float) $Point['x'], (float) $Point['y']);
                    $model->points[$index]->order = (int) $index;
                    $index++;
                }
                $areas[] = $model;
            }
        }
        var_dump(count($areas));
        return $areas;
    }

}

