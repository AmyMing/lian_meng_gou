<?php
 /**
 * 商品类模型
 */
 class Goods_model extends CI_Model
 {

 	public function insertGoods($params){

 		$this->db->trans_start();


		$res = $this->db->insert('goods',$params);
		if($res){
 			$newParams['goods_id'] = $this->db->insert_id();
 			$newParams['current_times'] = 1;
 			$newParams['limit_amount'] = $params['limit_amount'];
 			$newParams['current_amount'] = 0 ;
 			$this->db->insert("new_goods_info",$newParams);
 			$id = $this->db->insert_id();
 			if($id){
 				echo "添加成功";	
 			}
 			else{
 				echo "添加失败,数据回滚";
 			}
 		}
 		
		$this->db->trans_complete();
 	}

 	public function addGoodsTimes($goods_id,$amount){
 		$sql = "SELECT * FROM `new_goods_info` WHERE `goods_id` = ".$goods_id." ORDER BY `create_time` desc LIMIT 1 ";
 		$res = $this->db->query($sql)->result_array();
 		if(empty($res)){
 			$params = array("goods_id"=>$goods_id,"amount"=>$amount,"times"=>1);	
 		}
 		else{
 			$params = array("goods_id"=>$goods_id,"amount"=>$amount,"times"=>$res[0]['times']+1);
 		}
 		$res = $this->db->insert("new_goods_info",$params);

 		if($res){
 			echo "添加成功";
 		}
 		else{
 			echo "添加失败";
 		}
 		
 	}

 	public function getGoods2(){
 		$sql = "SELECT * FROM new_goods_info ";
 		$res = $this->db->query($sql)->result_array();
 		foreach ($res as $key => $value) {
 			$sql = "SELECT * FROM `goods` WHERE `id` = ".$value['goods_id'];
 			$res[$key]['intro'] = $this->db->query($sql)->result_array();
 		}
		return $res;
 	}


 	public function getGoods($orderKey='create_time',$orderType='desc'){
 		if(!isset($orderKey))
 			$orderKey = 'create_time';
 		if(!isset($orderType))
 			$orderType = 'desc';
 		$orderKeysList = array("id","price","current_buyer_amount","create_time");
 		$orderTypeList = array("desc","asc");
 		if(in_array($orderKey, $orderKeysList) && in_array($orderType, $orderTypeList)){
 			$sql = "SELECT a.* ,b.* FROM `new_goods_info` as a,`goods` AS b WHERE a.amount != a.current_amount and a.goods_id = b.id  ORDER BY b.type desc ";
	 		$res = $this->db->query($sql)->result_array();
	 		foreach ($res as $key => $value) {
	 			$picList = explode(',',$value['goods_pic_url']);
	 			$detailPicList = explode(',', $value['goods_detail_pic_url']);
	 			$res[$key]['frontCover'] = $picList[0];
	 			$res[$key]['goods_pic_url'] = $picList;
	 			$res[$key]['goods_detail_pic_url'] = $detailPicList;
	 			unset($res[$key]['id']);
	 			unset($res[$key]['publisher_name']);
	 			unset($res[$key]['amount']);
	 			unset($res[$key]['times_id']);
	 			$sql = "SELECT count(*) as count FROM `new_goods_info` WHERE `goods_id` = ".$value['goods_id'];
	 			$count = $this->db->query($sql)->row()->count;
	 			$res[$key]['product_times'] = $count;
	 			$res[$key]['orders_info'] = array(
	 				"do_i_in"=>true,
	 				'my_num'=>1111,
	 				'Winning'=>array(
	 					"winer_name"=>"wuyingming",
	 					"winer_id"=>111,
	 					"winer_pic"=>'1111',
	 					"winer_address"=>"sssss",
	 					"winer_times"=>1,
	 					"winning_time"=>1111111,
	 					"Winning_no"=>1111111222));

	 		}
	 		return $res;
 		}

 		$res = array("status"=>"1","info"=>"非搜索关键字");
 		return $res;
 	}

 	
 	public function getOneGoodsDetail($goodsId){
 		$sql = "SELECT `id`,`goods_name`,`goods_pic_url`,`price`,`buyer_amount`,`current_buyer_amount`,`schedule`,`status` FROM `goods` where `id` = $goodsId";
 		$goodsInfo = $this->db->query($sql)->result_array();
 		$sql = "SELECT `unionId`,`amount`,`create_time` FROM `orders` WHERE `goods_id` = $goodsId";
 		$orderInfo = $this->db->query($sql)->result_array();
 	
 		$res['goodsInfo'] = $goodsInfo;
 		$res['orderInfo'] = $orderInfo;
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
 				return $res;
 			}
 			else{
 				$res['status'] = 1 ;
 				$res['info'] = 'More than total';
 				return $res;
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