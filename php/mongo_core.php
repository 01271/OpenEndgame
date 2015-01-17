<?php

require_once 'scan_core.php';
require_once '440_core.php';
/*
This is the mongoDB PHP test sheet meant to be used with TF2EG.<br>
If it doesn't look that impressive it's because there's a lot more to a database than simply looking good.<br>
Oh yeah also this is going to be storing the following:<br>
<ul>
<li>STEAMID (num) - Will be used to find the user.       </li>
<li>FIRST_SCANNED (num) - When was he added here?      </li>
<li>RECENT_SCANNED (num) - Is the data fresh?          </li>
<li>SAPI_INFO (string) - Steam API Info, I want everything.  </li>
<li>TF2BP_JSON (string) - backpack, not storing whitespace.  </li>
<li>HASBUDS (num) - make searching faster for buds.      </li>
<li>HASUNUSUAL (num) - make searching faster for unusuals.   </li>
<li>HIGHEST_ITEM_ID (num) estimate what days items were made.</li>
<li>API KEY used for scan - identify users who are griefing. </li>
</ul>
Not sure what else to add in here, seems to be that this is going to work well for now.<br>
But if there's stuff to add I'd be happy to hear about it.<br>
 */

//db.items_440.find({'bp.result.items.defindex':5726}).pretty().limit(1)

function arrayToNumeric(&$array) {
	foreach ($array as &$key) {
		if (is_array($key)) {
			arrayToNumeric($key);
		} else {

			$key = intval($key);
		}
	}
}

function returnAllUserData($profile) {
	$playerURL = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . AKey() . "&steamids=" . $profile . "&format=json";//can take multiple players with commas.
	$playerData = json_decode(get_data($playerURL), true);
	return $playerData['response']['players'];
}

function userList($cursor, $input) {
	$userList = array();
	foreach ($cursor as $document) {
		array_push($userList, $document['_id']);
	}
	$upToDateUserData = checkCurrentUserData($userList);
	//print_r_html($upToDateUserData);
	if ($upToDateUserData === 0) {
		echo "could not get updated data due to steam servers.<br>";
	}

	$allSchema = localSchema();
	$allItemValues = localPriceList();
	$gameList = loadgames();
	echo '<table><thead></thead><tbody>';
	echo '<tr><td>user data</td><td>Reserve</td><td>Last Online</td><td>Last Updated</td><td>Items</td></tr>';

	foreach ($cursor as $user) {
		$f2pstate = "";
		if ($upToDateUserData != 0) {

			$userStateNames = array(0 => 'Offline', 1 => 'Online', 2 => 'Busy', 3 => 'Away', 4 => 'Snooze', 5 => 'looking to trade', 6 => 'looking to play');

			if (isset($upToDateUserData[$user['_id']]['gameid'])) {
				$current_state = '<span class=game>' . getGameName($upToDateUserData[$user['_id']]['gameid'], $gameList) . '</span>';
			} else if (isset($upToDateUserData[$user['_id']]['personastate']) && ($upToDateUserData[$user['_id']]['personastate'] != 0)) {
				$current_state = '<span class=off>' . $userStateNames[$upToDateUserData[$user['_id']]['personastate']] . '</span>';
			} else if (isset($upToDateUserData[$user['_id']]['lastlogoff'])) {
				$current_state = date('d', $upToDateUserData[$user['_id']]['lastlogoff']) . ' ' . date('M', $upToDateUserData[$user['_id']]['lastlogoff']);
			} else {
				$current_state = "";
			}
		} else {
			$current_state = "";
		}

		if (isset($user['TF2BP']['result']['num_backpack_slots']) && $user['TF2BP']['result']['num_backpack_slots'] < 200) {
			$f2pstate = "<b>F2P.</b>";
		}

		$lastScanned = date('d', $user['recent']) . ' ' . date('M', $user['recent']);

		echo profileBlockArea($user, 440, $user['hrs']) . //'<a href="http://bazaar.tf/profiles/' . $user['_id'] . '/" title="Bazaar" target="blank"><img src="/img/bztf.png"></a>' . '<a href="http://tf2outpost.com/user/' . $user['_id'] . '/" title="outpost" target="blank"><img src="/img/tfop.png"></a><a href="steam://friends/add/' . $user['_id'] . '"><img src="/img/addUser.png" title="Add user" alt="Add user"></a>' .
		'<td><form action=""><input type="submit" name="' . $user['_id'] . '" value="' . (($_SERVER['PHP_SELF'] == '/dblist.php') ? 'un' : '') . 'reserve"/></form></td>' .
		'<td>' . $current_state . '</td><td>' . $lastScanned . '</td><td class="pitms">';

		$userNumOfItems = 0;
		foreach ($user['unusual'] as &$item) {

			$item['crateNum'] = 0;//be sure to set it to 0 or else it will be really confused.
			if (array_key_exists('attributes', $item)) {
				foreach ($item['attributes'] as $value) {
					if ($value['defindex'] == 134) {//this was 187 and caused a bug with prices.
						$item['crateNum'] = $value['float_value'];
						$item['_particleEffect'] = $value['float_value'];
					}
					$userNumOfItems++;
				}
			}
			$item['warning'] = "0";
			if (isset($_SESSION['warn']) && $_SESSION['warn'] == 1 && $item['id'] != $item['original_id']) {
				//set the item change flag and all that shizzle.
				$item['warning'] = ' Item ID is different than original ID.';
			}

			item_prepare($item);
			item_price($item);
			if ((!isset($input['defindex']) || in_array($item['defindex'], $input['defindex'])) && (!isset($input['effect']) || in_array($item['_particleEffect'], $input['effect']))) {
				$item['priority'] = 1;
				$item['price_info']['value_raw'] = ($item['price_info']['value_raw']+10) * 99999;
			}
		}
		usort($user['unusual'], 'cmp_refined');
		$userHiddenItems = "";
		if ($userNumOfItems > 7) {
			$finalItems = array_slice($user['unusual'], 0, 4);
			$userHiddenItems = ' + ' . ($userNumOfItems - 4) . ' more unusuals.';
		} else {

			$finalItems = $user['unusual'];
		}

		foreach ($finalItems as $item) {
			if (isset($item['priority'])) {
				echo item_image($item);
			} else {

				echo item_image($item);
			}
			// item is not prioritized, make the item smaller in the future.
		}
		echo $userHiddenItems . '</td></tr>';
	}
	echo '</table>';
}

