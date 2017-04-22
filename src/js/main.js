console.log("Hola soy Sara Fernandez!");
$(window).load(function() {
    // Animate loader off screen
    //$(".se-pre-con").fadeOut("slow");

});
$(document).ready(function() {
  //initSlide();
  $('#carousel-example-generic2').carousel();
  $('.zoom').zoom();

});

angular.module('saraApp', ['ngDialog'])
  .controller('homeCtl', function($log, $scope) {
    $log.log("homeCtl");
      $(".se-pre-con").fadeOut("slow");


  })
  .controller('bioCtl', function($log, $scope) {
    $log.log("bioCtl");
      $(".se-pre-con").fadeOut("slow");


  })
  .controller('portfolioCtl', function($log, $scope, $http) {
    $log.log("portfolioCtl");
    $scope.ready=false;
    $scope.portfolio=[];
      $(".se-pre-con").fadeIn("slow");
    $http.get('http://fernandezsara.com/slim2/public/api.php/adj_categorias').then (function (data) {
      $log.log(data.data);
      $scope.portfolio=data.data;
      $scope.ready=true;
        $(".se-pre-con").fadeOut("slow");
    });


  })
  .controller('portfolioDetCtl', function($log, $scope, $location, $http) {
    $log.log("portfolioDetCtl");
    // $log.log($location.search().id);
    var id = $location.search().id;
    $scope.cat = id;
    $scope.ready=false;
    $scope.portfolio=[];
    $scope.lista=[];
      $(".se-pre-con").fadeIn("slow");
    $http.get('http://fernandezsara.com/slim2/public/api.php/adj_galeria/filtro/categoria,=,'+id).then (function (data) {
      $log.log(data.data);
      $scope.portfolio=data.data;
      $scope.lista=data.data;
      $scope.ready=true;
        $(".se-pre-con").fadeOut("slow");
    });


  })
  .controller('faqCtl', function($log, $scope, $http) {
    $log.log("faqCtl");
      $(".se-pre-con").fadeOut("slow");

    // $http.get('https://www.bmros.com.ar/promociones/slim/api.php/cms/promociones').then (function (data) {
    //   $log.log(data);
    // });

  })
  .controller('shopCtl', function($log, $scope, $http, ngDialog, $sce) {
    $log.log("shopCtl");
    $scope.ready=false;
    $scope.articulos=[];
      $(".se-pre-con").fadeIn("slow");
    $http.get('http://fernandezsara.com/slim2/public/api.php/adj_articulos').then (function (data) {
      $log.log(data.data);
      $scope.articulos=data.data;
      $scope.ready=true;
        $(".se-pre-con").fadeOut("slow");

    });
    $scope.open = function (art) {
        $log.log(art);
        $scope.sel = art;
        $scope.desc = $sce.trustAsHtml(art.desc_larga);

    };


    $scope.contacto = { nombre: "", correo: "", asunto:"", consulta:"" };
    //http://www.fernandezsara.com/web/envia_mails.php
    $scope.envio = function (articulo) {
      //$scope.contacto.consulta += '<br> Sobre el articulo: '+articulo.descripcion;
      $log.log(contacto);
      $(".se-pre-con").fadeIn();
      (function($) {
      jQuery.post('envia_mails.php', $scope.contacto).success(function(response) {
        console.log(response);
        $scope.contacto = { nombre: "", correo: "", asunto:"", consulta:"" };
        $(".se-pre-con").fadeOut();
        alert(response);
      });
      })(jQuery);
    };

  })
  .controller('contactoCtl', function($log, $scope, $http) {
    $log.log("contactoCtl");
      $(".se-pre-con").fadeOut("slow");
    $scope.contacto = { nombre: "De", correo: "Email", asunto:"Asunto", consulta:"Comentarios" };
    //http://www.fernandezsara.com/web/envia_mails.php
    $scope.envio = function () {
        $(".se-pre-con").fadeIn();
      // $http.post('http://www.fernandezsara.com/web/envia_mails.php', { nombre: "David", correo: 'david@diseenio.com.ar', asunto:"hola", consulta:"prueba" }).success(function(response) {
      //   $log.log(response) ;
      //   $scope.loading = false;
      // });
      (function($) {
      jQuery.post('envia_mails.php', $scope.contacto).success(function(response) {
        console.log(response);
        $scope.contacto = { nombre: "De", correo: "Email", asunto:"Asunto", consulta:"Comentarios" };
        $(".se-pre-con").fadeOut();
        alert(response);
      });
      })(jQuery);
    };



  })
    .controller('mobileCtl', function($log, $scope, $http, $location) {
        $log.log("mobileCtl");

        $scope.ready=false;
        $scope.portfolio=[];

        $http.get('http://fernandezsara.com/slim2/public/api.php/adj_categorias').then (function (data) {
            $log.log(data.data);
            $scope.portfolio=data.data;
            $scope.ready=true;
            $(".se-pre-con").fadeOut("slow");

        });
        var id = $location.search().id;
        $scope.cat = id;
        $scope.lista=[];
        $(".se-pre-con").fadeIn("slow");
        $http.get('http://fernandezsara.com/slim2/public/api.php/adj_galeria/filtro/categoria,=,'+id).then (function (data) {
            $log.log(data.data);
            $scope.lista=data.data;
            $scope.ready=true;
            $(".se-pre-con").fadeOut("slow");
        });


    })
  ;
