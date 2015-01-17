<?php
include 'php/440_core.php';
createHead('Restricted Test');

if (isset($_SESSION['sid']) && $_SESSION['sid'] == 76561198013370444) {

	$res = get_data('http://api.steampowered.com/IEconItems_440/GetSchema/v0001/?key=' . AKey() . '&language=en', 5);

	var_dump($res);

} else {

	echo 'Hey! you\'re not digits, get out of here!';
}

createFooter(440);
