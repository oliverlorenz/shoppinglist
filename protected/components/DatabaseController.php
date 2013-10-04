<?php

class DatabaseController extends CController
{
	protected function _getModelName() 
	{
		return ucfirst($this->id) . 'Model';
	}

	protected function _getViewName() 
	{
		$return = '';
		if(!$this->_useControllerView) {
			$return .= '../';
		}
		$viewName = $this->action->id;
		return $return . strtolower($viewName);
	}

	protected $_viewActionEdit = 'edit';
	protected $_viewActionAdd = 'add';
	protected $_viewActionDelete = 'delete';
	protected $_viewActionView = 'view';
	protected $_viewProperties = array();

	protected function _getLinkBase() {
		return '/';
	}

	protected function _getEditLink($id) {
		return $this->_getListLink() 
		     . $this->_viewActionEdit 
		     . '/' 
		     . $id
		     ; 
	}

	protected function _getViewLink($id) {
		return $this->_getListLink() 
		     . $this->_viewActionView 
		     . '/' 
		     . $id
		     ; 
	}

	protected function _getDeleteLink($id) {
		return $this->_getListLink() 
		     . $this->_viewActionDelete 
		     . '/' 
		     . $id
		     ; 
	}

	protected function _getAddLink() {
		return $this->_getListLink() 
		     . $this->_viewActionAdd 
		     ; 
	}

	protected function _getListLink() {
		return $this->_getLinkBase() 
		     . $this->id
		     . '/' 
		     ; 
	}

	protected $_useControllerView = false;

	protected function _renderView()
	{
		$this->render(
			$this->_getViewName(),
			$this->_viewProperties
		);
	}

	public function beforeAction() 
	{
		$this->_viewProperties = array(
			'language' => $this->_getLanguageVariables($this->action->id),
			'actions' => array(
				'add' => $this->_viewActionAdd,
				'edit' => $this->_viewActionEdit,
				'delete' => $this->_viewActionDelete,
				'view' => $this->_viewActionView,
			)
		);
		return true;
	}

	protected function _addViewProperty($key, $value) 
	{
		$this->_viewProperties[$key] = $value;
	}

	protected function _getLanguageVariables($view = null)
	{
		$controllerNameSingular = 'Eintrag';
		$controllerNamePlural 	= 'Eintr&aumlge';

		if('meal' == $this->id) {
			$controllerNameSingular = 'Gericht';
			$controllerNamePlural	= 'Gerichte';
		} elseif ('ingredient' == $this->id) {
			$controllerNameSingular = 'Zutat';
			$controllerNamePlural	= 'Zutaten';
		}

		$data = array(
			'en' => array(
				'list' => array(
					'headline' 		=> 'All Entries',
					'edit' 			=> 'edit',
					'add' 			=> 'add',
					'delete' 		=> 'delete',
					'addToList' 	=> 'Add to list',
					'back'			=> 'back'
				),
				'add' => array(
					'headline' 		=> 'Add Entry',
					'list'			=> 'back',
					'delete' 		=> 'delete',
					'add'			=> 'add',
					'save'			=> 'save',
				),
				'edit' => array(
					'headline'  	=> 'Edit Entry',
					'list'			=> 'back',
					'delete' 		=> 'delete',
					'add'			=> 'add',
					'save'			=> 'save',
				),
				'index' => array(
					'meals'			=> 'Meals',
					'ingredients'	=> 'Ingredients',
					'lists'			=> 'Lists',
				),
				'view' => array(
					'back'			=> 'back',
				),
			),
			'de' => array(
				'list' => array(
					'headline' 		=> 'Alle ' . $controllerNamePlural,
					'add' 			=> 'hinzufügen',
					'edit' 			=> 'Bearbeiten',
					'delete' 		=> 'Löschen',
					'addToList' 	=> 'Zu Liste hinzufügen',
					'back'			=> 'Zurück'
				),
				'add' => array(
					'headline' 		=> $controllerNameSingular . ' hinzufügen',
					'list'			=> 'Zurück',
					'delete' 		=> 'Löschen',
					'add'			=> 'Hinzufügen',
					'save'			=> 'speichern',
				),
				'edit' => array(
					'headline' 		=> $controllerNameSingular . ' hinzufügen',
					'list'			=> 'Zurück',
					'delete' 		=> 'Löschen',
					'add'			=> 'Hinzufügen',
					'save'			=> 'speichern',
				),
				'index' => array(
					'meals'			=> 'Gerichte',
					'ingredients'	=> 'Zutaten',
					'lists'			=> 'Listen',
				),
				'view' => array(
					'back'			=> 'Zurück',
				),
			)
		);
		$defaultConfig  = Yii::app()->params['language']['default'];
		$languageConfig = Yii::app()->params['language']['selected'];
		$data = array_merge($data[$defaultConfig], $data[$languageConfig]);
		
		$return = $data;

		if($view
		&& isset($data[$view])
		) {
			$return = $data[$view];
		}
		return $return;
	}


