<?php
include './includes/page-header.php';

if (! empty($_FILES)) {

     if(is_uploaded_file($_FILES['avatar']['tmp_name'])){ 
           $upfile = $_FILES["avatar"]; 
           $name =$upfile["name"];
           $tmp_name = $upfile["tmp_name"]; 
           move_uploaded_file($tmp_name,'public/picture/'.$name);  
           $destination="public/picture/".$name;
           $database_config = require __DIR__ . '/config/database.php';  //包含配置文件
           require_once __DIR__ . '/lib/Medoo.class.php';  //包含数据库
           $medoo = @new Medoo($database_config);    //连数据库
           $medoo->query('set names utf8');      //设置字符接编码
          
           $medoo->update('users',['picture' => $name ],
           	                      ['name' => $_SESSION['user']['name'] ]    );

           $_SESSION['user']['picture'] = $name;//更新$_SESSION


      }
      else  {
	  	  echo "error!!!";
	  	
      }     
	                                 
//var_dump($_FILES);                                                                               


	//die;
}
?>
<body>
    <?php include './includes/nav.php'; ?>
  <div class="am-g">
         
         <div class="am-u-sm-6 am-text-xl"> <img src="./public/picture/<?php echo $_SESSION['user']['picture'];?>" class="am-circle" width="100" height="100">
         </div>
         <div class="am-u-sm-6"></div>
    </div>
   <div class="am-g">
         <div class="am-u-sm-6">    
                   <form action="user.php" method="post" enctype="multipart/form-data"><!--enctype属性必须要改-->
                   		 <div class="am-form-group am-form-file">
	                         <p class="am-text-xl">修改头像：</p>
	                         <button type="button" class="am-btn am-btn-default am-btn-sm">
	                         <i class="am-icon-cloud-upload am-text-xl"></i> 浏览</button>
	                         <input type="file" name="avatar" required>
                    	 </div>
                    	 <input type="submit" value="更新">
                   </form>
         </div>
         <div class="am-u-sm-6"></div> 
    <div class="am-g">  
         <div class="am-u-sm-6"></div>   
         <div class="am-u-sm-6 am-text-xl">id:<?php echo $_SESSION['user']['id']; ?></div>
         
    </div>
    <div class="am-g">
         <div class="am-u-sm-6"> </div>
         <div class="am-u-sm-6 am-text-xl"> 用户名：<?php echo $_SESSION['user']['name']; ?></div>
    </div>
    </div>
    <div class="am-g">
         <div class="am-u-sm-6"> </div>
         <div class="am-u-sm-6 am-text-xl">邮箱：<?php echo $_SESSION['user']['email']; ?></div>
         
    </div>
    <div class="am-g">
         <div class="am-u-sm-6"> </div>
         <div class="am-u-sm-6 am-text-xl"> 电话：<?php echo $_SESSION['user']['mobile']; ?></div>
    </div>
    <div class="am-g">
         <div class="am-u-sm-6"> </div>
         <div class="am-u-sm-6 am-text-xl" >创建日期：<?php echo $_SESSION['user']['created_at']; ?></div> 
         
    </div>
        <div class="am-g">
         <div class="am-u-sm-6"> </div>
         <div class="am-u-sm-6 am-text-xl"> <a href="./changepassword.php">修改密码</a></br> </div> 
         
    </div>
    <?php include './includes/footer.php';?>
</body>
<?php
include './includes/page-end.php';
?>

