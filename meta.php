<?php
include 'php/core.php';
createHead('Metadata', 440);

echo '<div class="lt col2">';
echo '<ul>';
echo '<li><span class="lt">Price list last updated:</span><span class="rt">' . date('M d, Y', db_load('440_pricelist_v4_time')) . '</span></li>';
echo '<li><span class="lt">Schema (itemlist) last updated:</span><span class="rt">' . date('M d, Y', db_load('440_schema_time')) . '</span></li>';
echo '<li><span class="lt">Paint bucket images last updated:</span><span class="rt">' . date('M d, Y', db_load('440_paint_time')) . '</span></li>';
echo '<li><span class="lt">Game list last updated:</span><span class="rt">' . date('M d, Y', db_load('753_list_time')) . '</span></li>';
//echo '<li><span class="lt">Old-ass pricelist I don\'t even use anymore last updated:</span><span class="rt">' . date('M d, Y', db_load('440_pricelist_v2_time')) . '</span></li>';
echo '</ul>';
echo '</div>';

createFooter(440);