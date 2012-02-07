<?php

class CMongoDocumentDataProvider extends EMongoDocumentDataProvider {
    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     * @since v1.0
     */
    protected function fetchData() {
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->setItemCount($this->getTotalItemCount());

            $this->_criteria->setLimit($pagination->getLimit());
            $this->_criteria->setOffset($pagination->getOffset());
        }

        if (($sort = $this->getSort()) !== false && ($order = $sort->getOrderBy()) != '') {
            $sort = array();
            foreach ($this->getSortDirections($order) as $name => $descending) {
                $sort[$name] = $descending ? EMongoCriteria::SORT_DESC : EMongoCriteria::SORT_ASC;
            }
            $this->_criteria->setSort($sort);
        }
        return $this->model->findAll($this->_criteria)->toArray();
    }
    
    public function __toString() {
        $string = '';
        $criteria = $this->criteria;
        $string.= $this->modelClass;
        if(count($criteria->getSelect())>0)
            $string.= CJSON::encode($this->criteria->getSelect());
        if(count($criteria->getConditions())>0)
            $string.= CJSON::encode($this->criteria->getConditions());
        if(count($criteria->getSort())>0)
            $string.= CJSON::encode($this->criteria->getSort());
        if($criteria->getLimit()!=null)
            $string.= CJSON::encode($this->criteria->getLimit());
        if($criteria->getOffset()!=null)
            $string.= CJSON::encode($this->criteria->getOffset());
        if($criteria->getWorkingFields()!=null)
            $string.= CJSON::encode($this->criteria->getWorkingFields());
        return $string;
    }
}
?>
