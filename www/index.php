<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['validation']) && $_SESSION['validation'] == 1){

    echo '<!DOCTYPE html>
    <html lang="fr">

    <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>Efrei Dynamo (internal)</title>

      <!-- Bootstrap core CSS -->
      <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="css/blog-home.css" rel="stylesheet">

    </head>

    <body>

      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="#">Projet Efrei Dynamo (internal)</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Répondre à des questions
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="newquestion.php">Poser une question</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Mon compte</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Se déconnecter</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <div class="container">

        <div class="row">

          <!-- Blog Entries Column -->
          <div class="col-md-8">

            <h1 class="my-4">Bienvenue sur Efrei Dynamo,
              <small>', $_SESSION['pseudo'], '</small>
            </h1>

            <!-- Blog Post -->
            <div class="card mb-4">
              <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
              <div class="card-body">
                <h2 class="card-title">Post Title</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                <a href="#" class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on January 1, 2020 by
                <a href="#">Start Bootstrap</a>
              </div>
            </div>

            <!-- Blog Post -->
            <div class="card mb-4">
              <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
              <div class="card-body">
                <h2 class="card-title">Post Title</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                <a href="#" class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on January 1, 2020 by
                <a href="#">Start Bootstrap</a>
              </div>
            </div>

            <!-- Blog Post -->
            <div class="card mb-4">
              <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
              <div class="card-body">
                <h2 class="card-title">Post Title</h2>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>
                <a href="#" class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on January 1, 2020 by
                <a href="#">Start Bootstrap</a>
              </div>
            </div>

            <!-- Pagination -->
            <ul class="pagination justify-content-center mb-4">
              <li class="page-item">
                <a class="page-link" href="#">&larr; Plus ancien</a>
              </li>
              <li class="page-item disabled">
                <a class="page-link" href="#">Plus récent &rarr;</a>
              </li>
            </ul>

          </div>

          <!-- Sidebar Widgets Column -->
          <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
              <h5 class="card-header">Rechercher</h5>
              <div class="card-body">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Rechercher...">
                  <span class="input-group-append">
                    <button class="btn btn-secondary" type="button">Go !</button>
                  </span>
                </div>
              </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
              <h5 class="card-header">Catégories</h5>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                      <li>
                        <a href="#">L1</a>
                      </li>
                      <li>
                        <a href="#">L2</a>
                      </li>
                      <li>
                        <a href="#">L3</a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                      <li>
                        <a href="#">M1</a>
                      </li>
                      <li>
                        <a href="#">M2</a>
                      </li>
                      <li>
                        <a href="#">Campus</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
              <h5 class="card-header">Récapitulatif</h5>
              <div class="card-body">
                Vous avez posé 0 questions, et vous avez répondu à 0 questions sur Efrei Dynamo. 0 questions sont en attente de réponse dans votre promo.
              </div>
            </div>

          </div>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.container -->

      <!-- Footer -->
      <footer class="py-5 bg-dark">
        <div class="container">
          <p class="m-0 text-center text-white">&copy; 2021 Efrei Dynamo. Tous droits reservés.</p>
        </div>
        <!-- /.container -->
      </footer>

      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>
';

}
else {
  echo '<!DOCTYPE html>
  <html lang=fr>
    <head>
      <meta charset="utf-8">
      <title>Efrei Dynamo</title>
      <style>
        .screen {
          height: 100vh;
          width: 100%;
          text-align: center;
          display: table;
        }

        .v-center {
          display: table-cell;
          vertical-align: middle;
        }

        p {
          margin: auto;
          color: white;
          font-family: "Helvetica Neue Light", Helvetica, sans-serif;
          text-decoration: none;
          font-size: 60px;
          font-weight: thin;
        }
        b {
          color: white;
          font-family: "Helvetica Neue Bold", Helvetica, sans-serif;
          font-size: 60px;
          font-weight: 3000;
        }
        a {
          color: white;
          font-family: "Helvetica Neue Bold", Helvetica, sans-serif;
          text-decoration: none;
          font-size: 60px;
          font-weight: thin;
        }
        a:hover {
          cursor: default;
        }
        body {
          background-color: black;
        }
      </style>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
      <div class="screen">
        <div class="v-center">';
        if (isset($_SESSION['validation'])) {
          echo '<p><b>Hello ', $_SESSION['pseudo'], ' !</b><br> Tu dois confirmer ton statut d\'Efreien pour accéder au site.<br><a href = "logout.php">Se déconnecter</a></p>';
        } else {
          echo'<p><b>Projet Dynamo</b><br>Rendez-vous prochainement.</p>';
        }
        echo '
        </div>
      </div>
    </body>
  </html>';
}

?>
