<?php

require('simple_html_dom.php');

// Create DOM from URL or file
$opts = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: PHP'
                ]
        ]
];
$get_url=$_GET["url"];
$get_country=$_GET["country"];
$get_district=$_GET["district"];
$context = stream_context_create($opts);
$html = file_get_html($get_url,false,$context);

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password,"travel_tracker");
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
$details=array();
$image=array();
$tab=array();
$title;
foreach ( $html->find('div[class="entry-content"] p,div[class="item"] img,figure[class="aligncenter"] img,h1,header[class="entry-title"] h2,div[class="entry-content"] h3,div[class="entry-content"] h4, div[class="entry-content"] table[class="wp-block-table"],div[class="location"] a') as $element) {
          if($element->tag=='h1')
          {
           $title=$element->innertext;
          }
          if($element->tag=='a')
          {
			$title.= " -> ".$element->innertext;
      
          }
         if($element->tag=='p'|| $element->tag=='h2' || $element->tag=='h3' || $element->tag=='h4' )
         {
         	 $f=strip_tags($element->innertext);
         	array_push($details,$f);
         	//echo $element;
         }else if($element->tag== 'img')
         {
         	array_push($image,$element->src);
         // echo ($element->src);
         }
         else if($element->tag== 'table')
         {
         	
        foreach ($element->find('tr') as $row) {
        	 $go="tbl ";
             foreach ($row->find('td') as $rows) {
        	$go.=strip_tags($rows->innertext).'|';
        	}
        	$go.="||";
        	array_push($details,$go);
       	 }
         }


         
}
//print_r($details);die();

//$c=implode('|',$details);
// $c=json_encode($details,JSON_UNESCAPED_UNICODE);
$c=serialize($details);
// echo $c;
// echo "-----------------------------------------------";
// echo implode('|',unserialize($c));
//die();
//$img=implode('|',$image);
$img=serialize($image);
// $sql = "INSERT INTO posts (post_title, post_details, post_map,post_image,country_id,district_id)
// VALUES ('"$title"','"$details"', 'post_map','"$post_image"',1001,1002)";
$sql = "INSERT INTO posts (id,post_title, post_details, post_map,post_image,country_id,district_id)
VALUES ('','$title','$c', 'post_map','$img',$get_country,$get_district)";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>