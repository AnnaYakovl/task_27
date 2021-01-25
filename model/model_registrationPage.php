<?php
class model_registrationPage extends Model
{	  
    //Проверям, существует ли пользователь
    function checkUserExistance(string $userLogin)
	{
        $userExist = true;
        
        $dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $sql = "select user_id from users where user_login = '$userLogin'"; 

        $result = $dateBase->query($sql);
        $resultArray = $result->FETCH(PDO::FETCH_NUM);

        if($resultArray === false)
        {
            $userExist = false;
        }  
        
        return $userExist;
    }

    //Создаём пользователя
    function createUser(string $userLogin, string $userPassword)
    {
        // Убираем лишние пробелы и делаем двойное хэширование (используем старый метод md5)
        $password = md5(md5(trim($userPassword)));         
        $sql = "insert into users(user_login, user_password) 
        values ('".$userLogin."', '".$password."');"; 
        $dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $result =  $dateBase ->exec($sql); 
        if($result)
        {
            return true;
        }  
        return false; 
    }
}?>