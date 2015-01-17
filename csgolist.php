<?php
//error_reporting(E_ALL);
//ini_set('display_startup_errors', TRUE);
//ini_set('display_errors', TRUE);
include 'php/scan_core.php';
createHead('CS:GO Pricelist', 730);

//http://steamcommunity.com/market/priceoverview/?appid=730&market_hash_name=SCAR-20%20|%20Contractor%20%28Field-Tested%29

//ok time for the shit list.

$col = db_init('market_730', 'item_index');
$item_prices_db = db_init('market_730', 'item_prices');

$num_unpriced = 0;

$curs = $col->find()->sort(array('name' => 1));

$num_priced = $curs->count();

echo $curs->count() . ' priced items in the db with ' . $item_prices_db->count() . ' price points overall.<br>';

$pricelist = array();
echo '<table><thead><th>image</th><th data-sort="float" >Price $ (USD)</th><th data-sort="string" >name</th><tbody>';
foreach ($curs as $item) {
	$price = (int) cs_price($item['name']);
	if (isset($item['valve_avg']) && $item['valve_avg'] != -1 && $item['valve_avg'] != 0) {
		$price = sprintf("%.2f", ($item['valve_avg'] / 100));
	} else {
		if (isset($price) && $price != 0 && $price != -1) {
			$price = sprintf("%.2f", (cs_price($item['name']) / 100));
		} else {
			$price = 0;
			$num_unpriced++;
		}
	}
	echo '<tr><td><img src="' . $item['img_url'] . '"></td><td data-sort-value="' . $price . '">' . (($price != 0) ? $price : 'N/A') . '</td><td>' . $item['name'] . '</td></tr>';
	$pricelist[$item['name']] = array('img' => $item['img_url'], 'price' => $price, 'classid' => ((isset($item['classid'])) ? $item['classid'] : ''));
}
echo '</table>';
echo $num_unpriced, ' Unpriced items remain.';

file_put_contents(json_directory() . '/cs_schema.json', json_encode($pricelist));
db_save('730_schemalist_time', array('time' => time(), 'priced' => $num_priced));

//echo '<br><br>';
//echo cs_price( 'Nova | Tempest (Minimal Wear)' );

function cs_price($itemName) {
	$col = db_init('market_730', 'item_prices');
	//old query that worked: array( array( '$match' => array( 'name' =>$itemName ) ), array( '$group' => array( '_id'=>null,  'avgPrice' => array( '$avg'=> '$price' ) ) ) );

	$count = $col->count(array("name" => "$itemName"));
	if ($count == 0) {

		//$res = json_decode( get_data( 'http://steamcommunity.com/market/priceoverview/?appid=730&market_hash_name=' . urlencode( $itemName ) ), true );
		//if(isset($res['success'] ) && $res['success'] == true && (isset($res['lowest_price']) || isset($res['median_price']) ) ){
		// if (isset($res['median_price']))
		//  return substr($res['median_price'], 1);
		// if (isset($res['lowest_price']))
		//  return substr($res['lowest_price'], 1);
		//}
		return -1;
	}
	$item = $col->find(array("name" => "$itemName"))->sort(array("price" => 1))->skip(($count / 2 - 1))->limit(1);

	$a = iterator_to_array($item);
	foreach ($a as $a) {
		return $a['price'];
	}

	//$query = array( 'name' =>$itemName );
	//$price = $col -> find( $query );

	//if ( isset( $price['result'][0]['avgPrice'] ) )
	//  $avgPrice = $price['result'][0]['avgPrice'];
	//else $avgPrice = 0;
	//return $avgPrice;

}

createFooter(730);
?>
