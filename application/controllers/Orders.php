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
		$userId = $this->input->get_post("userId");
		$timesId = $this->input->get_post("timesId");
		$amount = $this->input->get_post("amount");
		$clientTime = $this->input->get_post("clientTime");

		$res = $this->orders_model->setOrders($userId,$timesId,$amount,$clientTime);
		echo json_encode($res);
	}

}