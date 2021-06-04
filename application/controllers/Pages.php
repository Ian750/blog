<?php

class Pages extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
	}

	public function view($page = 'home')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		$data['title'] =ucfirst($page);//串入值改成大寫，確保找到該路徑

		$this->load->view('templates/header',$data);
		$this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
	}
}
?>