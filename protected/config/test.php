<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'),
                array(
            'components' => array(
                'fixture' => array(
                    'class' => 'EMongoDbFixtureManager',
                ),
                'mongodb' => array(
                    'class' => 'EMongoDB',
                    'connectionString' => 'mongodb://localhost',
                    'dbName' => 'kajak',
                    'fsyncFlag' => true,
                    'safeFlag' => true,
                    'useCursor' => true
                ),
            ),
                )
);
