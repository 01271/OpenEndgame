<?php
session_start();
header("Content-type: text/css");
echo'@charset "UTF-8";' . "\n";

if ( !isset( $_SESSION['sid'] ) || !isset( $_SESSION['pref']['css']['Normal']['bg'] ) )
	$qualities = array(
		'Normal'	 => array( 'bg' => 'cccccc', 'border' => '999999'),
		'rarity1'	 => array( 'bg' => '669966', 'border' => '264d26'),
		'rarity2'	 => array( 'bg' => '000', 'border' => '000'),
		'vintage'	 => array( 'bg' => '6699cc', 'border' => '003366'),
		'rarity3'	 => array( 'bg' => '000', 'border' => '000'),
		'rarity4'	 => array( 'bg' => '9966cc', 'border' => '330066'),
		'Unique'     => array( 'bg' => 'cbd623', 'border' => '666600'),
		'community'  => array( 'bg' => '99ff99', 'border' => '33cc33'),
		'developer'  => array( 'bg' => 'c50a88', 'border' => '60115b'),
		'selfmade'   => array( 'bg' => '99ff99', 'border' => '33cc33'),
		'customized' => array( 'bg' => '000', 'border' => '000'),
		'strange'	 => array( 'bg' => 'ff9933', 'border' => '996633'),
		'completed'	 => array( 'bg' => '000', 'border' => '000'),
		'haunted'	 => array( 'bg' => '66ffcc', 'border' => '33cc99'),
		'collectors' => array( 'bg' => 'cc3333', 'border' => '660000'),

		);
else
$qualities = $_SESSION['pref']['css'];

$qualities['tf2eg'] = array( 'bg' => '00ff08', 'border' => 'ff0051');

foreach ($qualities as $quality => $val){
	echo '.' . $quality . '{background-color:#' . $val['bg'] . ';border-color:#' . $val['border'] . ';}' . "\n";
}
