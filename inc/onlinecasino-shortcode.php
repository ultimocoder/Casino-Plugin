<div class="container">
<h3 style="text-align:center;marging:20px;">Casino List shortcode</h3>
1. Add shortcode on your pages : [onlinecasinoshortcode region="NY" limit="10"]
<br>
   a. Region : NY or NJ
   <br>
   b. limit data : 10 
   <br>
   c. By default limit = 10;
   <br>
2. Use shortcode [onlinecasinoshortcode]
<br>
   if region is NY or NJ , then region autoselect by ipaddress using this shortcode .
</div>
<br>
<br>
<br>
<br>

<?php
$userIpAddress = $_SERVER['REMOTE_ADDR'];
// Make a request to ipinfo.io to get country and state information
$url = "https://ipinfo.io/{$userIpAddress}/json";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$decode = json_decode($response);

if(isset($decode->region) && isset($decode->country)){
    $state = $decode->region;
    $country = $decode->country;
	
    echo "<br>Your Current IP address detail <br><br>";
   
    if(isset($decode->ip)){
      echo " <b>IP</b> : $decode->ip <br>";
    }
    if(isset($decode->city)){
      echo " <b>city</b> : $decode->city <br>";
    }
    if(isset($decode->region)){
      echo " <b>region</b> : $decode->region <br>";
    }
    if(isset($decode->country)){
      echo " <b>country</b> : $decode->country <br>";
    }

}

?>
