<?php

class JSController extends Controller {

    public $layout = null;

    /**
     * Declares class-based actions.
     */
    public function filters() {
        return array(
                //'rights',
        );
    }

    public function actionFilter() {
        $objects = array();
        $filters = array();
        //select good object types
        if (isset($_GET['type']))
            $type = $_GET['type'];
        else
            $type = array('Place', 'Route', 'Area');
        //set good scenario
        if (isset($_GET['scenario']))
            $scenario = $_GET['scenario'];
        else
            $scenario = 'view';
        $filterObjects = array();
        foreach ($type as $t) {
            //select object of $t type
            //$objects[$t] = CMongoDocument::model($t)->findAll();
            $obj = CMongoDocument::model($t);
            
            $obj->unsetAttributes();
            if (isset($_GET[$t]))
                $obj->setAttributes($_GET[$t]);
            
            //get filters from selected category
            if(is_array($obj->category))
            {
                //many categories, gather all possible filters ?
            }
            elseif($obj->category!=null)
            {
                //one category, select filter from this category
                $filters[$t] = CMongoDocument::model('Category'.$t)->findByPk(new MongoId($obj->category))->filters;       
            }
            else
            {
                //try to get one category from 
            }
            $objects[$t] = $obj->search()->data;
            
            //catogry select
            $filters[$t] = array();
            if($obj->category!=null)
                $categories = $obj->category;
            else
            {
                $categories = $obj->getDb()->command(array("distinct" => $obj->getCollectionName(), "key" => "category","query"=>$obj->search()->getCriteria()->getConditions()));
                $categories = $categories['values'];
            }
            if(is_array($categories))
            {
                //many categories, gather all possible filters ?
                foreach($categories as $category)
                {
                    $filters[$t] = CMap::mergeArray($filters[$t], CMongoDocument::model('Category'.$t)->findByPk(new MongoId($category))->filters);
                }
            }
            elseif($categories!=null)
            {
                //one category, select filter from this category
                $filters[$t] = CMongoDocument::model('Category'.$t)->findByPk(new MongoId($categories))->filters;       
            }
            
            foreach ($objects[$t] as $index => $object) {
                $objects[$t][$index] = $this->array_filter_recursive($object->{'export' . ucfirst($scenario)}());
            }
            $filterObjects[$t] = $obj;
        }
        echo CJSON::encode(array('objects'=>$objects,
            'panel'=>  $this->renderPartial('panel',  CMap::mergeArray($filterObjects,array('filters'=>$filters,'objects'=>$objects,'type'=>$type)),true)));
    }

    protected function array_filter_recursive($input) {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->array_filter_recursive($value);
            }
        }

        return array_filter($input,'checkNull');
    }
}
function checkNull($value)
    {
        return $value!==null;
    }