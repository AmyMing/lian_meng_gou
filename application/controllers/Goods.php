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
		$page = $this->input->get_post("page");
		$orderKey = $this->input->get_post("orderKey");
		$orderType = $this->input->get_post("orderType");
		$goods = $this->goods_model->getGoods($page,$orderKey,$orderType);
		exit(json_encode($goods));
	}

	/*
		获取某商品的详情
	 */
	public function getOneGoodsDetail(){
		$userId = $this->input->get_post("userId");
		$timesId = $this->input->get_post("timesId");
		$res = $this->goods_model->getOneGoodsDetail($userId,$timesId);
		exit(json_encode($res));
	}

	/*
		获取某期数的详情信息
		主要用于刷新  当前参与人数  我有没有参与此次夺宝
	 */
	public function fresh(){

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