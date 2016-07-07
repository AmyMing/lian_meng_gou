<?php
/**
* 
*/
class Admin extends CI_Controller
{
	
	function __construct()
	{	
		parent::__construct();

		if ( $_SERVER['PHP_AUTH_USER'] == 'lianmenggou'  && $_SERVER['PHP_AUTH_PW'] == 'yes' ) {
		} else {
		header('WWW-Authenticate: Basic realm=""');
		header('HTTP/1.0 401 Unauthorized');
		exit;
		}
		$this->load->model('goods_model');
	}

	public function index(){
		$this->load->view("admin.php");
	}

	public function goodsList(){
		$res = $this->goods_model->getGoods2();
		$this->load->view("list.php",array("data"=>$res));
	}

	public function addIndex(){
		$this->load->view("add.php");
	}

	public function insertIndex(){
		$this->load->view("insert.php");
	}
	/*
		添加商品
	 */
	public function insertGoods(){
		$params = $_POST;
		$data = $this->goods_model->insertGoods($params);
	}
	/*
		已知商品 添加期数
	 */
	public function addGoodsTimes(){
		$goods_id = $this->input->post("goods_id");
		$amount = $this->input->post("amount");

		$this->goods_model->addGoodsTimes($goods_id,$amount);
		
	}

	public function users(){
		echo "ss";
	}
}