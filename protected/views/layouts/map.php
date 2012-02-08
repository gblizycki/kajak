<!doctype html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="stylesheet" href="css/style.css">
        <?php 
        $cs=Yii::app()->clientScript;
        $cs->scriptMap=array(
            'jquery.js'=>false,
            'jquery.ui.js'=>false,
            'jquery-ui.min.js'=>false,
        );
        echo CGoogleApi::init(); ?>
        <?php  CHtml::script(
            CGoogleApi::load('jquery','1.7.1')."\n".
            CGoogleApi::load('jqueryui',"1.8.16")
        ); ?>
        
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.17/jquery-ui.min.js"></script>
        <script src="js/libs/modernizr-2.0.6.min.js"></script>
        <script src="js/libs/async.min.js"></script>
        <script src="js/libs/jstorage.js"></script>
        <script src="js/libs/jquery.scrollTo-1.4.2-min.js"></script>
        <script src="js/libs/jquery.cookie.js"></script>
    </head>
    <body>
        <?php echo $content; ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui');?>
        
        <?php 
            Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
        ?>
        <!--[if lt IE 7 ]>
                <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
                <script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
        <![endif]-->

    </body>
</html>
