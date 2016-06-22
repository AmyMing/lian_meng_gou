<?php
 /**
 * 商品类模型
 */
 class Goods_model extends CI_Model
 {
 	public function getGoods($orderKey='create_time',$orderType='desc'){
 		$orderKeysList = array("id","price","current_buyer_amount","create_time");
 		$orderTypeList = array("desc","asc");
 		if(in_array($orderKey, $orderKeysList) && in_array($orderType, $orderTypeList)){
 			$sql = "SELECT * FROM `goods` WHERE `status` = 0 ORDER BY $orderKey $orderType";
	 		$res = $this->db->query($sql)->result_array();
	 		return $res;
 		}
 		$res = array("status"=>"1","info"=>"非搜索关键字");
 		return $res;
 	}

 	public function setOrders($openId,$unionId,$goodsId,$goodsAmount){

 		//执行事务  插入到订单表  并更新商品表
 		$this->db->trans_start();
 		//是否超过了总数
 		$sql = "SELECT `buyer_amount`,`current_buyer_amount` FROM `goods` WHERE `id` = $goodsId";
 		$temp = $this->db->query($sql)->row();
 		$buyer_amount = $temp->buyer_amount;
 		$current_buyer_amount = $temp->current_buyer_amount;
 		if($current_buyer_amount+$goodsAmount > $buyer_amount){
 			$goodsAmount = $buyer_amount - $current_buyer_amount;
 			if($goodsAmount == 0){
 				$res['status'] = 1;
 				$res['info'] = 'No Product';
 			}
 			else{
 				$res['status'] = 'More than total';
 			}
 		}
 		else{
 			$res['status'] = 0;
 		}
 		$sql = "INSERT INTO `orders` SET `unionId` = '".$unionId."',`openId` = '".$openId."',`goods_id` = $goodsId,`amount` = $goodsAmount";
		$this->db->query($sql);
		$sql = "UPDATE `goods` SET `current_buyer_amount` = current_buyer_amount+$goodsAmount ,`schedule` =  (current_buyer_amount+$goodsAmount)/buyer_amount WHERE `id` = $goodsId";
		$this->db->query($sql);
		$this->db->trans_complete();

		//返回此用户此商品的交易记录
		$sql = "SELECT * FROM `orders` WHERE `unionId` = '".$unionId."' and `goods_id` = $goodsId";
		$orderInfo = $this->db->query($sql)->result_array();
		$sql = "SELECT * FROM `goods`  WHERE `id` = $goodsId";
		$goodsInfo = $this->db->query($sql)->result_array();
		$res['orderInfo'] = $orderInfo;
		$res['goodsInfo'] = $goodsInfo;

		return $res;

 	}
 }