<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model("user_model");
	}

	
	/*
		平台登录 保存平台返回的用户信息
	 */
	public function saveInfo(){
		$infoTemp = file_get_contents("php://input");

		if(!$infoTemp){
			$result = array("status"=>1,'info'=>"no params");
			exit(json_encode($result));
		}

		$info = json_decode($infoTemp,true);
		$result = $this->user_model->saveUsers($info);

		//$this->load->library('session');
		//$this->session->set_userdata($info);

		exit(json_encode($result));
	}

}
