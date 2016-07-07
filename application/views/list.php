<!doctype html>
<html class="no-js fixed-layout">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Amaze UI Admin index Examples</title>
  <meta name="description" content="这是一个 index 页面">
  <meta name="keywords" content="index">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="http://amazeui.org/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.7.0/css/amazeui.min.css"/>
  <link rel="stylesheet" href="http://amazeui.org/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
  <![endif]-->

  <header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
      <strong>Amaze UI</strong> <small>后台管理模板</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

  </div>
</header>



<!-- content start -->
<div class="admin-content">
  <div class="admin-content-body">
    <div class="am-cf am-padding">
      <div class="am-fl am-cf">
        <strong class="am-text-primary am-text-lg">首页</strong>
      </div>
    </div>


  <hr>

<div class="am-g am-container">
<table class="am-table am-table-striped am-table-hover">
  <thead>
  <tr>
    <th>商品id</th>
    <th>商品名称</th>
    <th>商品类别</th>
    <th>期数</th>
    <th>约定人数</th>
     <th>当前人数</th>
     <th>百分比</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($data as $item):?>
  <tr>

    <td><?php echo $item['goods_id'];?></td>
    <td><?php echo $item['intro'][0]['goods_name'];?></td>
    <td><?php echo $item['intro'][0]['type'];?></td>
    <td><?php echo $item['current_amount'];?></td>
    <td><?php echo $item['limit_amount'];?></td>
    <td><?php echo $item['current_amount'];?></td>
    <td><?php echo $item['current_amount']/$item['limit_amount'];?></td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>

</div>
</div>
</div>

<footer class="admin-content-footer">
  <hr>
  <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
</footer>
</div>
<!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="http://amazeui.org/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="http://amazeui.org/js/amazeui.min.js"></script>
<script src="http://amazeui.org/js/app.js"></script>
</body>
</html>
