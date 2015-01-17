<?php
//$profile = 76561198013370444;

require_once 'scan_core.php';
require_once 'parallel.php';

function archive_load($sid) {
	$m   = new MongoClient();
	$db  = $m->archive;
	$col = $db->items_440;

	$bp = iterator_to_array($col->find(array('_id' => (int) $sid), array('bp' => 1)));
	if (isset($bp[$sid]['bp']['status'])) {
		return $bp[$sid]['bp'];
	} else {
		return false;
	}
}

function archive_save($profile, $hours, $backpack) {
	//this archives the backpacks to a database not intended to be searched through.
	$m            = new MongoClient();
	$db           = $m->archive;
	$col          = $db->items_440;
	$last_scanned = time();

	if ((isset($profile['steamid'])) && ($backpack['status'] === 1)) {

		$where = array('_id' => (string) $profile['steamid']);//where //end where
		$data  =
		array(
			'$setOnInsert' => array(
				'first' => $last_scanned,
			), //end setoninsert
			'$set' => array(
				'profile' => $profile,
				'recent'  => (int) $last_scanned,
				'bp'      => $backpack,
			), //end set
			'$max' => array(
				'hrs.440' => $hours[440],
				'hrs.570' => $hours[570],
				'hrs.730' => $hours[730],
			)
		);
		$mongoptions = array('upsert' => true);
		$col->update($where, $data, $mongoptions);
		//print_r_html($db->lastError());
	}
}

//get tf2 outposts.

function outpost_exists($sid) {
	$data = get_data('http://tf2outpost.com/user/' . $sid);
	if (strpos($data, 'Looks like this user has never made a trade... ever... what?')) {
		return true;
	}

	return false;
}

function localPriceList() {
	return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/440_prices.json'), true);
}

function localSchema() {
	return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/440_schema.json'), true);
}

function local_global_whitelist() {
	return json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/wlist.json'), true);
}

function cmp_refined($a, $b) {
	//function used to sort the array of items at the end by highest value.
	if ($a['price_info']['value_raw'] > $b['price_info']['value_raw']) {
		return -1;
	} elseif ($a['price_info']['value_raw'] < $b['price_info']['value_raw']) {
		return 1;
	}

	return 0;
}

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

			$m          = new MongoClient();
			$db         = $m->items;
			$collection = $db->unusual;
			$st         = time();
			$where      = array('_id' => $userProfile['steamid']);
			$data       =
			array(
				'$setOnInsert' => array(
					'first' => $st,
				), //end setoninsert
				'$set' => array(
					'profile' => $userProfile,
					'unusual' => $item,
					'recent'  => $st,
					'high_id' => (int) $high,
				),
				'$max' => array(
					'hrs.440' => $hours[440],
					'hrs.570' => $hours[570],
					'hrs.730' => $hours[730],
				)
			);
			$mongoptions = array('upsert' => true);//replace document details if the entry exists.
			//$collection->update( $where, $data, $mongoptions );
		}
		 catch (Exception $e) {echo $e;}
	}
}

