<?php
if (isset($_GET['q']) and $_GET['q'] != '') {
	$schema = json_decode(file_get_contents('../api/440_schema.json'), true);
	$schemaItems = $schema['items'];
	//
	$string = strtoupper($_GET['q']);
	// initialize the results array
	$results = array();
	foreach ($schemaItems as $item) {
		// if it starts with 'part' add to results//
		if (stripos($item['item_name'], $string) !== false) {
			$json['value'] = 'def_' . $item['defindex'];//important or else it will return a comma as part of the value.
			//$json['label'] = $item['item_name'];
			$json['name'] = $item['item_name'] . ' (#' . $item['defindex'] . ')';
			$results[] = $json;
		}
	}
	header("Content-type: application/json");
	echo json_encode($results);

}
?>
