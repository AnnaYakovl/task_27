<?php
class controller_imagePage extends Controller
{	
    private $commentsList = [];
    private $commentsFile;
	
    function __construct()
	{
        require_once 'model/model_imagePage.php';
        $this->model = new model_imagePage();
        $this->authorised = $this->checkAuth();
        $this->view = new View();
	}       
    
    private function createCommentsSet($fileName)
	{
        $lines = [];
        if(file_exists($fileName))
        {               
            $lines = file_get_contents($fileName);
            $lines = explode("\n", file_get_contents($fileName));   
            for ($i = count($lines) - 1; $i > -1; $i--)
            {
                if ($lines[$i] == "")
                {
                   unset($lines[$i]); 
                }                
            }  
        }
        return $lines;
	}
	
	function createPage(string $viewName)
	{
        if(!empty($_GET['fileName']))
        {
            $commentFileName = str_replace("jpg", "txt", $_GET['fileName']);
            $commentsFile = COMMENT_DIR.'/'.$commentFileName; 
            if (file_exists($commentsFile))
            {
                $this->commentsList = $this->createCommentsSet($commentsFile);
            }
            $this->view->generate('imagePage.php', $this->authorised, $this->commentsList, $_GET['fileName']);
        }
        else
        {
            print "Картинка не найдена";
        }
    }

    function createComment(){
        if (!empty($_POST['comment']) && $this->checkAuth())
        {
            if(!empty($_GET['fileName']))
            {
                $commentFileName = str_replace("jpg", "txt", $_GET['fileName']);
                $commentsFile = COMMENT_DIR.'/'.$commentFileName; 
                $newComment = $this->model->addComment($commentsFile, $_POST['comment']);
                if($newComment)
                {
                    print "Комментарий создан";
                }
                else
                {
                    print "Комментарий не создан";               
                }
            }
            else
            {
                print "Нет файла </br>";
            }
        }
    }

    function deleteComment()
    {
        if (!empty($_POST['commentToDelete']) && $this->checkAuth())   
        {
            if(!empty($_GET['fileName']))
            {
                $commentFileName = str_replace("jpg", "txt", $_GET['fileName']);
                $commentsFile = COMMENT_DIR.'/'.$commentFileName; 
                $this->model->deleteComment($commentsFile,$_POST['commentToDelete']);
            }
            else
            {
                print "Нет файла </br>";
            }
        }   
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