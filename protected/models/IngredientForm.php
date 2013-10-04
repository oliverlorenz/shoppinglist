<?php

class IngredientForm extends CFormModel
{
	public $nameSingular;
	public $namePlural;
	public $unit;

	public function rules()
	{
		return array(
			array('nameSingular, namePlural, unit', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'nameSingular' 	=> 'Name (Einzahl)',
			'namePlural' 	=> 'Name (Mehrzahl)',
			'unit' 			=> 'Einheit',
		);
	}
}
