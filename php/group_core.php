<?php
//provides core functions for the group scanner.

function group_scan_start($url, $gid) {//requires a validated group url from multi_scan_start()
	$groupData = new SimpleXMLElement(get_data($url));
	echo '<img src="' . htmlspecialchars($groupData->groupDetails->avatarFull) . '" title="group image" alt="group image"><br>';
	echo '<h1>' . htmlspecialchars($groupData->groupDetails->groupName) . '</h1><h3>' . $groupData->groupDetails->memberCount . ' users.</h3><br>';
	$groupData = json_decode(json_encode($groupData->members), true);

	$sec = 0;
	if (isset($_POST['sec'])) {
		$sec = (int) $_POST['sec'];
	}

	//if (empty($_POST['var']) && !is_numeric($_POST['var'])) to code around the 0 return.
	$groupData = array_slice($groupData['steamID64'], ($sec * 100), (($sec + 1) * 100));
	scan_start($groupData, $gid);
}

function group_scan_footer() {
	if (isset($_POST['pg']) && is_numeric($_POST['pg'])) {
		$page = (int) $_POST['pg'];
		$sec = (int) $_POST['sec'];
		if ($sec > 9) {
			$page++;
			$sec = 0;
		}
	} else {
		$page = 1;
		$sec = 0;
	}
	$sec++;

	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post"">next page:<input type="text" style="width: 40px;" name="pg" value="' . $page . '"> Section:<input type="text" style"width: 40px;" name="sec" value="' . $sec . '"><input type="hidden" name="input" value="' . $_POST['input'] . '"><input type="submit" name="" value="Scan next 1000 Users"></form>';

}

function multi_scan_start($url, $gid) {
	//http://steamcommunity.com/app/204300
	//http://steamcommunity.com/ogg/230410

	if (isset($_POST['pg']) && is_numeric($_POST['pg'])) {
		$page = (int) $_POST['pg'];
	} else {
		$page = 1;
	}

	//community hub
	if ((substr($url, 0, 30) == 'http://steamcommunity.com/app/')) {// this is a community hub, convert it to a group.
		$group_id = explode("/", substr($url, 30), 2);
		$dl_url = 'http://steamcommunity.com/ogg/' . $group_id[0] . '/memberslistxml/?xml=1&p=' . $page;
		group_scan_start($dl_url, $gid);
	}
	//normal group
	if ((substr($url, 0, 33) == 'http://steamcommunity.com/groups/')) {
		$dl_url = $url . '/memberslistxml/?xml=1&p=' . $page;
		group_scan_start($dl_url, $gid);
	}
	// official games group
	if ((substr($url, 0, 32) == 'http://steamcommunity.com/games/')) {
		$dl_url = $url . '/memberslistxml/?xml=1&p=' . $page;
		group_scan_start($dl_url, $gid);
	}

	$sid = any_to_64($url);

	if ($sid != false) {
		$dl_url = 'http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key=' . AKey() . "&steamid=" . $sid . "&relationship=friend";
		//this is a steamid.
		$userlist = json_decode(get_data($dl_url), true);

		if (isset($userlist['friendslist']['friends'][0]['steamid'])) {
			$scan_list = array();
			$userlist = $userlist['friendslist']['friends'];
			foreach ($userlist as $user) {
				$scan_list[] = $user['steamid'];
			}
			$playerData = json_decode(get_data($dl_url), true);
			echo '<img src="' . $playerData['response']['players'][0]['avatarFull'] . '"><br>';
			echo "<h1>Scanning " . ((isset($playerData['response']['players'][0]['personaname'])) ? htmlentities($playerData['response']['players'][0]['personaname']) : 'Error retrieving username') . "'s Friend list</h1>";

			scan_start($scan_list, $gid);
		} else {
			echo 'Target friend list is empty.';
		}
	}

	if (isset($dl_url)) {

	}

}
