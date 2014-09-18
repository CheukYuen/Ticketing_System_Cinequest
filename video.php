<html>
<head>
<link rel="stylesheet" type="text/css" href="theme.css">
<link rel="stylesheet" type="text/css" href="css/video.css">
<style type="text/css">
img{
	width:282px;
	height:154px;
	display:inline-block;
}

#cqff{
width:200px;
display:inline-block;
margin-left:2px;
height:228px;
}

.second{
width:292px;
float:right;
margin-top:0px;
display:inline-block;
}

.vid_layout
{
	position: absolute;
	width:768;
	height:228;
	background-color:#FFF;
	margin-top:0px;
	display:block;
	top:0px;
	left:0px;
}

.heading {
background-color:#F00;
top:0px;
padding:0px;
margin-top:0px;
margin-bottom:0px;
padding:0px;
padding-bottom:0px;
width: 768px;
}

.heading h3{
margin-bottom:0px;
margin-top:0px;
text-align:center;
color:#FFF;
}
 
.item{
 display:inline-block;
 float:left;
 height:218px;
}

.item_right{
 display:inline-block;
 float:right;
 height:218px;
}

.title_style{
 text-align:center;
 margin-bottom:50px;
}

#cqff div{
	padding: 5 5 5 5;
}
</style>
</head>
<body>
<div class="vid_layout">
<div class="heading"><h3>Cinequest Film Festival Videos</h3></div>
<?php
$cqff='<div id="cqff"><div><h3 style="text-align:center;">Cinequest Videos</h3><p style="text-align:center;"><b>Check back often to watch new videos from Cinequest. </b><br><br>Tap on the image to play the video.</p></div></div>';
$html="";
$xml=@simplexml_load_file("video.xml");
$count=0;
foreach($xml->item as $item)
{
	$count++;
	$name=$item->name;
	$id=$item->id;
	$title_link=$item->title;
	$title='<h3>'.$title_link.'</h3>';
	$image_link=$item->image;
	$image='<img class="img" src="'.$image_link.'"/>'.'<br>';
	$nav=$item->nav;
	
	
	$image_click='<a href="'.$nav.'">'.$image.'</a>';
	
	if($count==2)
	{
		$html .='<div class="item_right">'.$image_click.'<div class="title_style">'.$title.'</div>'.'</div>';
		break;
	}
	else
	{
	$html .='<div class="item">'.$image_click.'<div class="title_style">'.$title.'</div>'.'</div>';
	echo $cqff;
	}
	
}

echo $html.'<br>';
?>
</div>
</body>
</html>