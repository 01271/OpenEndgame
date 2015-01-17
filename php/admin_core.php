<?php

require_once 'db_core.php';

function admin_password() {if (isset($_POST['pass']) && $_POST['pass'] == 'gregorian') {return true;}
}

function admin_page_display() {
	user_db_find();

	random_10_user();
	global_whitelist_update();
	big_button_list();
	apiKeyBox();
	get_latest_errors();
	bug_list();
}

function global_whitelist_update() {

	echo '<div class="col2 lt"><h2>Global Whitelist:</h2>';
	if (isset($_POST['gwhitelist']) && admin_password()) {
		file_put_contents(htmlentities($_SERVER['DOCUMENT_ROOT'] . '/api/wlist.json'), json_encode(json_decode($_POST['gwhitelist']), true));
		//wow look at that encoding, that's really a great way to just turn it into a meaningless blob.
		echo 'whitelist updated.<br>';

	}
	echo '<form id="JSONValidate" method="post" action="', $_SERVER['PHP_SELF'], '" name="JSONValidate"><input id="reformat" value="1" type="hidden"><input id="compress" value="0" type="hidden"><div><textarea name="gwhitelist" wrap="off" id="json_input" class="json_input col2-content" rows="30" cols="100" spellcheck="false">', file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/api/wlist.json'), '</textarea></div><button name="validate" id="validate" value="Validate" class="button left bold" >Validate</button> <input type="password" class="ddinput" name="pass"> <input type="submit"><div id="results_header" class="hide"><h3>Results <img title="Loading..." class="reset" alt="Loading" src="/img/load.gif" id="loadSpinner" name="loadSpinner"></h3></div><pre id="results"></pre></form></div>';

	// echo '<div class="col2 rt"><pre>';
	// var_dump( json_decode( file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/api/wlist.json' ), true ) );
	// echo '</pre></div>';
}

function bug_list() {
	$c = db_init('site_data', 'bugs');
	if (isset($_POST['bugfeedback']) && isset($_POST['errorid'])) {
		$errid = new MongoId(htmlentities($_POST['errorid']));
		$c->update(array('_id' => $errid), array('$set' => array('answer' => (string) htmlentities($_POST['bugfeedback']))));
	}
	$res = $c->find(array('answer' => array('$exists' => false)))->limit(30);
	$num = $res->count();
	$res = iterator_to_array($res);

	$type = array(2 => 'Reports', 3 => 'Suggests', 4 => 'Asks', 5 => 'Says');
	$bcount = 0;
	echo '<div class="col2 rt"><h2>BUGS LOL</h2>', $num, ' unsolved bugs detected<br><br><div class=bugreports>';
	foreach ($res as $key => $doc) {$bcount++;echo '<br><b>', $bcount, '. <a href=http://steamcommunity.com/profiles/', $doc['sid'], ' target=blank>', $doc['sid'], '</a> ', $type[$doc['bug_type']], ':</b><br>', $doc['bug_text'], '<br><form action="' . $_SERVER['PHP_SELF'] . '" method=post><input type=hidden name=errorid value="' . $doc['_id'] . '"><input name=bugfeedback type=text><input type=submit></form><br>';}
	echo '</div></div>';
}

function big_button_list() {

	$pricelist = db_load('440_pricelist_v4_time');
	$schema = db_load('440_schema_time');
	$paint = db_load('440_paint_time');

	echo '<div class="col2 rt"><h2>Update Schemas:</h2>',
	'<form method="post" action="' . $_SERVER['PHP_SELF'] . '"><br>',

	'<ul>',
	'<li><span class="lt"> <input type="submit" name="priceUpdate" value="x">Update prices:</span><span class="rt">' . date('M d, Y', db_load('440_pricelist_v4_time')) . '</span></li>',
	'<li><span class="lt"> <input type="submit" name="schemaUpdate" value="x">Update schema:</span><span class="rt">' . date('M d, Y', db_load('440_schema_time')) . '</span></li>',
	'<li><span class="lt"> <input type="submit" name="paintUpdate" value="x">Update paints:</span><span class="rt">' . date('M d, Y', db_load('440_paint_time')) . '</span></li>',
	'<li><span class="lt"> <input type="submit" name="gamesupdate" value="x">Update games</span><span class="rt">' . date('M d, Y', db_load('753_list_time')) . '</span></li>',
	'</ul>',
	'<br><br><input name="pass" type="password" class="ddinput"><br>';

	if (isset($_POST['paintUpdate']) && admin_password()) {
		include_once 'php/update.php';
		updatePaints();
		echo 'paints updated.';
	}
	if (isset($_POST['schemaUpdate']) && admin_password()) {
		include_once 'php/update.php';
		resetUpdateCounters('schema');
	}
	if (isset($_POST['priceUpdate']) && admin_password()) {
		include_once 'php/update.php';
		resetUpdateCounters('prices');
	}
	if (isset($_POST['gamesupdate']) && admin_password()) {
		include_once 'php/update.php';
		updateListOfAllSteamGames();
	}

	echo '</form></div>';
}

