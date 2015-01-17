<?php
include_once 'core.php';

function is_groupscan() {
	if ($_SERVER['PHP_SELF'] == '/440_group.php' || $_SERVER['PHP_SELF'] == '/730_group.php') {
		return 'gs';
	}
	return 'ss';
}

function globalSchemas($gid) {
	if ($gid == 440 && !isset($GLOBALS['schemas_440'])) {
		$GLOBALS['schemas_440'] = array('schema' => localSchema(), 'prices' => localPriceList(), 'est' => local_global_whitelist());
	}

	if ($gid == 730 && !isset($GLOBALS['schemas_730'])) {
		$GLOBALS['schemas_730'] = schema_730();
	}

	if ($gid == 570 && !isset($GLOBALS['schemas_570'])) {
		$GLOBALS['schemas_570']['schema'] = schema_570();
	}
}

function scan_start($input, $gid) {

	increment_scan($gid);

	$GLOBALS['users_hidden']['hours'] = 0;
	$GLOBALS['users_hidden']['worthless'] = 0;
	$GLOBALS['users_hidden']['private'] = 0;
	$GLOBALS['users_hidden']['f2p'] = 0;

	$time_start = time();
	if (!isset($input) || (empty($input) && !is_array($input))) {
		echo 'No data submitted';
		return false;
	}
	if (!is_array($input)) {
		//look for steamid32s in this string to make into an array.
		$userlist = steamidFormatConvert($input);
	} else if (is_numeric($input[0])) {
		$userlist = $input;
	}

	if (!isset($userlist[0]) || empty($userlist[0]) || !is_array($userlist) || !is_numeric($userlist[0])) {
		echo 'no steamids detected...';
		return false;
	}

	$small = 0;
	$large = 99;
	$profiles100 = array();

	globalSchemas($gid);

	if ($gid == 440) {
		preference_get();
	}

	//ob_start();

	echo '<table class="sres" ><thead><tr><th data-sort="float">player</th><th>items</th></tr></thead><tbody>';
	while ($small <= count($userlist)) {

		$profiles100 = array_slice($userlist, $small, $large);// slice it from point 0 to point 99 (100 total)
		$small += 100;
		$large += 100;
		$playerURL = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . AKey() . '&steamids=' . implode(",", $profiles100) . '&format=json';

		$playerData = json_decode(get_data($playerURL), true);

		if (isset($playerData['response']['players'][0]['steamid'])) {
			echo scan_queue($playerData['response']['players'], $gid);
		} else {
			$playerData = json_decode(get_data($playerURL), true);

			if (isset($playerData['response']['players'][0]['steamid'])) {
				echo scan_queue($playerData['response']['players'], $gid);
			} else {
				echo '</tbody></table>Something went wrong with steam!<br>';
				break;
			}
		}
	}
	echo '</tbody></table>';
	//ob_end_flush();
	echo ($GLOBALS['users_hidden']['hours']+$GLOBALS['users_hidden']['worthless']+$GLOBALS['users_hidden']['private']+$GLOBALS['users_hidden']['f2p']),
	' users hidden. ( ', $GLOBALS['users_hidden']['hours'], ' hours. ', $GLOBALS['users_hidden']['worthless'], ' worthless. ', $GLOBALS['users_hidden']['private'], ' private. ', $GLOBALS['users_hidden']['f2p'], ' F2P.', ' )<br>';
	echo 'Scan took ' . (time() - $time_start) . ' second' . (((time() - $time_start) > 1) ? 's' : '') . '. Bugs? Report them <a target=blank href=/bug.php>here</a>';
}

function isIssetReturn($var) {if (isset($var) && $var != " " && !empty($var)) {return $var;
} else {
	return false;}
}

function getLevel($sid) {
	$url = 'http://api.steampowered.com/IPlayerService/GetSteamLevel/v1/?key=' . AKey() . '&steamid=' . $sid . '&format=json';
	$lvl_json = json_decode(get_data($url), true);
	if (!isset($lvl_json['response']['player_level']) || empty($lvl_json['response']['player_level'])) {
		return false;
	}

	return (int) $lvl_json['response']['player_level'];
}

function getHours($sid) {
	$url = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=' . AKey() . '&format=json&input_json={"appids_filter":[440,570,730],"include_played_free_games":1,"steamid":' . $sid . '}';
	$playerGames = json_decode(get_data($url), true);
	$hours[440] = 0;
	$hours[570] = 0;
	$hours[730] = 0;
	if (!empty($playerGames['response']['games'])) {
		foreach ($playerGames['response']['games'] as $game) {
			if ($game['appid'] === 440) {$hours[440] = round(($game['playtime_forever'] / 60), 2);}
			if ($game['appid'] === 570) {$hours[570] = round(($game['playtime_forever'] / 60), 2);}
			if ($game['appid'] === 730) {$hours[730] = round(($game['playtime_forever'] / 60), 2);}
		}
	}
	if (empty($hours[440]) || !isset($hours[440])) {$hours[440] = 0;
	}

	if (empty($hours[570]) || !isset($hours[570])) {$hours[570] = 0;
	}

	if (empty($hours[730]) || !isset($hours[730])) {$hours[730] = 0;
	}

	return $hours;
}

