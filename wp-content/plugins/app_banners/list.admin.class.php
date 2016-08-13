<?php

if(!class_exists('BannersManage')) {
  	class BannersManage
  	{
		public function page() {
  			global $wpdb; 
  			$b_table = "dp24_banners"; ?>
      		<div class='wrap'>
      			<h2><?php _e('Managing Banners', BANNER_DOMAIN); ?></h2>
      		</div>
      		
      		<div class="clear"></div>
  			<table class="widefat fixed" cellpadding="0">
  				<thead>
					<tr>
						<th id="t-idg" class="column-title" style="width:5%;"><?php _e('ID', BANNER_DOMAIN); ?></th>
						<th id="t-name" class="column-title" style="width:31%;"><?php _e('Name', BANNER_DOMAIN);?></th>     
					</tr>
			    </thead>
			    <body>
			    	<?php 
			    		$bSql = "SELECT id, name FROM {$b_table}";
			    		$banners = $wpdb->get_results($bSql, ARRAY_A);

			    		foreach ($banners as $i => $banner) { ?>
					    	<tr class="<?php echo (($i & 1) ? 'alternate' : ''); ?>">
								<td class="post-title column-title"><?php echo $banner['id']; ?></td>
								<td class="post-title column-title"><strong><a href="<?php echo admin_url('admin.php'); ?>?page=banner-edit&mode=edit&item=<?php echo $banner['id']; ?>"><?php echo $banner['name'];?></a></strong>
								</td>
							</tr>
                        <?php } ?>
			    </body>
  			</table>
      		<?php
  		}
  	}
}

