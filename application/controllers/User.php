<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/*
		微信登录,保存微信返回的用户信息
		wxInfo 客户端传来的用户信息 json结构
	 */
	public function saveInfo()
	{
		$infoTemp = file_get_contents("php://input");
		$info = json_decode($infoTemp,true);
		$info['privilege'] = json_encode($info['privilege']);

		$unionid  = $info['unionid'];
			
		//判断是否新用户
		$ifNewUsers = $this->db->select("id")->where(array("unionid"=>$unionid))->get("weixin_users")->num_rows();

		if($ifNewUsers){
			$result = array("status"=>"0","info"=>"旧用户");
			exit(json_encode($result));
		}
		$this->db->insert('weixin_users',$info);
		$result = array("status"=>"0","info"=>"保存成功");

		$this->load->library('session');
		$this->session->set_userdata($info);
		exit(json_encode($result));
	}
}
