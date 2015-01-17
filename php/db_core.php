<?php
//database functions for tf2endgame version 4.
//includes functions for the database to save preferences

//db.classid_440.find({"market_hash_name" : /.*Australium*./i})

function db_init($db_name, $col_name) {
	$m = new MongoClient();
	$d = $m->$db_name;
	return $d->$col_name;
}

function db_save($key, $value) {
	$col = db_init('site_data', 'central_storage');
	$col->save(array('_id' => (string) $key, 'data' => $value));
}
function db_load($key) {
	$col = db_init('site_data', 'central_storage');
	$res = $col->find(array('_id' => (string) $key), array('_id' => 0, 'data' => 1));
	$res = iterator_to_array($res);
	if (isset($res[0]['data'])) {
		return $res[0]['data'];
	} else {
		return false;
	}
}

function db_remove($key) {
	$col = db_init('site_data', 'central_storage');
	$col->remove(array('_id' => (string) $key));
}

function donator_level($threshold) {
	//gets the donator rank for the current user!
	if (isset($_SESSION['sid']) && isset($threshold)) {
		$priv = get_database_field_contents($_SESSION['sid'], array('privilege'));
		if ($priv['privilege'] >= $threshold) {
			return true;
		}
	}

	return false;
}

function get_database_field_contents($sid, array $fields) {

	$c = db_init('site_data', 'site_users');
	$where = array('_id' => (int) $sid);

	foreach ($fields as $field => $val) {
		unset($fields[$field]);
		$fields[$val] = 1;
	}

	$fields['_id'] = 0;
	$result = $c->find($where, $fields);
	$ret = iterator_to_array($result);
	if (isset($ret[0])) {
		return $ret[0];
	} else {
		return false;

	}
}

function increment_scan($gid) {
	$c = db_init('site_data', 'site_users');
	$c->update(array('_id' => (int) $_SESSION['sid']), array('$inc' => array("number_scans.$gid"=> 1)));
}

function default_pref() {
	return array(
		'numeric' => array(
			'ss' => array(
				'threshold' => 1,
				'maxhours' => 999999999,
				'worthless' => 1,
				'f2p' => 1,
			),
			'gs' => array(
				'threshold' => 1,
				'maxhours' => 99999,
				'worthless' => 1,
				'f2p' => 1,
				'timeaway' => 1209600,
				'hidenotplaying' => 0,
			),
			'timeValue' => 1,
			'bp' => array(1, 2),
			'warn' => 0,
		),
	);
}

function preference_get($type = 'all') {
	$c = db_init('site_data', 'site_users');
	if (donator_level(20)) {
		$a = get_database_field_contents($_SESSION['sid'], array('pref', 'bwlist'));
		if (isset($a['pref'])) {
			$_SESSION['pref'] = $a['pref'];
		} else {
			$_SESSION['pref'] = default_pref();
		}

		if (isset($a['bwlist'])) {
			$_SESSION['bwlist'] = $a['bwlist'];
		}

	} else {
		$_SESSION['pref'] = default_pref();
	}
}

function preference_delete() {

	$c = db_init('site_data', 'site_users');
	$c->update(array('_id' => (int) $_SESSION['sid']), array('$set' => array('pref' => null)));

}

function preference_update() {
	if (isset($_SESSION['sid']) && donator_level(20)) {
		try {
			$prefs = pref_validate($_POST);//defined in settings_core.php
			$c = db_init('site_data', 'site_users');
			$c->update(array('_id' => (int) $_SESSION['sid']), array('$set' => array('pref' => $prefs)));

			echo '<div class="cf notice good">Preferences updated for ' . ucfirst(htmlentities($_SESSION['currentUserName'])) . ' (' . $_SESSION['sid'] . ')</div>';
		} catch (Exception $e) {
			echo '<div class="cf notice bad">Preferences not updated. (something went wrong!)</div>';
		}
	} else {
		echo '<div class="cf notice bad">Not a donator, not updating.</div>';
	}
}

function legacy_removeUserData($sid) {
	$steamID64 = md5($sid);
	$db = new PDO('sqlite:TF2EG.sqlite');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "DELETE FROM SteamUsers WHERE steamID64 = ?";
	$q = $db->prepare($sql);
	$q->bindParam('steamID64', $steamID64, PDO::PARAM_STR);
	$q->execute(array($steamID64));
}

function legacy_getUserData($profile) {
	$steamID64 = md5($profile);
	$db = new PDO('sqlite:TF2EG.sqlite');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$sql = "SELECT * FROM SteamUsers WHERE steamID64 = ?";
	$q = $db->prepare($sql);
	$q->bindParam('steamID64', $steamID64, PDO::PARAM_STR);
	$q->execute(array($steamID64));
	$row = $q->fetch();
	if (!isset($profile)) {
		return FALSE;
	}

	$userData = array(
		'steamID64' => $row['steamID64'],
		'steamName' => $row['steamName'],
		'joinDate' => $row['join_date'],
		'privilege' => $row['privilege'],
		'item_prefs' => $row['item_prefs'],
		'user_prefs' => $row['user_prefs'],
	);
	$db = NULL;
	return $userData;

}

function database_login($sid) {
	if (isset($sid) && is_numeric($sid) && strlen($sid) == 17) {
		$sid = (int) $sid;
		$priv = (int) 10;
		$st = time();
		$usr = legacy_getUserData($sid);

		if (isset($usr['steamID64'])) {

			if (isset($usr['joinDate'])) {
				$st = $usr['joinDate'];
			}

			if (isset($usr['privilege']) && $usr['privilege'] != 0) {
				$priv = (int) $usr['privilege'];
			}

			//legacy_removeUserData( $sid );
		}
		$c = db_init('site_data', 'site_users');
		$where = array('_id' => (int) $sid);
		$data =
		array(
			'$setOnInsert' => array(
				'first_login' => (int) $st,
				'privilege' => (int) $priv,
			), //end setoninsert
			'$set' => array(
				'last_login' => (int) time(),
			),
		);
		$mongoptions = array('upsert' => true);//replace document details if the entry exists.
		$c->update($where, $data, $mongoptions);
	}
}
