<?php

class Home extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->library('session');
    }

    public function index(){
        $data['page_body'] = "part";
        // $data['message'] = "test";
        $data['results'] = $this->Post_model->get_post();
         // show_error($data['results'][0]['id']);
        $this->load->view('pages/home/index', $data);

    }
    // public function test(){
    //     echo "Test route <br>";
    //     $data['res'] = "Hi hello bye bye";
    //     $this->load->view('test/test', $data);
    // }
}