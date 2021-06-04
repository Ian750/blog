<div class="categories">
	<p class="categories-header">ToolBar</p>

	<div class="main-category-list">
		<div class="main-category-list-item">
			
			<!-- 大標題 -->
				<p>
		            <a class="nav-link" href="<?php echo base_url(); ?>index.php/home">Home</a>
		        </p>

		    <!-- 小標題 -->
		         <div class="sub-category-list">
                     <div class="sub-category-list-item">
				        <?php if($this->session->userdata('islogin')){ ?>
			                <p>
			                    <a href="<?php echo base_url(); ?>index.php/post/create">Post</a>
			                </p>
			                <p>
			                    <a href="<?php echo base_url(); ?>index.php/user/profile/<?php echo $this->session->userdata('userid'); ?>">Profile</a>
			                </p>
			                <p>
			                    <a href="<?php echo base_url(); ?>index.php/user/logout">LoginOut</a>
			                </p>
			            <?php }else{ ?>
			            	<?php $this->session->unset_userdata('firstlogin');?>
			                <p>
			                    <a href="<?php echo base_url(); ?>index.php/user">Login</a>
			                </p>
			            <?php } ?>
			      	</div>
                </div>       
	    </div>
	</div>
</div>