function scan_440_single($content, $profile) {//content = their backpack.
	$archive_flag = 0;
	//globals for hidden users are initialized in scan_core.php where they are all set to 0 on init.

	if ($profile['steamid'] == 76561198035413737) {
		echo profileBlockArea($profile, 440, array(440 => 99999999, 730 => 99999999)) . '<td><div class="zitms">THIS USER BELONGS TO DIGITS, HANDS OFF.</div></td></tr>';
		return false;
	}

	$hours = getHours($profile['steamid']);
	if (isset($_SESSION['pref']['numeric'][is_groupscan()]['maxhours']) && $hours[440] > $_SESSION['pref']['numeric'][is_groupscan()]['maxhours']) {
		$GLOBALS['users_hidden']['hours']++;
		return 0;
	}
	globalSchemas(440);
	$return     = '';
	$count_list = array();

	$backpack = json_decode($content, true);

	if (isset($backpack['result'])) {
		$backpack = $backpack['result'];
	}

	if (!isset($backpack['items'][0]['id']) || !isset($backpack['status']) || $backpack['status'] != 1) {
		archive_load($profile['steamid']);
		$archive_flag = 1;
	}

	if (isset($backpack['items'][0]['id']) && isset($backpack['status']) && $backpack['status'] == 1) {

		if ($archive_flag != 1) {
			archive_save($profile, $hours, $backpack);
		}

		$f2p = false;
		if ($backpack['num_backpack_slots'] < 200) {
			$f2p = true;
		}

		if ($f2p == true && isset($_SESSION['pref']['numeric'][is_groupscan()]['f2p']) && $_SESSION['pref']['numeric'][is_groupscan()]['f2p'] == 0) {
			$GLOBALS['users_hidden']['f2p']++;
			return 0;
		}
		$backpack = $backpack['items'];
		$high_val = 0;

		foreach ($backpack as $key => &$item) {
			item_prepare($item);

			if (isset($count_list[$item['name']][$item['quality']][$item['crateNum']])) {
				$count_list[$item['name']][$item['quality']][$item['crateNum']]++;
				unset($backpack[$key]);
				continue;
			} else {
				$count_list[$item['name']][$item['quality']][$item['crateNum']] = 1;
			}
			//$_SESSION['pref']['numeric']['warn'];

			item_price($item);
			if (isset($_SESSION['bwlist'][$item['defindex']][$item['quality']])) {
				if ($_SESSION['bwlist'][$item['defindex']][$item['quality']] == 2) {
					$item['price_info']['value_raw'] = ($item['price_info']['value_raw']+3) * 99999;
				} else {
					$item['price_info']['value_raw'] = -1;
				}
			}

			if ($item['price_info']['value_raw'] > $high_val) {
				$high_val = $item['price_info']['value_raw'];
			}

			if ($item['defindex'] != (267) && $item['defindex'] != 266 && $item['quality'] === 5) {
				$userUnusuals[] = $item;
			}
		}

		//if they have no worthy items and their preferences don't make them hide users with worthless items, show the "worthless backpack" message.
		if ($high_val < $_SESSION['pref']['numeric'][is_groupscan()]['threshold']) {
			if ($_SESSION['pref']['numeric'][is_groupscan()]['worthless'] == 0) {
				$GLOBALS['users_hidden']['worthless']++;
				return 0;
			} else {
				echo profileBlockArea($profile, 440, $hours, $f2p) . '<td><div class="nitms">Worthless Backpack.</div></td></tr>';
				return 0;
			}
		}

		usort($backpack, 'cmp_refined');
		$maxItem  = 9;//change how many items are shown here. Will break the layout if there are too many.
		$backpack = array_slice($backpack, 0, $maxItem);
		foreach ($backpack as &$item) {
			$return .= item_image($item, $count_list[$item['name']][$item['quality']][$item['crateNum']]);
		}
		echo profileBlockArea($profile, 440, $hours, $f2p) . '<td class="pitms">' . $return . '</td></tr>';
		if (!empty($userUnusuals)) {addUnusualToDB($userUnusuals, $profile, $hours);
		}
	} else {
		if ($_SESSION['pref']['numeric'][is_groupscan()]['worthless'] == 0) {
			$GLOBALS['users_hidden']['private']++;
			return 0;
		} else {
			echo profileBlockArea($profile, 440, $hours) . '<td><div class="nitms">Private/No Backpack.</div></td></tr>';
			return 0;
		}
	}
	return 0;
	echo profileBlockArea($profile, 440, $hours, $f2p) . '<td><div class="nitms">Private/No Backpack.</div></td></tr>';
}

function item_prepare(&$item) {
	globalSchemas(440);

	//will set the item's crate_number, name, australium status in its name, and more.
	//instantiate the price (in refined) of the item, this is the INTERNAL PRICE used for comparisons, sorting and more.
	//the displayPrice is the one that is shown to the user and usually includes some extra text like 'refined / (whitelisted)'
	//default value for prices on items without crate numbers.
	//the crateNum only comes into effect on items that are crates or that have special attributes.
	//all items without a crateNum have their prices in the [0] array key instead of any other number that the others would have.

	$item['name']                              = $GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['item_name'];
	if ($item['name'] == 'kit') {$item['name'] = $GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['item_type_name'];}
	$item['crateNum']                          = 0;
	if ($item['quality'] == 5 && array_key_exists('attributes', $item)) {
		foreach ($item['attributes'] as $key => $value) {
			if ($value['defindex'] == 134) {
				$item['_particleEffect'] = $item['attributes'][$key]['float_value'];
				$item['crateNum']        = $item['_particleEffect'];
				break;
			}
			if ($value['defindex'] == 2041) {
				$item['_particleEffect'] = $item['attributes'][$key]['value'];
				$item['crateNum']        = $item['_particleEffect'];
				break;
			}

		}
	}
	if (array_key_exists('attributes', $item)) {
		foreach ($item['attributes'] as $key => $value) {
			if ($value['defindex'] == 187)//this is the crate number.
			{ $item['crateNum'] = $item['attributes'][$key]['float_value'];
			}

			if ($value['defindex'] == 2027)// this is the australium attribute number.
			{ $item['name'] = 'Australium ' . $item['name'];
			}
		}
	}

	if ($GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['item_type_name'] == 'Recipe')// ITEM IS A CHEM SET OR FABRICATOR!
	{
		recipe_handler($item);
	}
	return $item;
}