function scan_queue($profile_list, $gid) {

	if (donator_level(20)) {
		$max_requests = 24;
	} else {

		$max_requests = 2;
	}

	$curl_options = array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_CONNECTTIMEOUT => 5,
		CURLOPT_TIMEOUT => 7,
		CURLOPT_FOLLOWLOCATION => TRUE
	);

	$parallel_curl = new ParallelCurl($max_requests, $curl_options);

	foreach ($profile_list as $profile) {
		if ($gid == 440) {
			$url = 'http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=' . AKey() . '&SteamID=' . $profile['steamid'] . '&format=json';
			$parallel_curl->startRequest($url, 'scan_440_single', $profile);
		}
		if ($gid == 730) {
			$url = 'http://steamcommunity.com/profiles/' . $profile['steamid'] . '/inventory/json/730/2';
			$parallel_curl->startRequest($url, 'scan_730_single', $profile);
		}
		if ($gid == 570) {
			$url = 'http://api.steampowered.com/IEconItems_570/GetPlayerItems/v0001/?key=' . AKey() . '&SteamID=' . $profile['steamid'] . '&format=json';
			$parallel_curl->startRequest($url, 'scan_570_single', $profile);
		}
		//ob_flush();
		//flush();
	}

	// This should be called when you need to wait for the requests to finish.
	// This will automatically run on destruct of the ParallelCurl object, so the next line is optional.
	$parallel_curl->finishAllRequests();

}

function profileBlockArea($profile, $gid, $steamHours = 0, $f2p = false) {
	$sid = $profile['steamid'];
	if ($profile['communityvisibilitystate'] != 15) {
		//$APIkey = AKey();
		if (isset($backpack['result']['items'])) {
			$items = $backpack['result']['items'];
		} else {
			$items = "";
		}
	} else {

		$steamHours = array(440 => -1, 570 => -1, 730 => -1);
	}

	$playerName = htmlentities($profile['personaname'], ENT_QUOTES, 'UTF-8');

	$userCards = "";
	if (isset($_SESSION['cards']) && $_SESSION['cards'] == 1 && $profile['communityvisibilitystate'] == 3) {
		$userCards = 'C: ' . getUserCards($sid);
	}

	$state = 'off';
	if (isset($profile['personastate']) && $profile['personastate'] >= 1) {
		$state = 'on';
	}
	if (isset($profile['gameid'])) {
		$state = 'game';
	}

	$BPLinks = backpack_link($sid, ((isset($_SESSION['pref']['numeric']['bp'][1]) ? $_SESSION['pref']['numeric']['bp'][1] : 1)), $gid) . backpack_link($sid, ((isset($_SESSION['pref']['numeric']['bp'][2]) ? $_SESSION['pref']['numeric']['bp'][2] : 2)), $gid);
	//This is the person's name and avatar.
	//their backpack, hours
	return '<tr><td class="pinf' . (($sid == 76561198013370444) ? ' gp-rb' : '') . '" data-sort-value="' . $steamHours[$gid] . '">' .
	'<a href="http://steamcommunity.com/profiles/' . $sid . '" target=blank>' . '<img src="' . $profile['avatarmedium'] . '" alt="Avatar" class="avatar ' . $state . '"></a>' .
	'<div class="pdata"><a class="pname ' . $state . '" href="http://steamcommunity.com/profiles/' . $sid . '" target=blank>' .
	$playerName . '</a><br>' .
	(($steamHours[$gid] != -1) ? $steamHours[$gid] : 'Private hrs') .
	'<br>' .
	$BPLinks . //backpack links
	'<a href="steam://friends/add/' . $sid . '" class="lk addi"></a>' . //add user link
	'<a href="http://steamcommunity.com/profiles/' . $sid . '/stats/TF2" target=blank class="lk stati"></a>' . //user stats link
	((isset($profile['gameserverip'])) ? '<a href="steam://connect/' . $profile['gameserverip'] . '" class="lk jns"></a>' : '') . //join server link
	(($f2p == true) ? '<div class="lk f2p">' : '') . '</div></td>';//f2p icon
}

function backpack_link($sid, $lid, $gid) {
	$BPViewers = array(
		730 => array(
			1 => 'tf2b.com/csgo/',
			2 => 'tf2b.com/csgo/',
			3 => 'endgame.tf/bp.php?sid=',
			4 => 'tf2b.com/csgo/',
			5 => 'tf2b.com/csgo/',
			6 => 'tf2b.com/csgo/',
		),
		440 => array(
			1 => 'tf2b.com/tf2/',
			2 => 'backpack.tf/profiles/',
			3 => 'endgame.tf/bp.php?sid=',
			4 => 'bazaar.tf/backpack/',
			5 => 'tf2outpost.com/backpack/',
			6 => 'tf2items.com/profiles/',
		)
	);
	return '<a href="http://' . $BPViewers[$gid][$lid] . $sid . '" target=blank class="lk bpi"></a>';
}
