<?php

add_action("wp_ajax_nopriv_GetSteamLibraryData","GetSteamLibraryData");
add_action("wp_ajax_GetSteamLibraryData","GetSteamLibraryData");


function GetSteamLibraryData(){

    $file_path = SG4WP_PLUGIN_DIR . "API/json/steam.json";
    
    $array = array();
    $limit = $_GET["limit"];
    $page = $_GET["page"];

    // 判断获取的参数
    if (empty($limit)) {
        die('limit 为必须参数');
    } elseif (empty($page)) {
        $page = 0;
    }

    CheckUpdate();

    $pagenum = $page * $limit;  // 第一页为 page = 0
    $game_info = file_get_contents($file_path);
    $game_data = json_decode($game_info, true);
    $total = count($game_data);  // 游戏总数
    $total_page =  intdiv($total, $limit);  // 分页总数
    //echo "<pre>";
    //echo var_dump($game_data);

    // 构造请求接口
    foreach ($game_data as $key => $value) {
        // limit
        if ($key == $limit || $game_data[$pagenum]['appid'] == NULL) {
            break;
        }
        $array[$key]['num'] = $key;
        $array[$key]['name'] = $game_data[$pagenum]['name'];
        $array[$key]['logo'] = $game_data[$pagenum]['logo'];
        $array[$key]['appid'] = $game_data[$pagenum]['appid'];
        $array[$key]['hours_forever'] = !empty($game_data[$pagenum]['hours_forever']) ? $game_data[$pagenum]['hours_forever'] : "0";
        $pagenum++;
    }
    echo '{"total": ' . $total . ',"total_page": ' . $total_page . ', "limit": ' . $limit . ', "page": ' . $page . ', "data":' . json_encode($array, true) . '}';
    die();
}





function CheckUpdate()
{
    $file_path = SG4WP_PLUGIN_DIR . "API/json/steam.json";
    //TODO: 修改
    $steamAPI = "https://api.miao33.top/SteamAPI.php";
    $api_url = $steamAPI . "?id=" . esc_attr(get_option('zm_sg4wp_id')) . "&type=all";  // 拼合Steam api_url
    if (!file_exists($file_path) || (time() - filemtime($file_path)) > 86400) {  // 缓存Steam API数据24小时，使用我的API请不要改为0
        file_put_contents($file_path, file_get_contents($api_url, false, stream_context_create(
            ["ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false
            ]]
        )));
    }
}
