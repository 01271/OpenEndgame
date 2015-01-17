<?php
if (isset($_GET['q']) and $_GET['q'] != '') {
	$schema = json_decode(file_get_contents('../api/440_schema.json'), true);
	$schemaItems = $schema['items'];
	$schemaItems['1']['item_name'] = "Any item";
	$schemaItems['1']['defindex'] = 1;
	$schemaItems['1']['item_slot'] = 'misc';
	$schemaEffects = $schema['effect'];
	$schemaEffects['1']['name'] = "Any effect";
	$schemaEffects['1']['id'] = 1;
	//
	$_GET['q'] = strtoupper($_GET['q']);
	// initialize the results array
	$results = array();
	foreach ($schemaItems as $item) {
		// if it starts with 'part' add to results//
		if (isset($item['item_slot']) && stripos($item['item_name'], $_GET['q']) > -1 && ($item['item_slot'] == 'misc' || $item['item_slot'] == 'head' || $item['item_slot'] == 'taunt')) {

			$json['value'] = 'def_' . $item['defindex'];//important or else it will return a comma as part of the value.
			//$json['label'] = $item['item_name'];
			$json['name'] = $item['item_name'];
			$results[] = $json;
		}
	}
	foreach ($schemaEffects as $effect) {
		if (stripos($effect['name'], $_GET['q']) > -1) {
			$json['value'] = 'eff_' . $effect['id'];
			$json['name'] = 'effect: ' . $effect['name'];
			$results[] = $json;
		}
	}

	header("Content-type: application/json");
	echo json_encode($results);

}
?>
