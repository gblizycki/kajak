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
     * Import and map to @see Route model
     */
    public function importRoutes($newOnly=false);

    /**
     * Import and map to @see Place model
     */
    public function importPlaces($newOnly=false);

    /**
     * Import and map to @see Area model
     */
    public function importAreas($newOnly=false);
    
    /**
     * Import only new data from source
     */
    public function synchronize();
}

