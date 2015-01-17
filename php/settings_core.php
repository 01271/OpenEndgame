<?php
require_once 'scan_core.php';
function quality_colours_prefs($num) {

	$c =
	array(
		1 => array('Normal' => array('bg' => 'cccccc', 'border' => '999999'),
			'rarity1' => array('bg' => '669966', 'border' => '264d26'),
			'rarity2' => array('bg' => '', 'border' => ''),
			'vintage' => array('bg' => '6699cc', 'border' => '003366'),
			'rarity3' => array('bg' => '', 'border' => ''),
			'rarity4' => array('bg' => '9966cc', 'border' => '330066'),
			'Unique' => array('bg' => 'cbd623', 'border' => '666600'),
			'community' => array('bg' => '99ff99', 'border' => '33cc33'),
			'developer' => array('bg' => 'c50a88', 'border' => '60115b'),
			'selfmade' => array('bg' => '99ff99', 'border' => '33cc33'),
			'customized' => array('bg' => '', 'border' => ''),
			'strange' => array('bg' => 'ff9933', 'border' => '996633'),
			'completed' => array('bg' => '', 'border' => ''),
			'haunted' => array('bg' => '66ffcc', 'border' => '33cc99'),
			'collectors' => array('bg' => 'cc3333', 'border' => '660000'),
			//	'' => array( 'bg' => '', 'border' => ''),
		),
		2 => array(
			'Normal' => array('bg' => 'cccccc', 'border' => '999999'),
			'rarity1' => array('bg' => '669966', 'border' => '264d26'),
			'rarity2' => array('bg' => '', 'border' => ''),
			'vintage' => array('bg' => '6699cc', 'border' => '003366'),
			'rarity3' => array('bg' => '', 'border' => ''),
			'rarity4' => array('bg' => '9966cc', 'border' => '330066'),
			'Unique' => array('bg' => 'cbd623', 'border' => '666600'),
			'community' => array('bg' => '99ff99', 'border' => '33cc33'),
			'developer' => array('bg' => 'c50a88', 'border' => '60115b'),
			'selfmade' => array('bg' => '99ff99', 'border' => '33cc33'),
			'customized' => array('bg' => '', 'border' => ''),
			'strange' => array('bg' => 'ff9933', 'border' => '996633'),
			'completed' => array('bg' => '', 'border' => ''),
			'haunted' => array('bg' => '66ffcc', 'border' => '33cc99'),
			'collectors' => array('bg' => 'cc3333', 'border' => '660000'),
			//	'' => array( 'bg' => '', 'border' => ''),
		),
	);
	return $c[$num];
}

function arrayToNumeric(&$array) {
	foreach ($array as &$key) {
		if (is_array($key)) {
			arrayToNumeric($key);
		} else {

			$key = intval($key);
		}
	}
}

function pref_validate($input) {

	$css_default = quality_colours_prefs(1);

	foreach ($css_default as $quality => $val) {

		if (ctype_xdigit($input['css'][$quality]['bg'])) {
			$css[$quality]['bg'] = (string) $input['css'][$quality]['bg'];
		} else {

			$css[$quality]['bg'] = (string) $val['bg'];
		}

		if (ctype_xdigit($input['css'][$quality]['border'])) {
			$css[$quality]['border'] = (string) $input['css'][$quality]['border'];
		} else {

			$css[$quality]['border'] = (string) $val['border'];

		}
	}

	$numeric = $input['numeric'];
	arrayToNumeric($numeric);
	$res['css'] = $css;
	$res['numeric'] = $numeric;
	return $res;
}
