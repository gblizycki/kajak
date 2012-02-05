<?php

return array(
    //Users
    'kajak' => array(
        //'_id' => new MongoID('4efaf3c0b1a7882d20000000'),
        'name' => 'Producent kajaków',
        'description'=>'Produkcja kajaków',
        /*'filters'=>array(
            array('name'=>'Nazwa','attribute'=>'info[name]','class'=>'text','order'=>1,'type'=>'string','partialMatch'=>true),
            array('name'=>'Opis','attribute'=>'info[description]','class'=>'textarea','order'=>2,'type'=>'string','partialMatch'=>true),
            array('name'=>'Trudność','attribute'=>'info[data][hardness]','class'=>'dropdown','order'=>3,'type'=>'string','partialMatch'=>false,'options'=>array(
                'data'=>array('WW1'=>'WW1','WW2'=>'WW2','WW3'=>'WW3'),
                'emptyElement'=>''
            )),
            array('name'=>'Atrakcyjność','attribute'=>'info[data][beauty]','class'=>'dropdown','order'=>4,'type'=>'string','partialMatch'=>false,'options'=>array(
                'data'=>array('*'=>'*','**'=>'**','***'=>'***','****'=>'****','*****'=>'*****'),
                'emptyElement'=>''
            )),
        )*/
    ),
    'wiosla' => array(
        'name' => 'Producent wioseł',
        'description'=>'Produkcja wioseł',
    ),
    'importer' => array(
        'name' => 'Importer',
        'description'=>'Importer sprzętu',
    ),
    'odziez' => array(
        'name' => 'Producent odzieży',
        'description'=>'Produkcja odzieży sportowej',
    ),
    'kamizelka' => array(
        'name' => 'Producent kamizelek',
        'description'=>'Produkcja kamizelek asekuracyjnych i ratunkowych',
    ),
    'wypozyczalnia' => array(
        'name' => 'Wypożyczalnia',
        'description'=>'Wypożyczalnia sprzętu pływającego',
    ),
    'biuro' => array(
        'name' => 'Biuro',
        'description'=>'Biuro podróży / organizator spływów',
    ),
    'sklep' => array(
        'name' => 'Sklep',
        'description'=>'Sklep sportowy lub turystyczny',
    ),
    'klub' => array(
        'name' => 'Klub',
        'description'=>'Klub kajakowy',
    ),
    'camping' => array(
        'name' => 'Camping/pole biwakowe',
        'description'=>'Camping lub pole biwakowe',
    ),
    'serwis' => array(
        'name' => 'Serwis',
        'description'=>'Naprawa kajaków itp.',
    ),
    'komis' => array(
        'name' => 'Komis',
        'description'=>'komis sprzętu kajakowego',
    ),
    'inne' => array(
        'name' => 'Inne',
        'description'=>'nie pasuje do żadnej z innych kategorii',
    ),
    'organizator' => array(
        'name' => 'Organizator szkoleń',
        'description'=>'Organizator szkoleń kajakowych',
    ),
);
?>
