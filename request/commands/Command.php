<?php

namespace platron\request\commands;

abstract class Command {
	
	const PLATRON_URL = 'https://www.platron.ru/';
	
	/** @var array */
	protected $errors = [];
	
	/**
	 * Предпроверка отправляемых полей
	 * @return boolean
	 */
	public function beforeValidate(){
		return true;
	}
	
	/**
	 * Добавить ошибку
	 * @param string $error
	 * @param int $errorCode
	 */
	protected function addError($error, $errorCode){
		$this->errors[$errorCode] = $error;
	}
	
	/**
	 * @return array Список ошибок
	 */
	public function getErrors(){
		return $this->errors;
	}
	
	public function getParameters() {
		$filledvars = [];
		foreach(get_object_vars($this) as $name => $value){
			if($value){
				$filledvars[$name] = $value;
			}
		}
		
		return $filledvars;
	}
}
