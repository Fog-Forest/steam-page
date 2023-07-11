<?php
class SteamCard
{
	// main
	public function __construct($id, $key, $steamAPI, $card)
	{
		// Steam信息卡片
		if (empty($card)) {
			echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img src='https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg' alt=''/></a></div>";
		} else {
			echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img src=\"". $card ."\" alt=''/></a></div>";
		}
		echo "<div class=\"colorline\"></div>";

		// 缓存游戏库数据
		$api_url = $steamAPI . "?id=" . $id . "&key=" . $key;  //拼接api_url
		// echo "$api_url";
		if (!file_exists("json/steam.json")) {  //缓存Steam API数据24小时，使用我的API请不要改为0
			file_put_contents("json/steam.json", file_get_contents($api_url));
		} else if ((time() - filemtime("json/steam.json")) > 86400) {
			file_put_contents("json/steam.json", file_get_contents($api_url));
		}
	}
}
