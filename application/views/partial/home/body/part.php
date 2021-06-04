<?php if($this->session->flashdata('create_success')){ ?>
    <div class="info-area">
        <?php echo $this->session->flashdata('create_success'); ?>
    </div>
<?php } ?> 

<!--每筆blog資訊-->
<?php foreach ($results as $row){ ?>
	<div class="post-card">
        <div class="post-header">
            <p class="post-title"><?php echo $row->title; ?></p>
            <p class="author">
            	By
            		<?php
                        if((int)$this->session->userdata('userid') === (int)$row->author_id){
                            echo "You";
                        }else{
                            echo $row->author_name;
                        }
                    ?>
            </p>
        </div>
         <div class="post-image">
            <img src="<?php echo base_url() ?>uploads/image/<?php echo $row->image; ?>">
         </div>
         <div class="post-text">
            <p>
                <?php echo substr($row->content, 0, 118);?>
            </p>
        </div>
    </div>
<?php } ?>