<?php

return array(
    //Users
    'xmlkajakorg' => array(
        '_id' => new MongoID('4efaf3c0b1a7882c70000000'),
        'format' => 'XML_kajak_org_pl',
        'pending'=>false,
        'version'=>'1.0',
    ),
    'gpxkajakorg' => array(
        '_id' => new MongoID('4efaf3c0b1a7882c80000000'),
        'format' => 'GPX_kajak_org_pl',
        'pending'=>true,
        'version'=>'0.2',
    ),
    'wikimapia' => array(
        '_id' => new MongoID('4efaf3c0b1a7882c90000000'),
        'format' => 'wikimapia',
        'pending'=>false,
        'version'=>'0.1',
    ),
    'kajakorgpl' => array(
        '_id' => new MongoID('4efaf3c0b1a7882d00000000'),
        'format' => 'kajakorgpl',
        'pending'=>false,
        'version'=>'0.1',
    ),
);
?>
