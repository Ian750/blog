<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
     <?php $this->load->view('partial/home/common/header'); ?>
</head>
<body>
<!--navbar-->


<!--end navbar-->
<div class="container-costom">
    <div class="row-costom">
        <div class="left-box">
           <?php $this->load->view('partial/home/common/sidebar'); ?>
        </div>
            <div class="middle-box">
                <?php
                if($page_body === "part"){
                    $this->load->view('partial/home/body/part');
                }else if($page_body === 'create_post'){
                    $this->load->view('partial/home/body/create_post');
                }else if($page_body === 'view_post'){
                    $this->load->view('partial/home/body/view_post');
                }else if($page_body === 'edit_post'){
                    $this->load->view('partial/home/body/edit_post');
                }else if($page_body === 'profile_view'){
                    $this->load->view('partials/home/body/profile_view');
                }else if($page_body === 'errors'){
                    $this->load->view('partials/home/body/errors');
                }
                ?>
            </div>
        <div class="right-box">右邊欄位</div>
    </div>
</div>
</body>
</html>