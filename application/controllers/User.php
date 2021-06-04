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
                            'userid' => $userdata[0]->id,
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

         // $this->form_validation->set_rules('Email','Name','required');
         // $this->form_validation->set_rules('password','text','required');
         // $this->form_validation->set_rules('fullname','text','required');
         // $this->form_validation->set_rules('username','text','required');
         // $this->form_validation->set_rules('gender','text','required');

        //  $data['title'] = 'validation error';
        //  if ($this->form_validation->run()) {
        //     $this->User_model->register();
        //     // $this->load->view('pages/success',$data);
        //     // echo "success!";
        //     $this->load->helper('url');
        //     //導轉頁面
        //     redirect('pages/view');
        //  }else{
        //    // $this->load->view('templates/header', $data);
        //    // $this->load->view('pages/register');
        //    // $this->load->view('templates/footer');
        // }
    }





	/**
	 public function index(){
            $data['all_student'] = $this->Student_model->get_student();
            $data['title'] = 'All Students form controllers';

            $this->load->view('templates/header', $data);
            $this->load->view('class/index', $data);
            $this->load->view('templates/footer');
     }*/

    //查詢單筆 view.php
	public function view($number){
            $data['student'] = $this->Student_model->get_student($number);
            
            // show_error($data['student']);
          // $first = $data['student'][0]['name'];
			//show_error($first);

            if(empty( $data['student'])){
            	show_404();
            }
 
            //各別顯示
            $data['title'] = "Student：".$data['student']['name'];
       

            $this->load->view('templates/header', $data);
            $this->load->view('class/view', $data);
            $this->load->view('templates/footer');
    }

    //新增資料 create.php
    public function create(){
    	$this->load->helper('form');
    	$this->load->library('form_validation');

    	$data['title'] = 'Create a new student';

    	 //新增檢核 前端畫面student_name及text必須有值
    	 $this->form_validation->set_rules('student_name','Name','required');
    	 $this->form_validation->set_rules('text','text','required');

    	 if ($this->form_validation->run() === FALSE) {
    	 	
            $this->load->view('templates/header', $data);
            $this->load->view('class/create');
            $this->load->view('templates/footer');
    	 }else{
    	 	//成功就執行新增至資料庫，並顯示成功頁面
    	 	 $this->Student_model->set_students();
    	 	 $this->load->view('class/success',$data);
    	 }
    }

    //刪除資料
    public function remove(){
    	$this->load->helper('form');
    	$this->load->library('form_validation');

    	$data['title'] = 'Remove a new student';

    	$this->form_validation->set_rules('student_name','Name','required');

    	if ($this->form_validation->run() === FALSE) {
    		$this->load->view('templates/header', $data);
            $this->load->view('class/remove', $data);
            $this->load->view('templates/footer');
    	}else{
    		$data['title'] = 'Remove success!';
    		$this->Student_model->remove_students();
    	 	 $this->load->view('class/success',$data);
    	}
    }
}

?>