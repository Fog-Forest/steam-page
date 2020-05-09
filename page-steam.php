<?php

/**
 Template Name: Steam游戏库
 Template Author：老蘑菇&梨花镇的阿肾
 */

get_header(); ?>

<style>
	/* 个人资料卡 */
	.steam-card-img {
		text-align: center;
		margin-top: 10px;
	}

	/* 彩色分割线 */
	.colorline {
		width: 100%;
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
		color: #fff;
		background-color: #fe798d;
		margin-left: 5px;
		border-radius: 20px;
		padding: 5px;
		transition: all .6s;
	}

	.steam-game-link .steam-game-button:hover {
		background: rgba(251, 120, 139, .6);
	}
	/* 移动端布局 */
	@media (max-width:600px) {
		.steam-game-item * {
			padding: 0;
			margin: 0;
		}
		/* 外层大盒子 */
		.steam-game-item {
			position: relative;
			display: inline-grid;
			justify-content: center;
			align-items: center;
			float: left;
			margin: 3px;
			width: 48%;
			height: 120px;
			background-color: #fff;
			margin: 0 1% 20px 1%;
			box-shadow: 3px 3px 2px rgba(0, 0, 0, .3);
		}

		/* 游戏宣传图 */
		.steam-game-picture {
			clear: both;
			overflow: hidden;
		}

		/* 游戏信息块 */
		.steam-game-info {
			clear: both;
			text-align: center;
            margin: auto;
            left: 50%;
		}
		
		/* 游戏时长 */
		.steam-game-info .steam-game-meta {
			position: static;
		}
		
		/* 游戏标题 */
		.steam-game-info .steam-game-title {
			font-size: 12px;
			height: 16px;
			overflow: hidden;
			margin-bottom: 10px;
		}

		/* 游戏信息按钮块 */
		.steam-game-link {
			display: none;
		}
	}

	.showall {
		color: #ffaa00;
		font-size: 20px;
		text-align: center;
		padding: 20px 0;
		transition: all .6s;
	}

	.showall:hover {
		color: #e67474;
	}
</style>
<?php
	$id = "76561198849944519";  // 你的SteamID，可以在这里获取https://steamsignature.com/
	$steamAPI = "https://api.miao33.top/SteamAPI.php";  // SteamAPI，我提供了两个API（在我博客获取），更推荐你自建。境外服务器推荐走本地，$steamAPI = "http://你的网址/json/SteamAPI.php"
	$page = 7;  // 首次要展示游戏数目默认为8个

	require_once("json/classSteam.php");
	$steam = new Steamgame($id, $steamAPI, 3);  // PS: 个人信息图片是实时更新的，有三种样式，默认为Profile，1为"Lite Status"，2为"Card"
	$count = count($steam->game_name);  // 游戏数量统计
	if($count == 0){
		echo "<p>哦噢~你好像并没有够买任何游戏哦！</p>";
	}
	else
	{
		for ($i = 0; $i < $count; $i++)
		{
			if($i > $page){
				$num = "more";
			}
			if($steam->game_appid[$i] == 205790){
				continue;  // Dota2 Test图片有问题，跳过该游戏
			}
			echo "<div class=\"steam-game-item ".$num."\"><div class=\"steam-game-picture\"><img src=\"".$steam->game_logo[$i]."\" referrerpolicy=\"no-referrer\"></div><div class=\"steam-game-info\"><div class=\"steam-game-title\"><a target=\"_blank\" href=\"https://store.steampowered.com/app/".$steam->game_appid[$i]."\">".$steam->game_name[$i]."</a></div><div class=\"steam-game-meta\"><span class=\"steam-game-info-time\">总时数 ".$steam->game_hours[$i]." 小时</span></div></div><div class=\"steam-game-link\"><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/app/".$steam->game_appid[$i]."\">商店页面</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/app/".$steam->game_appid[$i]."/discussions\">论坛</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/search/groups/?text=".$steam->game_name[$i]."\">查找社区组</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/news/?appids=".$steam->game_appid[$i]."\">相关新闻</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamdb.info/app/".$steam->game_appid[$i]."\">SteamDB</a></div></div>";
		}
	}
	if($count > $page){
		echo "<div style=\"clear:both\"></div><div class=\"showall\">. Show All .</div>";
	}
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
<script type="text/javascript">  // 收缩展示
$(document).ready(function(){
	$(".more").hide();
	$(".showall").click(function(){
		$(".more").fadeIn();
		$(".showall").text("真的已经到头了哦~");
	});
});</script>

<?php get_footer();
