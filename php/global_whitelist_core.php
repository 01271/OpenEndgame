<?php
include_once '440_core.php';
include_once 'db_core.php';

function item_display($defindex_shit) {

	echo '<div class="col2 lt bp-content"><form action="', $_SERVER['PHP_SELF'], '" method=post><table><thead><tr><th>Item</th><th>Show</th><th>Hide</th><th>Price</th></tr></thead><tbody>';

	if (!is_array($defindex_shit)) {$defindex = (int) substr($defindex_shit, 5);} else {
		$defindex = 0;
	}

	globalSchemas(440);

	$qualities = $GLOBALS['schemas_440']['schema']['quality'];
	unset($qualities[0]);
	unset($qualities[2]);
	unset($qualities[4]);
	unset($qualities[7]);
	unset($qualities[8]);
	unset($qualities[9]);
	unset($qualities[10]);
	unset($qualities[12]);

	$item = $GLOBALS['schemas_440']['schema']['items'][$defindex];

	$item_redux = array('defindex' => $item['defindex'], 'name' => $item['item_name'], 'origin' => 0, 'original_id' => 0, 'id' => 0, "_particleEffect" => 13, 'crateNum' => 13);

	foreach ($qualities as $key => $quality) {
		$item_redux['quality'] = $key;

		item_prepare($item_redux);
		//set the crateNum AFTER item_prepare since it will unset it.
		if ($key == 5) {$item_redux['_particleEffect'] = 13; $item_redux['crateNum'] = 13;} else { $item_redux['crateNum'] = 0; $item_redux['_particleEffect'] = 0;}

		item_price($item_redux);

		echo '<tr><td>', item_image($item_redux), '</td>',
		'<td><input type="radio" name="' . $item_redux['defindex'] . '[' . $key . ']" class="' . $item_redux['defindex'] . '_on  wlist_rb" value="2" /></td>',
		'<td><input type="radio" name="' . $item_redux['defindex'] . '[' . $key . ']" class="' . $item_redux['defindex'] . '_off wlist_rb" value="3" /></td>',
		'<td>' . ((-1 != $item_redux['price_info']['value']) ? $item_redux['price_info']['value'] : 'N/A') . ' ' . $item_redux['price_info']['currency'] . '</td></tr>';

		unset($item_redux['price_info']);

	}
	echo '</tbody></table><input type=submit name=save value=save></form></div>';
}

function bwlist_save(array $array) {
	$res = array();
	unset($array['save']);
	$c = db_init('site_data', 'site_users');
	foreach ($array as $defindex => $item) {

		if (is_numeric($defindex) && count($defindex) <= 14) {
			foreach ($item as $qual => $val) {
				//$res[(string) $defindex][(int) $qual] = (int) $val;
				$c->update(array('_id' => (int) $_SESSION['sid']), array('$set' => array("bwlist.$defindex.$qual"=> (int) $val)));
			}
		} else {echo '<div class="notice bad cf">could not save preferences.</div>';
			return 0;
		}
	}

	echo '<div class="notice good cf">Preferences updated for ' . ucfirst(htmlentities($_SESSION['currentUserName'])) . ' (' . $_SESSION['sid'] . ')</div>';
}

function bwlist_delete() {
	$c = db_init('site_data', 'site_users');
	$c->update(array('_id' => (int) $_SESSION['sid']), array('$unset' => array('bwlist' => '')));
}

function bwlist_display() {
	echo '<div class= "col2 rt bp-content"><b>Your currently listed items</b><br>';
	//each black/whitelist item is stored like this:
	//defindex[quality] = w/b
	globalSchemas(440);
	$wlist = '<div>';
	$blist = '<div>';
	$list = get_database_field_contents($_SESSION['sid'], array('bwlist'));
	if ($list != false) {
		foreach ($list['bwlist'] as $key => $item) {
			foreach ($item as $quality => $set) {
				$item_redux = array('defindex' => $key, 'name' => $GLOBALS['schemas_440']['schema']['items'][$key]['item_name'], 'origin' => 0, 'original_id' => 0, 'id' => 0, "_particleEffect" => 13, 'crateNum' => 13);
				$item_redux['quality'] = $quality;

				item_prepare($item_redux);
				//set the crateNum AFTER item_prepare since it will unset it.
				if ($quality == 5) {$item_redux['_particleEffect'] = 13; $item_redux['crateNum'] = 13;} else { $item_redux['crateNum'] = 0; $item_redux['_particleEffect'] = 0;}
				item_price($item_redux);
				if ($set == 2) {
					$wlist .= item_image($item_redux);
				} else if ($set == 3) {
					$blist .= item_image($item_redux);
				}
			}
		}
	} else {echo '<b>No Preferences found.</b></div>';
		return false;}
	echo 'whitelisted (shows up as if it\'s worth 99999 refined.):<br>', $wlist, '</div><br><br>Blacklisted (hidden from all scans):<br>', $blist, '<br><br><form action="', $_SERVER['PHP_SELF'], '" method=post><input type=submit name=delete value=delete></form></div></div>';

}

/*
foreach ( $GLOBALS['schemas_440']['schema']['result']['items'] as $useless => $item ) {

foreach ( $qualities as $quality => $qualityData ) {

if ( ( !isset( $item['craft_material_type'] ) || $item['craft_material_type'] != 'weapon' ) && $quality == 5   )
foreach ( $GLOBALS['schemas_440']['schema']['result']['effect'] as $effect => $effectData ) {
$item_redux = array( 'defindex' => $item['defindex'], 'quality' => $quality, 'name' => $item['item_name'], 'origin' => 0, 'original_id' => 0, 'id' => 0, '_particleEffect' => $effect );

item_price( $item_redux );

if ( $item_redux['price_info']['value'] == -1 )
echo item_image( $item_redux );
}
else {
$item_redux = array( 'defindex' => $item['defindex'], 'quality' => $quality, 'name' => $item['item_name'], 'origin' => 0, 'original_id' => 0, 'id' => 0, '_particleEffect' => 0 );

item_price( $item_redux );

if ( $item_redux['price_info']['value'] == -1 )
echo item_image( $item_redux );

}
}
}
 */
