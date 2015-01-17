<?php
include 'php/core.php';
createHead('Tutorials', 440);
if (isset($_SESSION['sid'])) {?>
	<div class="col2 lt"><h2>Using the scanner:</h2>
		<div class="col2-content"><ol><li>Launch TF2.</li>
		<li>Enable the console:<ul>
			<li>Visit Options > Keyboard > Advanced.</li>
			<li>Click "Enable Developer Console"</li>
		</ul>
		<li>Join a server with any number of players (the more the better!)</li>
		<li>Press The button located above Tab ~ or / or whatever key you have bound to be your console key.</li>
		<li>Type in "status" then press enter/return, a list of players will appear.</li>
		<li>Copy the result, careful to include the STEAM_X.XXXXX or the U[X.XXXXX] of each user</li>
		<li>Paste the result into the scanner and press "Submit"</li>
		<li>Do with the result as you wish.</li>
	</ol>
	Tips:<br/><ul><li>Typing <b>bind L "status"</b> in your console will make the command "status" only a keystroke [L] away.</li><li>Sometimes the steamcommunity or the steam API may go down, the scanner will not be able to scan until it comes back.</li><li>Hovering over an item will show you its name, price and more!</li></ul>
	</div></div>
	<div class="col2 rt"><h2>Using Donator Features:</h2><div class="col2-content">
	<b>How to use the group scanner:</b>
	<ol>
		<li>Go to a group or steam hub's page.</li>
		<li>copy the group's URL, "http://steamcommunity.com/groups/skial"</li>
		<li>Paste it into the group scanner.</li>
		<li>The group scanner will now scan 100 players from the group.</li>
		<li>Click "scan next 100" to erase the current page and scan the next 100.</li>
	</ol><br>
	<b>How to use the database:</b>
	<ol>
		<li>Start to enter an item's name in the textbox.</li>
		<li>Select a suggested item's name from the autocomplete list that shows up.</li>
		<li>Select an item quality: Unique is what most items are (yellow border).</li>
		<li>Press "Search/Submit".</li>
	</ol><br>
	<b>How to use the Blacklist:</b>
	<ol>
		<li>Start to enter an item's name in the textbox.</li>
		<li>Select a suggested item's name from the autocomplete list that shows up.</li>
		<li>Press "Search/Submit".</li>
		<li>Select the qualities of the item you want to show or hide from the list.</li>
		<li>Press "Save".</li>
	</ol>
	</div></div>
	<div class="col2 lt"><h2>How to trade like a pro:</h2>Here are a few guides:<div class="col2-content">
		<ul>
		<li><a target=blank href="http://www.youtube.com/watch?v=zirsekLds2U">TF2: The Complete Sharking Guide | Easy Profit! (video)</a></li>
		<li><a target=blank href="http://steamcommunity.com/sharedfiles/filedetails/?id=113146337#153">How to Get Good Deals in Team Fortress 2 Trading</a></li>
		<li><a target=blank href="http://pastebin.com/DEtB1jw0">4chan /vg/ Trading Tips</a></li>
		<li><a target=blank href="http://pastebin.com/9nZR31Tn">Ancient trading guide from 2012</a></li>
		<li><a target=blank href="http://vimeo.com/49352825">Acesgamer's sharking guide</a></li> (Interesting part starts at 3:34)
		<li><a target=blank href="http://bazaar.tf/thread/299">Why you won't be banned for sharking on bazaar and backpack.tf.</a></li>
	<?php if (donator_level(20)) {echo '<li><a href=/digitsguide.php>Digits\' guide</a></li>';
	}
	?>
	</div></div>
	<div class="col2 rt"><h2>FAQ:</h2><div class="col2-content">
		<ul><li><b>How long does donator rank last?</b></li><li>It lasts forever.</li>
		<li><b>Why is it more expensive with keys than bills?</b></li><li>Bills take up less place in my backpack and are somewhat easier to sell.</li>
		<li><b>What's in the database?</b></li><li>Unusuals But I've been promising a second database of items for a while now.</li>
		<li><b>Why does the scanner say "steam api error"?</b></li><li>The Steam API is the method by which the scanner gets data about users & backpacks. If it goes down, so does scanning.</li>
	</ul></div></div>
	<?php
	if (donator_level(20)) {}
} else {
	echo '<h1>Log in to access.</h1>Seriously, this page is for users of my site only.';
}

createFooter(440);