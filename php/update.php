<?php

//include 'actionScan.php';

require_once 'core.php';
//let me learn from my mistakes.

if (!function_exists('json_directory')) {
	function json_directory() {
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/api';
		if (!file_exists($dir)) {
			mkdir($dir, 0777);
		}
		return $dir;
	}
}

function pricelist_mod(&$a) {
	if (is_array($a)) {
		unset($a['last_update']);
		unset($a['difference']);
		if (isset($a['value_raw']) && $a['currency'] == 'usd') {
			$a['value'] = round($a['value_raw'] / $GLOBALS['eb_metal'], 2);
			$a['currency'] = 'earbuds';
		}
		array_walk($a, __FUNCTION__);
	}
}

function updatePriceListV4() {

	$dir = json_directory();
	$old = db_load('440_pricelist_v4_time');
	if ($old == false || (time() - $old) >= 28800) {
		//backpack.tf's v4 api requires a key.
		$pricelist = json_decode(get_data('http://backpack.tf/api/IGetPrices/v4/?key=' . BKey() . '&compress=1&raw=1'), true);
		if (isset($pricelist['response']['success']) && $pricelist['response']['success'] == true) {

			$GLOBALS['eb_metal'] = $pricelist['response']['items']['Earbuds']['prices'][6]['Tradable']['Craftable'][0]['value_raw'];

			//$price_of_unusual_in_buds = $price_of_unusual_in_metal / $price_of_buds_in_metal;

			pricelist_mod($pricelist['response']['items']);

			file_put_contents($dir . '/440_prices.json', json_encode($pricelist['response']));
			db_save('440_pricelist_v4_time', time());
		}
	}
}

function updatePriceList() {
	$dir = json_directory();

	$old = db_load('440_pricelist_v2_time');
	if ($old == false || (time() - $old) >= 28800) {

		$BPTFList = 'http://backpack.tf/api/IGetPrices/v2/?format=json&currency=metal&key=' . BKey();
		$allItemValues = (get_data($BPTFList));
		// create new directory with 777 permissions if it does not exist yet.
		// owner will be the user/group the PHP script is run under.

		$success = json_decode($allItemValues, true);
		$success = $success['response']['success'];
		if ($success == "1") {

			file_put_contents($dir . "/pricelist.json", $allItemValues);
			db_save('440_pricelist_v2_time', time());
		}
	}

}

function updatePaints() {
	$dir = json_directory();
	//file_put_contents( $dir . '/paint_time.txt', 0);
	$old = db_load('440_paint_time');
	if ($old == false || (time() - $old) >= 172800) {

		$allSchema = localSchema();
		$allSchema = $allSchema['items'];
		$marketMasterList = json_decode(get_data('http://api.steampowered.com/ISteamEconomy/GetAssetPrices/v0001/?appid=440&key=' . AKey()), true);
		if (!isset($marketMasterList['result']['success']) || $marketMasterList['result']['success'] != true) {
			$marketMasterList = json_decode(get_data('http://api.steampowered.com/ISteamEconomy/GetAssetPrices/v0001/?appid=440&key=' . AKey()), true);
			if (!isset($marketMasterList['result']['success']) || $marketMasterList['result']['success'] != true) {
				return false;
			}
		}

		//print_r_html( $marketMasterList );

		foreach ($allSchema as $item) {
			if (isset($item['item_type_name']) && $item['item_type_name'] == 'Tool' && $item['tool']['type'] == 'paint_can') {
				//this is a paint can. Let's get its TRUE IMAGE.
				$paint_can_ids[$item['defindex']] = $item;
			}
		}
		foreach ($marketMasterList['result']['assets'] as $asset) {
			if (isset($paint_can_ids[$asset['name']]['defindex'])) {
				$data = json_decode(get_data('http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001/?appid=440&classid0=' . $asset['classid'] . '&class_count=3&key=' . AKey()), true);
				$paint_can_ids[$asset['name']]['image_url'] = (string) 'http://cdn.steamcommunity.com/economy/image/' . $data['result'][$asset['classid']]['icon_url'] . '=/50fx50f';
				$paint_can_ids[$asset['name']]['image_url_large'] = (string) 'http://cdn.steamcommunity.com/economy/image/' . $data['result'][$asset['classid']]['icon_url'] . '=/512fx512f';
			}
		}
		file_put_contents($dir . "/schema_addon.json", json_encode($paint_can_ids));
		db_save('440_paint_time', time());
	}
}

