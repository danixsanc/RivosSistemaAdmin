app.controller('cabbieCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) 
{
    //initially set those objects to null to avoid undefined error
    $scope.lista= {};
    $scope.datosCabbie = {};
    $scope.nameWindow={};
    $scope.listaCompany={};

    $scope.cargarDatosCabbie = function (customer) {
        Data.post('datosCabbie').then(function (results) {
            if (results.status == "success") {
                $scope.lista = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puedieron cargar los datos.");
            }
        });
    };


   $scope.cargarListaCompany = function (customer) {
        Data.post('listaCompany').then(function (results) {
            if (results.status == "success") {
                $scope.listaCompany = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puedieron cargar los datos.");
            }
        });
    };


      $scope.cargarDrop = function(){
         $(document).ready(function() {
            $('select').material_select();
          });
     };


    $scope.cargarModalCabbie = function (cabbie_id, read, mod, add, type) {
        Data.post('detalleCabbie', {
            cabbie_id: cabbie_id
        }).then(function (results) {
            if (results.status == "success") {
                $scope.datosCabbie = results;
                $("#modalCabbie").openModal({
                    dismissible: false
                });
                    if(read){
                        $scope.lectura = true;
                    }
                    else{
                        $scope.lectura = false;
                    }
                    if (mod) {
                        $scope.modificar = true;
                    }
                    else{
                        $scope.modificar = false;
                    }
                    if (add){
                        $scope.datosCabbie = {};
                        $scope.agregar = true;
                    }
                    else{
                        $scope.agregar = false;   
                    }

                    $scope.nameWindow = type;
                            
            }
            else if(results.status  == "error"){
                Data.toast("No se puede cargar información.");
            }
        });
    };


      $scope.limpiarCamposCabbie = function(){
        $scope.datosCabbie = {};
    };


    $scope.datosCabbie = {cabbie_id:'', Name:''};
    $scope.deleteCabbieData = function(datosCabbie){
        Data.post('deleteCabbie', {
            datosCabbie: datosCabbie
        }).then(function (results) {
            if (results.status == "success") {
                $scope.cargarDatosCabbie();
            }

        });
    };


 $scope.deleteModalCabbie = function (cabbie_id) {
        $("#modalDeleteCabbie").openModal();
        $scope.cabbie_id  = cabbie_id;
        $scope.cabbieName = cabbie_id.name;
    };



 

  $scope.addCabbieData = function(datosCabbie){

        if($scope.validar2()){
            Data.post('addCabbie', {
                datosCabbie: datosCabbie
            }).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                   $("#modalCabbie").closeModal();
                  $scope.cargarDatosCabbie();

                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };




    $scope.datosCabbie = {cabbie_id:'',name:'',phone:'',contract:'',company:'',password:'',repeatpassword:''};
    $scope.updateCabbieData = function(cabbieUser){
       if($scope.validar2()){

            Data.post('updateCabbie', {
                cabbieUser: cabbieUser
            }).then(function (results) {
                if (results.status == "success") {
                    $("#modalCabbie").closeModal();
                   $scope.cargarDatosCabbie();
                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };





        $scope.validar2 = function(){
        $err = 0;
        if ($scope.datosCabbie.name == '' || $scope.datosCabbie.name == null)
        {
            $("#name").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else
        {

               //console
        console.log($scope.datosCabbie.name); 
        console.log($scope.datosCabbie.phone); 
            $("#name").removeClass("invalid");
        }
    
        if ($scope.datosCabbie.phone == '' || $scope.datosCabbie.phone == null)
        {
            $("#phone").addClass("invalid");
            Materialize.toast('El telefono esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#phone").removeClass("invalid");
        }
        if ($scope.datosCabbie.name.length < 5)
        {
            $("#name").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else
        {
            $("#name").removeClass("invalid");
        }
        if ($scope.datosCabbie.phone.length != 10)
        {
            $("#phone").addClass("invalid");
            Materialize.toast('El telefono debe ser a 10 digitos', 4000);
            $err++;
        }
        else
        {
            $("#phone").removeClass("invalid");
        }

        if ($err > 0) 
        {
            return false;
        }
        else
        {
            return true;
        }
    };


});