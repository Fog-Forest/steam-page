<?php
class Steamgame
{
    public $game_name = array();  // 游戏名
    public $game_logo = array();  // 游戏图片
    public $game_appid = array();  // 游戏Appid
    public $game_hours = array();  // 游戏时长
    private $game_data = array();

    // 主函数
    public function __construct($id, $steamAPI, $type)
    {
        // 个人信息卡片
        if($type == 1)
        {
            echo "<a href=\"https://steamcommunity.com/profiles/".$id."\" target=\"_blank\"><img src=\"https://steamsignature.com/status/schinese/".$id.".png\"></a>";
        }
        elseif ($type == 2)
        {
            echo "<a href=\"https://steamcommunity.com/profiles/".$id."\" target=\"_blank\"><img src=\"https://steamsignature.com/card/0/".$id.".png\"></a>";
        }
        else 
        {
            echo "<a href=\"https://steamcommunity.com/profiles/".$id."\" target=\"_blank\"><img src=\"https://steamsignature.com/profile/schinese/".$id.".png\"></a>";
        }

        // 判断走本地API 或 走外链API
        if($steamAPI){
	        $api_url = $steamAPI."?id=".$id."&type=all";  // 拼合外链api_url
            if((time() - filemtime("json/steam.json")) > 86400)  // 缓存Steam API数据24小时，使用我的API请不要改为0
            {
                file_put_contents("json/steam.json", file_get_contents($api_url));
                $game_info = file_get_contents("json/steam.json");
            } else {
                $game_info = file_get_contents("json/steam.json");
            }
        }
        else
        {
            $api_url = "json/SteamAPI.php?id=".$id."&type=all";  // 拼合本地api_url
            if((time() - filemtime("json/steam.json")) > 86400)  // 缓存Steam API数据24小时
            {
                file_put_contents("json/steam.json", file_get_contents($api_url));
                $game_info = file_get_contents("json/steam.json");
            } else {
                $game_info = file_get_contents("json/steam.json");
            }
        }
        
        $this->game_data = json_decode($game_info, true);
        //echo "<pre>";
        //echo var_dump($this->game_data);

        // 存储获得的数据,关联数组
        for($i=0; $i<count($this->game_data); $i++)
        {
            array_push($this->game_name, $this->game_data[$i]['name']);
            array_push($this->game_logo, $this->game_data[$i]['logo']);
            array_push($this->game_appid, $this->game_data[$i]['appid']);
            array_push($this->game_hours, !empty($this->game_data[$i]['hours_forever'])?$this->game_data[$i]['hours_forever']:"0");
        }
    }
}
?>