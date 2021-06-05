<?php

class Post_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	//首頁取所有文章
    public function get_post($post_id = -1){
    	if($post_id == -1){
    		$this->db->select('posts.*, users.fullname AS author_name');
	        $this->db->join('users', 'posts.author_id = users.user_id');
	        $result = $this->db->get('posts', 6);
        	return $result->result();
    	}else{
    		$this->db->select('posts.*, users.fullname AS author_name');
	        $this->db->where('posts.posts_id', $post_id);
	        $this->db->join('users', 'posts.author_id = users.user_id');
	        $result = $this->db->get('posts');
	        return $result;
    	}
	        

    }
	//新增文章
	public function insert($file){
        $data['title'] = $this->input->post('title');
        $data['author_id'] = $this->session->userdata('userid');
        $data['image'] = $file['file_name'];
        $data['content'] = $this->input->post('content');

        date_default_timezone_set('Asia/Taipei'); 
        $now = date('Y-m-d H:i:s');
        
        $this->db->set('create_date', $now);
        $this->db->insert('posts', $data);
    }

    //編輯文章
    public function edit($file){
    	$data['posts_id'] = $this->input->post('posts_id');
    	$data['title'] = $this->input->post('title');
        if($file){
            $data['image'] = $file['file_name'];
            $this->db->set('image', $data['image']);
        }
    	$data['content'] = $this->input->post('content');

        date_default_timezone_set('Asia/Taipei');
        $now = date('Y-m-d H:i:s');

    	$this->db->set('title', $data['title']);
    	$this->db->set('content', $data['content']);
        $this->db->set('update_date', $now);
    	$this->db->where('posts_id',$data['posts_id']);
        $this->db->update('posts');
    }

	//刪除文章
	public function delete($post_id){
		$this->db->where("posts_id", $post_id);
	    $res = $this->db->delete("posts");
	    return $res;
    }


}