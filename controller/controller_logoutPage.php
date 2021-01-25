<?php
class controller_logoutPage extends Controller
{	    
    function __construct()
	{
        $this->model = new Model();
	}    
    
	function logout()
	{
        $result = $this->model->checkUser();
		if(!is_null($result))
		{
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/",null,null,true); // httponly !!! 
            header("Location: /index.php?page=1");
		}
	}
}
