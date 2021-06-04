<?php

class Post extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('post_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
	}

    //初始頁面create_post.php
    public function index(){
        if($this->session->userdata('islogin')){
            $data['page_body'] = 'create_post';
            $this->load->view('page/home/index', $data);
        }else{//若不是登入中，導回主頁
            redirect('home');
        }
    }

    public function create_post(){
    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    		$this->form_validation->set_rules('title', 'Title', 'required|min_length[1]');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[1]');
            if($this->form_validation->run()){
            	//uplooda image set
            	$config['upload_path'] = './uploads/image';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = 100;
                $config['max_width'] = 1024;
                $config['max_height'] = ;
            }
        }
    }

}
?>