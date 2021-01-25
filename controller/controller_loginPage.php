<?php
class controller_loginPage extends Controller
{	
	function __construct()
	{
        require_once 'model/model_loginPage.php';
        $this->model = new model_loginPage();
		$this->view = new View();
	}
	
	function createPage(string $viewName)
	{
		$this->view->generate('loginPage.php');
	}
	

    // Функция для генерации случайной строки
    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    } 

    function login(){
        $hash = md5($this->generateCode(10));

        $login = $this->model->getUser($_POST['login'], md5(md5($_POST['password'])),$hash, str_replace('.', '', $_SERVER['REMOTE_ADDR']));
        if($login)
        {
            setcookie("id", $login, time()+60*60*24*30, "/");
            setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!         
            header("Location: /index.php?page=1");
        }
        else
        {
            print "<b>Вы ввели неверные данные</b><br>";        
        }
    }
}
