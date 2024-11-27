<?php
set_time_limit(0);
require("config.php");
$pwd = '';
$root_project_dir = '';
$revision = "Revision 6.4 ~ 27th November 2024";

error_reporting(0); //Disabled for keeping console clean. Set to 1 if you got an error or problem while downloading :)
echo "THINKIFIC DOWNLOADER".PHP_EOL.$revision.PHP_EOL."Author : SumeetWeb ~ https://github.com/sumeetweb".PHP_EOL."Consider buying me a coffee at : https://www.ko-fi.com/sumeet".PHP_EOL."Want to download only selected videos? Thinki-Parser is available! : https://sumeetweb.github.io/Thinki-Parser/".PHP_EOL;
echo "----------------------------------------------------------".PHP_EOL;
require("include/file.functions.php");
require("include/downloader.functions.php");
require("include/wistia.downloader.php");

// Run.
// If --json, then read from json file.
// Else, download from url.
if(in_array("--json", $argv) && isset($argv[2])) {
	$json = file_get_contents($argv[2]);
	$data = json_decode($json, true);
	$contentsdata = $data["contents"];
	init_course($data);
} else if(isset($argv[1])) {
	$url = query($argv[1]);
	$p = parse_url($argv[1]);
	$path = $p;
	$path = explode("/", $path["path"]); 
	file_put_contents(end($path).".json",$url); //save coursename.json
	$data = json_decode($url,true);
	$contentsdata = $data["contents"];
	if(isset($data["error"]))
		die($data["error"].PHP_EOL);
	else
		echo "Fetching Course Contents... Please Wait...".PHP_EOL;
	init_course($data);
} else {
	echo "Usage for using course url: php thinkidownloader3.php <course_url>".PHP_EOL;
	echo "Usage for selective download: php thinkidownloader3.php --json <course.json>".PHP_EOL;
}
?>
