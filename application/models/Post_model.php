<?php

class Post_model extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
	}

	    public function get_all(){
	    	// $query = $this->db->get('posts');
	    	// return $query->row_array();

	        $this->db->select('posts.*, users.fullname AS author_name');
	        $this->db->join('users', 'posts.author_id = users.id');
	        $result = $this->db->get('posts', 6);
        	return $result->result();
    }
}