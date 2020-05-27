<?php
$steamid = $_GET['id'];  // SteamID，可以在这里获取https://steamsignature.com/
$showtype = $_GET['type'];  // 默认为最近游玩,所有游戏参数为"all"

if (empty($steamid)) {
	die("Steam id 为必须参数！");
} else {
	preg_match("#(?<=var\srgGames\s=\s).*?false}}](?=;)#", steaminfo($steamid, $showtype), $json);  // 正则取Steam游戏库JSON
	echo $json[0];
}

// 获取Steam信息函数
function steaminfo($steamid, $showtype)
{
	$url = "https://steamcommunity.com/profiles/$steamid/games/?tab=$showtype";
	$ch = curl_init(); // 初始化curl模块
	curl_setopt($ch, CURLOPT_URL, $url);  // 登录提交的地址
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // 以文件流的方式返回不直接输出到页面
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // 自动获取新url内容：302跳转
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 发送请求头（返回中文页面）
		"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36",
		"Accept-Language: zh-CN,zh"
	));
	$gameinfo = curl_exec($ch);
	curl_close($ch);
	$temp = str_replace("steamcdn-a.akamaihd.net", "media.st.dl.pinyuncloud.com", $gameinfo);  // 替换为Stean 国内CDN节点
	$gameimg = ["https:\/\/media.st.dl.pinyuncloud.com\/steam\/apps\/205790\/capsule_184x69.jpg"];  // 404的图片，例如 Dota2 Test，如果还有自行往里加
	return str_replace($gameimg, "https://cdn.jsdelivr.net/gh/IMGRU/IMG/2020/05/28/5ece9990c9be7.jpg", $temp);
}