	public function actionList() 
	{
		$modelClassName = $this->_getModelName();
		if(class_exists($modelClassName)) {
			$model = $modelClassName::model()->findAll();
			$this->_addViewProperty('model', $model);
			//$this->_addViewProperty('id', $id);
		    $this->_renderView();
		}
	}

	public function actionView($id) 
	{
		$modelClassName = $this->_getModelName();
		$modelFormName = ucfirst($modelClassName);
		$model = $modelClassName::model()->findByPk($id);
		$this->_addViewProperty('id', $id);
		$this->_addViewProperty('model', $model);
		$this->_renderView();
	}

	public function actionAdd()
	{
		$modelClassName = $this->_getModelName();
		$modelFormName = ucfirst($modelClassName);
		$model = new $modelClassName;

	    if(isset($_POST[$modelFormName]))
	    {
	        $model->attributes = $_POST[$modelFormName];
	        if($model->validate())
	        {
	            $model->save();
	            $this->redirect($this->_getListLink($this->id));
	        }
	    }
	    $this->_addViewProperty('model', $model);
	    $this->_renderView();
	}

	public function actionEdit($id) 
	{
		$modelClassName = $this->_getModelName();
		$modelFormName = ucfirst($modelClassName);
		$model = $modelClassName::model()->findByPk($id);

		if(isset($_POST[$modelFormName]))
	    {
	        $model->attributes = $_POST[$modelFormName];
	        if($model->validate())
	        {
	            $model->save();
	            $this->redirect($this->_getListLink($id));
	        }
	    }

		$this->_addViewProperty('model', $model);
		$this->_renderView();
	}

	public function actionDelete($id) 
	{
		$modelClassName = $this->_getModelName();
		$modelFormName = ucfirst($modelClassName);
		$model = $modelClassName::model()->findByPk($id);
		$model->delete();
		$this->redirect($this->_getListLink());
	}

	protected $_formName = 'IngredientForm';
	protected $_redirectUrl = '/ingredient';
	protected $_databaseName = 'ingredient';


	protected function _getDatabase($name = null) {
		if(is_null($name)) {
			$name = $this->_databaseName;
		}
		return DatabaseProvider::getInstance($name);
	}

	protected function _getKey($attributes = array()) {
		return md5(microtime());
	}

	// public function actionEdit($id)
	// {
	// 	$model = new $this->_formName;
	// 	if(isset($_POST[$this->_formName]))
	//     {
	//         $model->attributes = $_POST[$this->_formName];
	//         if($model->validate()) {
	//         	$db = $this->_getDatabase();
	//         	$db->updateEntry($id,$model->attributes);
	//         	$this->redirect($this->_redirectUrl);
	//         }
	//     } else {
	//     	$db = $this->_getDatabase();
	//     	if($db->keyExists($id)) {
	//     		$data = $db->readEntry($id);
	//     		$model->attributes = $data;
	//     	}
	//     }
		
	// 	$this->render('add',array('model'=>$model));
	// }
}