<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Carfi.com - Find your next ride.</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
    <!--TODO: Hunter put this behind login-->
      <a class="btn btn-primary" href="admin.html">Employee Sign In</a>
    </div>
  </nav>

  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Search for a vehicle across all of our dealership locations!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form>
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="text" id="search" class="form-control form-control-lg" placeholder="'Audi X3', 'Audi', 'X3', or blank to see all products"  value="">
              </div>
              <div class="col-12 col-md-3">
                <button type="button" class="btn btn-block btn-lg btn-primary" onclick="showCars(document.getElementById('search').value)">Search!</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <div id = "searchResults"></div>

   <!-- Image Showcases -->
   <section id="categories" class="showcase">
    <div class="container-fluid p-0">
      <div class="row no-gutters">

        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/audi_suv.jpg');"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Shop SUVs</h2>
          <p class="lead mb-0"><a onclick="showCars('SUV')">Find a large collection of the latest SUVs from Audi, BMW, Tesla & more.</a></p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/cyber.jpg');"><a onclick="showCars('Cybertruck')"></a></div>
        <div class="col-lg-6 my-auto showcase-text">
          <h2>Tesla Cybertruck</h2>
          <p class="lead mb-0"><a onclick="showCars('Cyber Truck')">It's so weird, you want it.</a></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section  id="testimonials" class="testimonials text-center bg-light">
    <div class="container">
      <h2 class="mb-5">What people are saying...</h2>
      <div class="row">
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/testimonials-1.jpg" alt="">
            <h5>Margaret E.</h5>
            <p class="font-weight-light mb-0">"This is fantastic! I love my new car!"</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/ryguy.jpg" alt="">
            <h5>Ryan L.</h5>
            <p class="font-weight-light mb-0">"I found the perfect ride!"</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="img/testimonials-3.jpg" alt="">
            <h5>Sarah W.</h5>
            <p class="font-weight-light mb-0">"Thanks so much for making this!"</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Your Website 2020. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

<script>
  function showCars(q) {
    var xhttp;
  
    xhttp = new XMLHttpRequest();
    // Define when we receive answer from server, write the data to result div
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("searchResults").innerHTML = this.responseText;
            $("#testimonials").hide();
            $("#categories").hide();
        }
    };
    // Make async get request to server
    console.log(q);
    xhttp.open("GET", "customerSearch.php?q="+q, true);
    xhttp.send();
  }

  function reset () {
    $("#tabela1 tbody tr").show();
    $( "input:checkbox:checked" ).prop( "checked", false );
  }

  function home () {
    $("#tabela1").hide();
    $( "input:checkbox:checked" ).prop( "checked", false );
    $("#testimonials").show();
    $("#categories").show();
    document.getElementById("searchResults").innerHTML = "";
  }

  function filterResults () {
        $(".colorcheckbox, .modelcheckbox, .pricecheckbox").on("change", function () {
          var colorchecked = $(".colorcheckbox:checked").map(function () {
              return $(this).val()
          }).get();
          var modelchecked = $(".modelcheckbox:checked").map(function () {
              return $(this).val()
          }).get();
          var pricechecked = $(".pricecheckbox:checked").map(function () {
              return $(this).val()
          }).get();

          var all = $("#tabela1 tbody tr").hide();

          var models = $(".model").filter(function () {
              var model = $(this).text(),
                  index = $.inArray(model, modelchecked);
                  
              return index >= 0
          }).parent()
          if (!models.length) models = all;

          var colors = $(".color").filter(function () {
              var color = $(this).text(),
                  index2 = $.inArray(color, colorchecked);
              return index2 >= 0
          }).parent()
          if (!colors.length) colors = all;

          var prices = $(".price").filter(function () {
              var price = $(this).text(),
                  index3 = $.inArray(price, pricechecked);
              return index3 >= 0
          }).parent()
          if (!prices.length) prices = all;

          models.filter(colors).filter(prices).show();
        }).first().change()   
  } 
</script>
</html>
