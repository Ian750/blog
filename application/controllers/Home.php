<?php

class Home extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->library('session');
    }
    //首頁查出所有文章
    public function index(){
        $data['page_body'] = "part";
        $data['results'] = $this->Post_model->get_post();
        $this->load->view('pages/home/index', $data);
    }
    //個人頁查詢個人文章
    public function getProfile($user_id){
         $data['page_body'] = "part";
        $data['results'] = $this->Post_model->getAll_by_author_id($user_id);
        $this->load->view('pages/home/index', $data);
    }
}