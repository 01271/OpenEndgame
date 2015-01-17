<?php

include 'php/440_core.php';
createHead('Portal 2 Scanner', 620);

if (isset($_SESSION['sid']) && donator_level(20)) {

	if (!form_spam_valid()) {
		$noscan = true;
	}

	echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"><textarea placeholder="Enter \'status\' output here." rows="20" name="form-data" class="scanSubmit"></textarea><input type="submit" class="scansub"> ' . form_spam_fields() . '</form>';

	if (isset($_POST['form-data']) && !isset($noscan)) {
		scan_start($_POST['form-data'], 570);
	} else {
	}
} else {
	echo '<h1 class="ct login_notice">Please login to scan.</h1>';
}

createFooter(620);