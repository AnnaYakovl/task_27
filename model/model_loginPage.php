<?php
class model_loginPage extends Model
{	   
    //Проверям, существует ли пользователь
    function getUser(string $userLogin, string $password, string $hash, string $Insip='')
	{
        $dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        // проверяем, не существует ли пользователя с таким именем
        $sql = "select user_id, user_password from users where user_login = '$userLogin' LIMIT 1";
        $result = $dateBase->query($sql);
        $resultArray = $result->FETCH(PDO::FETCH_ASSOC);     
        if($resultArray['user_password']===md5(md5($_POST['password'])))
        {
            // Записываем в БД новый хеш авторизации и IP
            $sql = "update users set user_hash='".$hash.$Insip." where user_id= ".$resultArray['user_id']."';";          
            $createResult = $dateBase->prepare($sql); 
            $createResult->execute();
            if($createResult->rowCount()>0)
            {
                return $resultArray['user_id'];
            }  
            return null;
        } 
        else 
        {
            return null;
        }              
    }
}?>
