<?php

/**
 * Description of DataExchange
 *
 * @name DataExchange
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @package dataexchange
 * Created: 2011-12-30
 */
class DataExchange
{

    private static $_m;

    /**
     * Returns the base url to DataExchange.
     * @return the url to DataExchange.
     */
    public static function getBaseUrl()
    {
        $module = self::module();
        return Yii::app()->createUrl($module->baseUrl);
    }

    /**
     * @return DataExchangeModule the DataExchange module.
     */
    public static function module()
    {
        if (isset(self::$_m) === false)
            self::$_m = self::findModule();

        return self::$_m;
    }

    /**
     * Searches for the DataExchange module among all installed modules.
     * The module will be found even if it's nested within another module.
     * @param CModule $module the module to find the module in. Defaults to null,
     * meaning that the application will be used.
     * @return the DataExchange module.
     */
    private static function findModule(CModule $module=null)
    {
        if ($module === null)
            $module = Yii::app();

        if (($m = $module->getModule('dataexchange')) !== null)
            return $m;

        foreach ($module->getModules() as $id => $c)
            if (($m = self::findModule($module->getModule($id))) !== null)
                return $m;

        return null;
    }

}

