<div class="row header justify-content-center">
    <div class="col-6  headerCol">
            <h1>Галерея изображений</h1>
    </div>
    <div class="row fileListH ">
        <div class="col-12 justify-content-center">
             <h2>Список файлов:</h2>
             <hr>
        <div>
    </div>
    <div class="row no-gutters imgRow">
        <!-- генерация галереи из фалов -->
        <?php if (!count($data)): ?>
            <h3>Картинок нет</h3>
        <?php endif; ?>
        <?php if (count($data)): ?> 
            <?php foreach($data as $file):?>    
                <div class="col-4  d-flex justify-content-center my-auto imgCol">
                    <a href="<?php echo URL."?page=5&fileName=".$file;?>" title="Перейти к изображению">
                        <img src="<?php echo URL.UPLOAD_DIR. '/' .$file;?>" class="img-thumbnail" alt="<?php echo URL.UPLOAD_DIR. '/' .$file;?>">
                    </a>
                    <form method="POST">
                        <input type="hidden" name="name" value="<?php echo $file; ?>">
                        <button type="submit" class="close" aria-label="Удалить" id="deleteImg">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </form>
                </div> 
            <?php endforeach; ?>
        <?php endif;?>            
    </div>
    <div class="row addFileForm">
        <div class="col-12"><hr>
            <div class="row justify-content-center">
                <div class="col-12">
                <form method="POST" enctype="multipart/form-data">
                    Загрузите вашу картинку: <br /><input name="files[]" type="file">
                    <input name="submit" type="submit" value="Загрузить" />
                </form>
                </div>               
            </div>    
            <hr>
        </div>            
    </div>
</div>