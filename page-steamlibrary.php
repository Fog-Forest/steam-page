<?php

/**
 Template Name: Steam游戏库
 Template Author：老蘑菇&梨花镇的阿肾
 */

get_header(); 

require_once("json/classSteamCard.php");

?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<link rel="stylesheet" href="<?php echo SG4WP_PLUGIN_URL . "/API/assets/css/steamlibrary.css" ?>">
<script src="<?php echo SG4WP_PLUGIN_URL . "/API/assets/js/steamlibrary.js" ?>"></script>
<?php the_content(); ?>
<?php
	$id = esc_attr(get_option('zm_sg4wp_id'));  
	$steam = new SteamCard($id,intval(esc_attr(get_option('zm_sg4wp_cardtype'))));
?>
<div id="steam-game-div"></div>
<div class="page-list">
	<ul>
		<li id="last">上一页</li>
		<li id="next">下一页</li>
	</ul>
</div>

<script type="text/javascript">
// window.addEventListener("load",function() {
		var pagenum = 0;
		var limit = 8; //单页展示数
		GetSteamData(limit, 0);
		document.getElementById("next").addEventListener("click",()=>{
			GetSteamData(limit, ++pagenum);
			console.log("第 " + pagenum + " 页");
		});

		document.getElementById("last").addEventListener("click",()=>{
			GetSteamData(limit, --pagenum);
			console.log("第 " + pagenum + " 页");
		})
	// });

	function GetSteamData(limit, page) {
		let gameDiv = document.getElementById("steam-game-div");
		gameDiv.innerHTML = "<img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\"/>";
		fetch( "<?php   echo (admin_url('admin-ajax.php') .'?action=GetSteamLibraryData')  ?>" + "&limit="+ limit + "&page="+page,{
			method:"GET"
		}).then(async response=>{
			if(response.ok){
				await response.json().then((data)=>{

					let i;

					
					gameDiv.innerHTML = "";
					if (data.total_page == page && page == 0) { // 判断是否家境贫寒
						fadeOut(document.getElementById("next"),0.3);
						fadeOut(document.getElementById("last"),0.3);

					} else if (data.total_page == page) { // 判断是否最后一页
						fadeOut(document.getElementById("next"),0.3);
					} else if (page == 0) { // 判断是否为第一页
						fadeOut(document.getElementById("last"),0.3);
					} else {
						fadeIn(document.getElementById("next"),0.3);
						fadeIn(document.getElementById("last"),0.3);
					}
					for (i = 0; i < data.data.length; i++) {
						gameDiv.innerHTML += "<div class=\"steam-game-item\"><div class=\"steam-game-picture\"><img class=\"lazy\" src=\"https://cdn.jsdelivr.net/gh/Fog-Forest/Steam-page@1.2/json/loading.svg\" dataset=\"" + data.data[i].logo + "\" referrer=\"no-referrer\"></div><div class=\"steam-game-info\"><div class=\"steam-game-title\"><a target=\"_blank\" href=\"https://store.steampowered.com/app/" + data.data[i].appid + "\">" + data.data[i].name + "</a></div><div class=\"steam-game-meta\"><span class=\"steam-game-info-time\">总时数 " + data.data[i].hours_forever + " 小时</span></div></div><div class=\"steam-game-link\"><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/app/" + data.data[i].appid + "\">商店页面</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/app/" + data.data[i].appid + "/discussions\">论坛</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamcommunity.com/search/groups/?text=" + data.data[i].name + "\">查找社区组</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://store.steampowered.com/news/?appids=" + data.data[i].appid + "\">相关新闻</a><a class=\"steam-game-button\" target=\"_blank\" href=\"https://steamdb.info/app/" + data.data[i].appid + "\">SteamDB</a></div></div>";
					}
					lazyLoad();
				})
			}else{
				Promise.reject(new Error(response.status + response.statusText));
			}
		}).catch(e=>{
			console.log(e);
			alert(e.message);
		})
	}
</script>
<?php endwhile; else: endif;?>
<?php get_footer();
