<?php

include 'php/440_core.php';
include 'php/group_core.php';
createHead('TF2 Multi Scanner', 440);

st_click();

if (isset($_SESSION['sid']) && donator_level(20)) {

	if (!form_spam_valid()) {
		$noscan = true;
	}

	echo 'Group and Friend list scanner.<br class="cf"><br>';
	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><input type="text" placeholder="Enter a steamid/url or group url here." name="form-data" class="col1"><br>Start from page:<input type="text" class="ddinput" name="pg" value="' . ((isset($_POST['pg'])) ? $_POST['pg']++ : '0') . '"> Section:<input type="text" class="ddinput" name="sec" value="' . ((isset($_POST['sec'])) ? $_POST['sec']++ : '0') . '"><br><input type="submit" class="scansub">' . form_spam_fields() . '</form>';
	if (isset($_POST['form-data']) && !isset($noscan)) {
		multi_scan_start($_POST['form-data'], 440);
	} else {
		include 'php/update.php';
		updateEverything();
	}
} else {
	login_or_donator();
}

createFooter(440);
