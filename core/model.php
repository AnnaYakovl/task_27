<?php
class Model
{
   // проверяем, залогинен ли пользователь
	public function checkUser()
	{
		if(isset($_COOKIE['id']))
		{
            $dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $sql = "select * from users where user_id= '".intval($_COOKIE['id'])."' LIMIT 1";
			$createResult = $dateBase->prepare($sql); 
            $createResult->execute();
			$userdata  = $createResult->FETCH(PDO::FETCH_ASSOC);     
            
            if($userdata)
			{			
				if(($userdata['user_hash'] !== $_COOKIE['hash']) or strcasecmp($userdata['user_hash'], $_COOKIE['hash']) !== 0)
				{
					setcookie("id", "", time() - 3600*24*30*12, "/");
					setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!

					return null;
				}
				else
				{
					return $userdata['user_login'];
				}
			}
			else
			{
				return null; 
			}
		}
		else
		{

			return null;
		}
	}

	public function getUserName(string $UserName)
	{
        $dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $sql = "select user_login from users where user_id= '".$UserName."' LIMIT 1";
		$createResult = $dateBase->prepare($sql); 
        $createResult->execute();
		$userdata  = $createResult->FETCH(PDO::FETCH_NUM);    
        
        if(strlen($userdata[0])>0) 
		{
			return $userdata[0]; 
		}	
		else
		{
			return null;
		}	
	}	
}