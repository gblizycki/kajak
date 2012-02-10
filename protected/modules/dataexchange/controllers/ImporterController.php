<?php

class ImporterController extends Controller
{
    public $layout = '//layouts/admin';
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }
    public function actionIndex()
    {

        //$de = DataExchange::module()->getDataSource('XML_kajak_org_pl');
        //$de->uri = Yii::getPathOfAlias('webroot.tmp').DIRECTORY_SEPARATOR.'testdata.xml';
        //DataExchange::module()->save($dataSource, $data);
        //echo 'yupi';die();
        $models = DataSource::model()->findAll();
        $this->render('sources', array('model' => $models));
        //$this->renderPartial('test');
    }

    public function actionSelect($id)
    {
        $ds = DataSource::model()->findByPk(new MongoId($id));
        $model = DataExchange::module()->getDataSource($ds->format);
        if ($model instanceof DEDataSourceDb)
        {
            $this->redirect(array('selectdb', 'id' => $id));
        }
        elseif ($model instanceof DEDataSourceFile)
        {
            $this->redirect(array('selectfile', 'id' => $id));
        }
        elseif($model instanceof DEDataSourceWebService)
        {
            //DataExchange::module()->save($ds, $model->import());
            $this->redirect(array('selectprovider', 'id' => $id));
        }
    }

    public function actionSelectDb($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_POST['username'],$_POST['password']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->username = $_POST['username'];
            $de->password = $_POST['password'];
            $de->init();
            //try{
                //$de->connection->connectionStatus;
                $data = $de->import();
            //var_dump($data['places'][0]->info);die();
            DataExchange::module()->save($model, $data);
                Yii::app()->user->setFlash('top','Import successful');
                $this->redirect(array('admin'));
            /*}catch(Exception $e)
            {
                Yii::app()->user->setFlash('top','Bad username or password');
            }*/
            
        }
        $this->render('selectDb',array('model'=>$model));
        
    }

    public function actionSelectFile($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_FILES['dataFile']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->uri = CUploadedFile::getInstanceByName('dataFile')->tempName;
            $data = $de->import();
            DataExchange::module()->save($model, $data);
                Yii::app()->user->setFlash('top','Import successful');
                $this->redirect(array('admin'));
        }
        $this->render('selectFile',array('model'=>$model));
    }
    
    public function actionSelectProvider($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_POST['provider']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->provider = $_POST['provider'];
            $data = $de->import();
            DataExchange::module()->save($model, $data);
                Yii::app()->user->setFlash('top','Import successful');
                $this->redirect(array('admin'));
        }
        $this->render('selectprovider',array('model'=>$model));
    }

}