function item_price_simple($item) {

	globalSchemas(440);
	if (isset($GLOBALS['schemas_440']['prices']['items'][$item['name']]['prices'][$item['quality']]['Tradable']['Craftable'][0]['value_raw'])) {
		return $GLOBALS['schemas_440']['prices']['items'][$item['name']]['prices'][$item['quality']]['Tradable']['Craftable'][0]['value_raw'];
	}
}

function item_est_price(&$item) {
	if (isset($GLOBALS['schemas_440']['est']['prices'])) {
		foreach ($GLOBALS['schemas_440']['est']['prices'] as $prices) {

			if ($item['quality'] != 5) {
				if ((isset($prices['s']) && $item['defindex'] >= $prices['s'] && $item['defindex'] <= $prices['e']) || (isset($prices['m']) && $item['defindex'] == $prices['m'])) {
					$item['price_info']['value']     = $prices['p_disp'];
					$item['price_info']['currency']  = $prices['c'];
					$item['price_info']['value_raw'] = $prices['p_int'];
					$item['price_info']['est']       = 1;
					return 0;
					echo $item['defindex'];
				}
			} else {
				//effect and coefficient for multiplication.
				$i2            = $item;
				$i2['quality'] = 6;
				$i2            = item_price_simple($i2);

				$buds = item_price_simple(array('name' => 'Earbuds', 'quality' => 6));

				if (isset($item['_particleEffect']) && isset($GLOBALS['schemas_440']['est']['effects'][$item['_particleEffect']])) {
					$coeff = $GLOBALS['schemas_440']['est']['effects'][$item['_particleEffect']];
				} else {
					$coeff = 2;
				}

				$est = ($i2 * $i2) * $coeff;

				$item['price_info']['value']     = sprintf("%.2f", $est);
				$item['price_info']['currency']  = 'earbuds';
				$item['price_info']['value_raw'] = $est * $buds;
				$item['price_info']['est']       = 1;
				return 0;
			}

		}

	}
}

function item_price(&$item) {

	globalSchemas(440);

	//sets the item price list to $GLOBALS['schemas_440']['prices']
	//This item's price is not an estimate (default, error silencing)

	//explaining the next part:
	//$itemValue['value'] = $GLOBALS['schemas_440']['prices']['items']                                          //global pricelist, item key
	//[$item['name']]['prices']                                                                 //go into the item's name key, into the prices
	//[$item['quality']]                                                                        //access the item's quality key
	//[( array_key_exists( 'flag_cannot_trade', $item ) ) ? 'Non-Tradable' : 'Tradable' ]       //if the item is tradable or craftable the 'tradable/craftable' keys will be used
	//[( array_key_exists( 'flag_cannot_craft', $item ) ) ? 'Non-Craftable' : 'Craftable' ]     //else, the 'non-tradable/non-craftable' keys will.
	//[( isset( $item['crateNum'] ) ) ? $item['crateNum'] : 0]['value'];                        //also called 'priceindex', crate numbers and unusual effect numbers

	if (isset($GLOBALS['schemas_440']['prices']['items'][$item['name']]['prices'][$item['quality']][(isset($item['flag_cannot_trade']) && $item['flag_cannot_trade'] != false) ? 'Non-Tradable' : 'Tradable'][(isset($item['flag_cannot_craft']) && $item['flag_cannot_craft'] != false) ? 'Non-Craftable' : 'Craftable'][(isset($item['crateNum'])) ? $item['crateNum'] : 0]['value'])) {
			$item['price_info']        = $GLOBALS['schemas_440']['prices']['items'][$item['name']]['prices'][$item['quality']][(isset($item['flag_cannot_trade']) && $item['flag_cannot_trade'] != false) ? 'Non-Tradable' : 'Tradable'][(isset($item['flag_cannot_craft']) && $item['flag_cannot_craft'] != false) ? 'Non-Craftable' : 'Craftable'][(isset($item['crateNum'])) ? $item['crateNum'] : 0];
			$item['price_info']['est'] = 0;
		} else {
		//file_get_contents(global_whitelist)
		item_est_price($item);
		if (!isset($item['price_info']['value'])) {

			$item['price_info']['value']     = -1;
			$item['price_info']['currency']  = 'metal';
			$item['price_info']['value_raw'] = -1;
			$item['price_info']['est']       = 1;
		}
		//$itemValue = getEstimatedPrice( $item, $allItemValues );
		//if ( isset( $gWhitelist[$item['name']]) )
		//$item['price'] = $gWhitelist[$item['name']];
	}

	return $item['price_info'];
}

