<?php
class model_imagePage extends Model
{	
    function deleteComment($commentsFile, $comment)
    {
        $messages = [];
        $errors = [];

        if (file_exists($commentsFile)) 
        {
            $deletedComment = $comment;
            $deletedComment = trim($deletedComment);
            $file = file($commentsFile);

            //delete line breaks
            $arrayToReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n");
            $newFile = str_replace($arrayToReplace, "", $file);   
            
            //find comment to delete
            if (in_array($deletedComment, $newFile))
            {
                $key = array_search($deletedComment, $newFile); //delete comment
                unset($newFile[$key]);       
                //add line breaks
                $newContent = implode("\n", $newFile);
                $newContent = $newContent."\n";
                //write to file
                file_put_contents($commentsFile, $newContent);   
                array_push($messages, 'Комментарий был удалён'); 
                var_dump($messages);
            }
            else {
                echo $errors[] = 'Комментарий не найден';
            }

            $this->deleteCommentFromDataBase($deletedComment);
        }
        else {
            print 'Файл не найден';
        }
    }

    function deleteCommentFromDataBase($comment)
    {
        $bSuccess = false;

        $sql = "delete from comments where comment_text= '" .$comment."';";
        $dateBase = getDataBase();
        $result =  $dateBase ->exec($sql); 
        if($result)
        {
            $bSuccess = true;
        }
         
        return $bSuccess; 
    }

    function addCommentToDataBase($userLogin, $imageName, $comment)
    {
        $bSuccess = false;

        $sql = "insert into comments(user_login, image_name, comment_text) 
        values ('".$userLogin."', '".$imageName."', '".$comment."');"; 
        $dateBase = getDataBase();
        $result =  $dateBase ->exec($sql); 
        if($result)
        {
            $bSuccess = true;
        }

        return $bSuccess; 
    }

    function addComment($commentsFile, $comment)
    {
        setlocale(LC_TIME, 'ru-Latn');
        $bCommentAdded = false;
        
        //if empty comment
        if($comment !== '')
        {
            //delete line breaks
            $arrayToReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n");
            $comment = str_replace($arrayToReplace, "", $comment);
            $commentText = $comment;
            $user_name = $this->checkUser();

            if (is_null($user_name))
            {
                $comment =  date("D M j G:i:s T Y").":"." Без имени ".$comment;
                $comment = trim($comment);
            }
            else
            {
                 $comment =  date("D M j G:i:s T Y").":".$user_name. " " .$comment;
            }

            //add comment
            file_put_contents($commentsFile,$comment."\n",FILE_APPEND);

            $imageName = $_GET['fileName'];            
            $this->addCommentToDataBase($user_name, $imageName, $commentText);
            $bCommentAdded =  true;
        }
        
        return $bCommentAdded;
    }                   

    // проверяем, залогинен ли пользователь
	public function checkUser()
	{
		if(isset($_COOKIE['id']))
		{
            $dateBase = getDataBase();
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
        $dateBase = getDataBase();
        $sql = "select user_login from users where user_login= '".$UserName."' LIMIT 1";
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

    function getDataBase()
	{
		$dateBase = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
		return $dateBase;
	}
}