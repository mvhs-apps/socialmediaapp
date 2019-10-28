<?php
include('firebase.php');
include('navbar.php');
include_once('includes.php');
$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
session_start();
$user = stripper($_SESSION["user"]);
if($user == "invalid") {
    header("Location: http://localhost/socialmediaapp/index.php");
}
?>

<!-- Card -->
<div class="card">

<!-- Card image -->
<div class="view overlay">
  <img class="card-img-top" src="https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg" alt="Card image cap">
  <a href="#!">
    <div class="mask rgba-white-slight"></div>
  </a>
</div>

<!-- Card content -->
<div class="card-body">

  <!-- Title -->
  <h4 class="card-title">Card title</h4>
  <!-- Text -->
  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  <!-- Button -->
  <a href="#" class="btn btn-primary">Button</a>

</div>

</div>
<!-- Card -->