function updateTF2Schema() {

	$dir = json_directory();
	//loadSchemaFromLocal();

	$old = db_load('440_schema_time');
	if ($old == false || (time() - $old) >= 14400) {

		$res = json_decode(get_data('http://api.steampowered.com/IEconItems_440/GetSchema/v0001/?key=' . AKey() . '&language=en', 5), TRUE);
		echo 'updating.';
		if (isset($res['result']['status']) && $res['result']['status'] == 1) {
			//why check if attributes is set? So that we're sure we didn't miss anything important in between.
			$res = $res['result'];

			foreach ($res['originNames'] as $key => $val) {
				$res['origin'][$val['origin']] = $val['name'];
			}

			foreach ($res['qualities'] as $qual => $val) {
				$res['quality'][$val]['name'] = $qual;
				$res['quality'][$val]['display_name'] = $res['qualityNames'][$qual];
			}

			foreach ($res['attribute_controlled_attached_particles'] as $key => $effect) {
				$res['effect'][$effect['id']]['name'] = $effect['name'];
				$res['effect'][$effect['id']]['id'] = $effect['id'];
			}

			//lighten the list a bit. Attributes, string lookups are not necessary and take a lot of space.
			//qualitynames and qualities have been replaced by quality.
			unset($res['originNames']);
			unset($res['qualities']);
			unset($res['qualityNames']);
			unset($res['item_levels']);
			unset($res['item_sets']);
			unset($res['kill_eater_score_types']);
			unset($res['attributes']);
			unset($res['string_lookups']);
			unset($res['attribute_controlled_attached_particles']);

			//sort by item name

			if (!function_exists('cmp')) {
				function cmp($a, $b) {
					return strcmp($a['defindex'], $b['defindex']);
				}
			}

			$items = $res['items'];

			$add = false;
			if (file_exists($dir . "/schema_addon.json")) {
				$add = json_decode(file_get_contents($dir . "/schema_addon.json"), true);
			}

			usort($items, "cmp");
			foreach ($items as &$item) {

				if (isset($add[$item['defindex']])) {
					$item = $add[$item['defindex']];
				}
				unset($item['item_class']);
				unset($item['model_player']);
				unset($item['image_inventory']);

				$items_new[$item['defindex']] = $item;

			}

			$res['items'] = $items_new;

			$results = json_encode($res);

			file_put_contents($dir . '/qualities.json', json_encode($res['quality']));
			file_put_contents($dir . "/440_schema.json", $results);
			db_save('440_schema_time', time());

		}
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function updateListOfAllSteamGames() {
	$dir = json_directory();

	$old = db_load('753_list_time');
	if ($old == false || (time() - $old) >= 28800) {
		$listOfAllGamesOnSteam = json_decode(get_data('http://api.steampowered.com/ISteamApps/GetAppList/v2'), true);
		$listOfAllGamesOnSteam = $listOfAllGamesOnSteam['applist']['apps'];
		foreach ($listOfAllGamesOnSteam as $key => $game) {
			$OrderedList[$game['appid']] = $game['name'];
		}
		if ($OrderedList[5] === 'Dedicated Server') {
			$results = json_encode($OrderedList);

			file_put_contents($dir . "/753_games.json", $results);
			db_save('753_list_time', time());
		}
	}
}

function resetUpdateCounters($id) {
	if ($id == 'prices') {
		db_save('440_pricelist_v4_time', (int) 0);
	}

	if ($id == 'schema') {
		db_save('440_schema_time', (int) 0);
	}
}

function updateEverything() {
	updatePaints();
	//updatePriceList();
	updateTF2Schema();
	updatePriceListV4();
}
