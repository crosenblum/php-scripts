<html>
<head>
<title>DynaWebStart</title>
<head>

<link rel="icon" href="http://localhost/favicon.ico">

<style type="text/css">
* {
	padding: 0;
	margin: 0;
}

body {
	background-color:#EDEDE3;
}
/*HEADER STYLES*/

.header {
	width: 80%;
	margin: 30px auto;
	overflow: hidden;
}

.header h1 {
	font: 50px/1.0 sans-serif;
	font-weight: 400;
	text-transform: uppercase;
	margin: 0 0 15px 2%;
}

.header p {
	color: #797478;
	font: 10px/1.5 Verdana, Helvetica, sans-serif;
	margin: 0 0 0 2%;
}

/*CONTAINER STYLES*/

.container {
	width: 90%;
	margin: 5px auto;
	overflow: hidden;
}

.thumbnail {
    width: 200px;
    height: 120px;
}

/* resize images */
.thumbnail img {
    width: 100%;
    height: auto;
}

/*GALLERY STYLES*/
.galleryItem {
	color: #797478;
	font: 10px/1.5 Verdana, Helvetica, sans-serif;
	width: 16%;
	margin:  2% 2% 50px 2%;
	float: left;
	-webkit-transition: color 0.5s ease;
}

.galleryItem h3 {
	text-transform: uppercase;
	line-height: 2;
}

.galleryItem:hover {
	color: #000;
}

.galleryItem img {
	max-width: 100%;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}



/* MEDIA QUERIES*/
@media only screen and (max-width : 940px),
only screen and (max-device-width : 940px){
	.galleryItem {width: 21%;}
}

@media only screen and (max-width : 720px),
only screen and (max-device-width : 720px){
	.galleryItem {width: 29.33333%;}
	.header h1 {font-size: 40px;}
}

@media only screen and (max-width : 530px),
only screen and (max-device-width : 530px){
	.galleryItem {width: 46%;}
	.header h1 {font-size: 28px;}
}

@media only screen and (max-width : 320px),
only screen and (max-device-width : 320px){
	.galleryItem {width: 96%;}
	.galleryItem h3 {font-size: 18px;}
	.galleryItem p, .header p {font-size: 18px;}
	.header h1 {font-size: 70px;}
}
</style>



<body>

 
<div class="container">

<?php

// dynamic startpage thumbnail speeddial

ini_set('display_errors', 'On');
error_reporting(E_ALL);

// http://tecadmin.net/create-screenshots-of-websites-html-with-php-script/
function createThumb($url,$path,$filename) {

	// wkhtmltoimage command
	$command = "/usr/bin/wkhtmltoimage --no-images --load-error-handling ignore";
	 
	// execute this command string	
	$ex_cmd = "$command $url " . $filename;

	// actually execute command	 
	$output = shell_exec($ex_cmd);

}


// step 1. get list of top subdirectories
$directories = glob(getcwd() . '/*' , GLOB_ONLYDIR);

// step 2. loop thru array of subfolders
foreach($directories as $value) {

	// get just current foldername
	$newpath = pathinfo($value);
	$newvalue = $newpath['basename'];

	// show which folder I am looking at.
	// echo $newvalue.'<br/>';

	// create localhost url for this subfolder/site
	$localurl = 'http://localhost/'.$newvalue;

	// echo ' - site-url: ['.$localurl.']<br/>';

	// create thumbnail filename
	$thumb = $newvalue.'_thumb.jpg';
	$filepath = getcwd().'/'.$thumb;

	// echo ' - filepath: ['.$filepath.']<br/>';

	// get the thumbnail url
	$img_url = 'http://localhost/'.$thumb;

	// echo ' - img-url: ['.$img_url.']<br/>';

	// check if thumbnail already exists
	if (!file_exists($filepath)) {

		// create thumbnail
		createThumb($localurl,$filepath,$thumb);

	}


}

// step 3. loop through each thumb image
$dir = "/server/www/*.jpg";

//get the list of all files with .jpg extension in the directory and safe it in an array named $images
$images = glob( $dir );

//extract only the name of the file without the extension and save in an array named $find
foreach( $images as $image ) {

	// get just current foldername
	$newpath = pathinfo($image);
	$newvalue = $newpath['basename'];

	// show which folder I am looking at.
	// echo $newvalue.'<br/>';

	// extract url from filename
	$localurl = 'http://localhost'.$newvalue;

	// echo ' - site-url: ['.$localurl.']<br/>';

	// set thumbnail url
	$img_url =  'http://localhost/'.$newvalue;

	// echo ' - img-url: ['.$img_url.']<br/>';

	// start of thumbnail content
	echo '<div class="galleryItem">';

		echo '<a href="'.$localurl.'"><img src="'.$img_url.'" alt="" border=1 width=500 height=150></a><br/>';
		echo '<a href="'.$localurl.'">'.$localurl.'<br/>'.$img_url.'</a><br/>';

	echo '</div>';

	// reset variables
	$newpath = '';
	$value = '';
	$localurl = '';
	$img_url = '';

}
?>

</body>
</html>
