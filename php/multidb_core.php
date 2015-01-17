<?php
include_once 'db_core.php';

function database_search_prepare($gid) {
	//first of all, item names have to be extracted from the POST.
	switch ($gid) {
		case 730:
			//item names in CSGO are sent with commas before and after and are always stored in a key with as_values_* in it.
			foreach ($_POST as $k => $v) {
				if (strpos($k, 'as_values_') !== false) {
					$len       = strlen($v) - 2;
					$item_name = substr($v, 1, $len);
				}
			}
			search_730($item_name);
			break;

		case 440:
			search_440();
			break;
	}
}

function current_user_states(&$profiles100) {
	$playerData = json_decode(get_data('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . AKey() . '&steamids=' . implode($profiles100, ',') . '&format=json'), true);
	if (isset($playerData["response"]["players"]['0']["steamid"])) {
		foreach ($playerData['response']['players'] as $key => $UTDprofile) {
			$user_profile_states[$key]['profile']['personaname']  = $UTDprofile['personaname'];
			$user_profile_states[$key]['profile']['avatarmedium'] = $UTDprofile['avatarmedium'];
			$profiles100[$key]['profile']['personastate']         = $UTDprofile['personastate'];
			$user_profile_states[$key]['profile']['lastlogoff']   = $UTDprofile['lastlogoff'];
			if (isset($userProfile['gameid'])) {
				$user_profile_states[$key]['profile']['gameid'] = $UTDprofile['gameid'];
			}
		}
	} else {
		return false;
	}
}

function userItems_440($bp, $sdata) {

	$res = '';
	$c   = count($bp);
	if ($c > 5) {
		$c = ' + ' . ($c - 5) . ' more.';
	} else {
		$c = '';
	}

	foreach ($bp as $k => &$item) {
		item_prepare($item);
		item_price($item);
	}
	usort($bp, 'cmp_refined');
	$bp = array_slice($bp, 0, 5);
	foreach ($bp as $k => $item) {
		$res .= item_image($item);
	}
	return $res . $c;
}

function userItems_730($bp, $item_name) {
	$result = '';
	foreach ($bp as $item) {

		item_prepare($item);

		if (!isset($item['market_hash_name']) || !isset($item['classid']) || !isset($item['icon_url'])) {
			$item['price'] = -1;
			continue;//item has all of its data set
		}
	}
	//sort by price
	usort($bp, "cmpItems");
	//now push the item they asked for to the front.
	foreach ($bp as $k => $item) {
		if ($item['market_hash_name'] == $item_name && $k !== 0) {
			array_unshift($bp, $item);
			unset($bp[$k + 1]);
		}

	}

	$bp = array_slice($bp, 0, 4);

	foreach ($bp as &$item) {
		$result .= item_image($item, $count_list[$item['market_hash_name']]);
	}
	return $result;
}

function userlist_display($cursor, $sdata, $gid) {
	echo '<input type="hidden" id=gameid value="' . $gid . '"><table><thead><tr><th>user data</th><th>Reserve</th><th>Last Online</th><th>Last Updated</th><th>Items</th></tr></thead><tbody>';
	current_user_states($cursor);
	foreach ($cursor as $profile) {
		$result = '';

		switch ($gid) {
			case 730:
				$result = userItems_730($profile['bp'], $sdata);
				break;
			case 440:
				$result = userItems_440($profile['unusual'], $sdata);
				break;

			default:
				echo '</tbody></table>';
				echo 'We don\'t support that game at this time...';
				return 0;
		}

		$userStateNames = array(0 => 'Offline', 1 => 'Online', 2 => 'Busy', 3 => 'Away', 4 => 'Snooze', 5 => 'looking to trade', 6 => 'looking to play');

		if (isset($profile['profile']['gameid'])) {
			$current_state = '<span class=game>' . /*getGameName( $profile['profile']['gameid'], $gameList )*/'in-game.' . '</span>';
		} else if (isset($profile['profile']['personastate']) && ($profile['profile']['personastate'] != 0)) {
			$current_state = '<span class=off>' . $userStateNames[$profile['profile']['personastate']] . '</span>';
		} else if (isset($profile['profile']['lastlogoff'])) {
			$current_state = date('d', $profile['profile']['lastlogoff']) . ' ' . date('M', $profile['profile']['lastlogoff']);
		} else {
			$current_state = "";
		}

		echo profileBlockArea($profile['profile'], $gid, $profile['hrs']), '<td><form action=#><input type="submit" name="' . $profile['_id'] . '" value="' . (($_SERVER['PHP_SELF'] == '/dblist.php') ? 'un' : '') . 'reserve"/></form></td><td>' . $current_state . '</td><td>' . date('d', $profile['recent']) . ' ' . date('M', $profile['recent']) . '</td><td class="pitms rt">', $result, '</td></tr>';
	}
	echo '</tbody></table>';
}

function search_730($item_name) {
	include '730_core.php';
	$c = db_init('archive', 'items_730');

	$sort = 'hrs.730';

	$sortList = array(1 => 'hrs.730', 2 => 'recent', 3 => 'first');

	if (isset($_POST['sortby']) && isset($sortList[$_POST['sortby']])) {
		$sort = $sortList[$_POST['sortby']];
	}

	$sortorder = 1;

	if (isset($_POST['sortorder']) && $_POST['sortorder'] == 2) {
		$sortorder = -1;
	}
	$outdate_reserve = time() - 432000;
	$res             = $c->find(array('bp.market_hash_name' => (string) $item_name, 'date_reserved' => array('$not' => array('$gt' => $outdate_reserve))))->limit(100)->sort(array($sort => $sortorder));
	$count           = $res->count();
	echo '<h2>Searching for CSGO item: <span class=Covert_BG>&nbsp;', htmlentities($item_name), '&nbsp;</span>. ' . $count . (($count != 1) ? ' matches' : ' match') . ' found.</h2>';
	if ($count > 0) {
		userlist_display($res, $item_name, 730);
	}
}

function search_440() {
	include '440_core.php';

	if (!isset($_GET['pg'])) {
		$defindex = array();

		$effect = array();
		foreach ($_POST as $key => $value) {
			if (stripos($value, ",") > -1) {//this is to find the array key where the script stored the values.
				$process = explode(',', $value);
				foreach ($process as $key => $value) {
					if (stripos($value, "def_") > -1) {
						$defindex[] = preg_replace("/[^0-9]/", "", $value);
					}
					if (stripos($value, "eff_") > -1) {
						$effect[] = preg_replace("/[^0-9]/", "", $value);
					}
				}
			}
		}
	} else {
		$defindex = (int) $_GET['def'];
		$effect   = (int) $_GET['eff'];
		$pg       = $_GET['pg'];
		var_dump_html($_GET);
	}

	if (isset($_GET['pg']) && is_numeric($_GET['pg'])) {
		$pg = (int) $_GET['pg'];
	}

	$input = array('defindex' => $defindex, 'effect' => $effect, 'pg' => $pg);

	/*Here's how it works. The parameters are only used if they are present.
	If they are not present, they are not used as a part of the query and they are therefore equivalent to an sql "*".*/
	//find
	$qWhere = array();

	if (!isset($input) || $input == NULL || empty($input)) {
		echo "No data submitted<br>";
		return 0;
	}

	//$defVal = array( '$exists'=>true );

	$match = array();

	//{"unusual":{"$all":[{"$elemMatch":{"defindex":30030,"_particleEffect":{"$exists":true}}}]},"date_reserved":{"$not":{"$gt":1409106749}}}
	//{"unusual":{"$all":[{"$elemMatch":{"defindex":"30030"}, "_particleEffect":{"$exists":true}}]},"date_reserved":{"$lt":1409106917}}

	if (!in_array(1, $input['defindex']) && !empty($input['defindex'][0])) {
		$match['$elemMatch']['defindex'] = (int) $input['defindex'][0];
	} else {
		$match['$elemMatch']['defindex']['$exists'] = true;
	}

	if (!in_array(1, $input['effect']) && !empty($input['effect'][0])) {
		$match['$elemMatch']['_particleEffect'] = (int) $input['effect'][0];
	} else {
		$match['$elemMatch']['_particleEffect']['$exists'] = true;
	}

	$outdate_reserve = time() - 432000;
	$query           = array('unusual' => array('$all' => array($match)), 'date_reserved' => array('$not' => array('$gt' => $outdate_reserve)));

	//echo json_encode($query);

	//{ price: { $not: { $gt: 1.99 } } }
	//{ "price": { "$not": { "gt": 1.99 } } }
	//'date_reserved' => array( '$not' => array( 'gt' => $outdate_reserve ) )
	//echo '<br><br>' . json_encode( $query ) . '<br><br><br>';

	if (isset($pg) && $pg != 0) {
		$skip = (int) $pg * 100;
	} else {
		$skip = 0;
	}

	$col = db_init('items', 'unusual');

	$sort = 'hrs.440';

	$sortList = array(1 => 'hrs.440', 2 => 'recent', 3 => 'first');

	if (isset($_POST['sortby']) && isset($sortList[$_POST['sortby']])) {
		$sort = $sortList[$_POST['sortby']];
	}

	$sortorder = 1;

	if (isset($_POST['sortorder']) && $_POST['sortorder'] == 2) {
		$sortorder = -1;
	}

	$cursor      = $col->find($query)->sort(array($sort => $sortorder))->limit(100)->skip($skip);
	$resultCount = 0;
	$resultCount = $cursor->count();
	if ($resultCount > 0) {
		echo $resultCount . ' Users found.<br>';
		userlist_display($cursor, $input, 440);
		if (is_array($defVal)) {$defVal = 1;
		}

		if (is_array($effVal)) {$effVal = 1;
		}

		$page = $pg + 1;

		echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="GET"><br><br>Next Page: <input type="hidden" name="def" value="' . (int) $defindex[0] . '"><input type="hidden" name="eff" value="' . (int) $effect[0] . '"><input type="hidden" name="gid" value=440><input type="submit" name="pg" value="' . (int) $page . '"></form>';
	} else {

		echo 'No matches found.';
	}
}

function arrayToNumeric($array) {
	$numeric_array = array();
	foreach ($array as $key => $value) {
		$numeric_array[$key] = (float) $value;
	}
	return $numeric_array;
}
