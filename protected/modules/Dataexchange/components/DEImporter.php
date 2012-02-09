<?php

/**
 * Description of DEImporter
 *
 * @name DEImporter
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-22
 */
interface DEImporter
{

    /**
     * Import all object and return in array
     * array(
     *  'routes'=>array(...),
     *  'places'=>array(...),
     *  'areas'=>array(...)
     * );
     */
    public function import();
    /**
     * Import and map to {@see Route} model
     * @return array Routes array
     */
    public function importRoutes($newOnly=false);

    /**
     * Import and map to {@see Place} model
     * @return array Places array
     */
    public function importPlaces($newOnly=false);

    /**
     * Import and map to {@see Area} model
     * @return array Areas array
     */
    public function importAreas($newOnly=false);

}

