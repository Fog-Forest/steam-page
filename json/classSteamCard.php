<?php
class SteamCard
{
    // 主函数
    public function __construct($id, $type)
    {
        // 个人信息卡片
        if ($type == 1) {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" dataset=\"https://steamsignature.com/status/schinese/" . $id . ".png\"></a></div>";
        } elseif ($type == 2) {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" dataset=\"https://steamsignature.com/card/0/" . $id . ".png\"></a></div>";
        } else {
            echo "<div class=\"steam-card-img\"><a href=\"https://steamcommunity.com/profiles/" . $id . "\" target=\"_blank\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" dataset=\"https://steamsignature.com/profile/schinese/" . $id . ".png\"></a></div>";
        }
        echo "<div class=\"colorline\"></div>";
    }
}
