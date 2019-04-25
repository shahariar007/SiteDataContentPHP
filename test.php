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

$context = stream_context_create($opts);
$html = file_get_html('https://adarbepari.com/tikoil-alpona-village-chapainawabganj',false,$context);

// $html = file_get_html('https://ruchiexplorelimitless.com/bn/%E0%A6%B8%E0%A6%BE%E0%A6%87%E0%A6%95%E0%A7%87%E0%A6%B2%E0%A7%87%E0%A6%B0-%E0%A6%B8%E0%A6%BE%E0%A6%A5%E0%A7%87%E0%A6%87-%E0%A6%A5%E0%A6%BE%E0%A6%95%E0%A6%A4%E0%A7%87-%E0%A6%B9%E0%A6%AC%E0%A7%87/');

//var_dump($f);
//$html->clear();
//unset($html);
// foreach ( $html->find('div[class=entry-content] p ') as $element) {

//           echo ($element->innertext);
//           echo "<br>";
//           echo "<br>";

        
// }
// foreach ( $html->find('div[class="entry-content"] p') as $element) {
          
//           echo ($element);
//           echo "<br>";
//           echo "<br>";

        
// }
// TODO find image
// foreach ( $html->find('figure[class="aligncenter"] img') as $element) {
          
//           //echo ($element->dump());
//           echo ($element->src);
//           echo "<br>";
//           echo "<br>";

        
// }
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
$title;
foreach ( $html->find('div[class="entry-content"] p,div[class="item"] img,figure[class="aligncenter"] img,h1,header[class="entry-title"] h2,div[class="entry-content"] h3,div[class="entry-content"] h4, div[class="entry-content"] table[class="wp-block-table"]') as $element) {
          if($element->tag=='h1')
          {
           $title=$element->innertext;
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
         	
        foreach ($element->find('td') as $row) {
        	echo $row->innertext. '<br>';

        	 foreach ($row->find('tr') as $rows) {
        	echo $rows->innertext. '<br>';
        }
        }
         }
         echo $element->tag . '<br>' ;

         
}
die();
//print_r($details);die();

//$c=implode('|',$details);
$c=json_encode($details,JSON_UNESCAPED_UNICODE);
// echo $c;
// echo "-----------------------------------------------";
// echo implode('|',unserialize($c));
//die();
//$img=implode('|',$image);
$img=json_encode($image);
// $sql = "INSERT INTO posts (post_title, post_details, post_map,post_image,country_id,district_id)
// VALUES ('"$title"','"$details"', 'post_map','"$post_image"',1001,1002)";
$sql = "INSERT INTO posts (id,post_title, post_details, post_map,post_image,country_id,district_id)
VALUES ('','$title','$c', 'post_map','$img',1001,1002)";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>