<?php
class controller_homePage extends Controller
{	
	private $fileList = [];
	private $errors = [];
	private $messages = [];
	
	function createPage(string $viewName)
	{
		$this->fileList = scandir(UPLOAD_DIR);
		$this->fileList = array_filter($this->fileList, function ($file) {
            return !in_array($file, ['.', '..', '.gitkeep']);});
            
		$this->view->generate('mainPage.php', $this->checkAuth(), $this->fileList);
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

	function uploadfile()
	{
		if ($this->checkAuth())
		{
			$errors = [];
			
			// add file
			if (!empty($_FILES)){
				foreach($_FILES as $file){
					$uploadedName = $file['tmp_name'][0];
					$fileDir = UPLOAD_DIR.'/'.$file['name'][0];
					
					// check size
					if ($file['size'][0] > UPLOAD_MAX_SIZE) {
						$errors[] = 'Недопостимый размер файла ' . $fileDir;
						continue;
					}
					// check format
					if (!in_array($file['type'][0], ALLOWED_TYPES)) {
						$errors[] = 'Недопустимый формат файла ' . $fileDir;
						continue;
					}   

					if (!move_uploaded_file($uploadedName, $fileDir)) {
						$errors[] = 'Ошибка загрузки файла ' . $fileName;
						continue;
					}          
				};

				if (empty($errors)) {
					print 'Файлы были загружены'.'</br>';
				}
				else {
					foreach($errors as $error)
					{
						print "Ошибка: ".$error.'</br>';
					}
				}

				unset($_FILES);
			}	
		}
	}

	function deleteFile()
	{
		if ($this->checkAuth())
		{
			$messages = [];
			$errors = [];
	
			if (!empty($_POST['name'])) {
				$filePath = UPLOAD_DIR.'/'.$_POST['name'];
				$commentFileName = str_replace("jpg", "txt", $_POST['name']);
				$commentsFile = COMMENT_DIR.'/'.$commentFileName; 
				
				if (file_exists($filePath)) {
					unlink($filePath);
					$messages[] = 'Файл '.$filePath.' был удален';
				} else { 
					$errors[] = 'Файл не найден '.$filePath;
				}

				if (file_exists($commentsFile)) {
					unlink($commentsFile);
					$messages[] = 'Комментарии к файлу были удалены';
				}
				else { 
					$errors[] = 'Файл c комментариями не найден '.$commentsFile;
				}
			
				foreach($errors as $error)
				{
					print "Ошибка: ".$error.'</br>';
				}
	
				foreach($messages as $message)
				{
					print "Удачно выполнено: ".$message.'</br>';
				}

				unset($_POST['name']);
			}
		}
	}
}