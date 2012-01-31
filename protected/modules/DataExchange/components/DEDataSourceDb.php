<?php

/**
 * Description of DEDataSourceDb
 *
 * @name DEDataSourceDb
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2011-12-22
 */
abstract class DEDataSourceDb extends DEAbstractDataSource
{

    /**
     * @var CDbConnection Database connection
     */
    public $db;

    /**
     * @var string Connection string
     */
    public $connectionString;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string 
     */
    public $password;
    /**
     * Initialize component
     */
    public function init()
    {
        $this->db = new CDbConnection($this->connectionString,  $this->username,  $this->password);
    }
    /**
     * Return's database connection object
     * @return CDbConnection
     */
    public function getConnection()
    {
        return $this->db;
    }
    

}

