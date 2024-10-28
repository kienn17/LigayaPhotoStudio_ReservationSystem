<?php
session_start(); 
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ligaya Studio</title>
	<link rel="stylesheet" type="text/css" href="hstyle.css">

	<link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

</head>
<body>

	<header>
		<a href="#" class="logo"><img src="image/ligayalogo.png"></a>
		<div class="bx bx-menu" id="menu-icon"></div>

		<ul class="navlist">
			<li><a href="#Home">Home</a></li>
			<li><a href="#About-us">About us</a></li>
			<li><a href="#Service">Service</a></li>
			<li><a href="#Gallery">Gallery</a></li>
			<li><a href="#Reviews">Reviews</a></li>
			<li><a href="#Contact">Contact</a></li>
		</ul>
	</header>

	<section id="Home" class="main">
		<div class="main-text">
			<h1>Kumusta ka?</h1>
            <br>
			<p>Hellooo friends! We look forward to serve you with a 
				<br>big smile & joyful experience in our humble space!</p>
			<button class="main-button" type="button"><a href="login.php">Book now!</a></button>
		</div>
	</section>

	<section id="About-us" class="About-us">
		<div class="about-text">
			<br>
			<h1>About Us</h1>
            <br>
            <p>Ligaya Studios is a self-photo studio, established in May 2023, and located inside Hub Make Lab at the First United Building in Escolta, Binondo. We offer a creative space where you can capture
				 life’s special moments, whether you’re making new memories or reliving old ones. Our studio is designed for comfort and creativity, providing everything you need to express yourself in every shot. 
				 Whether you're visiting alone or with loved ones, we're here to make each moment memorable. </p>
			<p>At Ligaya Studio, we believe that every picture tells a story. We’re committed to making your experience fun, easy, and unforgettable. Come visit us and let’s create something special together!</p>
			
		</div>
		<div class="about-img">
			<img src="image/studio.jpg">
		</div>
	</section>

	<section id="Service" class="service">
		<div class="service-text">
			<br>
			<h1>Our Service</h1>
            <br>
            <p>Ligaya Studios offers self-photo sessions with packages starting at just PHP 299, including soft copies of your photos. Enjoy a professional and creative space to capture your special moments with ease.</p>
		</div>
		<div class="service-img">
			<img src="image/package.png">
			<img src="image/option.png">
		</div>
	</section>

	<section id="Gallery" class="gallery">
		<div class="gallery-text">
		  <br>
		  <h1>Gallery</h1>
		  <br>
		  <p>Explore our gallery to see how our customers have captured their special moments at Ligaya Studios! From fun solo shoots to joyful group photos, our space is perfect for creating and sharing memorable experiences. 
			  Browse through the vibrant and diverse snapshots of our clients enjoying their time in our studio.</p>  
		</div>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
		  </ol>
	  
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
			<div class="item active">
			  <div class="row">
				<div class="col-md-4">
				  <img src="image/gallery1.jpg" alt="Gallery 1">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery2.jpg" alt="Gallery 2">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery3.jpg" alt="Gallery 3">
				</div>
			  </div>
			</div>
	  
			<div class="item">
			  <div class="row">
				<div class="col-md-4">
				  <img src="image/gallery4.jpg" alt="Gallery 4">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery5.jpg" alt="Gallery 5">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery6.jpg" alt="Gallery 6">
				</div>
			  </div>
			</div>
	  
			<div class="item">
			  <div class="row">
				<div class="col-md-4">
				  <img src="image/gallery7.jpg" alt="Gallery 7">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery8.jpg" alt="Gallery 8">
				</div>
				<div class="col-md-4">
				  <img src="image/gallery9.jpg" alt="Gallery 9">
				</div>
			  </div>
			</div>

			<div class="item">
				<div class="row">
				  <div class="col-md-4">
					<img src="image/gallery10.jpg" alt="Gallery 10">
				  </div>
				  <div class="col-md-4">
					<img src="image/gallery11.jpg" alt="Gallery 11">
				  </div>
				  <div class="col-md-4">
					<img src="image/gallery12.jpg" alt="Gallery 12">
				  </div>
				</div>
			</div>
		  
	  
		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
			<span class="sr-only">Next</span>
		  </a>
		</div>
	</section>

	<div id="modal" class="modal">
		<span class="modal-close" onclick="closeModal()">&times;</span>
		<img class="modal-content" id="modal-img">
	</div>
	

	<section id="Reviews" class="reviews">
		<div class="reviews-text">
			<br>
			<h1>Reviews</h1>
            <br>
            <p>Hear directly from our satisfied customers! Read their reviews to find out why people love their experience at Ligaya Studios. 
			From the quality of our photo sessions to the friendly atmosphere, our clients share their positive feedback and memorable moments.
			<br>Click those pictures to read the reviews more clearly.</p>
			
			<div class="reviews-img">
				<img src="image/review1.png" alt="Review 1" onclick="openModal('image/review1.png')">
				<img src="image/review2.png" alt="Review 2" onclick="openModal('image/review2.png')">
				<img src="image/review3.png" alt="Review 3" onclick="openModal('image/review3.png')">
				<img src="image/review4.png" alt="Review 4" onclick="openModal('image/review4.png')">
				<img src="image/review6.png" alt="Review 6" onclick="openModal('image/review6.png')">
				<img src="image/review7.png" alt="Review 7" onclick="openModal('image/review7.png')">
			  </div>
			</div>
		</div>
	</section>

	<section id="Contact" class="contact">
		<div class="contact-text">
			<br>
			<h1>Contact us</h1>
            <br>
            <div class="social">
				<a href="https://www.facebook.com/ligaya.studios"><i class='bx bxl-facebook-circle'></i>Facebook</a>
				<a href="https://www.instagram.com/ligaya.studios/"><i class='bx bxl-instagram-alt'></i>Instagram</a>
				<a href="https://www.tiktok.com/@ligaya.studios"><i class='bx bxl-tiktok' ></i>Tiktok</a>
			</div>
		
		</div>
	</section>




</body>


<script>
	function openModal(src) {
	  var modal = document.getElementById("modal");
	  var modalImg = document.getElementById("modal-img");
	  modal.style.display = "flex";
	  modalImg.src = src;
	}
  
	function closeModal() {
	  var modal = document.getElementById("modal");
	  modal.style.display = "none";
	}
  
	window.onclick = function(event) {
	  var modal = document.getElementById("modal");
	  if (event.target === modal) {
		modal.style.display = "none";
	  }
	}


</script>

</html>