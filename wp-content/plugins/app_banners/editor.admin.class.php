<?php

if(!class_exists('BannersEdit')) {
  	class BannersEdit 
  	{
  		private function fn_update_banner_date($wpdb, $banner_data, $banner_id = 0, $app_banner_data = array(), $is_update = false)
  		{
  			$b_table = "dp24_banners";
      		$ab_table = "dp24_apps_banners";

  			$post_data = array(
  				'name' => stripslashes($banner_data['name']),
				'imageName' => stripslashes($banner_data['image_name']),
				'link' => stripslashes($banner_data['link']),
				'comment' => stripslashes($banner_data['comments'])
  			);
  			$formatRow = array( '%s', '%s', '%s', '%s');
  			if ($is_update) {
  				$wpdb->update($b_table, $post_data, array('id' => $banner_id), $formatRow);	
  			} else {
  				$wpdb->insert($b_table, $post_data, $formatRow);
  				$banner_id = $wpdb->insert_id;
  			}
  			
        	for ($i = 0; $i < count($app_banner_data['platform']); $i++) {
        		if (empty($app_banner_data['link'][$i]) || empty($app_banner_data['order_by'][$i])) {
        			continue;
        		}
				$insertRows = array (
					'bannerId' => $banner_id,
					'app' => $app_banner_data['app'][$i],
					'platform' => $app_banner_data['platform'][$i],
					'link' => $app_banner_data['link'][$i],
					'orderBy' => $app_banner_data['order_by'][$i],
					'isActive' => (empty($app_banner_data['is_active'][$i])) ? false : true,
				);
				$formatRow = array( '%d', '%s', '%s', '%s', '%d', '%d');
				if (!empty($app_banner_data['link_id'][$i])) {
					$wpdb->update($ab_table, $insertRows, array('id' => $app_banner_data['link_id'][$i] ), $formatRow);
				} else {
					$wpdb->insert($ab_table, $insertRows, $formatRow);	
				}				
			}
  			return $banner_id;
  		}

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

			  		<div id="app_links" style="float:right; max-width:390px">
			  			<div class="container">

			  				<?php if ($mode == 'edit') foreach ($app_banner_data as $key => $value) { ?>
				  			<div id="link_data" style="border: 1px solid green; margin:5px; padding: 10px; text-align: center;">
				  				<input type="hidden" name="link_data[link_id][]" value="<?php echo $value['id']?>">
				  				<select id="platform[]" name="link_data[platform][]">
						        	<option <?php if ($value['platform'] == 'android') {?> selected <?php } ?> value="android">android</option>
						        	<option <?php if ($value['platform'] == 'ios') { ?> selected <?php } ?> value="ios">ios</option>
						        	<option <?php if ($value['platform'] == 'windowsphone') { ?> selected <?php } ?>  value="windowsphone">windowsphone</option>
						        	<option <?php if ($value['platform'] == 'amazon') { ?> selected <?php } ?> value="amazon">amazon</option>
						        </select>
						        <select id="app[]" name="link_data[app][]">
						        	<option <?php if ($value['app'] == 'drumpads24') {?> selected <?php } ?> value="drumpads24">drumpads24</option>
						        	<option <?php if ($value['app'] == 'dubstepdrumpads24') {?> selected <?php } ?> value="dubstepdrumpads24">dubstepdrumpads24</option>
						        	<option <?php if ($value['app'] == 'electrodrumpads24') {?> selected <?php } ?> value="electrodrumpads24">electrodrumpads24</option>
						        	<option <?php if ($value['app'] == 'hiphopdrumpads24') {?> selected <?php } ?> value="hiphopdrumpads24">hiphopdrumpads24</option>
						        	<option <?php if ($value['app'] == 'trapdrumpads24') {?> selected <?php } ?> value="trapdrumpads24">trapdrumpads24</option>
						        </select>
				  				<input type="text" id="link[]" name="link_data[link][]" placeholder="link" value=<?php echo $value['link'] ?>>
				  				<input type="text" id="order_by[]" name="link_data[order_by][]" placeholder="order by" value=<?php echo $value['orderBy'] ?>>

				  				<input type="checkbox" name="link_data[is_active][]" id="is_active" value="1" <?php checked(1, $value['isActive']); ?> >
                        		<label for="is_active"><?php _e('status', SAM_DOMAIN); ?></label>
				  			</div>
			  			
			  			    <?php } ?>
			  				<div id="link_data" style="border: 1px solid green; margin:5px; padding: 10px; text-align: center;">
				  				<input type="hidden" value="" name="link_data[link_id][]" value="">
				  				<select id="platform[]" name="link_data[platform][]">
						        	<option value="android">android</option>
						        	<option value="ios">ios</option>
						        	<option value="windowsphone">windowsphone</option>
						        	<option value="amazon">amazon</option>
						        </select>
						        <select id="app[]" name="link_data[app][]">
						        	<option value="drumpads24">drumpads24</option>
						        	<option value="dubstepdrumpads24">dubstepdrumpads24</option>
						        	<option value="electrodrumpads24">electrodrumpads24</option>
						        	<option value="hiphopdrumpads24">hiphopdrumpads24</option>
						        	<option value="trapdrumpads24">trapdrumpads24</option>
						        </select>
				  				<input type="text" id="link[]" name="link_data[link][]" value="" placeholder="link">
				  				<input type="text" id="order_by[]" name="link_data[order_by][]" value="" placeholder="order by">
				  				<input type="checkbox" name="link_data[is_active][]" id="is_active[]">
                        		<label for="is_active[]"><?php _e('status', SAM_DOMAIN); ?></label>
				  			</div>
				  		</div>
			  			<button type="button" id="clone_button">
			          		<?php _e('Add_link', BANNER_DOMAIN) ?>
			        	</button>

			        	<button id="create_config_button" class="color-btn color-btn-left" name="create_config" type="submit">
			          		<?php _e('Create config', BANNER_DOMAIN) ?>
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

