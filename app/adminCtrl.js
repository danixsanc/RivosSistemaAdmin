app.controller('adminCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) 
{
    //initially set those objects to null to avoid undefined error
    $scope.lista = {};
    $scope.lista2 = {};
    $scope.datosAdmin = {};
    $scope.nameWindow={};




    $scope.cargaDatosAdmin = function (customer) {
        Data.post('datosAdmin').then(function (results) {
            if (results.status == "success") {
                $scope.lista = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puedieron cargar los datos.");
            }
        });
    };

    $scope.cargarModalPayment = function (admin_id) {
        Data.post('paymentAdmin', {
            admin_id: admin_id
        }).then(function (results) {
            if (results.status == "success") {
                
                $("#modalPayment").openModal({
                    dismissible: false
                });
                $scope.lista2 = results.records;
            }
            else if(results.status  == "error"){
                Data.toast("No se puede cargar información.");
            }
        });
    };


    $scope.cargarModalAdmin = function (admin_id, read, mod, add, type) {
        Data.post('detalleAdmin', {
            admin_id: admin_id
        }).then(function (results) {
            if (results.status == "success") {
                $scope.datosAdmin = results;
                $("#modalAdmin").openModal({
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
                        $scope.datosAdmin = {};
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


    $scope.cargarModalColony = function (admin_id) {
        Data.post('detalleColony', {
            admin_id: admin_id
        }).then(function (results) {
            if (results.status == "success") {
                $scope.datosColony = results;
                $("#modalColony").openModal({
                    dismissible: false
                });
 
                            
            }
            else if(results.status  == "error"){
                Data.toast("No se puede cargar información.");
            }
        });
    };

    $scope.deleteModalAdmin = function (admin_id) {
        $("#modalDeleteAdmin").openModal();
        $scope.admin_id_Admin  = admin_id;
        $scope.companyAdmin = admin_id.company;
    };

    $scope.limpiarCamposAdmin= function(){
        $scope.datosAdmin = {};
    };

    $scope.datosAdmin = {admin_id:'',company:'',email:'',phone:'',password:'',repeatpassword:''};
    $scope.updateAdminData = function(adminUser){
        if($scope.validar2()){

            Data.post('updateAdmin', {
                adminUser: adminUser
            }).then(function (results) {
                if (results.status == "success") {
                    $("#modalAdmin").closeModal();
                   $scope.cargaDatosAdmin();
                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };


$scope.updateColonyData = function(colonyUser){
        

            Data.post('updateColony', {
                colonyUser: colonyUser
            }).then(function (results) {
                if (results.status == "success") {
                    $("#modalColony").closeModal();
                   $scope.cargaDatosAdmin();
                }
            });
        
        };





    $scope.addAdminData = function(adminUser){

        if($scope.validar()){
            Data.post('addAdmin', {
                adminUser: adminUser
            }).then(function (results) {
                Data.toast(results);
                if (results.status == "success") {
                   $("#modalAdmin").closeModal();
                   $scope.cargaDatosAdmin();

                }
            });
        }
        else
        {
            Materialize.toast('Porfavor verifique todos sus campos escritos', 4000);
        }
    };

    $scope.datosAdmin = {uid:''};
    $scope.deleteAdminData = function(adminUser){
        Data.post('deleteAdmin', {
            adminUser: adminUser
        }).then(function (results) {
            if (results.status == "success") {
                $scope.cargaDatosAdmin();
            }

        });
    };

    $scope.validar = function(){
        $err = 0;
        if ($scope.datosAdmin.company == '' || $scope.datosAdmin.company == null){
            $("#admin_company").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else{
            $("#admin_company").removeClass("invalid");
        }
        if ($scope.datosAdmin.email == '' || $scope.datosAdmin.email == null){
            $("#admin_email").addClass("invalid");
            Materialize.toast('El email no es valido', 4000);
            $err++;
        }
        else{
            $("#admin_email").removeClass("invalid");
        }
        if ($scope.datosAdmin.phone == '' || $scope.datosAdmin.phone == null){
            $("#admin_phone").addClass("invalid");
            Materialize.toast('El telefono esta vacio', 4000);
            $err++;
        }
        else{
            $("#admin_phone").removeClass("invalid");
        }
        if ($scope.datosAdmin.password == '' || $scope.datosAdmin.password == null){
            $("#admin_password").addClass("invalid");
            Materialize.toast('La contraseña esta vacia', 4000);
            $err++;
        }
        else{
            $("#admin_password").removeClass("invalid");
        }
        if ($scope.datosAdmin.passwordrepeat == '' || $scope.datosAdmin.passwordrepeat == null){
            $("#admin_passwordrepeat").addClass("invalid");
            Materialize.toast('El contraseña de repeticion esta vacia', 4000);
            $err++;
        }
        else{
            $("#admin_passwordrepeat").removeClass("invalid");
        }
        if ($scope.datosAdmin.company.length < 5){
            $("#admin_company").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else{
            $("#admin_company").removeClass("invalid");
        }
        if ($scope.datosAdmin.phone.length < 10 || $scope.datosAdmin.phone.length > 10){
            $("#admin_phone").addClass("invalid");
            Materialize.toast('El telefono debe ser a 10 digitos', 4000);
            $err++;
        }
        else{
            $("#admin_phone").removeClass("invalid");
        }
        if ($scope.datosAdmin.password.length < 6){
            $("#admin_password").addClass("invalid");
            Materialize.toast('La contraseña debe ser mayor de 6 digitos', 4000);
            $err++;
        }
        else{
            $("#admin_password").removeClass("invalid");
        }
        if ($scope.datosAdmin.password != $scope.datosAdmin.passwordrepeat){
            $("#admin_passwordrepeat").addClass("invalid");
            Materialize.toast('Las contraseñas no coinciden', 4000);
            $err++;
        }
        else{
            $("#admin_passwordrepeat").removeClass("invalid");
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
        if ($scope.datosAdmin.company == '' || $scope.datosAdmin.company == null)
        {
            $("#admin_company").addClass("invalid");
            Materialize.toast('El nombre esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#admin_company").removeClass("invalid");
        }
        if ($scope.datosAdmin.email == '' || $scope.datosAdmin.email == null)
        {
            $("#admin_email").addClass("invalid");
            Materialize.toast('El email no es valido', 4000);
            $err++;
        }
        else
        {
            $("#admin_email").removeClass("invalid");
        }
        if ($scope.datosAdmin.phone == '' || $scope.datosAdmin.phone == null)
        {
            $("#admin_phone").addClass("invalid");
            Materialize.toast('El telefono esta vacio', 4000);
            $err++;
        }
        else
        {
            $("#admin_phone").removeClass("invalid");
        }
        if ($scope.datosAdmin.company.length < 5)
        {
            $("#admin_company").addClass("invalid");
            Materialize.toast('El nombre debe ser mayor a 5 caracteres', 4000);
            $err++;
        }
        else
        {
            $("#admin_company").removeClass("invalid");
        }
        if ($scope.datosAdmin.phone.length != 10)
        {
            $("#admin_phone").addClass("invalid");
            Materialize.toast('El telefono debe ser a 10 digitos', 4000);
            $err++;
        }
        else
        {
            $("#admin_phone").removeClass("invalid");
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