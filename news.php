<html>
<head>
<style type="text/css">
img{
	width:252px;
	display:inline-block;
}

.vid_layout
{
	position: absolute;
	width:768;
	height:228;
	background-color:#F00;
	margin-top:0px;
	display:block;
	top:0px;
	left:0px;
}

.item{
 display:inline-block;
 float:left;
 height:196px;
 width:372px;
 padding:5px;
 background-color:#FFF;
}

.item_right{
 display:inline-block;
 float:right;
  width:372px;
 height:196px;
  padding:5px;
  background-color:#FFF;
}
.title_style{
text-align:center;
}

.desc{
margin-left:10px;
}

.heading {
background-color:#F00;
top:0px;
padding:0px;
margin-top:0px;
margin-bottom:0px;
padding:0px;
padding-bottom:0px;
width:768px;
}
.heading h3{
margin-bottom:0px;
margin-top:0px;
text-align:center;
color:#FFF;
}

.link{
margin-left:10px;
}

</style>
</head>
<body>
<div class="vid_layout">
<div class="heading"><h3>Cinequest Film Festival News</h3></div>
<?php
$html="";
$xml=@simplexml_load_file("news.xml");
$count=0;
foreach($xml->item as $item)
{
	$count++;
	$title_link=$item->title;
	$title='<h3>'.$title_link.'</h3>';
	$description=$item->description;
	$nav_link=$item->nav;
	$link='Learn More >>';
	$nav='<a href="'.$nav_link.'">'.$link.'</a>';
	if($count==2)
	{
		$html .='<div class="item_right">'.'<div class="title_style">'.$title.'</div>'.'<p class="desc">'.$description.'</p>'.'<div class="link">'.$nav.'</div>'.'</div>';
		break;
	}
	else
	{
	$html .='<div class="item">'.'<div class="title_style">'.$title.'</div>'.'<p class="desc">'.$description.'</p>'.'<div class="link">'.$nav.'</div>'.'</div>';
	}
	
}

echo $html.'<br>';
?>
</div>
</body>
</html>