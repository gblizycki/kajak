<?php

/**
 * Description of DEExporter
 *
 * @name DEExporter
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-22
 */
interface DEExporter
{
    /**
     * Export all data
     */
    public function exportAll();
    /**
     * Export routes to given format
     */
    public function exportRoutes();

    /**
     * Export places to given format
     */
    public function exportPlaces();

    /**
     * Export areas to given format
     */
    public function exportAreas();
}

