<?php

// require 'instagram.class.php';

// initialize class
// $instagram = new Instagram(array(
//   'apiKey'      => '0b756f5e50e7487aa0dc0d8969f906c0',
//   'apiSecret'   => 'efd347421a2f4233ae6e6017043ceed4',
//   'redirect_uri' => 'http://victoriapavlova.com'
// ));

$client_id = "0b756f5e50e7487aa0dc0d8969f906c0";

$access_token = "3749057.0b756f5.5973fb3046154685abbdabac4e0dfc6c";
// $instagram->setAccessToken($access_token);

$id = "3749057";

$tag = 'priveporter';

 // $likes = $instagram->getUserLikes();

// $media = $instagram->getTagMedia($tag);


 // Set number of photos to show
    $limit = 100;

    // Set height and width for photos
    $size = '100';

// $api = "https://api.instagram.com/v1/tags/snow/media/recent?client_id=".$client_id;
   // $api = "https://api.instagram.com/v1/users/{$id}/media/recent/?access_token={$access_token}";
   $api = "https://api.instagram.com/v1/tags/{$tag}/media/recent?access_token={$access_token}";
$api2 = "https://api.instagram.com/v1/tags/{$tag}?access_token={$access_token}";
$response2 = get_curl($api2);
var_dump(json_decode($response2));

$output = "";

function get_curl($url) {
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $output;
    } else{
        return file_get_contents($url);
    }
}
$counter = 0;

while (($api !== NULL) && ($counter < 50)) {
    $response = get_curl($api);
    // var_dump(json_decode($response)->meta);
    foreach(json_decode($response)->data as $item){
        $src = $item->images->standard_resolution->url;
        $thumb = $item->images->thumbnail->url;
        $url = $item->link;
        $user_liked = $item->user_has_liked;

        // $images[] = array(
	       //  "src" => htmlspecialchars($src),
	       //  "thumb" => htmlspecialchars($thumb),
	       //  "url" => htmlspecialchars($url)
        // );
        if ($user_liked) {

    		$output .= "<a href=\"{$url}\" class=\"photo\"><img src=\"{$thumb}\" width=\"200\" height=\"200\"></a>";
    	}
    }
    $counter++;
    $api = json_decode($response)->pagination->next_url;
}


?>
<!doctype html>
<html>
<head>
	<title>InstaTry</title>
	<style>
		.photos {
			overflow: hidden;
			margin: 20px 0;
		}

		.photo {
			float: left;
			margin-right: 20px;
		}
	</style>
</head>
<body>
	<h1 class="p-title">It works!</h1>
	<?php
	   echo $output;
	 ?>
</body>
</html>