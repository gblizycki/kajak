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
												array('label'=>'App','url'=>array('/site/index'),'visible'=>!Yii::app()->user->isGuest),
                        array('label' => 'Route', 'url' => array('/route/admin'),'visible' => !Yii::app()->user->isGuest, 'items' => array(
                                array('label' => 'Admin', 'url' => array('/route/admin')),
                                array('label' => 'Create', 'url' => array('/route/create')),
                        )),
                        array('label' => 'Place', 'url' => array('/place/admin'),'visible' => !Yii::app()->user->isGuest, 'items' => array(
                                array('label' => 'Admin', 'url' => array('/place/admin')),
                                array('label' => 'Create', 'url' => array('/place/create')),
                        )),
                        array('label' => 'Area', 'url' => array('/area/admin'),'visible' => !Yii::app()->user->isGuest, 'items' => array(
                                array('label' => 'Admin', 'url' => array('/area/admin')),
                                array('label' => 'Create', 'url' => array('/area/create')),
                        )),
                        array('label' => 'Category','visible' => !Yii::app()->user->isGuest, 'items' => array(
                                array('label' => 'Route', 'url' => array('/categoryroute/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/categoryroute/admin')),
                                        array('label' => 'Create', 'url' => array('/categoryroute/create')),
                                )),
                                array('label' => 'Place', 'url' => array('/categoryplace/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/categoryplace/admin')),
                                        array('label' => 'Create', 'url' => array('/categoryplace/create')),
                                )),
                                array('label' => 'Area', 'url' => array('/categoryarea/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/categoryarea/admin')),
                                        array('label' => 'Create', 'url' => array('/categoryarea/create')),
                                )),
                        )),
                        array('label' => 'Data Source', 'url' => array('/datasource/admin'),'visible' => !Yii::app()->user->isGuest && Yii::app()->user->hasRole('Admin'), 'items' => array(
                                array('label' => 'Admin', 'url' => array('/datasource/admin')),
                                array('label' => 'Create', 'url' => array('/datasource/create')),
                        )),
                        array('label' => 'User', 'url' => array('/user/admin'),'visible' => !Yii::app()->user->isGuest && Yii::app()->user->hasRole('Admin'), 'items' => array(
                                array('label' => 'Admin', 'url' => array('/user/admin')),
                                array('label' => 'Create', 'url' => array('/user/create')),
                        )),
                        array('label' => 'Pedning objects', 'url' => '','visible' => !Yii::app()->user->isGuest, 'items' => array(
                                array('label' => 'Pending Route', 'url' => array('/dataexchange/routepending/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/dataexchange/routepending/admin')),
                                )),
                                array('label' => 'Pending Place', 'url' => array('/dataexchange/placepending/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/dataexchange/placepending/admin')),
                                )),
                                array('label' => 'Pending Area', 'url' => array('/dataexchange/areapending/admin'), 'items' => array(
                                        array('label' => 'Admin', 'url' => array('/dataexchange/areapending/admin')),
                                )),
                        )),
                        array('label' => 'Rights', 'url' => array('/rights'),'visible' => !Yii::app()->user->isGuest && Yii::app()->user->hasRole('Admin'), 'items' => array(
                                array(
                                    'label' => Rights::t('core', 'Assignments'),
                                    'url' => array('/rights/assignment/view'),
                                    'itemOptions' => array('class' => 'item-assignments'),
                                ),
                                array(
                                    'label' => Rights::t('core', 'Permissions'),
                                    'url' => array('/rights/authItem/permissions'),
                                    'itemOptions' => array('class' => 'item-permissions'),
                                ),
                                array(
                                    'label' => Rights::t('core', 'Roles'),
                                    'url' => array('/rights/authItem/roles'),
                                    'itemOptions' => array('class' => 'item-roles'),
                                ),
                                array(
                                    'label' => Rights::t('core', 'Tasks'),
                                    'url' => array('/rights/authItem/tasks'),
                                    'itemOptions' => array('class' => 'item-tasks'),
                                ),
                                array(
                                    'label' => Rights::t('core', 'Operations'),
                                    'url' => array('/rights/authItem/operations'),
                                    'itemOptions' => array('class' => 'item-operations'),
                                ),
                        )),
                        array('label' => 'Importer', 'url' => array('/dataexchange/importer/index'),'visible' => !Yii::app()->user->isGuest && Yii::app()->user->hasRole('Admin')),
                        array('label' => 'Login', 'url' => array('site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->

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