function mongoHandler($input) {
	/*Here's how it works. The parameters are only used if they are present.
	If they are not present, they are not used as a part of the query and they are therefore equivalent to an sql "*".*/
	//find
	$qWhere = array();

	if (!isset($input) || $input == NULL || empty($input)) {
		echo "No data submitted<br>";
		break;
	}

	if (in_array(1, $input['defindex']) || empty($input['defindex'])) {
		$defVal = array('$exists' => true);
	} else {
		arrayToNumeric($input['defindex']);
		$defVal = reset($input['defindex']);
	}//use the defindex array as a parameter.

	if (in_array(1, $input['effect']) || empty($input['effect'])) {
		$effVal = array('$exists' => true);
		//search type is any effect
	} else {
		arrayToNumeric($input['effect']);
		$effVal = reset($input['effect']);
	}
	$outdate_reserve = time() - 432000;
	if (isset($defVal) && isset($effVal)) {
		$match = array('$elemMatch' => array('defindex' => $defVal, '_particleEffect' => $effVal));
		$query = array('unusual' => array('$all' => array($match)), 'date_reserved' => array('$not' => array('$gt' => $outdate_reserve)));
		//{ price: { $not: { $gt: 1.99 } } }
		//{ "price": { "$not": { "gt": 1.99 } } }
		//'date_reserved' => array( '$not' => array( 'gt' => $outdate_reserve ) )
		//echo '<br><br>' . json_encode( $query ) . '<br><br><br>';

		if ($input['pg'] != 0) {
			$skip = (int) $input['pg'] * 100;
		} else {
			$skip = 0;
		}

		$m = new MongoClient();
		$db = $m->items;
		$collection = $db->unusual;

		$cursor = $collection->find($query)->sort(array("hrs.440" => 1))->limit(100)->skip($skip);
		$resultCount = 0;
		$resultCount = $cursor->count();
		if ($resultCount > 0) {
			echo $resultCount . ' Users found.<br>';
			userList($cursor, $input);
			if (is_array($defVal)) {$defVal = 1;
			}

			if (is_array($effVal)) {$effVal = 1;
			}

			$page = $input['pg']+1;

			echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="GET"><br><br>Next Page: <input type="hidden" name="def" value="' . $defVal . '"><input type="hidden" name="eff" value="' . $effVal . '"><input type="submit" name="pg" value="' . $page . '"></form>';
		} else {

			echo 'No matches found.';
		}

	}
}

function getFriendListProfiles($profile) {
	$profile = $profile;
	$profiles = "";
	$userFriends = array();
	$userURL = "http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=" . AKey() . "&steamid=" . $profile . "&relationship=friend";
	$userFriends = json_decode(get_data($userURL), true);

	if (!empty($userFriends)) {
		$userFriends = $userFriends['friendslist']['friends'];
		$profiles = array();

		foreach ($userFriends as $friend) {
			array_push($profiles, $friend['steamid']);
		}
	}

	return $profiles;
}

function getBackPack($profile) {
	$backpackURL = "http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=" . AKey() . "&SteamID=" . $profile . "&format=json";
	$userBackpack = json_decode(get_data($backpackURL), true);

	if ($userBackpack['result']['status'] == 1) {
		return $userBackpack;
	} else {

		return 0;
	}
}

