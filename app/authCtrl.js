app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) 
{
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};



    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };

   /* $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };*/



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

    
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }

   $scope.logoutModal = function () {
        $("#modalLogout").openModal();
 
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