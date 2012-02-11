<?php

class DataExchangeModule extends CWebModule
{

    /**
     * @property Bazowy adres modułu dataexchange
     */
    public $baseUrl = '/dataexchange';

    /**
     * @property Alias katalogu z dostępnymi formatami
     */
    public $formatsAlias = 'dataexchange.formats';

    /**
     * @property Lista obsłuigiwanych formatów
     * Jeżeli jest pusta importowane zostaną wszystkie znajdujące się w katalogu
     * (dataexchange.formats.*)
     */
    public $formats = array();
    private $_dataSources = array();
    private $_categories = array();

    /**
     * Funkcja inicializująca moduł.
     * Importowane zostaną wszystkie formatu 
     */
    public function init()
    {
        $formats = array();
        if ($this->formats == array())
        {
            $dirFormats = scandir(Yii::getPathOfAlias($this->formatsAlias));

            if ($dirFormats !== null)
            {
                foreach ($dirFormats as $dir)
                {
                    if ($dir !== '.' && $dir !== '..')
                    {
                        $this->formats[$dir] = $dir;
                    }
                }
            }
        }
        foreach ($this->formats as $format)
        {
            $formats[] = 'dataexchange.formats.' . $format . '.DE' . $format;
        }
        $this->_categories['Area'] = array();
        $this->_categories['Place'] = array();
        $this->_categories['Route'] = array();
        $this->setImport(CMap::mergeArray($formats, array(
                    'dataexchange.models.*',
                    'dataexchange.components.*',
                )));
    }

    /**
     * Funkcja zapisująca dane do bazy danych
     * @param DataSource $dataSource
     * @param array $data 
     */
    public function save(DataSource $dataSource, array $data)
    {
        foreach ($data['routes'] as $route)
        {
            if (!$dataSource->pending)
                $this->saveObject($dataSource, $route);
            else
                $this->saveObjectPending($dataSource, $route);
        }
        foreach ($data['areas'] as $area)
        {
            if (!$dataSource->pending)
                $this->saveObject($dataSource, $area);
            else
                $this->saveObjectPending($dataSource, $area);
        }
        foreach ($data['places'] as $place)
        {
            if (!$dataSource->pending)
                $this->saveObject($dataSource, $place);
            else
                $this->saveObjectPending($dataSource, $place);
        }
        Yii::app()->cache->flush();
    }

    /**
     * Funckja zwracająca obiekt DataSource na podstawie formatu
     * @param string $format
     * @return DataSource
     */
    public function getDataSource($format)
    {
        if (!isset($this->_dataSources[$format]))
        {
            $class = 'DE' . $format;
            $this->_dataSources[$format] = new $class();
            $this->_dataSources[$format]->format = $format;
        }
        return $this->_dataSources[$format];
    }

    /**
     * Funckja zwracająca kategorię obszaru na podstawie jej nazwy
     * @param string $name
     * @return CategoryArea
     */
    public function getCategoryArea($name)
    {
        if (!isset($this->_categories['Area'][$name]))
        {
            $this->_categories['Area'][$name] = $model = CategoryArea::model()->findByAttributes(array('name' => $name));
        }
        return $this->_categories['Area'][$name];
    }

    /**
     * Funckja zwracająca kategorię trasy na podstawie jej nazwy
     * @param string $name
     * @return CategoryRoute
     */
    public function getCategoryRoute($name)
    {
        if (!isset($this->_categories['Route'][$name]))
        {
            $this->_categories['Route'][$name] = $model = CategoryRoute::model()->findByAttributes(array('name' => $name));
        }
        return $this->_categories['Route'][$name];
    }

    /**
     * Funckja zwracająca kategorię miejsca na podstawie jej nazwy
     * @param string $name
     * @return CategoryPlace
     */
    public function getCategoryPlace($name)
    {
        if (!isset($this->_categories['Place'][$name]))
        {
            $this->_categories['Place'][$name] = CategoryPlace::model()->findByAttributes(array('name' => $name));
        }
        return $this->_categories['Place'][$name];
    }

    /**
     * Funckja zwracająca wszystkie dostępne kategorie tras
     * @return array
     */
    public function getAllCategoryRoute()
    {
        $model = CategoryRoute::model()->findAll();
        foreach ($model as $category)
        {
            $this->_categories['Route'][$category->name] = $category;
        }
        return $this->_categories['Route'];
    }

    /**
     * Funckja zwracająca wszystkie dostępne kategorie miejsc
     * @return array
     */
    public function getAllCategoryPlace()
    {
        $model = CategoryPlace::model()->findAll();
        foreach ($model as $category)
        {
            $this->_categories['Place'][$category->name] = $category;
        }
        return $this->_categories['Place'];
    }

    /**
     * Funckja zwracająca wszystkie dostępne kategorie obszarów
     * @return array
     */
    public function getAllCategoryArea()
    {
        $model = CategoryArea::model()->findAll();
        foreach ($model as $category)
        {
            $this->_categories['Area'][$category->name] = $category;
        }
        return $this->_categories['Area'];
    }

    /**
     * Funkcja zapisująca pojedyńczy obiekt do bazy danych
     * @param DataSource $dataSource
     * @param mixed $object 
     */
    private function saveObject(DataSource $dataSource, $object)
    {
        $object->info->format = $dataSource->format;
        $object->validate();
        $object->save();
    }

    /**
     * Funkcja zapisująca pojedyńczy obiekt do bazy danych oczekujących obiektów
     * @param DataSource $dataSource
     * @param mixed $object 
     */
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
        $pendingObject->info->format = $dataSource->format;
        $pendingObject->save();
    }

}
