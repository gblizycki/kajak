<?php

/**
 * Description of DEAbstractDataSource
 *
 * @name DEAbstractDataSource
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2012-01-02
 */
abstract class DEAbstractDataSource extends CWidget {

    public $format;

    public function renderObject($data=array(),$return=true) {
        if(!isset($data['model']))
            throw new CHttpException('404','No model to render');
        $class = str_replace('Pending', '', get_class($data['model']));
        return $this->{'render' . $class}($data,$return);
    }

    public function renderObjectForm($data=array(),$return=true) {
        if(!isset($data['model']))
            throw new CHttpException('404','No model to render');
        $class = str_replace('Pending', '', get_class($data['model']));
        $panel = Yii::app()->user->hasFlash('edit')?Yii::app()->user->getFlash('edit'):'';
        $panel .= CHtml::beginForm(array('js/edit'.$class,'id'=>$data['model']->id),'post',array('class'=>'object-edit'));
        $panel .= $this->renderBackButton($data['backUrl'], $data['currentUrl']);
        $panel .= $this->renderHiddenFields($data['model']);
        $panel .= $this->{'render' . $class . 'Form'}($data,$return);
        $panel .= $this->renderSubmitButton();
        $panel .= CHtml::endForm();
        return $panel;
    }

    public function renderObjectInfoWindow($data=array(),$return=true) {
        if(!isset($data['model']))
            throw new CHttpException('404','No model to render');
        $class = str_replace('Pending', '', get_class($data['model']));
        return $this->{'render' . $class . 'InfoWindow'}($data,$return);
    }

    public function renderObjectList($data=array(),$return=true)
    {
        if(!isset($data['model']))
            throw new CHttpException('404','No model to render');
        $class = str_replace('Pending', '', get_class($data['model']));
        return $this->{'render' . $class.'List'}($data,$return);
    }
    public function renderRoute($data=array(),$return=true) {
        return $this->render('view/route', $data,$return);
    }

    public function renderArea($data=array(),$return=true) {
        return $this->render('view/area', $data,$return);
    }

    public function renderPlace($data=array(),$return=true) {
        return $this->render('view/place', $data,$return);
    }

    public function renderRouteForm($data=array(),$return=true) {
        return $this->render('form/route', $data,$return);
    }

    public function renderAreaForm($data=array(),$return=true) {
        return $this->render('form/area', $data,$return);
    }

    public function renderPlaceForm($data=array(),$return=true) {
        return $this->render('form/place', $data,$return);
    }

    public function renderPointForm($data=array(),$return=true) {
        return $this->render('form/point', $data,$return);
    }

    public function renderRouteInfoWindow($data=array(),$return=true) {
        return $this->render('info/route', $data,$return);
    }

    public function renderAreaInfoWindow($data=array(),$return=true) {
        return $this->render('info/area', $data,$return);
    }

    public function renderPlaceInfoWindow($data=array(),$return=true) {
        return $this->render('info/place', $data,$return);
    }

    public function renderPointInfoWindow($data=array(),$return=true) {
        return $this->render('info/point', $data,$return);
    }
    public function renderAreaList($data=array(),$return=true)
    {
        return $this->render('list/area', $data,$return);
    }
    public function renderPlaceList($data=array(),$return=true)
    {
        return $this->render('list/place', $data,$return);
    }
    public function renderRouteList($data=array(),$return=true)
    {
        return $this->render('list/route', $data,$return);
    }
    //
    protected function renderBackButton($backUrl,$currentUrl)
    {
        $backButton = '';
        if(isset($backUrl))
        {
                $backButton .= CHtml::link('Back',array($backUrl),array('class'=>'back-button'));
                $backButton .= CHtml::hiddenField('backUrl',$currentUrl);
        }
        return $backButton;
    }
    protected function renderHiddenFields($object)
    {
        $fields = '';
        foreach($object->hiddenFields as $attribute=>$options)
        {
            if(is_array($options))
            {
                $fields .= CHtml::activeHiddenField($object, $attribute,$options);
            }
            else
            {
                $fields .= CHtml::activeHiddenField($object, $options);
            }
        }
        return $fields;
    }
    protected function renderSubmitButton()
    {
        return '<div class="row">'.CHtml::submitButton('Zapisz').'</div>';
    }

}

