<?php

function getFavouriteTF2Class($sid) {
	$ArrayOfClassNames = array('Scout', 'Soldier', 'Spy', 'Pyro', 'Medic', 'Demoman', 'Heavy', 'Engineer', 'Sniper');
	$data = json_decode(get_data('http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=440&key=' . AKey() . '&steamid=' . $sid), true);
	if (isset($data['playerstats']['steamID'])) {
		foreach ($data['playerstats']['stats'] as $key => $value) {
			foreach ($ArrayOfClassNames as $name) {
				if ($value['name'] === $name . '.accum.iPlayTime') {
					$classHours[$name] = $value['value'];
				}
			}
		}
	}

	arsort($classHours);
	return $classHours;
}

function getClassWeapons($tf2Class) {
	$arrayOfItems = array();
	foreach ($GLOBALS['schemas_440']['schema']['items'] as $item) {
		if (isset($item['craft_class']) && $item['craft_class'] == "weapon" && strpos($item['name'], 'TF_WEAPON_') === false) {
			if (empty($item['used_by_classes'])) {
				array_push($arrayOfItems, $item['defindex']);
				continue;
			}
			foreach ($item['used_by_classes'] as $tf2Classes => $tf2ClassName) {
				if ($tf2ClassName === $tf2Class) {
					array_push($arrayOfItems, $item['defindex']);
				}
			}
		}
	}

	return $arrayOfItems;
}

function fav_class_weapons_box($sid, $itemCount) {
	$favclass = getFavouriteTF2Class($sid);
	foreach ($favclass as $className => $value) {
		$check = 0;
		$listOfFavWeapons = getClassWeapons($className);
		echo '<a class="show_hide" href="#" rel="#slidingDiv_' . $className . '">Missing ' . $className . ' weapons.</a>',
		'<div id="slidingDiv_' . $className . '" class="toggleDiv bp-content">';
		foreach ($listOfFavWeapons as $k => $weapon) {
			if (!isset($itemCount[$weapon])) {
				$item = array('defindex' => $weapon, 'quality' => 6, 'origin' => 0, 'original_id' => 0, 'id' => 0, "_particleEffect" => 13, 'crateNum' => 13);
				item_prepare($item);
				item_price($item);
				echo item_image($item);
				$check = 1;
			}
		}
		if ($check == 0) {
			echo 'None.';
		}
		echo '</div><br>';
	}
}

function pg_chk($num) {
	if ($num > 0 && $num % 50 == 0) {
		return '<hr class="hline ct cf"/>';
	}
}

function sortInvPos($a, $b)
//function used to sort the array of items at the end by highest value.
{
	if ($a['inventory'] < $b['inventory']) {
		return -1;
	} elseif ($a['inventory'] > $b['inventory']) {
		return 1;
	}

	return 0;
}

