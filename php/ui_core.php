<?php
function createHead($title, $gid = 440, $includes = '') {
	if (donator_level(20)) {
		$donor = true;
	} else {
		$donor = false;
	}

	header('Access-Control-Allow-Origin: http://endgame.tf');
	$banners = array(
		440 => array('bnr' => '/440.gif', 'alt' => 'Team Fortress 2 Endgame', 'icn' => 't.gif'),
		730 => array('bnr' => '/730.gif', 'alt' => 'Counter-Strike Endgame', 'icn' => 's.gif'),
		570 => array('bnr' => '/570.gif', 'alt' => 'Dota 2 Endgame', 'icn' => 'd.gif'),
		620 => array('bnr' => '/620.gif', 'alt' => 'Portal 2 Endgame', 'icn' => 's.gif'),
	);
	?>
<!DOCTYPE HTML><html lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="The best free TF2/CSGO server scanner. Scan groups, friend lists with donator features including powerful user preference settings." />
<meta name="keywords" content="scanner, sharking, playtime, trading, jewing, team fortress 2, tf2, teamfortress, csgo, cs:go, Counter-Strike, Dota2, Dota" />
<link href=img/icn/<?php echo $banners[$gid]['icn']?> rel=icon>
<title><?php echo $title?></title>
<link href="css/tf2egv3.css" rel="stylesheet" type="text/css">
<link href="css/csgoeg.css" rel="stylesheet" type="text/css">
<link href="css/stylesheet.php" rel="stylesheet" type="text/css">
<script src="js/jquery.js" ></script>
<script src="js/stupidtable.min.js" ></script>
<?php echo $includes?>
</head><body class="a<?php echo $gid;?>">
<div class="top-holder">
<div class="color-top b<?php echo $gid?>"></div>
<?php echo '<div id="bnr-txt">', $banners[$gid]['alt'], '</div><img src="img/bnr/', $banners[$gid]['bnr'], '" alt="', $banners[$gid]['alt'], ' banner">'?>
<div class="b<?php echo $gid;?>" id="nav">
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="#">Scanning</a>
<ul>
<li><a href="440_scan.php">TF2 Scanner</a></li>
<?php echo ($donor == true) ? '<li><a href="440_group.php">TF2 Multi</a></li>' : ''?>
<li><a href="730_scan.php">CS:GO Scanner</a></li>
<?php echo ($donor == true) ? '<li><a href="730_group.php">CS:GO Multi</a></li>' : ''?>
<?php echo ($donor == true) ? '<li><a href="db.php">Databases</a></li>' : ''?>
<li class="listend b<?php echo $gid?>"></li>
</ul>
</li>
<?php
echo '<li>Help<ul><li><a href=/tutorials.php>Tutorials</a></li> ' .
	((isset($_SESSION['sid'])) ? '<li><a href=/bug.php>Bug report/contact</a></li>' : '') .
	'<li><a href=/donate.php>Donate</a></li>' .
	'<li><a href=/meta.php>Meta</a></li>' .
	'<li class="listend b', $gid, '"></li></ul></li>';

	if (isset($_SESSION['sid'])) {

		echo '<li><a href="profile.php">' . ((isset($_SESSION['currentUserName'])) ? substr(ucfirst(htmlentities($_SESSION['currentUserName'])), 0, 10) : 'user') . '</a><ul>';
		if ($_SESSION['sid'] == 76561198013370444) {
			echo '<li><a href="admin.php">Admin</a></li>';
		}
		echo
		(($donor == true) ? '<li><a href="settings.php">Settings</a></li><li><a href="whitelist.php">Hide/Show items</a></li><li><a href="dblist.php">My reserved users</a></li>' : ''),
		'<li>' . LoginButton() . '</li>',
		'<li class="listend b', $gid, '"></li>',
		'</ul></li>';
	} else {
		echo '<li>' . LoginButton() . '</li>';
	}

	echo '</ul></div></div><div id="content" class="cf">';
}

function login_or_donator() {
	if (isset($_SESSION['sid'])) {
		echo '<h1 class="ct login_notice">This page is donator-only.</h1>';
	} else {
		echo '<h1 class="ct login_notice">Please login to use this page.</h1>';
	}
}

function mem_use_format($size) {
	$unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
	return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

function createFooter($gid = 440) {
	echo '</div><footer class="b', $gid, '">Made by <a href="http://steamcommunity.com/profiles/76561198013370444">Digits - ' . date('Y') . '</a><br>',
	'<a target=blank href=/bug.php>Contact / Report A Bug</a><br>',
	'Page used ', mem_use_format(memory_get_usage(true)), '.<br>',
	'<a href="http://steampowered.com/">powered by Steam</a><br>',
	'<a href="http://steamcommunity.com/groups/TF2endgame">Steam Group</a>',
	'</footer></body></html>';
}

//cursor: url('https://31.media.tumblr.com/tumblr_mdhwb5CxPW1qg3bod.png'), auto;
