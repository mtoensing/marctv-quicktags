<?php
/*
  Plugin Name: Simple Comment Quicktags
  Plugin URI: https://marc.tv/marctv-wordpress-plugins/
  Description: Make commenting easier with bold, italic, add link and quote buttons on top of the form.
  Version: 2.7
  Author: Marc Tönsing
  Author URI: https://marc.tv
  Text Domain: marctv-quicktags

	Original author until 2010: Marc Tönsing -- http://www.marctv.de/blog/2010/08/25/marctv-wordpress-plugins/
	Rewritten by Mika Epstein 2012-2018 (ipstenu@halfelf.org)
	This version is based on the code by Mika Epstein.

	This file is part of Simple Comment Quicktags, a plugin for WordPress.

	Simple Comment Quicktags is free software: you can redistribute it and/or
	modify it under the terms of the GNU General Public License as published
	by the Free Software Foundation, either version 2 of the License, or
	(at your option) any later version.

	Simple Comment Quicktags is distributed in the hope that it will be
	useful, but WITHOUT ANY WARRANTY; without even the implied warranty
	of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with WordPress.  If not, see <http://www.gnu.org/licenses/>.
*/


if ( !class_exists( 'SimpleCommentsQuicktags' ) ) {
	class SimpleCommentsQuicktags {

		protected static $version;

		/**
		 * __construct
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
			add_action( 'init', array( &$this, 'init' ) );

			// Setting plugin defaults here:
			self::$version = '2.6';

		}

		/**
		 * init function.
		 *
		 * @access public
		 * @return void
		 */
		public function init() {

			if( !is_admin() && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
				add_action( 'wp_print_scripts', array( $this,'add_scripts_frontend' ) );
				add_action( 'wp_print_styles', array( $this,'add_styles_frontend' ) );
			}
		}

		function add_styles() {
			wp_enqueue_style( 'basic-comment-quicktags', plugins_url( '/quicktags.css' ,__FILE__) );
		}

		function add_scripts() {
			wp_enqueue_script( 'basic-comment-quicktags', plugins_url( '/quicktags.js' ,__FILE__ ), array( 'quicktags' ), self::$version, 1 );
			wp_localize_script('basic-comment-quicktags', 'scq_script_vars', array(
				'quote' => __('quote', 'marctv-quicktags')
			) );
		}

		/**
		 * add_styles_frontend function.
		 *
		 * @access public
		 * @return void
		 */
		function add_styles_frontend() {
			if ( is_singular() && comments_open() ) {
				$this->add_styles();
			}
		}

		/**
		 * add_scripts_frontend function.
		 *
		 * @access public
		 * @return void
		 */
		function add_scripts_frontend() {

			if ( is_singular() && comments_open() ) {
				$this->add_scripts();
			}
		}
	}
}

//instantiate the class
if ( class_exists( 'SimpleCommentsQuicktags' ) ) {
	new SimpleCommentsQuicktags();
}
