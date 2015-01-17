<?php

include 'php/core.php';
createHead('Bug Reporter', 440);
if (isset($_SESSION['sid'])) {
	echo '<h1>Thanks for helping Endgame become better!</h1>',
	'This is the place where you can report problems with endgame or suggest features!<br>',
	'Please select what kind of report you want to make and then submit it, I\'ll read it eventually, I promise :V.<br><br>',
	'<form action="', $_SERVER['PHP_SELF'], '" method=post><textarea maxlength="1000" class="scanSubmit" name=bugtext placeholder="Write Here!(up to 1000 characters)""></textarea><select name="bugtype">
  <option value="2">Bug Report</option>
  <option value="3">Feature suggestion</option>
  <option value="4">Endgame-Related Question</option>
  <option value="5">Contact/Other</option>
</select>&nbsp;
<input type=submit></form>';
} else {
	echo '<h1>Login to post a report.</h1>';
}

if (isset($_POST['bugtype']) && isset($_POST['bugtext']) && !empty($_POST['bugtype']) && !empty($_POST['bugtext'])) {
	bug_submit($_POST['bugtype'], $_POST['bugtext']);
}

/*
2 => 'Bug Report',
3 => 'Feature suggestion',
4 => 'Question',
5 => 'Contact/Other'
 */

createFooter(440);

function bug_submit($bug_type, $bug_text) {

	if (!is_numeric($bug_type) && $bug_type >= 2 && $bug_type <= 5) {
		echo 'invalid bug type, report not submitted.';
		return 0;
	}
	if (!isset($_SESSION['sid'])) {
		echo 'Not logged in, try again.';
		return 0;
	}
	$bug_text = (string) substr(htmlentities($bug_text), 0, 1000);
	$c = db_init('site_data', 'bugs');
	$c->insert(array('sid' => (int) $_SESSION['sid'], 'bug_type' => (int) $bug_type, 'bug_text' => $bug_text));
	echo '<h3>Report Submitted Successfully.</h3>';
}
