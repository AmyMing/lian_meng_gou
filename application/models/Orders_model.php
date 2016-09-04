<?php
 /**
 * 商品类模型
 */
 class Orders_model extends CI_Model
 {

 	public function setOrders($userId,$orderList){
 		foreach ($orderList as $key => $value) {
 			$sql = "SELECT `numbers` FROM `new_orders` WHERE `times_id` = ".$value['timesId']." ORDER BY `id` DESC LIMIT 1";
 			$numbers = $this->db->query($sql)->row()->numbers;
 			$new_numbers = '';
 			$temp = explode(' ', $numbers);
 			if($numbers){
 				for ($i=0; $i <= $value['amount']; $i++) { 
 					if($i == $value['amount']){
	 					$new_numbers .= end($temp) + $i;	
	 				}
	 				else{
	 					$new_numbers .= end($temp) + $i .",";
	 				}
 				}
 			}else{
 				for ($i=1; $i <= $value['amount'] ; $i++) { 
 					if($i === $value['amount']){
 						$new_numbers .= 10000000 + $i;
 					}
 					else{
 						$new_numbers .= 10000000 + $i . ",";
 					}
 				}
 			}
 			$sql = "INSERT INTO `new_orders` SET `lianmeng_id` = '".$userId."' ,`numbers` = '".$new_numbers ."',`times_id` = ".$value['timesId'].",`order_amount` = ".$value['amount'].",`client_time` = '".$value['clientTime']."'";
	 		$res = $this->db->query($sql);
	 		

 		}
 		$sql = "SELECT * FROM `new_orders` WHERE `lianmeng_id` = '".$userId."' and `times_id` = ".$value['timesId'];
	 	$orderList = $this->db->query($sql)->result_array();
 		return $orderList;

 	}

 /*	public function setOrders($userId,$timesId,$amount,$clientTime){
 		$sql = "SELECT `numbers` FROM `new_orders` WHERE `times_id` = $timesId ORDER BY `id` DESC LIMIT 1";
 		$numbers = $this->db->query($sql)->row()->numbers;
 		$new_numbers = '';
 		$temp = explode(' ', $numbers);
 		if($numbers){
 			//加的那种
 			for ($i= 1; $i <= $amount; $i++) { 
 				if($i == $amount){
 					$new_numbers .= end($temp) + $i;	
 				}
 				else{
 					$new_numbers .= end($temp) + $i ." ";
 				}
 				
 			}
 		}
 		else{
 			for ($i= 1; $i <= $amount; $i++) { 
 				if($i == $amount){
 					$new_numbers .= 10000000+$i;
 				}
 				else{
 					$new_numbers .= 10000000 + $i ." ";	
 				}
 				
 			}		
 		}
 		$sql = "INSERT INTO `new_orders` SET `lianmeng_id` = '".$userId."' ,`numbers` = '".$new_numbers ."',`times_id` = $timesId,`order_amount` = $amount,`client_time` = '".$clientTime."'";
 		$res = $this->db->query($sql);
 		
 		$sql = "SELECT * FROM `new_orders` WHERE `lianmeng_id` = '".$userId."' and `times_id` = $timesId";
 		$data = $this->db->query($sql)->result_array();
 		return $data;
 		
 	}*/
 	
 }