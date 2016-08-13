<?php

if ( !class_exists( 'AppBannersConfig' ) ) {
	class AppBannersConfig {
	  	public function __construct() {
			define('BANNER_DOMAIN', 'user-banners');
			$access = 'manage_options';
      		define('BANNER_ACCESS', $access);
		}
	}
}