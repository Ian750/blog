<?php

class Post extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Post_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        
	}

    //初始頁面create_post.php
    public function index(){
        if($this->session->userdata('islogin')){
            $data['page_body'] = 'create_post';
            $this->load->view('pages/home/index', $data);
            

        }else{//若不是登入中，導回主頁
            redirect('home');
        }
    }

    //發表文章
    public function create(){
    	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    		$this->form_validation->set_rules('title', 'Title', 'required|min_length[1]');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[1]');
            if($this->form_validation->run()){
            	//uplooda image set
            	$config['upload_path'] = './uploads/image';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '0';
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                //載入upload函數
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image')) {
                        $error = array(
                            'error' => $this->upload->display_errors(),
                            'page_body' => 'errors'
                        );
                        $this->load->view('pages/home/index', $error);
                    } else {
                        $file = $this->upload->data();
                        $this->Post_model->insert($file);
                        redirect('home');
                    }
            }else{//發表文章驗證失敗，先在前端做處理
                echo "validation error";
            }
        }else{
            echo "Request method error";
        }
    }

    //首頁點擊read more
    public function view($post_id){
        if(isset($post_id)){
            $result = $this->Post_model->get_post($post_id);
            $row = $result->result()[0];
            //設定傳給前端的值，index.php為跳轉頁
            $data = array(
                'page_body' =>'view_post',
                'post_id'=>$post_id,
                'title' => $row->title,
                'author_id'=>(int)$row->author_id,
                'author_name' => $row->author_name,
                'image' => $row->image,
                'content' =>$row->content
            ); 
            $this->load->view('pages/home/index', $data);
            
        }else{
            $data = array(
                'error' => '<p>Data is invalid. Make sure data is fill up</p>',
                'page_body' => 'errors'
            );
            $this->load->view('pages/home/index', $data);
        }
    }


    //寫一個點編輯導編輯頁方法，或者跟上面index寫在一起
    public function show_editpage($post_id){
        if($this->session->userdata('islogin')){
            $result = $this->Post_model->get_post($post_id);
            $row = $result->result()[0];
            //設定傳給前端的值，index.php為跳轉頁
            $data = array(
                'page_body' =>'edit_post',
                'post_id'=>$post_id,
                'title' => $row->title,
                'author_id'=>(int)$row->author_id,
                'author_name' => $row->author_name,
                'image' => $row->image,
                'content' =>$row->content
            ); 
            $this->load->view('pages/home/index', $data);
        }else{//若不是登入中，導回主頁
            redirect('home');
        }
    }

    //執行更新編輯文章
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->form_validation->set_rules('title', 'Title', 'required|min_length[1]');
            $this->form_validation->set_rules('content', 'Content', 'required|min_length[1]');
            if($this->form_validation->run()){
                //uplooda image set
                $config['upload_path'] = './uploads/image';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '0';
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                //載入upload函數
                $this->load->library('upload', $config);
                //如果沒有重新新增圖片，就不修改
                if ( ! $this->upload->do_upload('image')) {
                       $this->Post_model->edit(FALSE);
                    } else {
                        $file = $this->upload->data();
                        $this->Post_model->edit($file);
                    }
                //導回原本view_post
               $post_id= $this->input->post('posts_id');
               $this->view($post_id);   
            }else{
                echo "validation error";
            }
        }else{
            echo "Request method error";
        }
    }

    //刪除
    public function delete($post_id){
        //再驗一次目前登入者為該篇作者
        if( $this->session->userdata('author_id') == $this->session->userdata('userid')){
            if(isset($post_id)){
            //回傳布林值
            $response = $this->Post_model->delete($post_id);
                if($response==true){
                    echo "Deleted successfully !";
                    redirect('home');
                }else{
                    $data = array(
                        'error' => '<p>Deleted Error</p>',
                        'page_body' => 'errors'
                    );
                    $this->load->view('pages/home/index', $data);
                }
            }
        }
    }
}
?>