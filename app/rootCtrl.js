app.controller('rootCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) 
{
    //initially set those objects to null to avoid undefined error
    $scope.lista= {};
    $scope.datosRoot = {};
    $scope.nameWindow={};

    $scope.cargarDatosRoot = function (customer) {
        Data.post('datosRoot').then(function (results) {
            if (results.status == "success") {
                $scope.lista = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puedieron cargar los datos.");
            }
        });
    };

    $scope.cargarModalRoot = function (uid, read, mod, add, type) {
        Data.post('detalleRoot', {
            uid: uid
        }).then(function (results) {
            if (results.status == "success") {
                $scope.datosRoot = results;
                $("#modalRoot").openModal({
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
                        $scope.datosRoot = {};
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


    $scope.deleteModalRoot = function (uid) {
        $("#modalDeleteRoot").openModal();
        $scope.uidRoot  = uid;
        $scope.nameRoot = uid.name;
    };

    

    $scope.limpiarCamposRoot = function(){
        $scope.datosRoot = {};
    };

    $scope.datosRoot = {uid:'',name:'',email:'',phone:'',password:'',repeatpassword:''};
    $scope.updateRootData = function(rootUser){
        if($scope.validar2()){

            Data.post('updateRoot', {
                rootUser: rootUser
            }).then(function (results) {
                if (results.status == "success") {
                    $("#modalRoot").closeModal();
                   $scope.cargarDatosRoot();
                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };

    $scope.addRootData = function(rootUser){

        if($scope.validar()){
            Data.post('addRoot', {
                rootUser: rootUser
            }).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                   $("#modalRoot").closeModal();
                   $scope.cargarDatosRoot();

                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };

    $scope.datosRoot = {uid:''};
    $scope.deleteRootData = function(rootUser){
        Data.post('deleteRoot', {
            rootUser: rootUser
        }).then(function (results) {
            if (results.status == "success") {
                $scope.cargarDatosRoot();
            }

        });
    };

    $scope.validar = function(){
        $err = 0;
        if ($scope.datosRoot.name == '' || $scope.datosRoot.name == null){
            $("#root_name").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else{
            $("#root_name").removeClass("invalid");
        }
        if ($scope.datosRoot.email == '' || $scope.datosRoot.email == null){
            $("#root_email").addClass("invalid");
            Materialize.toast('El email no es valido', 4000);
            $err++;
        }
        else{
            $("#root_email").removeClass("invalid");
        }
        if ($scope.datosRoot.phone == '' || $scope.datosRoot.phone == null){
            $("#root_phone").addClass("invalid");
            Materialize.toast('El telefono esta vacio', 4000);
            $err++;
        }
        else{
            $("#root_phone").removeClass("invalid");
        }
        if ($scope.datosRoot.password == '' || $scope.datosRoot.password == null){
            $("#root_password").addClass("invalid");
            Materialize.toast('La contraseña esta vacia', 4000);
            $err++;
        }
        else{
            $("#root_password").removeClass("invalid");
        }
        if ($scope.datosRoot.passwordrepeat == '' || $scope.datosRoot.passwordrepeat == null){
            $("#root_passwordrepeat").addClass("invalid");
            Materialize.toast('El contraseña de repeticion esta vacia', 4000);
            $err++;
        }
        else{
            $("#root_passwordrepeat").removeClass("invalid");
        }
        if ($scope.datosRoot.name.length < 5){
            $("#root_name").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else{
            $("#root_name").removeClass("invalid");
        }
        if ($scope.datosRoot.phone.length < 10 || $scope.datosRoot.phone.length > 10){
            $("#root_phone").addClass("invalid");
            Materialize.toast('El telefono debe ser a 10 digitos', 4000);
            $err++;
        }
        else{
            $("#root_phone").removeClass("invalid");
        }
        if ($scope.datosRoot.password.length < 6){
            $("#root_password").addClass("invalid");
            Materialize.toast('La contraseña debe ser mayor de 6 digitos', 4000);
            $err++;
        }
        else{
            $("#root_password").removeClass("invalid");
        }
        if ($scope.datosRoot.password != $scope.datosRoot.passwordrepeat){
            $("#root_passwordrepeat").addClass("invalid");
            Materialize.toast('Las contraseñas no coinciden', 4000);
            $err++;
        }
        else{
            $("#root_passwordrepeat").removeClass("invalid");
        }

        if ($err > 0) {
            return false;
        }
        else{
            return true;
        }
    };


    $scope.validar2 = function(){
        $err = 0;
        if ($scope.datosRoot.name == '' || $scope.datosRoot.name == null)
        {
            $("#root_name").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#root_name").removeClass("invalid");
        }
        if ($scope.datosRoot.email == '' || $scope.datosRoot.email == null)
        {
            $("#root_email").addClass("invalid");
            Materialize.toast('El email no es valido', 4000);
            $err++;
        }
        else
        {
            $("#root_email").removeClass("invalid");
        }
        if ($scope.datosRoot.phone == '' || $scope.datosRoot.phone == null)
        {
            $("#root_phone").addClass("invalid");
            Materialize.toast('El telefono esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#root_phone").removeClass("invalid");
        }
        if ($scope.datosRoot.name.length < 5)
        {
            $("#root_name").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else
        {
            $("#root_name").removeClass("invalid");
        }
        if ($scope.datosRoot.phone.length != 10)
        {
            $("#root_phone").addClass("invalid");
            Materialize.toast('El telefono debe ser a 10 digitos', 4000);
            $err++;
        }
        else
        {
            $("#root_phone").removeClass("invalid");
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
