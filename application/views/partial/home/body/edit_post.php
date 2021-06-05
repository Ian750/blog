<div class="post-update-form" ng-controller="postController">
    <p class="post-create-form-title">編輯文章</p>
    <?php
        echo form_open_multipart('post/edit');
    ?>
        <div class="form-group">
            <input type="hidden" name="posts_id" value="<?php echo $post_id; ?>">
            標題：
            <input type="text" name="title" placeholder="標題" class="form-title-input form-control-plaintext" required value="<?php echo $title; ?>">
        </div>
        
        <div class="form-group">若無重新上傳封面圖片，將沿用舊圖：
            <input type="file" name="image">
            <img src="<?php echo base_url() ?>uploads/image/<?php echo $image; ?>">
        </div>
        <div class="form-group">
            內容：
            <textarea name="content" id="" cols="30" rows="10" class="form-content-input" placeholder="文章內容" required><?php echo $content;?>
            </textarea>
        </div>
         <p style="text-align:right;">
            <button class="btn btn-primary">更新</button>
        </p> 
    <?php
        echo form_close();
    ?>
</div>