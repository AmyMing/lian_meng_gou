<?php


class User_model extends CI_Model {

    public function saveUsers($unionid,$info){
    	//判断是否新用户
		$ifNewUsers = $this->db->select("id")->where(array("unionid"=>$unionid))->get("weixin_users")->num_rows();

		if($ifNewUsers){
			$result = array("status"=>"0","info"=>"旧用户");
			return $result;
		}


		$res = $this->db->insert('weixin_users',$info);
		if($res){
			$result = array("status"=>"0","info"=>"保存成功");
			return $result;	
		}

		$result = array("status"=>1,"info"=>"数据库错误");
		return $result;

		
    }

}