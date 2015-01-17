<?php
require_once 'scan_core.php';
require_once 'parallel.php';

//update_schema();

function schema_570() {return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/570_schema.json'), true);}

function cmp_refined($a, $b) {
	//function used to sort the array of items at the end by highest value.
	if ($a['price_info']['value_raw'] > $b['price_info']['value_raw']) {
		return -1;
	} elseif ($a['price_info']['value_raw'] < $b['price_info']['value_raw']) {
		return 1;
	}

	return 0;
}

function update_schema() {

	$schema = json_decode(get_data('http://api.steampowered.com/IEconItems_570/GetSchema/v0001/?key=' . AKey() . '&language=en_us', 12), true);
	if (isset($schema['result']['status']) && $schema['result']['status'] == 1 && isset($schema['result']['items'][1]['defindex'])) {
		$schema = $schema['result'];
	} else {
		return 0;
	}

	$res = array();

	foreach ($schema['originNames'] as $key => $val) {

		$schema['origin'][$val['origin']] = $val['name'];
	}

	//insert all items by defindex.
	foreach ($schema['items'] as $key => $item) {
		unset($item['item_description']);
		unset($item['proper_name']);
		unset($item['image_inventory']);
		unset($item['capabilities']);
		unset($item['tool']);
		unset($item['attributes']);

		$res[$item['defindex']] = $item;
	}
	$schema['items'] = $res;
	unset($res);

	//put all effects into the effect key.
	foreach ($schema['attribute_controlled_attached_particles'] as $key => $effect) {
		$schema['effect'][$effect['id']]['name'] = $effect['name'];
		$schema['effect'][$effect['id']]['id'] = $effect['id'];
	}
	foreach ($schema['qualities'] as $qual => $val) {
		$schema['quality'][$val]['name'] = $qual;
		$schema['quality'][$val]['display_name'] = $schema['qualityNames'][$qual];
	}

	unset($schema['attribute_controlled_attached_particles']);

	$result = json_encode($schema);
	$dir = json_directory();
	file_put_contents($dir . "/570_schema.json", $result);
	file_put_contents($dir . "/570_schema_time.txt", time());

}

function item_class($item) {
	$c = '';
	if (isset($item['flag_cannot_craft']) && $item['flag_cannot_craft'] != false) {
		$c .= ' uc';
	}
	if (isset($item['flag_cannot_trade']) && $item['flag_cannot_trade'] != false) {
		$c .= ' ut';
	}
	return $c;
}

function scan_570_single($content, $profile) {
	$f2p = false;
	if ($profile['steamid'] == 76561198035413737) {
		echo profileBlockArea($profile, 440, array(440 => 99999999, 730 => 99999999, 570 => 99999999)) . '<td><div class="zitms">THIS USER BELONGS TO DIGITS, HANDS OFF.</div></td></tr>';
		return false;
	}

	globalSchemas(570);
	$return = '';
	$count_list = array();

	$backpack = reset(json_decode($content, true));
	if (isset($backpack['items'][0]['id']) && isset($backpack['status']) && $backpack['status'] == 1) {
		foreach ($backpack['items'] as &$item) {
			item_prepare($item);
			item_price($item);
		}
		usort($backpack['items'], 'cmp_refined');
		$maxItem = 9;//change how many items are shown here. Will break the layout if there are too many.
		$backpack = array_slice($backpack['items'], 0, $maxItem);
		foreach ($backpack as &$item) {

			$return .= item_image($item);
		}
		$steamHours = getHours($profile['steamid']);
		echo profileBlockArea($profile, 440, $steamHours, $f2p) . '<td class="pitms">' . $return . '</td></tr>';
	}

}

function item_prepare(&$item) {
	$item['name'] = $GLOBALS['schemas_570']['schema']['items'][$item['defindex']]['name'];
}

function item_price(&$item) {
	$item['price_info']['value_raw'] = 1;
}

function item_image($item) {
	$c = item_class($item);
	$warn = '';
	$quantity = 0;
	$quality =

	$title = $item['name'];
	$item['img'] = $GLOBALS['schemas_570']['schema']['items'][$item['defindex']]['image_url'];
	return '<div><img alt="' . $item['name'] . '" title="' . $title . '" class="' . $warn . ($GLOBALS['schemas_570']['schema']['quality'][$item['quality']]['name']) . $c . '" src="' . $item['img'] . '">' . (($quantity != NULL && $quantity != 1) ? '<span class="icount">' . $quantity . '</span>' : '') . '</div>';

}
