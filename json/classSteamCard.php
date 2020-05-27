<?php
class SteamCard
{
    // 主函数
    public function __construct($id, $steamAPI, $type)
    {
        // 个人信息卡片
        if ($type == 1) {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" data-src=\"https://steamsignature.com/status/schinese/" . $id . ".png\"></a></div>";
        } elseif ($type == 2) {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" data-src=\"https://steamsignature.com/card/0/" . $id . ".png\"></a></div>";
        } else {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" data-src=\"https://steamsignature.com/profile/schinese/" . $id . ".png\"></a></div>";
        }
        echo "<div class=\"colorline\"></div>";

        // 缓存Steam游戏库数据
        $api_url = $steamAPI . "?id=" . $id . "&type=all";  // 拼合Steam api_url
        if (!file_exists("json/steam.json")) {  // 缓存Steam API数据24小时，使用我的API请不要改为0
            file_put_contents("json/steam.json", file_get_contents($api_url));
        } else if ((time() - filemtime("json/steam.json")) > 86400) {
            file_put_contents("json/steam.json", file_get_contents($api_url));
        }
    }
}
