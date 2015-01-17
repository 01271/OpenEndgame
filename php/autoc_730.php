<?php
if (isset($_GET['q']) and $_GET['q'] != '') {
	$schema = json_decode(file_get_contents('../api/cs_schema.json'), true);
	$string = strtoupper($_GET['q']);
	// initialize the results array
	$results = array();
	$x = 0;
	foreach ($schema as $name => $v) {
		// if it starts with 'part' add to results//
		if (stripos($name, $string) !== false) {
			$x++;
			$json['value'] = $name;//important or else it will return a comma as part of the value.
			//$json['label'] = $item['item_name'];
			$json['name'] = $name;
			$results[] = $json;
			if ($x >= 30) {break;}
		}
	}
	header("Content-type: application/json");
	echo json_encode($results);

}
?>
