<?php

/**
 Template Name: Steam游戏库
 */

get_header(); ?>

<style>
.steam-game-tabs{margin-bottom:15px;margin-top:15px;}.steam-game-tab{padding:5px;}a.steam-game-tab{text-decoration:none;}.steam-game-active{background:#657b83;color:#fff;}.steam-game-item{padding-bottom:10px;position:relative;clear:both;min-height:100px;padding:10px 0;border-bottom:1px #ddd solid;}@media screen and (max-width:600px){.steam-game-item{width:100%;}}.steam-game-picture{position:absolute;left:0;top:10px;width:184px;padding-top:5px;}.steam-game-info{margin:25px 0;padding-left:194px;}.steam-game-meta{font-size:12px;padding-right:10px;}.steam-game-pagination{margin-top:15px;text-align:center;margin-bottom:10px;}.steam-game-button{padding:5px;text-decoration:none;display:inline-block;}.steam-game-button:hover{background:#657b83;color:#fff;}.steam-game-hide{display:none;}.steam-game-show{display:block;}.steam-game-title{font-size:18px;}.steam-game-title a{line-height:1;color:#99a9bf;}.steam-game-link{min-height:50px;}.steam-game-link a{color:#99a9bf;}@media (max-width:400px){.steam-game-picture{padding-left:5px;}.steam-game-info{margin:10px 0;padding:85px 0 0 5px;}}
</style>

<?php
	$steamid = "76561198849944519";//你的SteamID，可以在这里获取https://steamsignature.com/
	echo "<a href=\"https://steamcommunity.com/profiles/".$steamid."\" target=\"_blank\"><img src=\"https://steamsignature.com/profile/schinese/".$steamid.".png\"></a>";
	//上面这个图片是实时更新的
	$data = json_decode(file_get_contents("gamelist/steam.json"),true);//获取本地JSON并转数组（社区被墙我也没辙）
	//echo '<pre>';
	//echo $data;//我瞅瞅里面有啥玩意儿
	$count = count($data); //游戏数量统计
	if($count == 0){
		echo "<p>哦噢~你好像并没有够买任何游戏哦！</p>";
	} else {
		for ($i = 0; $i < $count; $i++) {
			if($data[$i]['hours_forever'] == null){
				$hours = "0";
			} else {
				$hours = $data[$i]['hours_forever'];
			}
			echo "<div class=\"steam-game-item\"><div class=\"steam-game-picture\"><img src=\"".$data[$i]['logo']."\" referrerpolicy=\"no-referrer\"></div><div class=\"steam-game-info\"><div class=\"steam-game-title\"><a target=\"_blank\" href=\"https://store.steampowered.com/app/".$data[$i]['appid']."\">".$data[$i]['name']."</a></div><div class=\"steam-game-meta\"><span class=\"steam-game-info-time\">总时数 ".$hours." 小时</span></div></div><div class=\"steam-game-link\"><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/app/".$data[$i]['appid']."\">商店页面</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/app/".$data[$i]['appid']."/discussions\">论坛</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/search/groups/?text=".$data[$i]['name']."\">查找社区组</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/news/?appids=".$data[$i]['appid']."\">相关新闻</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamdb.info/app/".$data[$i]['appid']."\">SteamDB</a></div></div>";
		}
	}
?>
<br><br><br>

<?php get_footer();