function addUserToDB($profile, $backpack, $steamHours) {
	//this is where the magic happens. Add a user to the database!
	//check if user already existed, if yes, get the original timestamp.
	//echo ".";
	$last_scanned = time();

	$m = new MongoClient();
	$db = $m->steamUsers;
	$collection = $db->targets;
	if (!isset($steamHours[440])) {
		$steamHours[440] = 0;
	}

	if (!isset($steamHours[570])) {
		$steamHours[570] = 0;
	}

	if ((isset($profile['steamid'])) && ($backpack['result']['status'] === 1)) {
		$where = array('_id' => $profile['steamid']);//where //end where

		$data =
		array(
			'$setOnInsert' => array(
				'FIRST_SCANNED' => $last_scanned,
			), //end setoninsert

			'$set' => array(
				"SAPI_INFO" => $profile,
				"RECENT_SCANNED" => (int) $last_scanned,
				"TF2BP" => $backpack,
				"440_HRS" => (float) $steamHours[440],
				"570_HRS" => (float) $steamHours[570],
			)//end set
		);

		$mongoptions = array('upsert' => true);//replace document details if the entry exists.

		$collection->update($where, $data, $mongoptions);
		//print_r_html($db->lastError());
		//echo "user added to db.<br>";
	}

}

function targetCount() {

	$m = new MongoClient();
	$db = $m->items;
	$collection = $db->unusual;
	$cursor = $collection->count('unusual.defindex');
	return $cursor;
}

function dumpDB() {
	$m = new MongoClient();
	$db = $m->steamUsers;
	$collection = $db->targets;
	$cursor = $collection->find();

	echo "<table>";
	foreach ($cursor as $document) {
		//echo "<tr><td>" . $document["SAPI_INFO"]['personaname'] . "</td> <td>" . $document["TF2_HRS"] . "</td></tr>";
	}
	echo "</table>";
}

function ItemNameToDefindex($itemName) {
	$schema = localSchema();
	$schemaItems = $schema['result']['items'];
	$itemND = array();
	foreach ($schemaItems as $defindex => $defitem) {
		$itemND[$defindex] = strtoupper($defitem['item_name']);
	}
	$result = array();
	foreach ($itemND as $key => $color) {
		// if it starts with 'part' add to results
		if (!empty($_POST['defindex']) && strpos($color, strtoupper($_POST['defindex'])) === 0) {
			return $key;
		}
	}
}

function time2string($timeline, $days_only = false) {//set $days_only to true to make it show only the days (shorter!)
	$periods = array('D' => 86400, 'HR' => 3600, 'MN' => 60);
	if ($days_only == true) {
		$periods = array('D' => 86400);
	}

	$ret = "";
	foreach ($periods as $name => $seconds) {

		$num = floor($timeline / $seconds);
		$timeline -= ($num * $seconds);
		if ($num > 0) {
			$ret .= $num . ' ' . $name;
		}
	}

	return trim($ret);
}

function checkCurrentUserData($profiles) {
	$user_profile_states = array();
	$completeProfileSize = 0;

	$profileSize = count($profiles);
	$S = 0;
	$L = 100;
	$profiles100 = array();

	while ($profileSize > $completeProfileSize) {
		$profiles100 = array_slice($profiles, $S, $L);
		$urlProfiles = implode(",", $profiles100);
		$playerURL = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . AKey() . "&steamids=" . $urlProfiles . "&format=json";
		$playerData = get_data($playerURL);
		$playerData = json_decode($playerData, true);

		if (isset($playerData["response"]["players"]['0']["steamid"])) {
			$userList = $playerData['response']['players'];//lol headache.
			foreach ($userList as $key => $userProfile) {
				$user_profile_states[$userProfile['steamid']]['personastate'] = $userProfile['personastate'];
				$user_profile_states[$userProfile['steamid']]['lastlogoff'] = $userProfile['lastlogoff'];
				if (isset($userProfile['gameid'])) {
					$user_profile_states[$userProfile['steamid']]['gameid'] = $userProfile['gameid'];
				}
			}
		}

		$S = ($S + 100);
		$L = ($L + 100);
		$completeProfileSize = $completeProfileSize + 100;
	}
	if (isset($playerData["response"]["players"]['0']["steamid"])) {
		return $user_profile_states;
	} else {
		return 0;
	}
}

function loadUserInfoFromDB($profile) {
	//db.targets.find({"":"76561198013370444"})

	$m = new MongoClient();
	$db = $m->steamUsers;
	$collection = $db->targets;
	$query = array('_id' => $profile);
	$cursor = $collection->find($query);
	foreach ($cursor as $key => $value) {
		$m = NULL;
		$db = NULL;
		return $value;
	}
}
