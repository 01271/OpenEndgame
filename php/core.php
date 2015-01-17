<?php
#
#	core.php, this is it. This is the core of endgame. it's not actually the most important or do-it-all file but it's one of the ones that is used the most.
#	If you're reading this, I have either given up on this site, am dead, chose to fling shit at mattie for lulz or decided to be extremely generous with you all.
#	This site depends on the following:
#	PHP ( I used PHP-FPM from the rémi repository. )
#	PEAR
#	PECL
#	BCMath
#	MongoDB
#	PHP MongoDB driver
#	Add the following CSP to your headers for extra security: "default-src 'self'; script-src 'self'; img-src 'self' media.steampowered.com steamcommunity-a.akamaihd.net/economy/image/ *.steamcommunity.com/economy/image/ https://steamcommunity.com/public/images/signinthroughsteam/sits_small.png cdn.dota2.com/apps/570/icons/econ/items/ https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif https://www.paypalobjects.com/en_US/i/scr/pixel.gif;";
#	I recommend you use cron to keep everything up to date. This is my cron config accessible by using crontab -e
#
#	*/1 * * * * php -r "include('/usr/share/nginx/html/cron/mongoUpdate.php'); updateOutOfDate();" >/dev/null 2>&1
#	*/1 * * * * php -r "include('/usr/share/nginx/html/cron/phoenixmarket.php'); start_scrape();" >/dev/null 2>&1
#	*/1 * * * * php -r "include('/usr/share/nginx/html/cron/steam_averages.php'); getPrices();" >/dev/null 2>&1
#	*/20 * * * * php /usr/share/nginx/html/csgolist.php >/dev/null 2>&1
#	*/1 * * * * php -r "include('/usr/share/nginx/html/cron/market_classid_scrape.php'); market_classid_scrape( 10 );" >/dev/null 2>&1
#
#	If you want the admin page to work, you will need make your server save errors to /tmp/fpm_error.log, change the permissions so it'll play nice though.
#
#
#	###  ###  ### ### ###  ###
#	#  #  #  #     #   #  #
#	#  #  #  #  #  #   #   ##
#	#  #  #  #  #  #   #     #
#	###  ###  ### ###  #  ###
#
#
#	If I've left anything relating to my identity in these files I'd love it if you didn't harass me or anyone I know with this stuff, thanks.
#

include_once 'ui_core.php';
include_once 'openid.php';
include_once 'db_core.php';
session_set_cookie_params(172800);
ini_set('session.gc_maxlifetime', 172800);
session_start();

//this is where games-non-specific functions will go.
//get the api key. Used by all scanners pretty much.

function AKey() {return db_load('akey');}

function BKey() {return db_load('bkey');}

//get the directory for the schema and shit I store and update.
function json_directory() {$dir = $_SERVER['DOCUMENT_ROOT'] . '/api';if (!file_exists($dir)) {mkdir($dir, 0755);}return $dir;}
//this is the json_directory filepath return function.
function is_endgametf() {
	if ($_SERVER['HTTP_HOST'] == 'endgame.tf') {
		return true;
	}
	return false;}
//
function is_v4() {
	if ($_SERVER["SERVER_ADDR"] == '65.111.166.150') {
		return true;
	}
	return false;}

function session_digits() {
	if (isset($_SESSION['sid']) && $_SESSION['sid'] == 76561198013370444) {
		return true;
	}
	return false;}

function getGameName($gid, $gameList) {
	return $gameList[$gid];
}

function loadgames() {
	$dir = json_directory();
	$gameList = $dir . "/753_games.json";
	return json_decode(file_get_contents($gameList), true);
}

//preg_match_all( '/https?:\/\/steamcommunity.com\/(?:id\/([a-zA-Z0-9]{2,32})|profile\/(\d{17}))/', $input, $matches );
// /https?:\/\/steamcommunity.com\/(?:id\/([a-zA-Z0-9]{2,32})|profile\/(\d{17}))|(\d{17})/

function any_to_64($input) {
	if (substr($input, 0, 29) === 'http://steamcommunity.com/id/') {
		$vanity = rtrim(substr($input, 29, 32), '/');//remove slash if present, vanity urls are up to 32 characters.
		$userData = json_decode(get_data('http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=' . AKey() . '&vanityurl=' . $vanity), true);
		if ($userData['response']['success'] === 1) {
			return (int) $userData['response']['steamid'];
		}
		return false;
	}
	//Try if it's a steamid else return false.
	$input = preg_replace('/[^0-9]/', '', $input);
	if (is_numeric($input)) {
		return (int) $input;
	}

	return false;
}

function steamidFormatConvert($data) {
	$sidList = array();
	preg_match_all('/U:1:(\d{6,9})/', $data, $matches);
	foreach ($matches[1] as $id) {
		$sidList[] = (int) $id + 0x0110000100000000;
	}
	preg_match_all('/STEAM_[0-1]:[0-2]:[0-9]{6,9}/', $data, $matches);
	foreach ($matches[0] as $steam_id) {
		list(, $m1, $m2) = explode(':', $steam_id, 3);
		list($steam_cid, ) = explode('.', bcadd((((int) $m2 * 2) + $m1), '76561197960265728'), 2);
		$sidList[] = (int) $steam_cid;
	}
	return $sidList;
}

function form_spam_valid() {
	if (isset($_POST['token'])) {
		if ($_SESSION[$_SERVER['PHP_SELF']] == $_POST['token']) {
			return true;
		} else {
			echo 'Invalid token, try again.';
			return false;
		}
	}
	return false;
}

function form_spam_fields() {
	$t = md5(uniqid(rand(), TRUE));
	$_SESSION[$_SERVER['PHP_SELF']] = $t;
	return '<input type="hidden" name="token" value="' . $t . '">';
}
function st_click() {
	echo '<script>$(function(){var table = $("table").stupidtable();$(table).find("th").eq(0).click();});</script>';
}

function print_r_html($arr) {
	echo '<pre>';
	print_r($arr);echo '</pre>';}
function var_dump_html($array) {
	echo '<pre>';
	var_dump($array);echo '</pre>';}

function get_data($url, $timeout = 5)//Favourite cURL function, follows redirects.
{
	try {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		//if (is_endgametf())curl_setopt ($ch, CURLOPT_PORT , 6081);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	} catch (Exception $e) {
		return false;
	}
}
