<?php
include 'php/scan_core.php';
include 'php/update.php';
createHead('DB', 440, '<script src="js/slider.js" ></script><script src="js/char-insert.js" ></script><script src="js/reserve.js" ></script><script src="js/as-compiled.js" ></script><link rel="stylesheet" href="css/autoSuggest.css" type="text/css" media="screen">');

if (donator_level(20)) {

	$databases = array('440' => array('name' => 'unusual search', 'url' => 'php/autocomplete_nowep.php', 'db' => 'items', 'col' => 'unusual'),
		'730' => array('name' => 'csgo db', 'url' => 'php/autoc_730.php', 'db' => 'archive', 'col' => 'items_730'));
	echo '<h1>Endgame Database.</h1>';
	foreach ($databases as $key => $db) {
		$c = db_init($db['db'], $db['col']);
		echo
		'<a class="show_hide" href="#" rel="#slidingDiv_' . $key . '"><h2>' . $db['name'] . '</h2></a>',
		'<div id="slidingDiv_' . $key . '" class="toggleDiv bp-content cf">',
		'<form action="' . $_SERVER['PHP_SELF'] . '" method="POST">',
		($c->count()), ' Backpacks in database. ',
		'(Enter at least 3 characters then click the item you want.)<input type="text" id="as-input" class=as-input autocomplete=off data-autocompleteurl=' . $db['url'] . ' /><br>',
		'<input type=hidden name=gid value=' . $key . '><input type=submit>',
		(($key == 730) ? '&nbsp; copy and paste: stattrak™ ★' : ''),
		'<br><div class="col2 lt">',
		'Sort by: <select name=sortby>' .
		'<option value=1 selected=selected>Hours played</option>',
		'<option value=2>Last Updated</option>',
		'<option value=3>First added to DB</option>',
		'</select><select name=sortorder><option value=1 selected=selected>Sort lowest first</option><option value=2>Sort Highest First</option></select><br>',
		/*'<input type="checkbox" name=hideprivatehrs value="on"> Hide users with private hours.<br>',*/
		//<button type="button" value="stattrak™ " class="insert-word">stattrak™</button><button type="button" value="★ " class="insert-word">★</button>
		'</div></form>',
		'</div><br>';
		$c = null;
	}

	if ((isset($_POST['gid']) && is_numeric($_POST['gid'])) || (isset($_GET['gid']))) {
		include_once 'php/multidb_core.php';
		database_search_prepare($_POST['gid']);
	} else {
		echo 'No search submitted.';
		updateListOfAllSteamGames();
	}
} else {
	login_or_donator();
}

createFooter();
