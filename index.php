
<!--usuarui:6672010886   pass:danlok1-->
<!DOCTYPE html>
<html lang="en" ng-app="myApp" ng-controller="authCtrl">


  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>root</title>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  </head>

  <body ng-cloak="">

  <nav class="deep-purple darken-4" ng-hide="authenticated == false">
    <div class="nav-wrapper">
    
        <a href="" class="brand-logo">{{name}}</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
    
        <ul class="right hide-on-med-and-down">
            <li><a href="#/dashboard">Inicio</a></li>
            <!--<li><a href="#/root">Root</a></li>-->
           <!-- <li><a href="#/admin">Admin</a></li>-->
            <li><a href="#/cabbie">Cabbie</a></li>
            <li><a href="#/colony">Colony</a></li>
            <li><a href="#/request">Solicitudes</a></li>

            <li><a href="#" ng-click="logout()">Logout</a></li>
        </ul>

    </div>
</nav>

  <!--VENTANA MODAL LOGOUT-->
<div id="modalLogout" class="modal deep-orange lighten-2">
    <div class="card deep-orange lighten-1">
        <div class="card-content white-text">
            <span class="card-title">Eliminar</span>
            <p>Seguro que desea eliminar a</p>
  
           
        </div>
        <div class="card-action">
            <a ng-click="logout()" class="modal-action modal-close white waves-effect red-text waves-white btn">Eliminar</a>
            <a class="red modal-action modal-close waves-effect waves-red white-text btn">Cancelar</a>
        </div>
    </div>
</div>

        <div data-ng-view="" id="ng-view" class="slide-animation">
          <!--CONTENEDOR PRINCIPAL-->
        </div>
        


        <main>  </main>
        <footer class="page-footer deep-purple darken-4">
          <div class="container">
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2015 Copyright Yozzi Been's
            </div>
          </div>
        </footer>
  </body>


  <toaster-container toaster-options="{'time-out': 1000}"></toaster-container>
  <script src="js/angular.min.js"></script>
  <script src="js/angular-route.min.js"></script>
  <script src="js/angular-animate.min.js" ></script>
  <script src="js/toaster.js"></script>
  <script src="app/app.js"></script>
  <script src="app/data.js"></script>
  <script src="app/directives.js"></script>
  <script src="app/authCtrl.js"></script>
  <script src="app/rootCtrl.js"></script>
  <script src="app/adminCtrl.js"></script>
  <script src="app/cabbieCtrl.js"></script>
  <script src="app/requestCtrl.js"></script>
  <script src="app/colonyCtrl.js"></script>

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
</html>



