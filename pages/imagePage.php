<div class="row">
    <div class="col-12">
        <h2>Изображение:<?php echo $image ?></h2>
    </div>           
</div>
<div class="row justify-content-center">
    <img src="<?php echo UPLOAD_DIR. '/' .$image;?>" class="img-thumbnail" alt="<?php echo URL.UPLOAD_DIR. '/' .$image;?>">
</div>
<div class="row comments">
    <div class="col-12"><hr>
        <div class="row commentsList">
            <div class="col-md-12">
                <div class="row">
                    <h2>Комментарии:</h2><br>
                </div>
                <?php if (!count($data)>0):?>
                    <h3>Комментариев отсутствуют</h3>
                <?php endif; ?>
                <?php if (count($data)>0):?> 
                    <ul>                       
                        <?php 
                            foreach($data as $string):?>  
                            <li>
                                <form method="POST">
                                    <div>
                                        <textarea name ="commentToDelete"><?php echo $string;?> </textarea>
                                        <?php if ($bIsAdmin):?> 
                                            <button type = "submit" class = "close" aria-label = "Удалить" id = "deleteComment">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </form>   
                            </li>    
                        <?php endforeach; ?> 
                    </ul> 
                <?php endif;?>        
            <div>
        </div>
        <?php if($authorised):?> 
            <div class="row comment form">
                <div class="col-md-12">
                    <form method="POST">
                        <div class="form-group">
                            <textarea class="form-control" id="FormControlTextarea" rows="3" name="comment"></textarea>
                        </div>
                        <input name="submit" type="submit" value="Комментировать">
                    </form>
                </div>
            <div>
        <?php endif;?>  
    </div>
</div>