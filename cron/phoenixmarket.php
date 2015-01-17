<?php

libxml_use_internal_errors( true );

function start_scrape() {
	$c = 0;
	while ( $c < 2 ) {
		csgo_scrape();
		sleep( 2 );
		$c++;
	}
}

function csgo_scrape() {


	$results = "";
	for ( $i = 0; $i < 5; $i++ ) {
		$results = getMarket();
		if ( !empty( $results ) ) break;
		sleep( 2 );
	}

	if ( empty( $results ) ) exit( 0 );

	//echo htmlentities($results);

	preg_match_all( '/<img id="listing_sell_sold_\d+_image" ?src="([^"]+)"/', $results, $res['img'], PREG_PATTERN_ORDER ); //image
	preg_match_all( '/market\/listings\/[^\/]+([^"]+)/', $results, $res['name'], PREG_PATTERN_ORDER );// <a class="market_listing_item_name_link"[^>]+>([^<]+)
	preg_match_all( '/<span class="market_listing_game_name">[^<]*[^<\/span>]/', $results, $res['game'] ); //game name
	preg_match_all( '/<span class="market_listing_price market_listing_price_without_fee">([^<]+)<\/span>/', $results, $res['price'], PREG_PATTERN_ORDER ); //price
	preg_match_all( '/data-miniprofile="([^"]+)"/', $results, $res['sellers'] ); //seller name


	$list = array();
	$count = 0;
	while ( $count <= 9 ) {
		$game = substr( trim( utf8_decode( $res['game'][0][$count] ) ), 39 );
		$mone = trim( html_entity_decode( $res['price'][1][$count] ) );
		if ( $mone[0] != '$'  || $game != 'Counter-Strike: Global Offensive' ) {$count++;continue;}
		//echo $mone . ' ' . $mone[1] . '<br>';
		$list[] = array(
			'price'=>  (float) substr( $mone, 1 ) * 100,
			'name'=>   substr( urldecode( trim( $res['name'][1][$count] ) ), 1 ),
			'seller'=> trim( $res['sellers'][1][$count] ) + 0x0110000100000000,
			'img'=>    trim( $res['img'][1][$count] ),
			'game'=>   $game
		);
		$count++;
	}

	$m  = new MongoClient();
	$db = $m->market_730;
	$col = $db->item_index;

	foreach ( $list as $item ) {
		$where = array( 'name'=> (string) $item['name'] ); //where //end where
		$data  =
			array(
			'$setOnInsert' => array(
				'img_url' => (string) $item['img'],
				"first_added"  => (int) time(),
			),
		);
		$mongoptions = array( 'upsert' => true ); //replace document details if the entry exists.
		$col->update( $where, $data, $mongoptions );
	}

	$db = $m->market_730;
	$col = $db->item_prices;

	foreach ( $list as $item ) {
		$where = array( 'seller'=> (string) $item['seller'] ); //where //end where
		$data  =
			array(
			'$set' => array(
				'name'  => (string) $item['name'],
				'price' => (int) $item['price']
			)
		);
		$mongoptions = array( 'upsert' => true ); //replace document details if the entry exists.
		$col->update( $where, $data, $mongoptions );
	}

	exit( 0 );
}


function cURL( $url ) {
	$c = curl_init();
	curl_setopt( $c, CURLOPT_URL, $url );
	curl_setopt( $c, CURLOPT_HEADER, false );
	curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 2 );
	curl_setopt( $c, CURLOPT_TIMEOUT, 3 );
	curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
	//curl_setopt( $c, CURLOPT_COOKIEFILE, "cookies.txt" );
	$result = curl_exec( $c );
	curl_close( $c );
	return $result;
}

function getMarket() {
	$recent = "http://steamcommunity.com/market/recentcompleted?currency=usd";
	$json = cURL( $recent );
	$json = json_decode( $json, true );
	$results = $json["results_html"];
	$results = stripcslashes( $results );
	return $results;
}
