<div class="post-update-form" ng-controller="postController">
    <p class="post-create-form-title">發表文章</p>
    <?php
        $catIds = array();
        echo form_open_multipart('post/create');
    ?>
        <div class="form-group">
            <input type="text" name="title" placeholder="標題" class="form-title-input form-control-plaintext" required>
        </div>
        
        <div class="form-group">請選擇文章封面圖片：
            <input type="file" name="image" required>
        </div>
        <div class="form-group">
            <textarea name="content" id="" cols="30" rows="10" class="form-content-input" placeholder="文章內容" required></textarea>
        </div>
        <p style="text-align:right;">
            <button class="btn btn-primary">發表文章</button>
        </p> 
    <?php
        echo form_close();
    ?>
</div>