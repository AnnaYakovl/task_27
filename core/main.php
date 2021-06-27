<?php

	$pages = ['homePage', 'registrationPage', 'loginPage', 'logoutPage','imagePage','404'];

class Main {

    static function showPage()
    {

		$pageNumber = '0';

		if (!empty($_GET['page'])) 
		{     
				$pageNumber = (int) $_GET['page'];     
		}
		
		$page_name = $pages[$pageNumber - 1];
		
		$controller_file = strtolower($page_name);
		$controller_name = "controller_".$page_name;
		$controller_path = "controller/controller_".$page_name.'.php';
		if(file_exists($controller_path))
		{
			include $controller_path;                
			$controller = new $controller_name;

			if (isset($_POST['submit'])&$pageNumber == 1)
			{
				$controller->uploadfile();
			}
			elseif (isset($_POST['name'])&$pageNumber == 1)
			{
				$controller->deleteFile();
			}
			elseif (isset($_POST['commentToDelete'])&$pageNumber == 5){
				$controller->deleteComment();
			}
			elseif (isset($_POST['submit'])&$pageNumber == 5){
				$controller->createComment();
			}
			elseif (isset($_POST['submit'])&$pageNumber == 2){
				$controller->registration();
			}
			elseif (isset($_POST['submit'])&$pageNumber == 3){
				$controller->login();
			}
			elseif ($pageNumber == 4){
				$controller->logout();
				$page_name = 'homePage';
				$controller_name = "controller_".$page_name;
				$controller = new $controller_name;
			}

		}
		
		$controller->createPage('pages/'.$page_name.'.php');
	}

	

    
}