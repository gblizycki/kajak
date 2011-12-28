<?php

return array(
    //Users
    'Janina' => array(
        '_id' => new MongoID('4e5fc6aae20128417e600000'),
        'email' => 'janiazamojska@wp.pl',
        'password' => 'b23438dc518d034a5eee32eca5b4335a', //s1Pxv8fs
        'salt' => '3132e10a2ecd34d7968b3f5f59804aa5',
        'name' => 'Janina Zamojska',
        'birthday' => '1965-07-23',
        'type' => User::USER_UNREGISTER,
        'passwordRenewal' => new MongoDate(0),
        'createDate' => new MongoDate(strtotime('2011-08-19 14:37:30')),
        'updateDate' => new MongoDate(strtotime('2011-08-19 14:37:30')),
        'social' => array(
            'Twitter' => 'Janka',
            'Facebook' => '123412211'
        ),
    ),
    'Roman' => array(
        '_id' => new MongoID('4e5fc6aae20128417e610000'),
        'email' => 'roman@silme.pl',
        'password' => '182ce8125da31ed260dff70647c9ca71', //5Z5fpqct
        'salt' => 'd9db548088f506d879f46ece62e679de',
        'name' => 'Roman Madra',
        'birthday' => '1970-11-23',
        'type' => User::USER_REGISTER,
        'passwordRenewal' => new MongoDate(0),
        'updateDate' => new MongoDate(strtotime('2011-08-19 14:41:19')),
        'createDate' => new MongoDate(strtotime('2011-08-19 14:41:19')),
        'social' => array(
            'Yahoo' => 'roman@yahoo.com',
            'Facebook' => '123123412'
        ),
    ),
    //Admins
    'Grzegorz' => array(
        '_id' => new MongoID('4e5fc6aae20128417e660000'),
        'email' => 'gary@silme.pl',
        'password' => 'f84e1eec2880c4d921c748661247883a', //iu49dWrq
        'salt' => 'd27200fae1378f0cb8535357dc33854a',
        'name' => 'Grzegorz Bliżycki',
        'birthday' => '1987-07-27',
        'note' => '',
        'type' => User::USER_ADMIN,
        'passwordRenewal' => new MongoDate(0),
        'updateDate' => new MongoDate(strtotime('2011-08-20 08:25:37')),
        'createDate' => new MongoDate(strtotime('2011-08-20 08:25:37')),
    ),
    //Moderators
    'Mikołaj' => array(
        '_id' => new MongoID('4e5fc6aae20128417e670000'),
        'email' => 'mikolaj@ee.pw.edu.pl',
        'password' => 'f84e1eec2880c4d921c748661247883a', //iu49dWrq
        'salt' => 'd27200fae1378f0cb8535357dc33854a',
        'name' => 'Mikołaj Tymosz',
        'birthday' => '1985-23-05',
        'note' => '',
        'type' => User::USER_MODERATOR,
        'passwordRenewal' => new MongoDate(0),
        'updateDate' => new MongoDate(strtotime('2011-09-20 09:25:37')),
        'createDate' => new MongoDate(strtotime('2011-05-20 08:25:37')),
    ),
);
?>
