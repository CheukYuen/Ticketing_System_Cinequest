		<?php			
			
			// Load XMLFiles in PHP variables
			$rss_images=simplexml_load_file("images_feed.xml");
			//$rss_images=simplexml_load_file("http://www.cinequest.org/gallery/rss_feed");

			
			// Start a new list to print the TRENDING EVENTS
			
			foreach ($rss_images->channel->item as $show):
				
				//$title = $show->title;
				$link = $show->link;
				$description = $show->description;
				
				$desc_replace_01 = str_replace("<div class=\"field field-name-field-gallery-images field-type-image field-label-hidden\"><div class=\"field-items\"><div class=\"field-item even\">", "", $description);
				$desc_replace_02 = str_replace("/></div><div class=\"field-item odd\">", "/>", $desc_replace_01);
				$desc_replace_03 = str_replace("/></div><div class=\"field-item even\">", "/>", $desc_replace_02);
				$descript = explode('>', $desc_replace_03);
				//$description = preg_split(">", $desc_replace_03);
				//foreach ($descript as $image):
					
				// Print the saved values
				endforeach;
		?>
        
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CQFF24 Image Feed</title>

        <!-- Shared assets -->
        <link rel="stylesheet" type="text/css" href="style_test.css">

        <!-- Example assets -->
        <link rel="stylesheet" type="text/css" href="jcarousel.test.css">

        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="jquery.jcarousel.min.js"></script>

        <script type="text/javascript" src="jcarousel.basic.js"></script>

    </head>
    <body>

        <div class="wrapper">
    
            <div class="jcarousel-wrapper">
                <div class="jcarousel">
                    <ul>
                        <li><?php echo $descript[0]; ?>></li>
                        <li><?php echo $descript[1]; ?>></li>
                        <li><?php echo $descript[2]; ?>></li>
                        <li><?php echo $descript[3]; ?>></li>
                        <li><?php echo $descript[4]; ?>></li>
                        <li><?php echo $descript[5]; ?>></li>
                        <li><?php echo $descript[6]; ?>></li>
                        <li><?php echo $descript[7]; ?>></li>
                    </ul>
                </div>

                <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                
                <!-- <p class="jcarousel-pagination">
                    
                </p>-->
            </div>
        </div>

    </body>
</html>
