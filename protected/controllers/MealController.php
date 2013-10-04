<?php

class MealController extends DatabaseController
{ 

    public function actionEdit($id) 
    {
        $modelClassName = $this->_getModelName();
        $modelFormName = ucfirst($modelClassName);
        $modelMealIngredientFormName = 'MealIngredientModel';
        $modelIngredientFormName = 'IngredientModel';
        $model = $modelClassName::model()->findByPk($id);
        $newIngredient = new IngredientModel();

        if(isset($_POST[$modelFormName])
        && isset($_POST['yt0'])
        ) {
            $model->attributes = $_POST[$modelFormName];
            if($model->validate())
            {
                $model->save();
                $this->redirect($this->_getListLink($this->id));
            }
        } elseif(isset($_POST[$modelMealIngredientFormName])
              && isset($_POST['yt1'])
        ) {
            $modelIngredient = new MealIngredientModel();
            $modelIngredient->attributes = $_POST[$modelMealIngredientFormName];

            if($modelIngredient->validate())
            {

                $modelIngredient->save();
                //$this->redirect($this->_getListLink($this->id));
            }
        } elseif(isset($_POST[$modelIngredientFormName])
              && isset($_POST['yt2'])
        ) {
            print_r($_POST);
            $newIngredient->attributes = $_POST[$modelIngredientFormName];

            if($newIngredient->validate())
            {
                $newIngredient->save();
                $ingredientId = $newIngredient->id;

                $mealIngredient = new MealIngredientModel();
                $mealIngredient->mealId = $id;
                $mealIngredient->ingredientId = $ingredientId;
                $mealIngredient->save();

                //$this->redirect($this->_getListLink($this->id));
            }
        }

        $ingredients = MealIngredientModel::model()->findAllByAttributes(array('mealId' => $model->id));

        $ingredientsAll = array();
        $ingredientRows = IngredientModel::model()->findAll();
        $ingredientData = array();
        foreach ($ingredientRows as $row) {
            $ingredientsAll[$row->id] = $row->name . ' (' . $row->unit . ')';
            $ingredientData[$row->id] = $row;
        }
        $this->_addViewProperty('model', $model);
        $this->_addViewProperty('newIngredient', $newIngredient);
        $this->_addViewProperty('ingredients', $ingredients);
        $this->_addViewProperty('ingredientsAll', $ingredientsAll);
        $this->_addViewProperty('ingredientData', $ingredientData);
        $this->_addViewProperty('modelIngredient', new MealIngredientModel());
        $this->_renderView();
    }

    protected function _getIngredientDeleteLink($mealId, $ingredientId) {
        return $this->_getListLink() 
             . $mealId
             . '/ingredient/' 
             . $ingredientId
             . '/delete'
             ; 
    }

    public function actionAddToList($mealId) {
        $model = ListModel::model()->findByAttributes(array('date' => date('Y-m-d')));
        if(!$model) {
            $model = new ListModel();
            $model->date = date('Y-m-d');
            $model->save();
        }
        
        $listMeal = new ListMealModel();
        $listMeal->mealId = $mealId;
        $listMeal->listId = $model->id;
        $listMeal->save();
        $this->redirect('/');
    }

    public function actionRemoveFromList($mealId, $listId) {
        $list = ListMealModel::model()->deleteAllByAttributes(
            array(
                'listId' => $listId,
                'mealId' => $mealId,
                )
            );
        $this->redirect($this->_getListViewLink($listId));
    }

    protected function _getListViewLink($listId) {
        return $this->_getLinkBase()
             . '/list' 
             . '/view/' 
             . $listId
             ; 
    }

    

    public function actionList() {
        $this->_useControllerView = true;
        parent::actionList();
    }

    protected function _getAddToListLink($id) {
        return $this->_getLinkBase() 
             . 'meal/'
             . $id
             . '/addToList' 
             ; 
    }

    public function actionDeleteIngredient($mealId, $ingredientId)
    {
        $ingredients = MealIngredientModel::model()->findAllByAttributes(array(
                            'mealId' => $mealId,
                            'ingredientId' => $ingredientId
                       ));
        foreach ($ingredients as $model) {
            $model->delete();
        }
        $this->redirect($this->_getEditLink($mealId));
    }

    protected function _getQrUrl($mealId) {
        $url = $this->_getViewLink($mealId);
        $encodedUrl = urlencode($url);
        return 'http://api.qrserver.com/v1/create-qr-code/?data=' 
             . $encodedUrl 
             . '&size=125x125';
    }

    protected function _getQrImage($mealId)
    {
        return '<img src="' . $this->_getQrUrl($mealId) . '" />'; 
    }

}