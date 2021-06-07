<?php
$id = $_GET['id'];  //SteamID，可以在这里获取:https://steamsignature.com
$type = $_GET['type'];  //all(默认)，recent，perfect

if ($id == NULL) {
	exit("参数有误！");
} else {
	$data = steaminfo($id, $type);
	preg_match("#(?<=rgGames\s=\s).*?](?=;)#", $data, $json);  //正则取Steam游戏库JSON
	echo ($json[0]);
}

//获取Steam信息(需要设置Steam游戏库为公开)
function steaminfo($id, $type)
{
	if ($type == "recent") {
		$url = "https://steamcommunity.com/profiles/$id/games/?tab=recent";
	} elseif ($type == "perfect") {
		$url = "https://steamcommunity.com/profiles/$id/games/?tab=perfect";
	} else {
		$url = "https://steamcommunity.com/profiles/$id/games/?tab=all";
	}

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
			'Accept-Language: zh-CN'
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);

	$error_img = ["https:\/\/steamcdn-a.akamaihd.net\/steam\/apps\/205790\/capsule_184x69.jpg"];  //404的图片，例如："Dota2 Test"，自行增加
	$response = str_replace("steamcdn-a.akamaihd.net", "media.st.dl.pinyuncloud.com", $response);  //替换图片为大陆节点
	$info =  str_replace($error_img, "https://cdn.jsdelivr.net/gh/IMGRU/IMG/2020/05/28/5ece9990c9be7.jpg", $response);
	return $info;
}
