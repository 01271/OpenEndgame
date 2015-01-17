<?php
include_once 'php/440_core.php';
createHead('BP Viewer', 440, '<script src="js/slider.js" ></script>');
//get rid of this after testing.

if (isset($_GET['sid'])) {
	include 'php/bp_core.php';
	$sid = any_to_64($_GET['sid']);

	backpack_viewer($sid);

} else {
	echo '<div class="bp-container">';
	echo '<div class="bphead">';
	echo 'Error retrieving steamid.';
	echo '</div>';//end bp header
	echo '</div>';//end bp container.
}
createFooter(440);
