<?php
require 'php/scan_core.php';
require 'php/settings_core.php';
createHead('preferences', 440, '<script  src="js/jscolor.js"></script>');

echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
echo '<h1>Preferences</h1>';

if (isset($_POST['Update'])) {
	preference_update();
	sleep(0.5);
}
if (isset($_POST['Delete'])) {
	preference_delete();
	sleep(0.5);
}

/*
Items worth less than x 			√
Maximum Hours on a user 			√
Hide users with worthless Backpacks √
Hide F2P 							√
Hide players offline for X time 	x
Hide users not playing TF2 			x
Backpack viewer 1 and 2 			√
Item warnings 						√

 */

if (isset($_SESSION['sid'])) {
	preference_get();
}

echo '<div class="col2 lt">';
echo '<h2>Normal Scanner Options:</h2>';

echo 'Hide items worth less than <input type="text" class="ddinput" name="numeric[ss][threshold]" value="' . ((isset($_SESSION['pref']['numeric']['ss']['threshold'])) ? $_SESSION['pref']['numeric']['ss']['threshold'] : 1) . '"> refined.<br><br>';
echo 'Hide users with more than <input type="text" class="ddinput" name="numeric[ss][maxhours]" value="' . ((isset($_SESSION['pref']['numeric']['ss']['maxhours'])) ? $_SESSION['pref']['numeric']['ss']['maxhours'] : 99999) . '"> hours played.<br><br>';

echo 'Show users with private/empty/worthless backpacks?  ';
echo '<select name="numeric[ss][worthless]">' .
'<option value = "1"' . ((!isset($_SESSION['pref']['numeric']['ss']['worthless']) || $_SESSION['pref']['numeric']['ss']['worthless'] == 1) ? ' selected="selected"' : '') . '>Yes</option>' .
'<option value = "0"' . ((isset($_SESSION['pref']['numeric']['ss']['worthless']) && $_SESSION['pref']['numeric']['ss']['worthless'] == 0) ? ' selected="selected"' : '') . '>No</option></select><br><br>';

echo 'Show users who are Free To Play ( <div class="lk f2p"></div> ) ';
echo '<select name="numeric[ss][f2p]">' .
'<option value = "1"' . ((!isset($_SESSION['pref']['numeric']['ss']['f2p']) || $_SESSION['pref']['numeric']['ss']['f2p'] == 1) ? ' selected="selected"' : '') . '>Yes</option>' .
'<option value= "0"' . ((isset($_SESSION['pref']['numeric']['ss']['f2p']) && $_SESSION['pref']['numeric']['ss']['f2p'] == 0) ? ' selected="selected"' : '') . '>No</option></select><br><br>';

echo '</div>';//end pref-left

echo '<div class="col2 rt">';
echo '<h2>Group/Friend Scanner Options:</h2>';

echo 'Hide users with no items worth more than <input type="text" class="ddinput" name="numeric[gs][threshold]" value="' . ((isset($_SESSION['pref']['numeric']['gs']['threshold'])) ? $_SESSION['pref']['numeric']['gs']['threshold'] : 1) . '"> refined.<br><br>';

echo 'Hide users with more than <input type="text" class="ddinput" name="numeric[gs][maxhours]" value="' . ((isset($_SESSION['pref']['numeric']['gs']['maxhours'])) ? $_SESSION['pref']['numeric']['gs']['maxhours'] : 99999) . '"> hours played.<br><br>';

echo 'Show users with private/empty/worthless backpacks?  ';
echo '<select name="numeric[gs][worthless]">' .
'<option value = "1"' . ((!isset($_SESSION['pref']['numeric']['gs']['worthless']) || $_SESSION['pref']['numeric']['gs']['worthless'] == 1) ? ' selected="selected"' : '') . '>Yes</option>' .
'<option value = "0"' . ((isset($_SESSION['pref']['numeric']['gs']['worthless']) && $_SESSION['pref']['numeric']['gs']['worthless'] == 0) ? ' selected="selected"' : '') . '>No</option></select><br><br>';

echo 'Show users who are Free To Play ( <div class="lk f2p"></div> ) ';
echo '<select name="numeric[gs][f2p]">' .
'<option value = "1"' . ((!isset($_SESSION['pref']['numeric']['gs']['f2p']) || $_SESSION['pref']['numeric']['gs']['f2p'] == 1) ? ' selected="selected"' : '') . '>Yes</option>' .
'<option value= "0"' . ((isset($_SESSION['pref']['numeric']['gs']['f2p']) && $_SESSION['pref']['numeric']['gs']['f2p'] == 0) ? ' selected="selected"' : '') . '>No</option></select><br><br>';

