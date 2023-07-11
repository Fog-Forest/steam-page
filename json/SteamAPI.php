<?php
$id = $_GET['id'];  //SteamID，可以在这里获取:https://www.steamidfinder.com/
$key = $_GET['key'];  //Steam Web API 密钥

if ($id == NULL) {
	exit("参数有误！");
} else {
	$data = steaminfo($id, $key);
	echo ($data);
}

//获取Steam信息(需要设置Steam游戏库为公开)
function steaminfo($id, $key)
{
	$url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?include_appinfo=true&key=$key&steamid=$id";

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		// CURLOPT_PROXY => "127.0.0.1",  // 代理IP
        // CURLOPT_PROXYPORT => 7890,  // 代理端口
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
			'Accept-Language: zh-CN'
		),
	));
	$response = curl_exec($curl);
	curl_close($curl);
	// echo ($response);
	return $response;
}
