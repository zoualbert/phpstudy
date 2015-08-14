
  <?php
  include './includes/page-header.php';
  include './includes/functions.php';
   $host_url = host_url();


  if ( ! empty($_POST) ) {   
  //判断是否提交数据
  

      if ($_POST['verifycode'] == $_SESSION['verifycode']['code']) {
          $database_config = require __DIR__.'/config/database.php';
          require_once __DIR__.'/lib/Medoo.class.php';

          $medoo = @new Medoo($database_config);
          $medoo->query('set names utf8');

          $name = trim($_POST['name']);
          //$passer =  trim($_POST['passwd']);
            //获取数据并处理
         //var_dump($passer);
          $pass = md5(trim($_POST['password']));
        //  var_dump($pass);

          $user = $medoo->select('users','*',['AND' => ['name' => $name,
                                                         'password' => $pass],
                                            ]);
          // var_dump($user);
          // die();
          // 
          //上句中users是数据库中的数据表,And是与的意思，指名字密码都是要符合要求的。
            //$medoo = null;//将变量注销
            $medoo = null;
            if(count($user)){//count 计算数组中的单元数目或对象中的属性个数
              $_SESSION['user'] = $user[0];
            }

            if(isset($_SESSION['user']))//isset — 检测变量是否设置 
            {
                 echo "<p class='am-text-xl'>已经登录，稍后跳转页面！！！！</p>";
                 require  'jump1.php';
            }
            
   
      }
      else{
        echo "<p class='am-text-xxl'>验证码不正确！！</p>";
      }
  }

  ?>
<body>
  <?php include './includes/nav.php'; ?>
  <form action="login.php" method="post">
     <h2 class="am-u-sm-offset-4">登录页面<h2>
     <div class="am-g">
        <div class="am-u-sm-offset-4">账号：<input id="name" type="text" name="name" required></div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-4">密码：<input id="password" type="password" name="password" required></div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-4">验证码：<input type="text"  name="verifycode" id="verify" required></div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-5"><img id="js-get-verify-code" src="./verifycode.php"> </div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-4"><input type="submit"  id="button" value="登录"/></div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-4"><a href="<?php echo $host_url; ?>find_password.php">忘记密码</a></div>
     </div>
     <div class="am-g">
        <div class="am-u-sm-offset-4">还没有帐号?<a href="<?php echo $host_url; ?>regist.php">注册</a></div>
     </div>
        <?php include './includes/footer.php';?>
  </form>
</body>
  <?php
        include './includes/page-end.php';
  ?>