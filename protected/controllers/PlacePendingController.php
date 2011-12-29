<?php

class PlacePendingController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'admin';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view',
                array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new PlacePending;
        $model->info = new Info;
        $model->style = new Style;
        $model->location = new Point;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PlacePending']) || isset($_POST['Info']) || isset($_POST['Style']) || isset($_POST['Point']))
        {
            $model->attributes = $_POST['PlacePending'];
            if (isset($_POST['Info']))
                $model->info->attributes = $_POST['Info'];
            if (isset($_POST['Style']))
                $model->style->attributes = $_POST['Style'];
            if (isset($_POST['Point']))
                $model->style->attributes = $_POST['Point'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PlacePending']) || isset($_POST['Info']) || isset($_POST['Style']) || isset($_POST['Point']))
        {
            $model->attributes = $_POST['PlacePending'];
            if (isset($_POST['Info']))
                $model->info->attributes = $_POST['Info'];
            if (isset($_POST['Style']))
                $model->style->attributes = $_POST['Style'];
            if (isset($_POST['Point']))
                $model->style->attributes = $_POST['Point'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new PlacePending('search');
        $model->unsetAttributes();

        if (isset($_GET['PlacePending']))
            $model->setAttributes($_GET['PlacePending']);

        $this->render('admin', array(
            'model' => $model
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = PlacePending::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'place-pending-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
