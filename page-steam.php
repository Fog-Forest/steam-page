<?php

/**
 Template Name: Steam游戏库
 Template Author：老蘑菇&梨花镇的阿肾
 */

get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<style>
	#steam-game-div {
		margin: 0 5px;
		padding: 0;
	}

	.steam-game-item * {
		padding: 0;
		margin: 0;
	}

	/* 个人资料卡 */
	.steam-card-img {
		text-align: center;
		margin-top: 10px;
	}

	.steam-card-img a {
		display: inline-block;
	}

	.steam-card-img a img {
		width: 100%;
	}

	/* 彩色分割线 */
	.colorline {
		width: inherit;
		height: 5px;
		margin: 10px auto;
		background-size: 30px 30px;
		border: 1px solid #ff9191;
		background-image: linear-gradient(135deg, #ff9191 0%, #ff9191 25%, white 25%, white 50%, #ff9191 50%, #ff9191 75%, white 75%, white 100%);
	}

	/* 外层大盒子 */
	.steam-game-item {
		position: relative;
		width: 100%;
		min-height: 100px;
		margin: 5px 0;
		border-bottom: 1px solid #D3D3D3;
	}

	/* 游戏宣传图 */
	.steam-game-picture {
		float: left;
		margin-top: 10px;
	}

	.steam-game-picture img {
		width: 100%;
	}

	/* 游戏信息块 */
	.steam-game-info {
		float: left;
		margin: 10px 0 0 10px;
		max-width: 130px;
	}

	/* 游戏标题 */
	.steam-game-info .steam-game-title a {
		color: #6daaff;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
	}

	/* 游戏时长 */
	.steam-game-info .steam-game-meta {
		position: absolute;
		bottom: 10px;
		color: #fe9ab0;
		font-size: 12px;
	}

	/* 游戏信息按钮块 */
	.steam-game-link {
		float: right;
		margin: 28px 10px 0 0;
	}

	/* 信息按钮 */
	.steam-game-link .steam-game-button {
		display: inline-block;
		margin-left: 5px;
		padding: 5px;
		color: #fff;
		background-color: #fe798d;
		border-radius: 20px;
		transition: all .6s;
	}

	.steam-game-link .steam-game-button:hover {
		background: rgba(251, 120, 139, .6);
	}

	/* 移动端布局 */
	@media (max-width:600px) {

		/* 外层大盒子 */
		.steam-game-item {
			display: inline-grid;
			position: relative;
			float: left;
			justify-content: center;
			align-items: center;
			width: 48%;
			height: 130px;
			margin: 0 1% 20px 1%;
			background-color: #fff;
			box-shadow: 3px 3px 2px rgba(0, 0, 0, .3);
		}

		/* 游戏宣传图 */
		.steam-game-picture {
			clear: both;
		}

		/* 游戏信息块 */
		.steam-game-info {
			clear: both;
			left: 50%;
			margin: auto;
			text-align: center;
		}

		/* 游戏时长 */
		.steam-game-info .steam-game-meta {
			position: static;
		}

		/* 游戏标题 */
		.steam-game-info .steam-game-title {
			overflow: hidden;
			height: 16px;
			margin-bottom: 10px;
			font-size: 12px;
		}

		/* 游戏信息按钮块 */
		.steam-game-link {
			display: none;
		}
	}

	/* 清除浮动 */
	#steam-game-div::after {
		content: "";
		display: block;
		height: 0;
		clear: both;
		visibility: hidden;
	}

	/* 分页模块 */
	.page-list {
		text-align: center;
	}

	.page-list ul {
		display: inline-block;
		margin: 20px 0;
	}

	.page-list ul li {
		float: left;
		list-style: none;
		padding: 3px;
		margin: 0 10px;
		border: 0.5px solid #bbb;
		border-radius: 5px;
		transition: all .4s;
	}

	.page-list ul li:hover {
		color: #fff;
		background-color: #fe798d;
		transform: scale(1.1);
	}
</style>
<?php the_content(); ?>
<?php
$id = "76561198849944519";  // 你的SteamID，可以在这里获取 https://steamsignature.com/
$steamAPI = "https://api.miao33.top/SteamAPI.php";  // SteamAPI，我提供了两个API（在我博客获取），更推荐你自建。境外服务器推荐走本地，$steamAPI = "https://你的域名/json/SteamAPI.php"
require_once("json/classSteamCard.php");
$steam = new SteamCard($id, $steamAPI, 3);  // PS: 个人信息图片是实时更新的，有三种样式，默认为Profile，1为"Lite Status"，2为"Card"
?>
<div id="steam-game-div"></div>
<div class="page-list">
	<ul>
		<li id="last">上一页</li>
		<li id="next">下一页</li>
	</ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var pagenum = 0;
		var limit = 8; //单页展示数
		GetSteamData(limit, 0);
		$("li#last").click(function() {
			GetSteamData(limit, --pagenum);
			console.log("第 " + pagenum + " 页");
		});
		$("li#next").click(function() {
			GetSteamData(limit, ++pagenum);
			console.log("第 " + pagenum + " 页");
		});
	});

	function GetSteamData(limit, page) {
		$.ajax({
			type: "get",
			url: "/json/GetSteamData.php",
			data: {
				"limit": limit, // 每页个数
				"page": page // 页号,第一页 page = 0
			},
			dataType: "json",
			// 分页数据处理
			success: function(data) {
				var i;
				$("#steam-game-div").empty(); // 删除被选元素及其子元素
				if (data.total_page == page && page == 0) { // 判断是否家境贫寒
					$("li#last").hide();
					$("li#next").hide();
				} else if (data.total_page == page) { // 判断是否最后一页
					$("li#next").hide();
				} else if (page == 0) { // 判断是否为第一页
					$("li#last").hide();
				} else {
					$("li#next").fadeIn();
					$("li#last").fadeIn();
				}
				for (i = 0; i < data.data.length; i++) {
					$("#steam-game-div").append("<div class=\"steam-game-item\"><div class=\"steam-game-picture\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" data-src=\"" + data.data[i].logo + "\" referrer=\"no-referrer\"></div><div class=\"steam-game-info\"><div class=\"steam-game-title\"><a target=\"_blank\" href=\"https://store.steampowered.com/app/" + data.data[i].appid + "\">" + data.data[i].name + "</a></div><div class=\"steam-game-meta\"><span class=\"steam-game-info-time\">总时数 " + data.data[i].hours_forever + " 小时</span></div></div><div class=\"steam-game-link\"><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/app/" + data.data[i].appid + "\">商店页面</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/app/" + data.data[i].appid + "/discussions\">论坛</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/search/groups/?text=" + data.data[i].name + "\">查找社区组</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/news/?appids=" + data.data[i].appid + "\">相关新闻</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamdb.info/app/" + data.data[i].appid + "\">SteamDB</a></div></div>");
					// console.log(data); // 查看AJAX获取的数据
				}
				$("img.lazy").lazyload(); // 图片懒加载
			},
			error: function(data) {
				alert(data.result);
			}
		});
	}
</script>
<?php endwhile; else: endif;?>
<?php get_footer();
