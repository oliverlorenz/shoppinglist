<?php

class ListController extends DatabaseController
{
    public function actionList()
    {
        $model = ListModel::model()->findByAttributes(array('date' => date('Y-m-d')));
        if(!$model) {
            $model = new ListModel();
            $model->date = date('Y-m-d');
            $model->save();
        }
        $this->redirect($this->_getViewLink($model->id));
    }

    public function actionView($id)
    {
        // SELECT Meal.id, Meal.name, SUM(amount) as amount , unit, Ingredient.name FROM ListMeal 
        // LEFT JOIN Meal ON ListMeal.mealId = Meal.Id
        // LEFT JOIN MealIngredient ON MealIngredient.mealId=ListMeal.id
        // LEFT JOIN Ingredient ON Ingredient.id = MealIngredient.ingredientId
        // GROUP BY Ingredient.id
        // ORDER BY Ingredient.name
        $list = Yii::app()->db->createCommand()
            ->select('SUM(amount) as amount, Ingredient.name, Ingredient.unit, Meal.id as mealId, Meal.name as mealName')
            ->from('List')
            ->join('ListMeal',         'ListMeal.listId = List.id')
            ->join('Meal',             'ListMeal.mealId = Meal.id')
            ->join('MealIngredient',   'MealIngredient.mealId = Meal.id')
            ->join('Ingredient',       'MealIngredient.id = Ingredient.id')
            ->where('List.id=:id', array(':id'=>$id))
            ->group('Ingredient.id')
            ->order('Ingredient.name')
            ->queryAll()
            ;
        $this->_addViewProperty('list', $list);
        $this->_addViewProperty('listId', $id);

        $this->_renderView();
    }

    protected function _getAddMealLink($listId, $mealId) {
        return $this->_getListLink() 
             . $listId
             . '/meal/'
             . $this->_viewActionAdd
             . '/'
             . $mealId
             ; 
    }

    protected function _getRemoveMealLink($listId, $mealId) {
        return $this->_getListLink() 
             . $listId
             . '/meal/'
             . $this->_viewActionDelete
             . '/'
             . $mealId
             ; 
    }

    protected function _getDeleteMealLink($listId, $mealId) {
        return $this->_getListLink() 
             . $listId
             . '/meal/'
             . $this->_viewActionDelete
             . '/'
             . $mealId
             ; 
    }
}