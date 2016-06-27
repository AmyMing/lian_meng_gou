<?php


class User_model extends CI_Model {

	private $tableName = 'lianmenggouUsers';
    public function saveUsers($info){
    	//判断是否新用户
    	$lianmenggouId = md5($info['pingtaiOpenId'].$info['pingtaiName']);
    	$info['lianmenggouId'] = $lianmenggouId;
    	$ifNewUsers = $this->db->select("id")->where(array("lianmenggouId"=>$lianmenggouId))->get("lianmenggouUsers")->num_rows();
    	
		if($ifNewUsers){
			$result = array("status"=>"0","info"=>"旧用户");
			return $result;
		}

		$res = $this->db->insert($this->tableName,$info);
		if($res){
			$result = array("status"=>"0","info"=>"保存成功");
			return $result;	
		}

		$result = array("status"=>1,"info"=>"数据库错误");
		return $result;

		
    }

}