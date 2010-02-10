<?php
$start = 0;
$amount = 20;

if(isset($_GET['start'])){
    $start = intval($_GET['start']);
}            
$cururl = 'index.html';

$query = 'select * from flickr.photosets.photos(0) where photoset_id=72157623221277129';
$api = 'http://query.yahooapis.com/v1/public/yql?q='.
            urlencode($query).'&format=json';

            
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$data = json_decode($output);
 
$photos = $data->query->results->photo;
if(sizeof($photos)>0){
    echo '<ul>';
    
    $i = 1;
    foreach($photos as $p){
        echo '<li><a href="'.$cururl.'?id='.$p->id.
             '"><img src="http://static.flickr.com/'.$p->server.
             '/'.$p->id.'_'.$p->secret.'_s.jpg" '.
             'width="75" height="75" alt="'.
             $p->title.'" /></a><p>'.
             $p->title.'</p></li>';
             $i++;
             
        
             
    }
    echo '</ul>';
}
?>