<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
	}

    //初始頁面index.php
    public function index(){
        if($this->session->userdata('islogin')){
            redirect('home');
        }else{
            $this->load->view('pages/home/login');
        }
    }
    //導至註冊畫面
    public function showregister(){
        if($this->session->userdata('islogin')){
            redirect('home');
        }else{
            $this->load->view('pages/home/register');
        }
    }

    //登入
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->form_validation->set_rules('username', 'Usename', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]');
            if($this->form_validation->run()){
                //查詢資料庫
                try{
                     $getuserdata = $this->user_model->get_user();
                    if($getuserdata->num_rows() === 1){
                        $userdata = $getuserdata->result();
                        $data = array(
                            'userid' => $userdata[0]->user_id,
                            'username' => $userdata[0]->username,
                            'fullname' => $userdata[0]->fullname,
                            'islogin' => true
                        );
                        $this->session->set_userdata($data);
                        redirect('home');
                    }else if($getuserdata->num_rows() === 0){
                        $data = array(
                            'firstlogin'=> true
                        );
                        $this->session->set_userdata($data);
                        $this->load->view('pages/home/login');
                    }else{
                        throw new \Exception("Something error");
                    }
                }catch(\Exception $e){//如何處理exception?
                    die($e->getMessage());
                    // echo $e;
                }
            }else{
                 echo "validation error";
            }
        }else{
            echo "Request method error";
        }
    }

    //登出
    public function logout(){
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('fullname');
            $this->session->unset_userdata('islogin');
            redirect('home');
        }else{
            echo "Request method error";
        }
    }

    //註冊
    public function register(){
        // $this->load->helper('form');
        // $this->load->library('form_validation');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //新增檢核 前端畫面student_name及text必須有值
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('fullname', 'Name', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
            if($this->form_validation->run()){
                $getuserdata = $this->user_model->get_user();
                if($getuserdata->num_rows() === 0){//若帳號不存在
                    $getnewuser = $this->user_model->register();
                    $data = array(
                        'userid' => $getnewuser[0],
                        'username' => $getnewuser[1],
                        'fullname' => $getnewuser[2],
                        'islogin' => true
                    );
                $this->session->set_userdata($data);
                redirect('home');
                }else{//帳號重複
                    $data = array(
                        'existed'=> true
                    );
                    $this->session->set_userdata($data);
                    $this->load->view('pages/home/register');
                }
            }else{
                echo "validation error";
            }
        }

    }
}

?>