<?php

/**
 Template Name: Steam游戏库
 Template Author：老蘑菇&梨花镇的阿肾
 */

get_header(); ?>

<style>.steam-game-tabs{margin-bottom:15px;margin-top:15px;}.steam-game-tab{padding:5px;}a.steam-game-tab{text-decoration:none;}.steam-game-active{background:#657b83;color:#fff;}.steam-game-item{padding-bottom:10px;position:relative;clear:both;min-height:100px;border-bottom:1px #ddd solid;}@media screen and (max-width:1920px){.steam-game-item{width:100%;}}.steam-game-picture{position:absolute;left:0;top:10px;width:184px;padding-top:5px;}.steam-game-info{padding-left:194px;position:absolute;}.steam-game-meta{font-size:12px;padding:67px 0px;}.steam-game-pagination{margin-top:15px;text-align:center;margin-bottom:10px;}.steam-game-button{border-radius:300px;background:#ff4460b0;Margin:6px;padding:.35rem;overflow:hidden;z-index:2;transition:all 0.8s;float:right;display:inline-block;}.steam-game-button:hover{background:#657b83;color:#fff;}.steam-game-hide{display:none;}.steam-game-show{display:block;}.steam-game-title{max-width:180px;max-height:65px;overflow:hidden;padding:10px 0;position:absolute;}.steam-game-title a{color:#6daaff;overflow:hidden;font-size:17px;}.steam-game-link{min-height:50px;right:100%;padding:27px 0;}.steam-game-link a{color:#ffffff;}@media screen and (max-width:600px){.steam-game-picture{padding-left:5px;}.steam-game-link{float:right;}.steam-game-title{max-width:0px;max-height:0px;overflow:hidden;}.steam-game-meta{font-size:12px;padding-right:0px;padding-top:71%;}.steam-game-info{margin:10px 0;padding:0px 0px 0px 5px;}.steam-game-button{border-radius:300px;background:#ff4460b0;Margin:2px;padding:0.35rem;overflow:hidden;z-index:2;transition:all 0.8s;float:right;display:inline-block;font-size:13px;}.steam-game-picture{position:absolute;left:26%;top:10px;width:150px;padding-top:35px;}img{height:auto;max-width:100%;}}.showall{font-size:20px;color:orange;padding:20px 0 20px 0;}.showall:hover{color:#e67474;}
</style>
<?php
	$id = "76561198849944519";  // 你的SteamID，可以在这里获取https://steamsignature.com/
	$steamAPI = "https://api.mushroom.ga/SteamAPI.php";  // SteamAPI，我提供了两个API，更推荐你自建。留空走本地（需境外服务器）。
	$page = 8;  // 首次要展示游戏数目默认为8个

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
		echo "<center><div class=\"showall\">. Show All .</div></center><br>";
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
