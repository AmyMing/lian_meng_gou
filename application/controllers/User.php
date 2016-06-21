<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model("user_model");
	}

	/*
		微信登录,保存微信返回的用户信息
		wxInfo 客户端传来的用户信息 json结构
	 */
	public function saveInfo()
	{
		$infoTemp = file_get_contents("php://input");

		if(!$infoTemp){
			$result = array("status"=>1,'info'=>"no params");
			exit(json_encode($result));
		}

		$info = json_decode($infoTemp,true);
		$info['privilege'] = json_encode($info['privilege']);

		$unionid  = $info['unionid'];
			
		$result = $this->user_model->saveUsers($unionid,$info);

		//$this->load->library('session');
		//$this->session->set_userdata($info);

		exit(json_encode($result));
	}
}
