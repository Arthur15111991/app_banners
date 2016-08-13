<?php

if(!class_exists('BannersEdit')) {
  	class BannersEdit 
  	{
  		private function fn_get_banner_data($wpdb, $banner_id)
  		{
  			$b_table = "dp24_banners";
      		$ab_table = "dp24_apps_banners";
      		$banner_data = $wpdb->get_row("SELECT * FROM {$b_table} WHERE id = " . $banner_id, ARRAY_A);
      		return $banner_data;
	        
  		}

  		private function fn_get_app_banner_data($wpdb, $banner_id)
  		{
      		$ab_table = "dp24_apps_banners";
  			$app_banner_data = $wpdb->get_results("SELECT * FROM {$ab_table} WHERE bannerId = " . $banner_id, ARRAY_A);
  			return $app_banner_data;
  		}

		public function page()
		{
			global $wpdb;

      		$b_table = "dp24_banners";
      		$ab_table = "dp24_apps_banners";

			if(isset($_GET['mode'])) {
				$mode = $_GET['mode'];
			}
			else {
				$mode = 'banner_add';		
			}

			if(isset($_GET['item'])) {
				$item = $_GET['item'];
			}
			else {
				$item = null;
			}

			if(isset($_POST['update_banner'])) {
				$is_update = (!empty($_POST['banner_data']['id'])) ? true : false;
				self::fn_update_banner_date($wpdb, $_POST['banner_data'], $_POST['banner_data']['id'], $_POST['link_data'], $is_update);
	        }

			if ($mode == 'edit') {
	            $banner_data = self::fn_get_banner_data($wpdb, $item);
	            $app_banner_data = self::fn_get_app_banner_data($wpdb, $item);
	            
	        } else {
	            $banner_data = array();
	            $app_banner_data = array();
	        } ?>
			<div class="wrap">
				<h2><?php echo ( ( ($mode === 'banner_add')) ? __('New Banner', BANNER_DOMAIN) : __('Edit Banner', BANNER_DOMAIN) . ' (' . 'ID ' . $item . ')' ); ?></h2>
			  	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
			  	<input type="hidden" name="banner_data[id]" value="<?php if ($mode == 'edit') echo $banner_data['id'];?>" >
			  		<div id="post-body" style="width:450px; float:left;">
			  			<div id="banner-title">
			  				<p>
			              	<label for="title"><?php _e('Name', BANNER_DOMAIN); ?></label>
			              	<input id="title" type="text" style="width:100%;" size="30" name="banner_data[name]" value="<?php if ($mode == 'edit') echo $banner_data['name']; ?>">
			              	</p>
				        </div>
			  			<div class="banner-comments">
			  				<p>
							<label for="comments"><?php echo __('Comments', BANNER_DOMAIN).':'; ?></label>
							<textarea id="comments" name="banner_data[comments]" style="width:100%; height: 80px;" ><?php if ($mode == 'edit')  echo $banner_data['comment']?></textarea>
							</p>
			            </div>
			            <div id="banner-image-name">
			            	<p>		            
			              	<label for="image_name"><?php _e('image_name', BANNER_DOMAIN); ?></label>
			              	<input id="image_name" style="width:100%;" type="text" size="30" name="banner_data[image_name]" value="<?php if ($mode == 'edit')  echo $banner_data['imageName']; ?>">
			              	</p>
				        </div>
			            <div id="banner-link">
			            	<p>
			              	<label for="link"><?php _e('link', BANNER_DOMAIN); ?></label>
			              	<input id="link" style="width:100%;" type="text" size="30" name="banner_data[link]" value="<?php if ($mode == 'edit')  echo $banner_data['link']; ?>">
			              	</p>
				        </div>
				        <button id="submit_button" class="color-btn color-btn-left" name="update_banner" type="submit">
			          		<?php _e('Save', BANNER_DOMAIN) ?>
			        	</button>
			  		</div>	  		


			  		<script type="text/javascript">
                      	/* <![CDATA[ */
							jQuery( "#clone_button" ).click(function() {
							  	jQuery('#link_data').clone().appendTo('.container');
							});
                      	/* ]]> */
                    </script>			  		
			  	</form>
			</div>
<?php
  		}
  	}
}

