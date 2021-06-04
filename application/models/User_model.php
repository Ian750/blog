<?php
/**
 * 
 */
class User_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	//登入查詢
	public function get_user(){
        $this->db->where('username', $this->input->post('username'));
        $this->db->where('password', $this->input->post('password'));
        $result = $this->db->get('users');
        return $result;
    }

	//會員註冊
	public function register(){
		//設定寫入參數
		$data = array(
			'password' => $this->input->post('password'),
			'fullname' => $this->input->post('fullname'),
			'username' => $this->input->post('username'),
			'Email' => $this->input->post('email'),
			'gender' => $this->input->post('gender')
		);
		//寫入資料庫
		$this->db->insert('users',$data);
		//回傳生成的id及寫入的username
		return array($this->db->insert_id(), $this->input->post('username'));
	}

}

?>