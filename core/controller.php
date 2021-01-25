<?php
class Controller {
	public $model;
	public $view;
	
	function __construct()
	{
		$this->model = new Model();
		$this->view = new View();
	}

	function checkAuth()
	{
		$result = $this->model->checkUser();
		if(is_null($result))
		{
			return false;
		}
		else {
			return true;
		}
	}
}