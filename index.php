<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
   

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="style.css">
<style>
  #hero {
  background-image: url(img/cov2.png);
  background-size: cover; 
  background-position: center center; 
  background-repeat: no-repeat; 
  height: 450px; 
  position: relative; 
}
.hero-content {
  position: absolute; 
  top: 0%; 
  left: 25%; 
  transform: translate(-50%, 0);
  text-align: center; 
  color: white; 
}

#header{
    background-color:#80bfff;
}

    </style>
</head>
<body>

<!-- NAVBAR --> 
<section id="header">
    <a href="#"><img src="img/logo.jpg" width="80px" height="100%"   class="logo" alt=""></a>
    <h5><b>Book Your Doctor’s Appointment, Anytime, Anywhere!!</b></h5>
        <div>
            
            <ul id="navbar">
            
                <li><a href="#hero">Home</a></li>
                <li><a href="#cards"> features</a></li>
                <li><a href="#about">About </a></li>
                
                <li><a href="#login">Login</a></li>
          </ul>
        </div>
</section>


 <!--HEADER-->
 <section id="hero">
</section>
   
<!--LOGINS-->

<h3><b>Login As: </b></h3>
<hr>
<div id="login" class="container">
    <div class="image-container">
    <a href="alogin.php">
        <img src="img/badm.jpg" alt="Image 1" class="circle-image">
        <button class="image-button">Admin Login</button>
    </div>
    <div class="image-container">
    <a href="dlogin.php">
        <img src="img/bdoc.jpg" alt="Image 2" class="circle-image">
        <button class="image-button">Doctor Login</button>
    </div>
    <div class="image-container">
    <a href="plogin.php">
        <img src="img/bpat.jpg" alt="Image 3" class="circle-image">
        <button class="image-button">Patient Login</button>
    </a>
    </div>
</div>

  
<!--CARDS-->
<section id="cards">
<div  id="cards" class="row">
        <div class="col-md-12">
        <div class="contianer text-center mt-0 pb-0">
       
        <h4 >Take a look at some of the key features.</h4>
        <hr class="">
        <div class="row mx-auto container-fluid my-2 pb-3">
          
            <div class="product col-lg-3 col-md-5 col-12">
                <img class="img-fluid" src="img/c1.jpg" alt="Dermatologist">
                <h5 class="p-name">Dermatologist</h5>
                <div class="product-details">
                    <h5>Expert in skin conditions</h5>
                    <p>Our dermatologists offer a wide range of services for treating skin conditions, including acne, eczema, and more.</p>
                </div>
            </div>

            <div class="product col-lg-3 col-md-5 col-12">
                <img class="img-fluid" src="img/c3.jpg" alt="Pediatrician">
                <h5 class="p-name">Pediatrician</h5>
                <div class="product-details">
                    <h5>Specialized in children's health</h5>
                    <p>Our pediatricians provide expert care for your child's health from infancy through adolescence.</p>
                </div>
            </div>

            <div class="product col-lg-3 col-md-5 col-12">
                <img class="img-fluid" src="img/c4.jpg" alt="Ophthalmologist">
                <h5 class="p-name">Ophthalmologist</h5>
                <div class="product-details">
                    <h5>Expert in eye health</h5>
                    <p>Our ophthalmologists diagnose and treat a wide range of eye conditions and diseases.</p>
                </div>
            </div>

            <div class="product col-lg-3 col-md-5 col-12">
                <img class="img-fluid" src="img/c2.jpg" alt="Orthodontist">
                <h5 class="p-name">Orthodontist</h5>
                <div class="product-details">
                    <h5>Specialized in braces and teeth alignment</h5>
                    <p>Our orthodontists help straighten teeth and improve the overall appearance of your smile with customized braces.</p>
                </div>
            </div>

        </div>
    </div>
</section>
 <!--ABOUT US-->
 <section>
 <div id="about" class="row mt-0">
    <div class=" div1 col-lg-5 col-md-6 col-12">
      <img class="img-fluid w-100 pb-3" src="img/about.webp" id="MainImg" alt="" >
    </div>
    <div class="col-lg-6 col-md-12 col-12">
    <h2 class="head"><b>ABOUT US</b></h2>
    <p>Doctors at hospitals diagnose and treat medical conditions, and promote wellness. Doctors often work 
      long hours,sometimes up to 24 hours a shift. They may also be required to be available for emergencies 
      after their regular work hours. Doctors work with a variety of other professionals, including nurses, 
      therapists, and physician assistants. They may also liaise with other doctors, non-medical management 
      staff, and healthcare professionals. Doctors provide compassionate, effective care to patients, and must 
      be able to communicate well with them and their families.</p>
    </div>
 </div>
 </section>

 
<!--FOOTER-->
<footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h4>About Us</h4>
                <p>We are dedicated to providing quality services and building strong customer relationships. Learn more about our journey and mission.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <p><a href="#hero">Home</a></p>
                <p><a href="#cards">Services</a></p>
                <p><a href="#about">About</a></p>
                <p><a href="#login">Login</a></p>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#" title="Facebook">Facebook</a>
                    <a href="#" title="Twitter">Twitter</a>
                    <a href="#" title="Instagram">Instagram</a>
                    <a href="#" title="LinkedIn">LinkedIn</a>
                </div>
            </div>
        </div>
        <hr>
        <p>&copy; 2024 MyWebsite. All Rights Reserved.   </footer>
 

</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>