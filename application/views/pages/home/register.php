<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
    </head>
    <body>
        
        <?php
            $data = array(
                'class' => 'titleInput',
                'name' => 'signupForm'
            );
            echo form_open('User/register', $data);
            
        ?>
            <fieldset >
                <a href="<?php echo base_url(); ?>index.php/user/">Already have an account?</a>
                <legend>登入帳密</legend>
                    <?php $this->session->unset_userdata('firstlogin');?>
                    <?php if($this->session->userdata('existed')){ ?>
                                  <p style="color:red">帳號重複!</p>
                    <?php } ?>
                    <label>帳號：<input type="text" name="username" placeholder="Username" required pattern="[a-zA-Z0-9]{1,}")><br></label>
                    <label>密碼：<input type="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9]{1,}"><br></label>
                    <!--<label>確認密碼：<input type="password" name="checkPassword" placeholder="請再次輸入密碼"></label>-->
            </fieldset>
            <fieldset>
                <legend>個人資訊</legend>
                    姓名：<label><input type="text" name="fullname" placeholder="Fullname" required min="1"><br></label>
                    信箱：<label><input type="email" name="email" placeholder="Email address" required ><br></label>
                    性別：<label><input type="radio" name="gender" value="0" checked>女</label>
                        <label><input type="radio" name="gender" value="1">男<br></label>
                    <!--自介：<br><textarea name="about" rows="8" cols="80"></textarea><br>-->
            </fieldset>
            <button type="submit">註冊</button>
        <?php echo form_close(); ?>
            
           
    </body>
</html>