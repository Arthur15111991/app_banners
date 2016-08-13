<?php

if(!class_exists('AppConfigManage')) {
  	class AppConfigManage 
  	{
  		private function fn_get_apps($wpdb)
  		{
  			$ab_table = "dp24_apps_banners";
  			$b_sql = "SHOW COLUMNS FROM {$ab_table} WHERE Field = 'app'";
			$apps = $wpdb->get_results($b_sql, ARRAY_A);
			preg_match("/^enum\(\'(.*)\'\)$/", $apps['0']['Type'], $matches);
			$enum = explode("','", $matches['1']);
			return $enum;
  		}

  		private function fn_create_config_files($wpdb, $available_apps)
  		{
  			$ab_table = "dp24_apps_banners";
  			$apps_string = "'" . implode("','", array_keys($available_apps)) . "'";
  			$apps = $wpdb->get_results("SELECT * FROM {$ab_table} WHERE app IN ($apps_string) ORDER BY platform", ARRAY_A);

  			$_apps = array();
  			foreach ($apps as $key => $app) {
  				$_apps[$app['app']][$app['platform']][] = $app;
  			}  			

  			foreach ($_apps as $key => $app) {
  				foreach ($app as $_key => $platform) {
  					$text = json_encode($platform);
  					$file_path = get_home_path() . 'wp-content/plugins/user_banners/config_files/';
	  				$file_name = $_key . '.' . $key . '.php';

					$fp = fopen($file_path . $file_name, "w");
					fwrite($fp, $text);
					fclose($fp);
  				}
  			}
  			return true;
  		}

		public function page() 
		{
  			global $wpdb;  			

  			if (isset($_POST['create_config'])) {
  				self::fn_create_config_files($wpdb, $_POST['link_data']['create_config_file']);
  			}

  			$apps = self::fn_get_apps($wpdb); ?>
  			<div class='wrap'>
      			<h2><?php _e('Application', BANNER_DOMAIN); ?></h2>      		
      		
	      		<div class="clear"></div>
	      		<form method="post" action="<?php echo $_SERVER["REQUEST_URI"];?>">
		  			<table class="widefat fixed" cellpadding="0">
		  				<thead>
							<tr>						
								<th id="t-name" class="column-title" style="width:31%;"><?php _e('Name', BANNER_DOMAIN);?></th>     
								<th id="t-status" class="column-title" style="width:5%;"><?php _e('create config', BANNER_DOMAIN); ?></th>
							</tr>
					    </thead>
					    <body>
					    	<?php foreach ($apps as $i => $app) { ?>
						    	<tr class="<?php echo (($i & 1) ? 'alternate' : ''); ?>">
									<td class="post-title column-title"><strong><?php echo $app; ?></strong></td>						
									<td class="post-title column-title"><input type="checkbox" name="link_data[create_config_file][<?php echo $app; ?>]" id="is_create"></td>
								</tr>
							<?php } ?>
					    </body>
		  			</table>
	        	</form>
        	</div>

  			<?php
  		}
  	}
}

