<?php
$array = array();
$limit = $_GET["limit"];
$page = $_GET["page"];

// 判断获取的参数
if (empty($limit)) {
    die('limit 为必须参数');
} elseif (empty($page)) {
    $page = 0;
}

$pagenum = $page * $limit;  // 第一页为 page = 0
$game_info = file_get_contents("steam.json");
$game_data = json_decode($game_info, true);
$game_data = $game_data['response']['games'];
$total = count($game_data);  // 游戏总数
$total_page =  intdiv($total, $limit);  // 分页总数
//echo "<pre>";
//echo var_dump($game_data);

// 构造请求接口
foreach ($game_data as $key => $value) {
    // limit
    $appid = $game_data[$pagenum]['appid'];
    
    if ($key == $limit || $appid == NULL) {
        break;
    }
    $array[$key]['num'] = $key;
    $array[$key]['name'] = $game_data[$pagenum]['name'];
    // 中国大陆 CDN 图片加速
    $array[$key]['logo'] = "https://cdn.cloudflare.steamstatic.com/steam/apps/" . $appid . "/capsule_184x69.jpg";
    $array[$key]['appid'] = $appid;
    // 游玩时间计算 - 单位：小时
    $min_forever = $game_data[$pagenum]['playtime_forever'];
    $hours_forever = ceil($min_forever / 60);
    $array[$key]['hours_forever'] = !empty($hours_forever) ? (string)$hours_forever : "0";
    $pagenum++;
}
echo '{"total": ' . $total . ',"total_page": ' . $total_page . ', "limit": ' . $limit . ', "page": ' . $page . ', "data":' . json_encode($array, true) . '}';
