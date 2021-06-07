<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
    </head>
    <body>
        <div class="post-card">
            <div class="post-header">
        <?php
            $data = array(
                'class' => 'titleInput',
                'name' => 'signupForm'
            );
            echo form_open('user/register', $data);
            
        ?>
            <fieldset >
                <a href="<?php echo base_url(); ?>index.php/user/">Already have an account?</a>
                <legend>登入帳密</legend>
                    <?php $this->session->unset_userdata('firstlogin');?>
                    <?php if($this->session->userdata('existed')){ ?>
                                  <p style="color:red">帳號重複!</p>
                    <?php } ?>
                    <label>帳號：<input type="text" name="username" placeholder="Username" required pattern="[a-zA-Z0-9]{1,}")></label>
                    <label>密碼：<input type="password" name="password" placeholder="Password" required pattern="[a-zA-Z0-9]{1,}"></label>
                    <p style="color:#228B22">帳號密碼需為英文或數字</p>
            </fieldset>
            <fieldset>
                <legend>個人資訊</legend>
                    姓名：<label><input type="text" name="fullname" placeholder="Fullname" required min="1"></label>
                    信箱：<label><input type="email" name="email" placeholder="Email address" required ></label>
                    性別：<label><input type="radio" name="gender" value="0" checked>女</label>
                          <label><input type="radio" name="gender" value="1">男<br></label>
            </fieldset>
            <button type="submit">註冊</button>
        <?php echo form_close(); ?>
            </div>
        </div>    
           
    </body>
</html>