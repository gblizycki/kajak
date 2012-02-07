<?php

return array(
    //Users
    'kajak' => array(
        '_id' => new MongoID('4efaf3c0b1a7882d20000000'),
        'name' => 'Kajak',
        'description'=>'Trasy kajakowe',
        'title'=>'Kajakowe',
        'filters'=>array(
            array('name'=>'Nazwa','attribute'=>'info[name]','class'=>'text','order'=>1,'type'=>'string','partialMatch'=>true,'options'=>array(
                'slideEnable'=>true
            )),
            array('name'=>'Opis','attribute'=>'info[description]','class'=>'textarea','order'=>2,'type'=>'string','partialMatch'=>true,'options'=>array(
                'slideEnable'=>true
            )),
            array('name'=>'Trudność','attribute'=>'info[data][hardness]','class'=>'dropdown','order'=>3,'type'=>'string','partialMatch'=>false,'options'=>array(
                'data'=>array('WW1'=>'WW1','WW2'=>'WW2','WW3'=>'WW3'),
                'emptyElement'=>'',
                'slideEnable'=>true
            )),
            array('name'=>'Atrakcyjność','attribute'=>'info[data][beauty]','class'=>'dropdown','order'=>4,'type'=>'string','partialMatch'=>false,'options'=>array(
                'data'=>array('*'=>'*','**'=>'**','***'=>'***','****'=>'****','*****'=>'*****'),
                'emptyElement'=>'',
                'slideEnable'=>true
            )),
        )
    ),
    'rower' => array(
        '_id' => new MongoID('4efaf3c0b1a7882d30000000'),
        'name' => 'Rower',
        'description'=>'Trasy rowerowe',
        'title'=>'Rowerowe',
        'filters'=>array(
            
        )
    ),
);
?>
