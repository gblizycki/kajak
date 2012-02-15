<?php
/**
 * @package dataexchange
 */
class ImporterController extends Controller
{
    /**
     * Główny layout kontrolera
     * @var mixed 
     */
    public $layout = '//layouts/admin';

    /**
     * @return Filtry kontrolera
     */
    public function filters()
    {
        return array(
            'rights',
        );
    }
    /**
     * Główna akacja wyświetlająca listę możliwych importerów 
     */
    public function actionIndex()
    {
        $models = DataSource::model()->findAll();
        $this->render('sources', array('model' => $models));
    }
    /**
     * Pośrednia akcja wyboru odpowiedniego importera
     * @param string $id DataSource id
     */
    public function actionSelect($id)
    {
        $ds = DataSource::model()->findByPk(new MongoId($id));
        $model = DataExchange::module()->getDataSource($ds->format);
        if ($model instanceof DEDataSourceDb)
        {
            $this->redirect(array('selectdb', 'id' => $id));
        } elseif ($model instanceof DEDataSourceFile)
        {
            $this->redirect(array('selectfile', 'id' => $id));
        } elseif ($model instanceof DEDataSourceWebService)
        {
            $this->redirect(array('selectprovider', 'id' => $id));
        }
    }
    /**
     * Akcja pozwlająca wybrać parametry bazy danych do importu
     * @param string $id DataSource id
     */
    public function actionSelectDb($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_POST['username'], $_POST['password']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->username = $_POST['username'];
            $de->password = $_POST['password'];
            $de->init();
            $data = $de->import();
            DataExchange::module()->save($model, $data);
            Yii::app()->user->setFlash('top', 'Import successful');
            $this->redirect(array('index'));
        }
        $this->render('selectDb', array('model' => $model));
    }
    /**
     * Akcja pozwlająca wybrać parametry pliku do importu
     * @param string $id DataSource id
     */
    public function actionSelectFile($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_FILES['dataFile']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->uri = CUploadedFile::getInstanceByName('dataFile')->tempName;
            $data = $de->import();
            DataExchange::module()->save($model, $data);
            Yii::app()->user->setFlash('top', 'Import successful');
            $this->redirect(array('index'));
        }
        $this->render('selectFile', array('model' => $model));
    }
    /**
     * Akcja pozwlająca wybrać parametry serwisu do importu
     * @param string $id DataSource id
     */
    public function actionSelectProvider($id)
    {
        $model = DataSource::model()->findByPk(new MongoId($id));
        if (isset($_POST['provider']))
        {
            $de = DataExchange::module()->getDataSource($model->format);
            $de->provider = $_POST['provider'];
            $data = $de->import();
            DataExchange::module()->save($model, $data);
            Yii::app()->user->setFlash('top', 'Import successful');
            $this->redirect(array('index'));
        }
        $this->render('selectprovider', array('model' => $model));
    }

}