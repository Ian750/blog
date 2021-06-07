<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login Page</title>

    </head>
    <body>
        <!-- 登入 -->
        <div class="post-card">
            <div class="post-header">
                <fieldset >
                    <legend>登入</legend>
                        <?php $this->session->unset_userdata('existed');?>
                        <p>Don’t have an account? <a href="<?php echo base_url(); ?>index.php/user/showregister">Sign Up Now!</a></p>

                        <?php
                            $data = array(
                                'class' => 'loginForm',
                                'name' => 'loginForm'
                            );
                            echo form_open('user/login', $data);
                        ?>
                        <?php if($this->session->userdata('firstlogin')){ ?>
                              <p style="color:red">帳號或密碼錯誤!</p>
                        <?php } ?>

                        <label>帳號：<input type="text" name="username" placeholder="Username" required  pattern="[a-zA-Z0-9]{1,}"><br></label>
                        <label>密碼：<input type="password" name="password" placeholder="Password" required  pattern="[a-zA-Z0-9]{1,}"><br></label>
                        <p style="color:#228B22">帳號密碼需為英文或數字</p>
                </fieldset>
                    <button type="submit">登入</button>
                         <?php echo form_close(); ?>
            </div>
        </div>          
    </body>
</html>