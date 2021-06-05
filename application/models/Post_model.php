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
	        $result = $this->db->get('posts');
        	return $result->result();
    	}else{
    		$this->db->select('posts.*, users.fullname AS author_name');
	        $this->db->where('posts.posts_id', $post_id);
	        $this->db->join('users', 'posts.author_id = users.user_id');
	        $result = $this->db->get('posts');
	        return $result;
    	}	       
    }

    //個人首頁查詢個人blog
    public function getAll_by_author_id($author_id){
        $this->db->select('posts.*, users.fullname AS author_name');
        $this->db->join('users', 'posts.author_id = users.user_id');
        $this->db->where('author_id', $author_id);
        $result = $this->db->get('posts');
        return $result->result();
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

    //新增評論
    public function insert_comment($post_id){
        date_default_timezone_set('Asia/Taipei');
        $now = date('Y-m-d H:i:s');
        $data = array(
            'author_id' => $this->session->userdata('userid'),
            'author_name' => $this->session->userdata('fullname'),
            'post_id' => $post_id,
            'comment' => $this->input->post('comment'),
            'comment_createtime' => $now
        );
        $this->db->insert('comments', $data);
    }

    //查詢評論
     public function get_all_comment($post_id){
        $this->db->where('post_id', $post_id);
        $results = $this->db->get('comments');
        return $results->result();
    }
}