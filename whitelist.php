<?php
//this page's purpose is to provide a list where users will be able to contribute item defindexes to have the items whitelisted.
//this whitelist will be used in all parts of the scanner where no prices are available.
//this will allow users to set prices for as-of-yet unpriced items so that the stupid responsibility of doing so will not be exclusively on my shoulders.

include 'php/440_core.php';
include 'php/global_whitelist_core.php';
createHead('Price items!', 440, '<script src="js/as-compiled.js" ></script><link rel="stylesheet" href="css/autoSuggest.css" type="text/css" media="screen">');

echo '<div class="news">This is a page where you can vote on what items you want to see on the scanner.<br>By voting on items, you will change their prices which will make them appear in scans.</div>';

if (isset($_POST['save'])) {

	bwlist_save($_POST);

}
if (isset($_POST['delete'])) {
	bwlist_delete();
}

echo ' <form action="' . $_SERVER['PHP_SELF'] . '" method="POST">',
'<input type="text" id=as-input class=as-input autocomplete=off data-autocompleteurl=php/autocomplete.php>',
'<input type="submit"></form><br><br>',

bwlist_display();

item_display(reset($_POST));

createFooter();
