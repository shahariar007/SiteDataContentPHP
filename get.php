<?php

include_once('simple_html_dom.php');
require('book.php');

// Create DOM from URL or file
$opts = [
        'http' => [
                'method' => 'GET',
                'header' => [
                        'User-Agent: HTML'
                ]
        ]
];
$get_url=$_GET["url"];
$get_country=$_GET["country"];
$get_district=$_GET["district"];
$context = stream_context_create($opts);
$html = file_get_html($get_url,false,$context);
//echo "Connected successfully";
$details=array();
$image=array();
$tab=array();
$title;
foreach ( $html->find('h2[class="title-post"] a') as $element) {
          if($element->tag=='a')
          {
           $title=strip_tags($element->href);
           
         $classBox= new Book();
         $classBox->setPrice($title,$get_country,$get_district);
			}
		}
?>