<?php
$root = 'http://query.yahooapis.com/v1/public/yql?q=';

$yql = 'select * from html where url = \'http://de.wikipedia.org/wiki/'.$car.'\' and xpath="//div[@id=\'bodyContent\']/p" limit 3';
$url = $root . urlencode($yql) . '&format=xml';

$info = getstuff($url);


$info = preg_replace("/.*<results>|<\/results>.*/",'',$info);
$info = preg_replace("/<\?xml version=\"1\.0\"".
                  " encoding=\"UTF-8\"\?>/",'',$info);
$info = preg_replace("//",'',$info);
$info = preg_replace("/\"\/wiki/",'"http://de.wikipedia.org/wiki',$info);

echo $info;
echo "<a class=\"wiki_link\" href=\"http://de.wikipedia.org/wiki/".$car."\">".$car." @ Wikipedia</a>";

//echo urldecode($url);

function getstuff($url){
  $curl_handle = curl_init();
  curl_setopt($curl_handle, CURLOPT_URL, $url);
  curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
  curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
  
  $buffer = curl_exec($curl_handle);
  $curl_info = curl_getinfo($curl_handle);
  
  print_r(curl_error($curl_handle));
  curl_close($curl_handle);
  
  $xml = simplexml_load_file($url);
  $status_code = $xml->diagnostics->url['http-status-code'];  
  
  if ($status_code == ''){
    return $buffer;
  } else {
    return 'Error retrieving data, please try later.';
  }
}

?>