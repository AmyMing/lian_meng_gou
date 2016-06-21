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
		$goods = $this->goods_model->getGoods();
		exit(json_encode($goods));
	}


	/*
		购买商品
	 */
	public function buyGoods(){
		$unionid = $this->input->get_post("unionid");
		$goodsId = $this->input->get_post("goodsId");
	}

}