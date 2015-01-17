<?php

include '/usr/share/nginx/html/php/core.php';
//market_classid_scrape( 10 );

function db_init_market() {
	$m = new MongoClient();
	$d = $m -> classid_dump;
	return $d -> classid_440;
}

function latest_classid() {
	$db = db_init_market();
	$res = $db -> find( array(), array( '_id' => 1 ) )->sort( array( '_id'=>-1 ) )->limit( 1 );
	$res = iterator_to_array( $res );
	$res = reset( $res );
	return $res['_id'];
	// db.items_440.find( {}, {'_id':1} ).limit( 1 ).sort( {'_id':-1} ).pretty()
}
//app_data.def_index
function save_classid_data( $result ) {
	if ( isset( $result['result'] ) )
		$result = $result['result'];
	if ( isset( $result['success'] ) && $result['success'] == true ) {
		foreach ( $result as $key => $res ) {
			if ( $key != 'success' )
				$item = $res;
		}

		$db = db_init_market();
		$item['_id'] = (int) utf8_decode( $item['classid'] );
		echo $item['_id'] , "\n";
		$db -> save( $item );
	}
}

function market_classid_scrape( $num_to_scrape ) {
	$latest = (int) latest_classid() + 1;
	if ( !is_numeric( $latest ) )
		$latest = 4;
	$i = 0;
	while ( $i < $num_to_scrape ) {

		save_classid_data( json_decode( get_data( 'http://api.steampowered.com/ISteamEconomy/GetAssetClassInfo/v0001/?appid=440&classid0=' . $latest . '&class_count=1&key=' . AKey() ), true ) );
		$latest++;
		$i++;
	}
}
