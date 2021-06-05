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
	    		<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/post/show_editpage/<?php echo $post_id; ?>" role="button">Edit</a>
	    		
	    		<a class="btn btn-primary" href="<?php echo base_url() ?>index.php/post/delete/<?php echo $post_id; ?>" role="button">Delete</a>
	        <?php } ?>
	    	</p>
	    <?php } ?>
    </div>
</div>
<hr class="post-break-hr">
    <!-- 評論區 -->