function rank_update($sid, $plevel) {
	if (isset($sid) && is_numeric($sid) && isset($plevel) && is_numeric($plevel) && isset($_POST['yes'])) {
		if (admin_password()) {
			if ($plevel != 10 && $plevel != 20 && $plevel != 30) {
				echo 'invalid donator rank';
				break;
			}
			$c = db_init('site_data', 'site_users');
			$st = time();

			$where = array('_id' => (int) $sid);
			$data =
			array(
				'$setOnInsert' => array(
					'first_login' => (int) $st,
					'number_scans' => (int) 0,
				),
				'$set' => array(
					'privilege' => (int) $plevel,
					'level_date' => (int) $st,
				)
			);
			$mongoptions = array('upsert' => true);//replace document details if the entry exists.
			$c->update($where, $data, $mongoptions);
			echo 'Donator rank set for steam user ' . $sid . '! (Visit http://endgame.tf/profile.php If you want to check.)';
		} else {
			echo 'Invalid password.';
		}
	}
}

function timeSince($timestamp) {
	$date = new \DateTime();
	$date->setTimestamp($timestamp);
	$interval = $date->diff(new \DateTime('now'));
	return $interval->format('%y years, %m months, %d days');
}

function rank_upd_list($sid, $priv) {
	return '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">' .
	'<input type="hidden" name="steamid_forRank" value="' . $sid . '">' .
	'<select name="rank">' .
	'<option value="1"' . (($priv == 1) ? ' selected' : '') . '>Banned</option>' .
	'<option value="10"' . (($priv == 10) ? ' selected' : '') . '>Normal</option>' .
	'<option value="20"' . (($priv == 20) ? ' selected' : '') . '>Donator</option>' .
	'<option value="30"' . (($priv == 30) ? ' selected' : '') . '>Special Donator</option>' .
	'</select><br><input type="password" name="pass" class="ddinput">' .
	'<input type="submit" name="yes" value="Update"></form>';
}

function errorLineCount() {
	$file = '/tmp/fpm_error.log';
	$linecount = 0;
	$handle = fopen($file, "r");
	while (!feof($handle)) {
		$line = fgets($handle);
		$linecount++;
	}
	fclose($handle);
	return $linecount;
}

function tailShell($filepath, $lines = 1) {
	ob_start();
	passthru('tail -' . $lines . ' ' . escapeshellarg($filepath));
	return trim(ob_get_clean());
}

function get_latest_errors() {
	$lines = preg_replace('/\[.*America\/Vancouver\]/', '', tailShell('/tmp/fpm_error.log', 20));
	echo '<div class="col2 lt"><h2>Latest Errors:</h2><br>' . errorLineCount() . ' Lines of errors, my god.<br><textarea cols=52 rows=40>' . $lines . '</textarea></div>';

}

function apiKeyBox() {

	if (admin_password() && isset($_POST['apikeyfield']) && isset($_POST['apikeysubmit'])) {
		db_save('akey', $_POST['apikeyfield']);
	}

	$apikey = db_load('akey');
	echo '<div class="col2 rt"><h2>Api Key:</h2><br><form action="', $_SERVER['PHP_SELF'], '" method=post><input name="apikeyfield" type="text" placeholder="', $apikey, '"><br><input name="pass" type="password" class="ddinput"><input type=submit name=apikeysubmit value=apikeysubmit></form></div>';
}

function user_db_find() {
	echo '<div class="col2 lt"><h2>Find User</h2>';

	if (isset($_POST['steamid_forRank']) && isset($_POST['rank'])) {
		rank_update($_POST['steamid_forRank'], $_POST['rank']);
	}

	if (isset($_POST['sidsubmit'])) {

		$sid = any_to_64($_POST['sidsubmit']);

		$c = db_init('site_data', 'site_users');
		$user = $c->find(array('_id' => (int) $sid))->limit(1);
		$user = iterator_to_array($user);
		$user = $user[$sid];

		$qualities = array(1 => 'collector', 10 => 'normal', 20 => 'rarity1', 30 => 'vintage', 69 => 'strange', 100 => 'developer');

		echo '<table class="tbpad"><tr><th>userid</th><th>time since they joined</th><th>privilege</th></tr>';

		if ($user == false) {
			echo '<tr class="' . $qualities[10] . '"><td>' . $sid . '</td><td>Never Logged In.</td><td>' . rank_upd_list($sid, 10) . '</td></tr>';
		} else {
			echo '<tr class="' . $qualities[$user['privilege']] . '"><td>' . $user['_id'] . '</td><td>' . timeSince($user['first_login']) . '</td><td>' . rank_upd_list($user['_id'], $user['privilege']) . '</td></tr>';
		}
		echo '</table>';
	}
	echo '<br>Search for a user.<br><br>' .
	'<form method="post" action="' . $_SERVER['PHP_SELF'] . '">' .
	'<input type="text" name="sidsubmit"><input type="submit"></form></div>';
}

function random_10_user() {// why not populate my admin page a bit?

	$c = db_init('site_data', 'site_users');
	$users = $c->find()->limit(10)->sort(array('first_login' => -1));

	echo '<div class="col2 rt"><h2>Latest Users</h2><table class="tbpad">';
	echo '<tr><th>userid</th><th>time since they joined</th><th>privilege</th></tr>';

	$qualities = array(1 => 'collector', 10 => 'normal', 20 => 'rarity1', 30 => 'vintage', 69 => 'strange', 100 => 'unusual');

	foreach ($users as $user) {
		echo '<tr class="' . $qualities[$user['privilege']] . '"><td>' . $user['_id'] . '</td><td>' . timeSince($user['first_login']) . '</td><td>' . $user['privilege'] . '</td></tr>';
	}
	echo '</table>';
	$total_users = $c->count();
	$total_donors = $c->count(array('privilege' => (int) 20));
	echo '<h2>Usercount:</h2>There are ' . $total_users . ' users and ' . $total_donors . ' donator accounts in the db.</div>';

}
