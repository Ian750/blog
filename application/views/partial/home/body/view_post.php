<div class="post-card">
    <div class="post-header">
        <p class="post-title"><?php echo $title; ?></p>
        <p class="author" style="color:red; text-align:right;" >
        	By
        		<?php
                    if((int)$this->session->userdata('userid') === $author_id){
                        echo "You";
                    }else{
                        echo $author_name;
                    }
                ?>
        </p>
    </div>
     <div class="post-image">
        <img src="<?php echo base_url() ?>uploads/image/<?php echo $image; ?>">
     </div>
     <div class="post-text">
        <p>
            <?php echo $content;?>
        </p>
    </div>
    <div>

    	<?php if($this->session->userdata('islogin')){ ?>
    		<p style="text-align:right;">
	    	<?php if($this->session->userdata('userid') == $author_id){ ?>
	    		<?php
                    $data = array(
                        'author_id' => $author_id
                    );
                    $this->session->set_userdata($data);
                ?>
	    		<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/post/show_editpage/<?php echo $post_id; ?>" role="button">編輯文章</a>
	    		
	    		<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/post/delete/<?php echo $post_id; ?>" role="button">刪除文章</a>
	        <?php } ?>
	    	</p>
	    <?php } ?>
    </div>

<br>
    <!-- 評論 -->
<?php if($this->session->userdata('islogin')){ ?>
    <div class="comment-input-area">
                <?php echo form_open('post/comment/' . $post_id); ?>
                <div class="form-area">
                    <div class="form-comment-box">
                        <p>
                            <textarea class="form-content-input" name="comment" rows="5" id="comment" required></textarea><nobr>
                        </p>
                    </div>                    
                </div>
                <p style="text-align:right;">
                   <button type="submit" class="btn btn-primary btn-primary-costom">新增評論</button>   
                </p>   
                <?php echo form_close(); ?>
            </div>
<?php }else{ ?>
    <p style="text-align:right;"><a href="<?php echo base_url(); ?>index.php/user">登入</a>進行評論</p>
<?php } ?>  

<br><hr class="post-break-hr">    
    <!-- 現有評論 -->
    <?php if(count($All_comment) > 0){ ?>
        <?php foreach ($All_comment as $comment_row){ ?>
            <div class="comments-show-area">
                    <div class="comment-content">
                        <p class="comment-text">
                            <?php echo $comment_row->comment ?>
                        </p>
                        <p class="author" style="color:red; text-align:right;" >
                            Comment By
                                <?php
                                    if((int)$this->session->userdata('userid') === (int)$comment_row->author_id){
                                        echo "You";
                                    }else{
                                        echo $comment_row->author_name;
                                    }
                                ?>
                        </p>
                    </div>
                </div>
         <?php } ?> 
     <?php }else{ ?> 
        <p class="author">No Comment</p>
     <?php } ?>   
</div>  
