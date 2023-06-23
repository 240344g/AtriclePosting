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

// Bootstrap the framework - THIS LINE NEEDS TO BE FIRST!
require COREPATH.'bootstrap.php';

// Add framework overload classes here
\Autoloader::add_classes(array(
	// Example: 'View' => APPPATH.'classes/myview.php',
	'Login\\CheckUserInfo' => __DIR__.'/classes/model/Login/CheckUserInfo.php',
	'SignIn\\InsertUserInfo' => __DIR__.'/classes/model/Signin/InsertUserInfo.php',
	'Top\\GetArticles' => __DIR__.'/classes/model/Top/GetArticles.php',
	'MyPage\\GetMyArticles' => __DIR__.'/classes/model/MyPage/GetMyArticles.php',
	'MyPage\\UpdateUserInfo' => __DIR__.'/classes/model/MyPage/UpdateUserInfo.php',
	'MyPage\\DeleteAccount' => __DIR__.'/classes/model/MyPage/DeleteAccount.php',
	'MyPage\\DeleteArticle' => __DIR__.'/classes/model/MyPage/DeleteArticle.php',
	'Writing\\PostArticle' => __DIR__.'/classes/model/Writing/PostArticle.php',
	'Writing\\UpdateArticle' => __DIR__.'/classes/model/Writing/UpdateArticle.php',
	'Article\\GetArticleContents' => __DIR__.'/classes/model/Article/GetArticleContents.php',
	'Article\\CheckHeart' => __DIR__.'/classes/model/Article/CheckHeart.php',
	'Article\\AddHeart' => __DIR__.'/classes/model/Article/AddHeart.php',
	'Article\\DeleteHeart' => __DIR__.'/classes/model/Article/DeleteHeart.php',
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
Fuel::$env = Arr::get($_SERVER, 'FUEL_ENV', Arr::get($_ENV, 'FUEL_ENV', getenv('FUEL_ENV') ?: Fuel::DEVELOPMENT));

// Initialize the framework with the config file.
\Fuel::init('config.php');