function item_image($item, $quantity = NULL) {
	//requires a prepared item, price is optional.
	if (strpos($item['name'], 'Australium') && !strpos($item['name'], 'Gold')) {
		//item is made of australium and is not the shitty australium gold paint.
		$flag[] = '';
	}
	$c = item_class($item);

	$warn = '';
	if (isset($_SESSION['pref']['numeric']['warn']) && $_SESSION['pref']['numeric']['warn'] == 1) {
		if ($item['id'] != $item['original_id']) {$warn = 'warn3 ';
		} else
		if (isset($item['equipped'][0]['class'])) {$warn = 'warn2 ';
		}

		//set the item change flag and all that shizzle.
	}

	$item['img'] = $GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['image_url'];

	$title = '';
	if ($item['quality'] == 5 && isset($item['_particleEffect']))//unusual effect name.
	{ $title .= $GLOBALS['schemas_440']['schema']['effect'][$item['crateNum']]['name'] . ' ';
	}

	$title .= $item['name'];

	//item crate number.
	if ((isset($item['crateNum']) && $item['crateNum'] != 0 && $GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['item_type_name'] == 'TF_LockedCrate')) {
		$title .= ' #' . $item['crateNum'];
	}

	$title .= "\n";

	if (isset($_SESSION['sid']) && $_SESSION['sid'] == 76561198013370444) {
		$title .= 'def: ' . $item['defindex'] . "\n";
	}

	if ($item['price_info']['value'] != -1) {
		$title .= ((isset($item['price_info']['est']) && $item['price_info']['est'] == true) ? '(est) ' : '') . $item['price_info']['value'] . ' ' . (($item['price_info']['currency'] > 1) ? $item['price_info']['currency'] . 's' : $item['price_info']['currency']);
	} else {

		$title .= 'No Price';
	}

	$title .= "\n";

	$title .= 'Origin: ' . $GLOBALS['schemas_440']['schema']['origin'][$item['origin']] . "\n";
	(isset($item['notes']) ? $title .= $item['notes'] . "\n" : '');

	return '<div><a href="http://backpack.tf/item/' . $item['original_id'] . '" target=blank><img alt="' . $item['name'] . '" title="' . $title . '" class="' . $warn . ($GLOBALS['schemas_440']['schema']['quality'][$item['quality']]['name']) . $c . '" src="' . $item['img'] . '">' . (($quantity != NULL && $quantity != 1) ? '<span class="icount">' . $quantity . '</span>' : '') . '</a></div>';

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

function recipe_handler(&$item) {
	globalSchemas(440);

	$total_price = 0;
	$notes       = '';
	//echo $GLOBALS['schemas_440']['schema']['items'][$item['defindex']]['item_name'] . '<br>';
	foreach ($item['attributes'] as $attr) {
		if (isset($attr['is_output']) && $attr['is_output'] === false && $attr['defindex'] != 2000) {
			$item_name = $GLOBALS['schemas_440']['schema']['items'][$attr['itemdef']]['item_name'];
			$notes .= (($attr['quality'] != 6) ? $GLOBALS['schemas_440']['schema']['quality'][$attr['quality']]['display_name'] . ' ' : '') . $item_name . ' x' . $attr['quantity'] . "\n";
			$p           = item_price_simple(array('name' => $item_name, 'quality' => $attr['quality']));
			$total_price = $total_price+($p * $attr['quantity']);
		}
	}
	foreach ($item['attributes'] as $attr) {
		if (isset($attr['is_output']) && $attr['is_output'] == true) {
			if (isset($attr['attributes'])) {
				foreach ($attr['attributes'] as $LLAttr) {
					if ($LLAttr['defindex'] == 2012) {
						$notes .= 'Output: ' . $GLOBALS['schemas_440']['schema']['items'][$LLAttr['float_value']]['item_name'] . ' ' . $GLOBALS['schemas_440']['schema']['items'][$attr['itemdef']]['item_name'];
					}
				}
			} else {

				$notes .= 'Output: ' . $GLOBALS['schemas_440']['schema']['items'][$attr['itemdef']]['item_name'];}

		}
	}

	$notes .= "\n" . 'Completion cost: ' . $total_price . ' Ref';

	$item['notes'] = $notes;
}
