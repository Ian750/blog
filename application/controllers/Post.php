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
    		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[1]');
            if($this->form_validation->run()){
            	//uplooda image 偏好設定
            	$config['upload_path'] = './uploads/image';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '0';
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                //載入upload函數
                $this->load->library('upload', $config);
                try{
                    if ( ! $this->upload->do_upload('image')) {
                            //格式化錯誤
                            $error = array(
                                'error' => $this->upload->display_errors(),
                                'page_body' => 'errors'
                            );
                            $this->load->view('pages/home/index', $error);
                        } else {
                            $this->db->trans_begin();
                            $file = $this->upload->data();
                            $this->Post_model->insert($file);
                            if($this->db->trans_status() === TRUE){
                                $this->db->trans_commit();
                                redirect('home');
                            }else{
                                $this->db->trans_rollback();//交易出現異常
                            }
                        }
                }catch(\Exception $e){
                    $this->db->trans_rollback();//交易出現異常
                    die($e->getMessage());
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

            //查詢有哪些評論
            $All_comment = $this->getall_comment($post_id);

            //設定傳給前端的值，index.php為跳轉頁
            $data = array(
                'page_body' =>'view_post',
                'post_id'=>$post_id,
                'title' => $row->title,
                'author_id'=>(int)$row->author_id,
                'author_name' => $row->author_name,
                'image' => $row->image,
                'content' =>$row->content,
                'All_comment' => $All_comment,
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
        if(isset($post_id)){
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
        
    }

    //執行更新編輯文章
    public function edit(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[1]');
            $this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[1]');
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
                try{
                    $this->db->trans_begin();
                    if ( ! $this->upload->do_upload('image')) {
                           $this->Post_model->edit(FALSE);
                        } else {
                            $file = $this->upload->data();
                            $this->Post_model->edit($file);
                        }
                    //若無異常，導回原本view_post
                    if($this->db->trans_status() === TRUE){
                        $this->db->trans_commit();
                        $post_id= $this->input->post('posts_id');
                        $this->view($post_id);
                    }else{
                        $this->db->trans_rollback();
                    }
                }catch (\Exception $e){
                    $this->db->trans_rollback();
                    die($e->getMessage());
                }    
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
                try{ 
                    $this->db->trans_begin();
                    $response = $this->Post_model->delete($post_id);
                        if($this->db->trans_status() === TRUE){
                            $this->db->trans_commit();
                            redirect('home');
                        }else{
                            $this->db->trans_rollback();
                            $data = array(
                                'error' => '<p>Deleted Error</p>',
                                'page_body' => 'errors'
                            );
                            $this->load->view('pages/home/index', $data);
                        }
                }catch(\Exception $e){
                    $this->db->trans_rollback();
                    die($e->getMessage());
                }    
            }   
        }
    }

    //新增評論
    public function comment($post_id){
        if(isset($post_id)){
            if($_SERVER['REQUEST_METHOD'] === "POST"){
                $this->form_validation->set_rules('comment', 'Comment', 'trim|required|min_length[1]');
                if($this->form_validation->run()){
                    try{
                        $this->db->trans_begin();
                        $this->Post_model->insert_comment($post_id);
                        if($this->db->trans_status() === TRUE){
                            $this->db->trans_commit();
                            redirect('post/view/' . $post_id);
                        }else{
                           $this->db->trans_rollback(); 
                        }
                    }catch(\Exception $e){
                        $this->db->trans_rollback();
                        die($e->getMessage());
                    }
                }
            }else{
                $data = array(
                    'error' => '<p>Request method error</p>',
                    'page_body' => 'errors'
                );
                $this->load->view('page/home/index', $data);
            }
        }else{
            $this->load->view('page/home/index', $data);
        }
    }

    //查現有評論
    public function getall_comment($post_id){
        if(isset($post_id)){
            $Allcomment = $this->Post_model->get_all_comment($post_id);
            if($Allcomment > 1){
                return $Allcomment;
            }
        }else{
            $data = array(
                'error' => '<p>No post id define</p>',
                'page_body' => 'errors'
            );
            $this->load->view('page/home/index', $data);
        }
    }
}
?>