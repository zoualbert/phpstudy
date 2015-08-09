<?php
// 建立一幅 100X30 的图像
session_start();
$height = 120;
$width = 40;
$im = imagecreate($height, $width);//imagecreate()  返回一个图像标识符，代表了一幅大小为 x_size 和 y_size 的空白图像。

// 白色背景和蓝色文本
$bg = imagecolorallocate($im, 255, 255, 255);//为一幅图像分配颜色,三个数值代表三原色，搭配不同，调成一个颜色，百度在线调色板
$textcolor = imagecolorallocate($im, 0, 0, 255);
$store[4];
for ($i = 0; $i < 4; $i ++) { 
   
	$rand =  mt_rand(0, 9);//生成随机数，max = 9 min = 0
	$store[$i] = $rand;
	imagestring($im, mt_rand(15,20), 30 *$i + mt_rand(0,9), mt_rand(10,15), $rand, imagecolorallocate($im, mt_rand(0,128), mt_rand(128,255), mt_rand(127,240)));
}   //水平地画一行字符串 .一是图像，二是字体，三是x坐标 四是y坐标 五是要写入的字符串 六是字体的颜色

// 输出图像
header("Content-type: image/png");//输出网页的内容是PNG格式的图片
header("Cache-Control: no-cache");//发送一个报头，告诉浏览器当前页面不进行缓存，每次访问的时间必须从服务器上读取最新的数据
                                  //一般情况下，浏览器为了加快浏览速度会对网页进行缓存，在一定时间内再次访问同一页面的时候会
                                  //有缓存里面读取而不是从服务器上下载网页内容，若是服务器某个页面更新速度很快而且需要即时的，那么可以加上这个
imagepng($im);

$_SESSION['verifycode']['code'] = $store[0]*1000 + $store[1]*100 + $store[2]*10 + $store[3];


