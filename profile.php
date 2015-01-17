<?php
include_once 'php/core.php';
include_once 'php/db_core.php';

createHead('Your Profile', 440);

if (isset($_SESSION['sid'])) {
	$c   = db_init('site_data', 'bugs');
	$res = $c->find(array('sid' => (int) $_SESSION['sid']));
	$res = iterator_to_array($res);
	echo '<div class="col2 lt"><h1>Welcome, ' . ucfirst(htmlentities($_SESSION['currentUserName'])) . '.</h1>',
	' This is your personal profile page. There\'s not much here yet but I hope that one day this page will do a lot of stuff. For now, all it does is display answers to messages you posted on the bug report page and show your donator rank.</div>';
	echo '<div class="col2 rt"><h2>Your questions:</h2><br>';
	$type = array(2 => 'Reported', 3 => 'Suggested', 4 => 'Asked', 5 => 'Said');
	foreach ($res as $a => $doc) {
		echo '<b>You ' . $type[$doc['bug_type']] . ':</b><br>' . $doc['bug_text'] . '<br><br><b>Digits answered:</b><br>' . $doc['answer'] . '<br><br>';
	}
	echo '</div>';
	echo '<div class="col2 rt">You are', ((donator_level(20) == true) ? '' : ' not'), ' a donator.</div>';

} else {
	echo '<div class="col2 lt"><h1>Hi there, you\'re not logged in...</h1></div>';
}

createFooter(440);

?>
