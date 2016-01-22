app.controller('colonyCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) 
{
    //initially set those objects to null to avoid undefined error
    $scope.lista= {};
    $scope.datosColony = {};
    $scope.nameWindow={};



		$scope.cargarDatosColony = function (customer) {
        Data.post('datosColony').then(function (results) {
            if (results.status == "success") {
                $scope.lista = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puedieron cargar los datos.");
            }
        });
    };

      


    $scope.addColonyData = function(datosColony){

        if($scope.validar2()){
            Data.post('addColony', {
                datosColony: datosColony
            }).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                   $("#modalColony").closeModal();
                   $scope.cargarDatosColony();

                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };


 

//Botones
   $scope.cargarModalColony = function (uid, read, mod, add, type) {
        Data.post('detalleColony', {
         uid: uid
        }).then(function (results) {
            if (results.status == "success") {
                $scope.datosColony = results;
                $("#modalColony").openModal({
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
                        $scope.datosColony = {};
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


    $scope.deleteModalColony = function (uid) {
        $("#modalDeleteColony").openModal();
        $scope.uid  = uid;
        $scope.colony_name = uid.Name;
        $scope.pricee = uid.price;
        
    };

    $scope.datosColony = {uid:'', Name:''};
    $scope.deleteColonyData = function(uid){
        Data.post('deleteColony', {
            uid: uid
        }).then(function (results) {
            if (results.status == "success") {
                $scope.cargarDatosColony();
            }

        });
    };



$scope.limpiarCamposColony = function(){
        $scope.datosColony = {};
    };



$scope.datosColony = {uid:'',Name:'', price:'', price_id:''};
    $scope.updateColonyData = function(colonyUser){
       if($scope.validar2()){

            Data.post('updateColony', {
                colonyUser: colonyUser
            }).then(function (results) {
                if (results.status == "success") {
                    $("#modalColony").closeModal();
                   $scope.cargarDatosColony();
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
        if ($scope.datosColony.Name == '' || $scope.datosColony.Name == null)
        {
            $("#Name").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#Name").removeClass("invalid");
        }
        
        //console
        console.log($scope.datosColony.Name); 
        if ($scope.datosColony.Name.length < 5)
        {
            $("#Name").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else
        {
            $("#Name").removeClass("invalid");
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