<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
            </div><!-- header -->

            <div id="mainmenu">
                <?php
                $this->widget('ext.mbmenu.MbMenu', array(
                    'items' => array(
                        array('label' => 'Pending Route', 'url' => array('/dataexchange/routepending/admin'), 'items' => array(
                                array('label' => 'Admin', 'url' => array('/dataexchange/routepending/admin')),
                        )),
                        array('label' => 'Pending Place', 'url' => array('/dataexchange/placepending/admin'), 'items' => array(
                                array('label' => 'Admin', 'url' => array('/dataexchange/placepending/admin')),
                        )),
                        array('label' => 'Pending Area', 'url' => array('/dataexchange/areapending/admin'), 'items' => array(
                                array('label' => 'Admin', 'url' => array('/dataexchange/areapending/admin')),
                        )),
                        array('label' => 'Importer', 'url' => array('/dataexchange/importer/index')),
                        array('label' => 'Login', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->
            <div id="flash">
                <?php 
                   echo CHtml::encode(Yii::app()->user->getFlash('top'));
                ?>
            </div>
            <?php
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
            ));
            ?><!-- breadcrumbs -->

<?php echo $content; ?>

            <div id="footer">
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>