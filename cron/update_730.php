<?php

function get_100_users() {
	$c = db_init('archive', 'items_730');

	$OOD = $c->find(array("recent" => array('$lt' => (time() - 172800))), array('_id' => 1))->sort(array("recent" => 1))->limit(100);
	//get a list of the most out of date steamids in the database (returns steamids only)
	$sids = '';
	if ($OOD->count() > 100) {
		$is_additive = false;
		foreach ($OOD as $k => $usr) {
			$sids .= ',' . $usr['_id'];
		}
	} else {
		$steamid1 = db_load('start_steamid_730');
		if (empty($steamid1)) {
			$steamid1 = 76561197960287930;
		}
		$sc = 0;
		while ($sc <= 100 && $sc++) {
			$sids .= ',' . ($steamid1 + $sc);
		}
	}
	$playerData = json_decode(get_data('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . AKey() . '&steamids=' . $sids . '&format=json'), true);

	return $playerData['response']['players'];
}

function update_wrapper_730() {
	include '/usr/share/nginx/html/php/730_core.php';

	$players = get_100_users();

	if (empty($players) || !isset($players[0]['steamid']) || !is_array($players)) {die();}

	update_730($players);

	db_save('start_steamid_730', $steamid1 + 100);
}

function update_730($players) {

	foreach ($players as $k => $profile) {
		$hours = getHours($profile['steamid']);
		sleep(0.4);
		$bp = json_decode(get_data('http://steamcommunity.com/profiles/' . $profile['steamid'] . '/inventory/json/730/2'), true);
		if (isset($bp['rgDescriptions'])) {
			foreach ($bp['rgDescriptions'] as $k => &$item) {

				if (!isset($item['market_hash_name'])|!isset($item['classid']) || !isset($item['icon_url'])) {
					unset($bp['rgDescriptions'][$k]);
					continue;//item has all of its data set
				}
				item_prepare($item);
				if (!isset($item['price'])/* || $item['price'] < 0.30 ask the users about this. DO they want item under 30 cents in the db?*/) {
					unset($bp['rgDescriptions'][$k]);
					continue;
				}

				unset($item['descriptions']);
				unset($item['actions']);
				unset($item['market_actions']);
				unset($item['tags']);

			}
		}
		usort($bp['rgDescriptions'], "cmpItems");
		$bp = array_slice($bp['rgDescriptions'], 0, 9);
		if ($bp != null) {
			archive_save($profile, $hours, $bp);
		}
	}
}
