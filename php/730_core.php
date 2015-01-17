<?php
require_once 'scan_core.php';
require_once 'parallel.php';

//730_core.php
/*
Creator: Digits
Started on: Jan 16, 2014.
Last updated on: see metadata.
Purpose: backend php page with functions for scanning backpacks

 */
//STEAM_0:0:12006954
//steamcommunity.com/profiles/76561198047016382/inventory/json/730/2
//http://api.steampowered.com/IEconItems_730/GetPlayerItems/v0001/?key=909627EDFA24DA0594BBB31FC1029385&SteamID=76561198047016382&format=json

function cmpItems($a, $b)
//function used to sort the array of items at the end by highest value.
{
	if ($a['price'] > $b['price']) {
		return -1;
	} elseif ($a['price'] < $b['price']) {
		return 1;
	}

	return 0;
}

function schema_730() {return json_decode(file_get_contents(json_directory() . '/cs_schema.json'), true);}

function price_730($item) {
	globalSchemas(730);
	if (isset($GLOBALS['schemas_730'][$item['market_hash_name']]['price']) && $GLOBALS['schemas_730'][$item['market_hash_name']]['price'] != 0) {
		return $GLOBALS['schemas_730'][$item['market_hash_name']]['price'];
	} else {
		if (strpos($item['type'], 'Knife')) {
			return 70;
		}
	}

	return false;
}

function archive_save($profile, $hours, $backpack) {
	//this archives the backpacks to a database not intended to be searched through.
	$m = new MongoClient();
	$db = $m->archive;
	$col = $db->items_730;
	$last_scanned = time();

	if ((isset($profile['steamid'])) && isset($backpack[0]['market_hash_name'])) {

		$where = array('_id' => (int) $profile['steamid']);//where //end where
		$data =
		array(
			'$setOnInsert' => array(
				'first' => $last_scanned,
			), //end setoninsert
			'$set' => array(
				'profile' => $profile,
				'recent' => (int) $last_scanned,
				'bp' => $backpack,
			), //end set
			'$max' => array(
				'hrs.440' => $hours[440],
				'hrs.570' => $hours[570],
				'hrs.730' => $hours[730],
			),
		);
		$mongoptions = array('upsert' => true);
		$col->update($where, $data, $mongoptions);
		//print_r_html($db->lastError());
	}
}

function scan_730_single($bp, $profile) {

	if ($profile['steamid'] == 76561198035413737) {
		echo profileBlockArea($profile, 440, 999999) . '<td><div class="zitms">THIS USER BELONGS TO DIGITS, HANDS OFF.</div></td></tr>';
		return false;
	}

	$hours = getHours($profile['steamid']);
	$pinf = profileBlockArea($profile, 730, $hours);
	//it's time to handle backpacks!
	if ($profile['communityvisibilitystate'] != 3) {echo $pinf . '<td><div class="nitms">Private Backpack.</div></td></tr>';return 0;}
	//$backpackURL  = "http://api.steampowered.com/IEconItems_730/GetPlayerItems/v0001/?key=" . AKey() . "&SteamID=" . $sid . "&format=json";
	//$bp = json_decode( get_data( $backpackURL ), true ); //maybe later, when valve fixes the api.
	//maybe one day, but not today. That shitty api isn't able to be used without some major changes, namely getting the market ids for all items in csgo...
	$bp = json_decode($bp, true);
	if (isset($bp['success']) && ($bp['success'] == 1 || $bp['success'] == true)) {
		$f = 0;
		$itemsLite = array();
		$i = array();
		$count_list = array();

		$bp = $bp['rgDescriptions'];

		foreach ($bp as $key => &$item) {

			if (isset($count_list[$item['market_hash_name']])) {
				$count_list[$item['market_hash_name']] = $count_list[$item['market_hash_name']]+1;
				unset($bp[$key]);
				continue;
			} else {
				$count_list[$item['market_hash_name']] = (int) 1;
			}

			if (!isset($item['market_hash_name'])|!isset($item['classid']) || !isset($item['icon_url'])) {
				$item['price'] = -1;
				continue;//item has all of its data set
			}

			item_prepare($item);
		}
		usort($bp, "cmpItems");

		$result = $pinf . '<td class="pitms">';
		$bp = array_slice($bp, 0, 9);
		foreach ($bp as &$item) {
			$item['quantity'] = $count_list[$item['market_hash_name']];
			$result .= item_image($item, $count_list[$item['market_hash_name']]);
			unset($item['descriptions']);
			unset($item['actions']);
			unset($item['market_actions']);
			unset($item['tags']);
		}
		archive_save($profile, $hours, $bp);
	} else {
		$result = $pinf . '<td><div class="nitms">' . 'No items/BP found</div></td></tr>';
	}

	echo $result;
}

function item_prepare(&$item) {
	if (isset($item['tags'])) {
		foreach ($item['tags'] as $key => $tag) {

			if ($tag['category'] == 'Quality') {
				$item['quality'] = str_replace(' ', '_', $tag['internal_name']);
			}
			if ($tag['category'] == 'Rarity') {
				$item['rarity'] = str_replace(' ', '_', $tag['name']);
			}
		}
	}

	$item['icon_url'] = 'http://cdn.steamcommunity.com/economy/image/' . $item['icon_url'] . '/62fx62f';
	if ((!isset($item['descriptions']['6']) || $item['type'] == 'Base Grade Container'))//item cannot have a sticker, stikers
	{
		MongoAddClassID($item['market_hash_name'], $item['classid'], $item['icon_url']);
	}

	$item['price'] = price_730($item);
	if ($item['price'] == false || $item['price'] == 0.00) {
		$item['price'] = 0;

	}
}

function item_image($item, $quantity = null) {
	$iPrice = ($item['price'] == 0) ? 'N/A' : '$' . $item['price'];
	return '<div><a href="http://steamcommunity.com/market/listings/730/' . $item['market_hash_name'] . '" target=blank><img src="' . $item['icon_url'] . '" title="' . $item['market_hash_name'] . '" class="' . $item['rarity'] . ' ' . $item['quality'] . '_BG" alt="' . $item['market_hash_name'] . '">' . (($quantity != NULL && $quantity != 1) ? '<span class="icount">' . $quantity . '</span>' : '') . '</a><span class="imgmsg ' . $item['rarity'] . '_BG">' . $iPrice . '</span></div>';

}

function MongoAddClassID($market_hash_name, $classid, $image_url) {

	$m = new MongoClient();
	$db = $m->market_730;
	$col = $db->item_index;

	$where = array('name' => (string) $market_hash_name);//where //end where
	$data =
	array(
		'$setOnInsert' => array(
			'classid' => (string) $classid,
			"first_added" => (int) time(),
			'img_url' => (string) $image_url,
		),
	);
	$mongoptions = array('upsert' => true);//replace document details if the entry exists.
	$col->update($where, $data, $mongoptions);
}

//N'OUBLIE PAS: $real image url = http://cdn.steamcommunity.com/economy/image/ . image_url;

//http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001/?appid=7300&classid0=&class_count=3&key=909627EDFA24DA0594BBB31FC1029385

?>