echo 'Hide users who have been offline for more than <input type="text" name="numeric[gs][timeaway]" class="ddinput" value="' . ((isset($_SESSION['pref']['numeric']['gs']['timeaway'])) ? $_SESSION['pref']['numeric']['gs']['timeaway'] : '1209600') . '">' .
'<select name="numeric[timeValue]">' .
'<option value = "1">seconds</option>' .
'<option value= "60">minutes</option>' .
'<option value= "3600">hours</option>' .
'<option value= "86400">days</option>' .
'<option value= "604800">weeks</option>' .
'<option value= "2629743">months</option>' .
'<option value= "31556926">years</option>' .
'</select><br>Entering 0 will hide ALL users who are currently offline.<br><br>';

echo 'hide users who are not playing TF2 right now ';
echo '<select name="numeric[gs][hidenotplaying]">' .
'<option value="0"' . ((!isset($_SESSION['pref']['numeric']['gs']['hidenotplaying']) || $_SESSION['pref']['numeric']['gs']['hidenotplaying'] == 0) ? ' selected="selected"' : '') . '>No</option>' .
'<option value="1"' . ((isset($_SESSION['pref']['numeric']['gs']['hidenotplaying']) && $_SESSION['pref']['numeric']['gs']['hidenotplaying'] == 1) ? ' selected="selected"' : '') . '>Yes</option></select><br>';

echo '</div>';//end pref-right

echo '<div class="col2 lt">';
echo '<h2 class="cf">Other Options</h2>';
$viewers = array(1 => 'TF2B', 2 => 'Backpack.TF', 3 => 'TF2EG ripoff viewer', 4 => 'Bazaar', 5 => 'TF2Outpost', 6 => 'TF2Items');

echo 'Backpack <img src ="img/BPIcon.png" alt="Viewer" height="16" width="16"> 1: ' .
'<select name="numeric[bp][1]">';
foreach ($viewers as $key => $val) {
	echo '<option value="' . $key . '"';
	if (isset($_SESSION['pref']['numeric']['bp'][1]) && $_SESSION['pref']['numeric']['bp'][1] === $key) {
		echo ' selected="selected"';
	}

	echo '>' . $val . '</option>';
}
echo '</select><br>';
echo 'Backpack <img src ="img/BPIcon.png" alt="Viewer" height="16" width="16"> 2: ' .
'<select name="numeric[bp][2]">';
foreach ($viewers as $key => $val) {
	echo '<option value="' . $key . '"';
	if (isset($_SESSION['pref']['numeric']['bp'][2]) && $_SESSION['pref']['numeric']['bp'][2] === $key) {
		echo ' selected="selected"';
	}

	echo '>' . $val . '</option>';
}
echo '</select><br><br>';

//echo 'clicking an item will copy the following to your clipboard:<br><input type="text" style="width: 304px;" name="string[itemnote]" value="Would you be willing to trade your ##itemname##?"><br><br>';

echo 'Show warnings for hard-to-trade-for items: ';
echo '<select name="numeric[warn]">' .
'<option value="1"' . ((!isset($_SESSION['pref']['numeric']['warn']) || $_SESSION['pref']['numeric']['warn'] == 1) ? ' selected="selected"' : '') . '>On</option>' .
'<option value="0"' . ((isset($_SESSION['pref']['numeric']['warn']) && $_SESSION['pref']['numeric']['warn'] == 0) ? ' selected="selected"' : '') . '>Off</option></select><br>';

echo '<img src="/img/w3.png">Traded for/painted/named/described/gifted.<br><img src="/img/w2.png">Equipped.';

echo '</div>';

echo '<div class="col2 rt">';

$quality_colours = quality_colours_prefs(1);

echo '<h2 class="cf">Colour settings</h2>';
echo 'These colour settings will be used in all scans.<br>Colours can be reset to their original values with the "Delete Preferences" button.';

echo '<table class="preftable"><tr><th>quality</th><th>colour</th><th>border</th></tr>';
$x            = 0;
$qualityNames = json_decode(file_get_contents(json_directory() . '/qualities.json'), true);

foreach ($quality_colours as $colour => $value) {
	$name = $qualityNames[$x]['display_name'];
	echo '<tr><td>' . $name . '</td><td><input class="color" name="css[' . $colour . '][bg]" maxlength="6" size="6" value="' . ((isset($_SESSION['pref']['css'][$colour]['bg'])) ? $_SESSION['pref']['css'][$colour]['bg'] : $quality_colours[$colour]['bg']) . '"/></td><td>' .
	'<input type="text" class="color" name="css[' . $colour . '][border]" maxlength="6" size="6" value="' . ((isset($_SESSION['pref']['css'][$colour]['border'])) ? $_SESSION['pref']['css'][$colour]['border'] : $quality_colours[$colour]['border']) . '"/></td></tr>';
	$x++;

}
echo '</table>';

echo '</div>';

echo '<div class="col2 lt"><h2 class="cf">Update/Delete</h2><input name="Update" value="Update Preferences" type="submit"><input name="Delete" value="Delete Preferences" type="submit"></form><br></div>';
createFooter(440);
