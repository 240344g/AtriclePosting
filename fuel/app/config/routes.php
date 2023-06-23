<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

use Controller\Welcome;

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'loginSignIn/login',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	'_404_' => 'welcome/404',

	/**
	 * -------------------------------------------------------------------------
	 *  Example for Presenter
	 * -------------------------------------------------------------------------
	 *
	 *  A route for showing page using Presenter
	 *
	 */

	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),

	// ログインページ
	"login" => "loginSignIn/login",

	// ログインページ（リダイレクト用）
	"login_re" => "loginSignIn/login_re",

	// 新規登録ページ
	"sign_in" => "loginSignIn/sign_in",

	// 新規登録ページ（リダイレクト用）
	"sign_in_re" => "loginSignIn/sign_in_re",

	// トップページ
	"top" => "afterLogin/top",

	// マイページ
	"my_page" => "afterLogin/my_page",

	// 執筆ページ
	"writing" => "afterLogin/writing",

	// 記事ページ
	"article" => "afterLogin/article",
);
