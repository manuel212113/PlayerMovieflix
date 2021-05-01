<?php
error_reporting(0);
include "drive.php";
$id = $_GET['id'];
$URL = "https://drive.google.com/file/d/".$id."/view?pli=1";
$linkdown = Drive($URL);
	$URL = "https://drive.google.com/get_video_info?docid=$id";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_URL, $URL);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$response_data = urldecode(urldecode(curl_exec($curl)));
	curl_close($curl);									
	
	//status
	$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http";
	$shot = "https://drive.google.com/vt?".$_SERVER["QUERY_STRING"];
	$sharing = $protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	if(preg_match("/errorcode=100/", $response_data) && strlen($_SERVER["QUERY_STRING"])!= "28"){
		$title = "Masukkan kode identifikasi video yang benar.";
	} elseif(preg_match("/errorcode=100/", $response_data)) {
		$title = "Anda tidak memiliki akses ke video";
	} elseif(preg_match("/errorcode=150/", $response_data)) {
		$title = "Anda tidak memiliki izin untuk mengakses video ini.";
	} else {
		$title = preg_replace("/&BASE_URL.*/", Null, preg_replace("/.*title=/", Null, $response_data));
	}

$file = '"'.$linkdown.'"';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="videojs/video-js.css" rel="stylesheet">
<script src="videojs/video.js"></script>
</head>

<body>
  <video id="video-player" class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9"   controls preload="auto" width="640" height="264"
  poster="<?php echo $shot;?>" data-setup="{}">
    <source src=<?php echo $file?> type='video/mp4'>
    <p class="vjs-no-js">
      WG Tutoriales Canal Youtube
      <a href="http://videojs.com/html5-video-support/" target="_blank">Soporte: https://www.youtube.com/channel/UCL6NakGHDMpo23wBmj9Iduw</a>
    </p>
  </video>

</body>
</html>