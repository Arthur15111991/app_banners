<?php
/*
Plugin Name: Application banners
Plugin Script: custom-banners.php
Plugin URI: http://goldplugins.com/our-plugins/custom-banners/
Description: Allows you to create, edit custom banners for user application.
Version: 0.0.1
Author: Arthur Chernyshev
Author URI: https://vk.com/id28808075/

*/
include_once('class.config.php');
if ( !class_exists( 'AppBanners' && class_exists('AppBanners') ) ) {

	class AppBanners extends AppBannersConfig {

		function __construct()
		{
			parent::__construct();
			add_action('admin_menu', array(&$this, 'fn_reg_admin_page'));
		}

		public function fn_reg_admin_page() 
		{
	  		$menuPage = add_menu_page(__('AppBanners', BANNER_DOMAIN), __('AppBanners', BANNER_DOMAIN), BANNER_ACCESS, 'app-banners', array(&$this, 'fn_manage_banners'));
			
			add_submenu_page('app-banners', __('Manage banners', BANNER_DOMAIN), __('Manage banners', BANNER_DOMAIN), BANNER_ACCESS, 'banners-list', array(&$this, 'fn_manage_banners'));

			add_submenu_page('app-banners-list', __('Ad Editor', BANNER_DOMAIN), __('New Place', BANNER_DOMAIN), BANNER_ACCESS, 'banner-edit', array(&$this, 'fn_add_new_banner'));

			add_submenu_page('app-banners', __('Ad Editor', BANNER_DOMAIN), __('App config', BANNER_DOMAIN), BANNER_ACCESS, 'app-config', array(&$this, 'fn_manage_apps'));
		}


		public function fn_manage_banners() 
		{
		    
		}

		public function fn_add_new_banner()
		{
			
		}

		public function fn_manage_apps()
		{
			
		}
	}
}