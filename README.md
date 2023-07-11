# 在你的 WordPress 博客展示 Steam 游戏库
作为一个爱玩游戏的人，博客怎么能没有你的游戏库呢，所以按理是要把它攒出来的。本页面模版**理论**适配了大部分主题，部分布局比较奇葩的主题也能用但是需要修改样式，如果你有更好看的样式，也可以分享给我们~

本页面模版由 [蘑菇](https://fairysen.com/) 和 [阿肾](https://imashen.cn/) 二人合作开发完成，您可以使用和二次修改但请务必保留版权，谢谢！

插件版由 [野兔](https://www.azimiao.com) 制作：<https://www.azimiao.com/6425.html>


## 二次开发说明
由于 Steam 修改相关政策，导致原有的数据获取方式失效，于是我在 `蘑菇` 和 `阿肾` 二人的基础上对 SteamAPI 进行修复，现在个人游戏库相关的数据通过 Steam 官方提供的 Web API 获取。同时也修改了 Steam 个人资料卡片的获取方式，由 [exophase](https://gamercards.exophase.com) 网站提供支持。

## README
1. 下载项目中的文件，将 `page-steam.php` 扔到你的主题根目录，将 `json` 目录扔到你的站点根目录
2. 修改 `page-steam.php` 文件
   - 第 196 行填写 SteamID；
   - 第 197 行填写 Steam Web API 密钥；
   - 第 198 行填写 exophase 网站生成的个人资料卡片链接；
   - 第 203 行填写 SteamAPI 接口地址
   - 详细及其他请参考代码注释修改。
3. 服务器在境内，理论上API地址未被屏蔽，若不幸被屏蔽可修改 `SteamAPI.php` 文件第 25、26 行，自行添加代理；若服务器在境外直接走本地即可
4. 信息填好后，在 `WP后台 - 新建页面` 选择 `Steam游戏库` 这个模版
5. 若发现游戏库/游戏时长不正常显示，请到 Steam 个人设置界面，将数据全部改为公开，记得 ***游戏详情*** 底下有个附属选项，不要打勾 ✔

## API
接口文档：https://steamapi.xpaw.me/

## DEMO
[Steam游戏库](https://blog.grayzhao.com/together-game/)

## ISSUE
1. 如果数据不对，请手动删除 `steam.json` 文件，再次打开页面数据将会自动更新
2. 关于打开没有数据的问题请检测你的 Steam 游戏库是否设置为公开，信息是否填写正确，手动请求API是否能得到数据，格式为：`https://你的域名/json/SteamAPI.php?id=你的SteamID&key=您的 Steam Web API 密钥`
3. 第一次打开没有数据需要手动刷新一遍，请检查你是否开启了 *AJAX*
4. 打开页面报错，请使用 Chrome 浏览器或者 FireFox 浏览器，F12 查看具体错误
5. 如果第一次打开样式有问题就把 CSS 添加到全局里
6. 本页面模版理论适配了大部分 WP 主题，部分布局比较奇葩的主题也能用但是可能需要修改样式
