<?php
if(isset($_GET['id'])){
  if(preg_match('/\d+/',$_GET['id'])){
    $id = $_GET['id'];
  }
}

if($id !== null){
    $query = 'select * from flickr.photos.info where '.
             'photo_id = "'.$id.'"';
    $api = 'http://query.yahooapis.com/v1/public/yql?q='.
            urlencode($query).'&format=json';
           
            
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($output);
    $p = $data->query->results->photo;    

    $img = '<p><a href="'.$p->urls->url->content.
           '"><img src="http://static.flickr.com/'.$p->server.
           '/'.$p->id.'_'.$p->secret.'.jpg" alt="'.
           $p->title.' by '.$p->owner->username.'" /></a></p>';
    $extras = '<p>'.$p->description.'</p><p>by '.
              '<a href="http://www.flickr.com/people/'.$p->owner->username.
              '">'.$p->owner->username.'</a></p>';
    echo '<h1>'.$p->title.' ('.$p->tags->tag->raw.')</h1><div class="details">'.$img.'</div>';
    
    $car = $p->title;
    $car = $car = str_replace(' ','_',$car);
      
  }
 ?>