<?php include './includes/functions.php';
	  $host_url = host_url();
?>
<header class="am-topbar am-topbar-fixed-top php-topbar-inverse">
     	<div class="am-g am-g-fixed">
		    <div class="am-u-lg-12 am-u-md-12 am-u-sm-12">
		    	<h1 class="am-topbar-brand">
			      <a href="<?php echo $host_url;?>index.php">
			           <img src="./public/images/bbs.png" alt="标识" class="am-img-thumbnail am-circle" id="php-img-flag">&nbsp; 
			           <span class="am-kai php-text-white">PHP 学习</span>
			      </a>
			    </h1>
			    <form class="am-topbar-form am-topbar-left am-form-inline php-topform-left" name="search" method="get" action="search.php" >
			     
			      <div class="am-form-group">
			        <input type="text" class="am-form-field am-input-sm" placeholder="search" required name="keyword">
			      </div>
			    </form>
		        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only am-icon-bars" data-am-collapse="{target: '#collapse-head'}">
		    		<span class="am-sr-only">导航切换</span>
		    		<span></span>
		    	</button>

			    <div class="am-collapse am-topbar-collapse" id="collapse-head">
					    <div class="am-topbar-right">

					     	  <?php 
					     	  	if (!isset($_SESSION['user']))
					     	  	{
					     	  		?>
					     	  		<button class="am-btn am-btn-primary am-topbar-btn am-btn-sm am-radius" onclick="window.location.href='<?php echo $host_url;  ?>login.php'">
						     	  		<span class="am-icon-user"></span> 登录
						     	    </button>
					     	  		<?php
					     	  	}
					     	  	else 
					     	  	{
					     	  		?>
					     	  		<a href="<?php echo $host_url; ?>user.php" class="am-btn php-button am-margin-top-xs">
					     	  			<i class="am-icon-user php-text-white"></i>&nbsp;
					     	  			<span class="php-text-white"><?php echo $_SESSION['user']['name']; ?></span>
					     	  		</a>
					     	  		<a href="<?php echo $host_url; ?>logout.php"  class="am-btn php-button am-margin-top-xs">
					     	  			<i class="am-icon-sign-out php-text-white"></i>&nbsp;
					     	  			<span class="php-text-white">注销</span>
					     	  		</a>
					     	  		<?php
					     	  	}	
					     	  ?>
					     </div>
			    </div>

		    </div>
        </div>
</header>