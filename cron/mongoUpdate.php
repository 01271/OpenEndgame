<?php
include '/usr/share/nginx/html/php/scan_core.php';
//updateOutOfDate();

function addUnusualToDB($item, $userProfile, $hours) {
	{
		try {
			foreach ($item as $key => $val) {
				if (!isset($high)) {
					$high = $val['original_id'];
				}
				if ($val['id'] == $val['original_id'] && $val['id'] > $high) {
					$high = $val['id'];
				}
			}

			$m = new MongoClient();
			$db = $m->items;
			$collection = $db->unusual;
			$st = time();
			$where = array('_id' => $userProfile['steamid']);
			$data =
			array(
				'$setOnInsert' => array(
					'first' => $st,
				), //end setoninsert
				'$set' => array(
					'profile' => $userProfile,
					'unusual' => $item,
					'recent' => $st,
					'high_id' => (int) $high,
				),
				'$max' => array(
					'hrs.440' => $hours[440],
					'hrs.570' => $hours[570],
					'hrs.730' => $hours[730],
				)
			);
			$mongoptions = array('upsert' => true);//replace document details if the entry exists.
			$collection->update($where, $data, $mongoptions);
		}
		 catch (Exception $e) {echo $e;}
	}
}

function updateOutOfDate() {
	$m = new MongoClient();
	$db = $m->items;
	$collection = $db->unusual;
	$TenDaysOutOfDate = time() - 172800;//604800;
	$cursor = $collection->find(array("recent" => array('$lt' => $TenDaysOutOfDate)), array('_id' => 1))->sort(array("recent" => 1))->limit(100);
	if ($cursor->count() > 100) {
		$is_additive = false;
		foreach ($cursor as $doc) {
			$sid[] = $doc['_id'];
		}
	} else {
		if (!file_exists('/cron/sid.txt')) {
			file_put_contents('/cron/sid.txt', 76561197960287930);
		}

		$is_additive = true;
		$start_id = file_get_contents('/cron/sid.txt');
		$c = 0;
		while ($c != 100) {
			$sid[] = $start_id;
			$c++;
			$start_id++;
		}
	}

	$urlProfiles = implode(",", $sid);
	$playerURL = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . AKey() . "&steamids=" . $urlProfiles . "&format=json";
	$playerData = get_data($playerURL);
	$playerData = json_decode($playerData, true);
	$playerData = $playerData['response']['players'];
	if (empty($playerData) || !is_array($playerData)) {die();}
	mongoUpdateUsers($playerData, $is_additive);
	if (isset($is_additive) && $is_additive == true) {
		file_put_contents('/cron/sid.txt', ($start_id));
	}
}

function deleteUserFromDB($steamid) {
	$m = new MongoClient();
	$db = $m->items;
	$collection = $db->unusual;
	$collection->remove(array("_id" => $steamid), array("justOne" => true));

}

function mongoUpdateUsers($profile, $is_additive) {
	$timestamp = time();
	file_put_contents('/cron/history.txt', 'started on ' . gmdate("Y-m-d\TH:i:s\Z", $timestamp) . '
			', FILE_APPEND);
	$i = 0;
	$add = 0;
	$upd = 0;
	$rmv = 0;
	foreach ($profile as $userProfile) {
		$i++;
		$userUnusuals = array();
		$profile = $userProfile['steamid'];
		$backpack = NULL;

		$steamHours = getHours($profile);
		$backpackURL = "http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=" . AKey() . "&SteamID=" . $profile . "&format=json";
		$backpack = json_decode(get_data($backpackURL), true);
		if (isset($backpack['result']['items'][0]['defindex'])) {
			$items = $backpack['result']['items'];
		} else { $items = "";
			goto skipBackPack;
		}

		if (!isset($backpack['result']['status']) || $backpack['result']['status'] === 15) {goto skipBackPack;}

		foreach ($items as $item) {
			if (array_key_exists('flag_cannot_trade', $item)) {
				$item['flag_cannot_trade'] = 1;
			} else {

				$item['flag_cannot_trade'] = 0;
			}

			if (array_key_exists('flag_cannot_craft', $item)) {
				$item['flag_cannot_craft'] = 1;
			} else {

				$item['flag_cannot_craft'] = 0;
			}

			if ($item['quality'] == 5 && array_key_exists('attributes', $item)) {
				foreach ($item['attributes'] as $key => $value) {
					if ($value['defindex'] == 134) {
						$item['_particleEffect'] = $item['attributes'][$key]['float_value'];
					}
				}

				if ($item['defindex'] != (267) && $item['defindex'] != 266 && $item['quality'] === 5) {
					$userUnusuals[] = $item;
				}
			} else if ($item['quality'] == 5 && (!isset($item['_particleEffect']))) {
				$item['_particleEffect'] = "none";
			}

			$item['crateNum'] = 0;
			if (array_key_exists('attributes', $item)) {
				foreach ($item['attributes'] as $key => $value) {
					if ($value['defindex'] == 187) {
						$item['crateNum'] = $item['attributes'][$key]['float_value'];
					}

					if ($value['defindex'] == 2027) {
						$item['isAus'] = 1;
					}
				}
			}
		}

		skipBackPack:

		//echo $i . ' <a href="http://steamcommunity.com/profiles/' . $profile . '" target=blank>' . $userProfile['personaname'] . '</a> ';

		if (!empty($userUnusuals)) {
			addUnusualToDB($userUnusuals, $userProfile, $steamHours);
			if ($is_additive == true) {$add++;
			} else {
				$upd++;
			}
		}

		if (empty($userUnusuals) && $backpack['result']['status'] === 1) {
			//deleteUserFromDB($profile);
			//echo'removed. (no unusuals)';
			//deleteUserFromDB($profile);
			if ($is_additive == true) {;
			} else {
				$rmv++;
			}
		}

		/*
	if ( $backpack['result']['status'] === 15 ) {
	deleteUserFromDB( $profile );
	//echo'removed. (private bp)';
	deleteUserFromDB( $profile );
	if ( $is_additive == true );
	else $rmv++;
	}
	 */
	}
	$timestamp = time();
	file_put_contents('/cron/history.txt', 'finished on ' . gmdate("Y-m-d\TH:i:s\Z", $timestamp) . ' add:' . $add . ' rem' . $rmv . ' updt' . $upd . "\n", FILE_APPEND);
}
?>
