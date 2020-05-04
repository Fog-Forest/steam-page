<?php
class Steamgame
{
    public $game_name = array();  // 游戏名
    public $game_logo = array();  // 游戏图片
    public $game_appid = array();  // 游戏Appid
    public $game_hours = array();  // 游戏时长

    // 主函数
    public function __construct($api_url)
    {
         // 缓存Steam API数据
        if((time() - filemtime("json/steam.json")) > 86400)  // 缓存24小时
        {
		    file_put_contents("json/steam.json", file_get_contents($api_url));
		    $game_info = file_get_contents("json/steam.json");
	    } else {
		    $game_info = file_get_contents("json/steam.json");
        }
        
        $temp = json_decode($game_info, true);
        //echo "<pre>";
        //echo var_dump($temp);

        // 存储获得的数据,关联数组
        for($i=0; $i<count($temp); $i++)
        {
            array_push($this->game_name, $temp[$i]['name']);
            array_push($this->game_logo, $temp[$i]['logo']);
            array_push($this->game_appid, $temp[$i]['appid']);
            array_push($this->game_hours, !empty($temp[$i]['hours_forever'])?$temp[$i]['hours_forever']:"0");
        }
    }
}
?>