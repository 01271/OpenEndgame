<?php

include 'php/730_core.php';
createHead('CS:GO Scanner', 730);
echo '<div class=news>CSGO prices may not be accurate. Exercise caution when trading, thanks.</div>';
if (isset($_SESSION['sid']) && donator_level(10)) {

	if (!form_spam_valid()) {
		$noscan = true;
	}

	$json = db_load('730_schemalist_time');

	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><textarea placeholder="Enter &quot;status&quot; output here. ' . $json['priced'], ' Items Priced. Last Pricelist Update: ', (($json['time'] > 3600) ? (date('i', (time() - $json['time'])) . ' minutes') : 'Over an hour') . ' ago." rows="20" name="form-data" class="scanSubmit"></textarea><input type="submit" class="scansub"> ' . form_spam_fields() . '</form><br>';
	if (isset($_POST['form-data']) && !isset($noscan)) {
		scan_start($_POST['form-data'], 730);
	} else {

	}
} else {
	echo '<h1 class="ct login_notice">Please login to scan.</h1>';
}

createFooter(730);
