<?php

/**
 * Description of JSController
 *
 * @name JSController
 * @author Grzegorz Bliżycki <grzegorzblizycki@gmail.com>
 * @todo 
 * Created: 2012-01-03
 */
class JSController extends Controller
{

    public function actionData()
    {
        $routes = array();
        $places = array();
        $areas = array();
        foreach (Route::model()->findAll() as $key => $item)
        {
            $value = $item->exportArray();
            if ($value !== null)
                $routes[] = $value;
        }
        foreach (Place::model()->findAll() as $key => $item)
        {
            $value = $item->exportArray();
            if ($value !== null)
                $places[] = $value;
        }
        foreach (Area::model()->findAll() as $key => $item)
        {
            $value = $item->exportArray();
            if ($value !== null)
                $areas[] = $value;
        }

        echo CJSON::encode(array('routes' => $routes, 'areas' => $areas, 'places' => $places));
    }

    public function actionPanel()
    {
        //filtrowanie danych związanych z kategoriami
        if (isset($_POST['Type']))
            $type = $_POST['Type'];
        $category = array();
        $categoryClass = $type . 'Category';
        $category[$type] = new $categoryClass;
        $category[$type]->unsetAttributes();
        if (isset($_POST[$categoryClass]))
            $category[$type]->setAttributes($_POST['AreaPending']);
        $this->renderPartial('panel', array('model' => $category,'type'=>$type));
    }

}

