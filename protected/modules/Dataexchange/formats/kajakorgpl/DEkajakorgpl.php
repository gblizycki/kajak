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
        /*$szlaki = $this->db->createCommand('SELECT * FROM szlak')->query();
        
        foreach($szlaki as $szlak)
        {
            $model = new Route;
            $model->info->name = (string)$szlak['nazwasz'];
            $model->info->description = (string)$szlak['opissz'];
            $model->info->data->version = (int)$szlak['wersja'];
            $model->info->data->date = (string)$szlak['datasz'];
            //$odcinki = $this->db->createCommand('SELECT * FROM punktszlaku WHERE idsz = :szlakId',array('szlakId'=>$szlak['idsz']))->query();
            $punktyszlaku = $this->db->createCommand('SELECT * FROM punktszlaku WHERE idsz=:szlak')->bindParam('szlak', $szlak['idsz'])->query();
            $odcinki = $this->db->createCommand('SELECT * odcinek WHERE ido IN (SELECT DISTINCT ido FROM  `punktszlaku` JOIN punktodcinka ON punktszlaku.idp = punktodcinka.idp WHERE punktszlaku.idsz =:szlak)')->bindParam('szlak', $szlak['idsz'])->query();
            foreach($odcinki as $odcinek)
            {
                //select points
                $punktyodcinek = $this->db->createCommand('SELECT * FROM punkt WHERE ');
            }
            
            
            
        }*/
        return $routes;
    }

    public function importPlaces($newOnly = false)
    {
        $places = array();
        $podmioty = $this->db->createCommand('SELECT * FROM podmiot')->query();
        foreach($podmioty as $place)
        {
            if($place['we']==0 && $place['ns']==0)
                continue;
            $model = new Place;
            $kategorie = $this->db->createCommand('SELECT * FROM podmiotkategoria WHERE idpodmiot=:podmiot')->bindParam('podmiot', $place['idpodmiot'])->query();
            foreach($kategorie as $kategoria)
            {
                $catModel = DataExchange::module()->getCategoryPlace($this->categoryName((int)$kategoria['idkategoria']));
                $model->category[] = $catModel->id;
            }
            
            $model->address = (string)$place['adres'];
            $model->info->name = (string)$place['nazwa'];
            $model->info->description = (string)$place['opis'];
            $model->info->data['telephone'] = (string)$place['tel'];
            $model->info->data['fax'] = (string)$place['fax'];
            $model->info->data['mail'] = (string)$place['email'];
            $model->info->data['www'] = (string)$place['www'];
            $model->info->data['visible'] = (string)$place['widoczny'];
            $point = new Point;
            $point->location = array((float)$place['we'],(float)$place['ns']);
            $model->location = $point;
            $model->info->data['accurate'] = $this->accurate($place['dokladne']);
            $places[] = $model;
        }
        return $places;
    }

    public function importAreas($newOnly = false)
    {
        return array();
    }

    protected function categoryName($id)
    {
        switch($id)
        {
            case 2: return 'Producent kajaków';
            case 4: return 'Producent wioseł';
            case 5: return 'Producent odzieży';
            case 6: return 'Producent kamizelek';
            case 7: return 'Importer';
            case 9: return 'Wypożyczalnia';
            case 10:return 'Biuro';
            case 11:return 'Sklep';
            case 13:return 'Klub';
            case 20:return 'Camping/pole biwakowe';
            case 21:return 'Serwis';
            case 22:return 'Komis';
            case 24:return 'Organizator szkoleń';
            case 99:return 'Inne';
            default : throw new CException();
        }
    }
    protected function accurate($value)
    {
        switch($value)
        {
            case 'tak':return true;
                case 'nie': return false;
                default : return null;
        }
    }
}

