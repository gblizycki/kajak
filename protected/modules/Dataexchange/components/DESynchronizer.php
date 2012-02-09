<?php

/**
 * Description of DESynchronizer
 *
 * @name DESynchronizer
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-29
 */
interface DESynchronizer
{

    /**
     * Import only new {@see Routes} from source
     */
    public function synchronizeRoutes();
    /**
     * Import only new {@see Places} from source
     */
    public function synchronizePlaces();
    /**
     * Import only new {@see Areas} from source
     */
    public function synchronizeAreas();
}

