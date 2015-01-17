<?php

include 'php/440_core.php';
include 'php/admin_core.php';

createHead('Ban Everyone', 440, '<script src="js/jquery-linedtextarea.js" ></script>
<script src="js/jsl_002.js" ></script>
<script src="js/jsl_003.js" ></script>
<script src="js/jsl.js" ></script>
<link rel="stylesheet" href="/css/jquery-linedtextarea.css" type="text/css" media="screen, projection">');

if (isset($_SESSION['sid']) && $_SESSION['sid'] == 76561198013370444) {

	admin_page_display();

} else {

	echo 'Hey! you\'re not digits, get out of here!';
}

createFooter(440);
