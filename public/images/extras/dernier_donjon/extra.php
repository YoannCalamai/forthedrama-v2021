<?php

$images = scandir ( './' );

?>

<html>
<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
</head>
<body>
<div class="container">
	<div class="row">

			<?php 
			$i = 0;
				foreach( $images as $image ){
				
					if( $image != '..' && $image != '.' && $image != 'extra.php' ){
							$i++
						?>
							<div class="col-lg-3 col-md-4 col-xs-6 thumb">
								<a class="image-link"  href="<?php echo 'https://www.forthedrama.com/images/extras/dernier_donjon/' . $image; ?>">
									<img class="img-thumbnail"
										 src="<?php echo 'https://www.forthedrama.com/images/extras/dernier_donjon/' . $image; ?>"
										 alt="Image <?php $i;?>">
								</a>
							</div>
			
				<?php } }?>



    </div>
</div>
</body>


<!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<!-- Magnific Popup core JS file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.image-link').magnificPopup({type:'image',  disableOn: 400});
    });
</script>







