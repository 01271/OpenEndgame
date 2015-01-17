<?php
function getPrices() {
	$m  = new MongoClient();
	$db = $m->market_730;
	$col = $db->item_index;

	function get_data( $url ) {try {$ch = curl_init();curl_setopt( $ch, CURLOPT_URL, $url );curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );$data = curl_exec( $ch );curl_close( $ch );return $data;}catch ( Exception $e ) {return false;}}

	//find { 'valve_est': { $exists: false } }
	$curs = $col->find( array( 'valve_avg'=> array( '$not' => array( '$gt' => 0 ) ), 'valve_avg_time' => array( '$not' => array( '$lte' => ( time() - 432000 ) ) ) ) )->limit( 10 )->skip( rand( 0, 100 ) );
	$curs = iterator_to_array( $curs );
	if ( !empty( $curs ) ) {
		foreach ( $curs as $item ) {

			if ( isset( $item['name'] ) ) {
				$data = json_decode( get_data( 'http://steamcommunity.com/market/priceoverview/?appid=730&market_hash_name=' . urlencode( $item['name'] ) ), true );
				//echo '<pre>', $item['name'];print_r( $data );echo '</pre><br>';
				if ( isset( $data['success'] ) && $data['success'] == true && isset( $data['median_price'] ) ) {
					$col -> update( array( 'name' => (string) $item['name'] ), array( '$set' => array( 'valve_avg_time' => (int) time(), 'valve_avg' => (int) floor( substr( html_entity_decode( $data['median_price'] ), 1 ) ) * 100 ) ) , array( 'upsert' => false ) );
				}
				else if ( isset( $data['success'] ) && $data['success'] == true && !isset( $data['median_price'] ) ) {
						$col -> update( array( 'name' => (string) $item['name'] ), array( '$set' => array( 'valve_avg_time' => (int) time(), 'valve_avg' => (int) -1 ) ) , array( 'upsert' => false ) );
					}
			}
		}
	}
}
