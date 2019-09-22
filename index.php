<!DOCTYPE html>
<html>
<head>
  <title>Point of Sale System | Fortuna</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="javascript/jquery.min.js"></script>
  <script src="javascript/bootstrap.min.js"></script>
<style>

body {
  margin:0;
}

@font-face {
  font-family: opensans;
  src: url(fonts/OpenSans-Light.ttf);
}

@font-face {
  font-family: opensansbold;
  src: url(fonts/OpenSans-Regular.ttf);
}

@font-face {
  font-family: moon;
  src: url(fonts/ONEDAY.otf);
}

img {
  width: 100%;
}

footer {
    font-family: opensans;
    color: white;
    background-color: black;
    clear: left;
    text-align: center;
    width: 100%;
    opacity: 0.7;
}

.navbar {
  background-color: #1C1C1C;
}

.navbar a {
  color: white;
  text-align: center;
  padding: 14px 14px;
  text-decoration: none;
  font-family: opensans;
  font-size: 17px;
}

.navbar a:hover {
  background: #CCBDAD;
  color: black;
}

</style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="#"><span style="font-family: moon">Fortuna</span></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#about">About</a></li>
        <li><a href="#feature">Feature</a></li>
        <li><a href="#pricing">Pricing</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div id="about" class="container-fluid" style="background-color: white; padding-top: 40px; padding-bottom: 40px;">
  <br><br>
  <div id="myCarousel" class="carousel slide col-sm-12" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <div class="carousel-inner">
      <div class="item active">
        <img src="images/3.png" alt="Los Angeles" style="width:100%; height:100%;">
      </div>

      <div class="item">
        <img src="images/2.png" alt="Chicago" style="width:100%; height:100%;">
      </div>

      <div class="item">
        <img src="images/3.png" alt="New York" style="width:100%; height:100%;">
        <div class="carousel-caption">
        </div>
      </div>
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<div id="feature" class="container-fluid" align="center" style="background-color: #5C5C5C; color: white; height: 500px; font-family: opensans">
  <div class="container text-center">
    <h1>Why would you use Fortuna?</h1>
      <div class="row">
        <div class="col-sm-6">
          <h2>Affordable Price</h2>
          <br>
          <p1>You know what's better than dirt cheap? Free. That's right, this is completely
          FREE. No strings attached, no hidden agendas. You get to use our services for nothing!
          What more could you ask for?</p>
          <br>
          <h2>Easy-to-use</h2>
          <br>
          <p1>It simply requires you to finish the tutorial. That's it. No addition training
          needed, just don't skip the tutorial and you along with your colleagues are good</p>
        </div>
        <div class="col-sm-6">
          <h2>Easy of Accessibility</h2>
          <br>
          <p1>Fortuna is a cloudbased POS system. Which means you get to access and view
          the data in real time as long as you have an internet connection.</p>
          <br>
          <h2>FREE</h2>
          <br>
          <p1>Did I mention it's free?</p>
        </div>
      </div>
  </div>
</div>

<div id="pricing" class="container-fluid" style="font-family: opensans; background-color: white">
  <div class="text-center">
    <h2>Pricing</h2>
    <h4>Choose a payment plan that works for you</h4>
  </div>
  <div class="row">
    <div class="center-block" style="width: 50%;">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Basic</h1>
        </div>
        <div class="panel-body">
          <p><strong>20</strong> Lorem</p>
          <p><strong>15</strong> Ipsum</p>
          <p><strong>5</strong> Dolor</p>
          <p><strong>2</strong> Sit</p>
          <p><strong>Endless</strong> Amet</p>
        </div>
        <div class="panel-footer">
          <h3>$19</h3>
          <h4>per month</h4>
            <a href="signup.php"><button class="btn btn-lg">Sign Up</button></a>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>Copyright &copy; Fortuna</footer>

</body>

<script>
$(document).ready(function(){
  // Add scrollspy to <body>
  $('body').scrollspy({target: ".navbar", offset: 50});

  // Add smooth scrolling on all links inside the navbar
  $("#myNavbar a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }  // End if
  });
});
</script>

</html>
