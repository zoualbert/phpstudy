<?php
include './includes/page-header.php';
include './includes/functions.php';
 $host_url = host_url();
if ( ! empty($_POST) ) {   //判断是否提交数据
 
    $database_config = require __DIR__ . '/config/database.php';  //包含配置文件
    require_once __DIR__ . '/lib/Medoo.class.php';  //包含数据库
    $medoo = @new Medoo($database_config);    //连接数据库
    $medoo->query('set names utf8');      //设置字符编码
    $oldpassword = md5(trim($_POST['oldpassword']));   //获取数据并处理
    $newpassword = md5(trim($_POST['newpassword']));
    $again_newpassword = md5(trim($_POST['again_newpassword']));
    $user = $medoo->select('users','*',['And' => [
                                                   'password' => $oldpassword]
                                      ]);
    // $medoo = null;   
    if(count($user)){//count 计算数组中的单元数目或对象中的属性个数
        $_SESSION['user'] = $user[0];
    }
    if(isset($_SESSION['user']))//isset — 检测变量是否设置 
    {
      echo '存在此用户！！！！';
      if( ! ($newpassword == $again_newpassword) ){
          echo "<p class='am-text-xl'>  两次密码不一致！！！</p>";
      }
      else{

          $medoo->update('users',['password' => $newpassword],
                                    ['name' => $_SESSION['user']['name'] ]    );
          echo "<p class='am-text-xl'> 修改密码成功！请重新登录</p>";
            require  'jump2.php';
      }   
    }
    else{
      echo "<p class='am-text-xl'>不存在此用户，修改密码失败！</p>";
    }
    
}

?>
<body>
<?php include './includes/nav.php'; ?>
<form action="" method="post">
    <h2 class="am-u-sm-offset-4">修改密码<h2></br>
   <div class="am-g">
     <div class="am-u-sm-offset-4">旧密码：<input id="password" type="password" name="oldpassword" required></div></br>
  </div>
  <div class="am-g">
      <div class="am-u-sm-offset-4">新密码：<input id="password" type="password" name="newpassword" required></div></br>
  </div>
  
  <div class="am-g">
      <div class="am-u-sm-offset-4">确认新密码：<input id="password" type="password" name="again_newpassword" required></div></br>
  </div>
  <div class="am-g">
      <div class="am-u-sm-offset-4"><input type="submit"  id="button1" value="确认"/></div></br>
  </div>
      <?php include './includes/footer.php';?>
</form>
</body>