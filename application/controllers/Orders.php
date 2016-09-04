<?php
/**
* 商品类   
*/
class Orders extends CI_Controller
{
	

	public function __construct(){
		parent::__construct();
		$this->load->model('orders_model');
	}

	public function setOrders(){

		$params = file_get_contents('php://input');
		
		$paramsArr = json_decode($params,true);
		$userId = $paramsArr['userId'];
		$orderList = $paramsArr['orderList'];
		
		$res = $this->orders_model->setOrders($userId,$orderList);
		echo json_encode($res);
	}

}