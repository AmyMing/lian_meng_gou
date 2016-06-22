<?php
/**
* 商品类   
*/
class Goods extends CI_Controller
{
	

	public function __construct(){
		parent::__construct();
		$this->load->model('goods_model');
	}
	/*
		获取目前上品列表
	 */
	public function getGoods(){
		$orderKey = $this->input->get_post("orderKey");
		$orderType = $this->input->get_post("orderType");
		$goods = $this->goods_model->getGoods($orderKey,$orderType);
		exit(json_encode($goods));
	}


	/*
		购买商品
	 */
	public function buyGoods(){
		$openId = $this->input->get_post("openId");
		$unionId = $this->input->get_post("unionId");
		$goodsId = $this->input->get_post("goodsId");
		$goodsAmount = $this->input->get_post("goodsAmount");
		$res = $this->goods_model->setOrders($openId,$unionId,intval($goodsId),intval($goodsAmount));
		exit(json_encode($res));

	}

}