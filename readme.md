This is a readme for TF2Endgame Version 4.
This, and all previous versions of TF2Endgame were created by Digits.
TF2Endgame Version 4 requires multiple php extensions to work including json, bcmath, mongo.

Any file in the php folder is not meant to be viewable by the public, all files in that folder are code.
'core' files mean that they have functions required on user-viewable pages. They are included from those files.
Whenever a set of functions are used on one page but not the others, a new core file is created for the view file.
If you adopt this site, you will need to change line 99 of db\_core.php from  "$usr = legacy_getUserData( $sid );" to "$usr = false;".
