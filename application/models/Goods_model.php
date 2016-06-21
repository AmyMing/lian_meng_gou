<?php
 /**
 * 商品类模型
 */
 class Goods_model extends CI_Model
 {
 	public function getGoods(){
 		$sql = "SELECT * FROM `goods` WHERE `status` = 0";
 		$res = $this->db->query($sql)->result_array();
 		return $res;
 	}
 }