function backpack_viewer($sid) {
	globalSchemas(440);
	$profile = json_decode(get_data('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . AKey() . '&steamids=' . $sid . '&format=json'), true);
	$profile = $profile['response']['players'][0];

	$bp = '';
	$hours = getHours($sid);

	$backpack = json_decode(get_data('http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key=' . AKey() . '&SteamID=' . $sid . '&format=json'), true);

	if (isset($backpack) && $backpack['result']['status'] == 1) {

		usort($backpack['result']['items'], "sortInvPos");

		$mplace = '';

		$itemCount = array();

		//misplaced items
		foreach ($backpack['result']['items'] as $key => $item) {
			if ($item['inventory'] == 3221225475) {
				item_prepare($item);
				item_price($item);
				$mplace .= item_image($item);
				$itemCount[$item['defindex']] = 1;
			}
		}

		if ($mplace != '') {
			$bp .= '<div class="bp-mplaced">' . $mplace . '</div><br>';
		}

		$inv_pos = 2147483649;
		$total_items = 0;

		//start normal items
		foreach ($backpack['result']['items'] as $key => $item) {

			if ($item['inventory'] == 3221225475) {//end-of-backpack handler, writes out empty slots until we reach the max slots in the backpack.
				while ($backpack['result']['num_backpack_slots'] >= $total_items) {
					$bp .= '<div><img alt="empty" class="mt" src="img/mt.gif"></div>';
					$total_items++;
					$bp .= pg_chk($total_items);// echoes empty backpack slots.
				}
				break;
			}

			while ($item['inventory'] > $inv_pos + 1) {
				$bp .= '<div><img alt="empty" class="mt" src="img/mt.gif"></div>';

				$total_items++;
				$inv_pos++;
				$bp .= pg_chk($total_items);
			}

			item_prepare($item);
			item_price($item);
			$bp .= item_image($item);
			$inv_pos = $item['inventory'];
			$total_items++;
			$bp .= pg_chk($total_items);
			$itemCount[$item['defindex']] = 1;
		}

	} else {
		$bp .= 'problem retrieving backpack.';
	}

	echo
	'<div class="bp-container w800">',
	'<div class="bp-head">',
	'<img src=', $profile['avatarfull'], ' />',
	'<h1>', htmlspecialchars($profile['personaname']), '</h1>',
	'<h3>TF2: ', $hours[440], ' / DOTA 2: ', $hours[570], ' / CSGO: ', $hours[730], '</h3>',
	'</div>', //end head
	'<div class="bp-mweapons">';
	fav_class_weapons_box($sid, $itemCount);
	echo
	'</div>',
	'<div class="bp-info">',
	'</div>',
	'<div class="bp-content">',
	$bp,
	'</div></div>';//end bp container.
}

/*
include_once 'php/730_core.php';
createHead( 'CSGO Backpack Viewer' );


if ( isset( $_SESSION['sid'] ) || isset( $_GET['sid'] ) ) {

if ( isset( $_SESSION['sid'] ) )
$sid = $_SESSION['sid'];
if ( isset($_GET['sid']) && is_numeric($_GET['sid']) )
$sid = $_GET['sid'];

$profile = json_decode( get_data( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . AKey() . '&steamids=' . $sid . '&format=json' ), true );

$profile = $profile['response']['players'][0];

if ( $profile['communityvisibilitystate'] != 3 ) { $result = 'No items/BP found';goto echoresults;}

$userstate = 'off';
if ( isset( $userProfile['personastate'] ) && $userProfile['personastate'] < 0 )
$userstate = 'on';
if ( isset( $userProfile['gameid'] ) )
$userstate = 'game';

$schema = schema_730();
$bp = json_decode( get_data( 'http://steamcommunity.com/profiles/'. $profile['steamid'] .'/inventory/json/730/2' ), true );
if ( isset( $bp['success'] ) && $bp['success'] == 1 ) {
$f = 0 ;
$itemsLite = array();
$i = array();
$bp = $bp['rgDescriptions'];
foreach ( $bp as &$item ) {
$item['price'] = price_730( $item, $schema );
if ( $item['price'] == false || $item['price'] == 0.00 )
$item['price'] = 0;
}
usort( $bp, "cmpItems" );

$bpVal = 0;
$result ="";
foreach ( $bp as $item ) {
foreach ( $item['tags'] as $tag ) {
if ( $tag['category'] === 'Rarity' )
$colour = $tag['color'];
}
$bpVal = $bpVal + $item['price'];
$iPrice = ( $item['price'] == 0 ) ? 'N/A' : '$' . $item['price'] ;
$result .= '<span class="itimg profileItems"><img src="http://cdn.steamcommunity.com/economy/image/'.$item['icon_url'].'/62fx62f" style="background-color:#'.$item['name_color'].';" title="'. $item['market_hash_name'] . '" alt=""><span class="imgmsg" style="background-color:#' . $colour . ';">' . $iPrice . '</span></span>';
}
}
else $result = $playerInfo . '<li>' . 'No items/BP found</li>';

echoresults:

echo '<br><br><span class="pinf ' .$userstate . '">';
echo '<img class="avatar" src="'.$profile['avatarfull'].'" alt="'.htmlentities( $profile['personaname'] ).'\'s avatar" style="float:left;">';
echo '<h1>' . htmlentities( $profile['personaname'] ) . '</h1>Total Value: $' . $bpVal;
echo '</span>';

echo '<ul class="pitms" style="margin:64px; clear:both;">' . $result . '</ul>';

}
else echo 'pls log in or set a target steamid.';
 */
