<?php

include_once ROOT.'/models/main.php';


class MainController
{
	
	public function actionIndex() {


		require_once(ROOT.'/views/index/index.php');

		return true;
	}
	public function actionCreate(){

		$createItem = array();
		$createItem = Admin::createItem($_POST);
		print_r($createItem);

		return true;
	}
}