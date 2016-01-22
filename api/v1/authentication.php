<?php 
/*$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["Admin_Id"] = $session['Admin_Id'];
    $response["Email"] = $session['Email'];
    $response["Company"] = $session['Company'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';

    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('Email', 'password'),$r->customer);

    $response = array();
    $db = new DbHandler();

   $password = $r->customer->password;
    $Email = $r->customer->Email;
  

    $user = $db->getOneRecord("select Admin_Id,Company,Encrypted_Password,Email from Admin where Phone='$Email' or Email='$Email'");
   

    if ($user != NULL) {

        if(passwordHash::check_password($user['Encrypted_Password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['Company'] = $user['Company'];
        $response['Admin_Id'] = $user['Admin_Id'];
        $response['Email'] = $user['Email'];


        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['Admin_Id'] = $user['Admin_Id'];
        $_SESSION['Email'] = $user['Email'];
        $_SESSION['Company'] = $user['Company'];
        
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});*/





$app->get('/session', function() {
    $db = new DbHandler();
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select uid,name,password,email from root where phone='$email' or email='$email'");
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['name'];
        $response['uid'] = $user['uid'];
        $response['email'] = $user['email'];
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['name'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});


$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from root where phone='$phone' or email='$email'");
    if(!$isUserExists){
        //emcrypted
        $r->customer->password = passwordHash::hash($password);
        
        $tabble_name = "root";
        $column_names = array('phone', 'name', 'email', 'password', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});

$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});



/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/
/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/
/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/

$app->post('/addRoot', function() use ($app) 
{   
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    require_once 'passwordHash.php';
    $response = array();
    $r = json_decode($app->request->getBody());

    $name = $r->rootUser->name;
    $email = $r->rootUser->email;
    $phone = $r->rootUser->phone;
    $password = $r->rootUser->password;
    $passwordrepeat = $r->rootUser->passwordrepeat;

    if ($password != $passwordrepeat) 
    {
        $response["status"] = "error";
        $response["message"] = "Las Contraseñas no coinciden.";
        echoResponse(201, $response);
    }
    else
    {
        $password = passwordHash::hash($password);      
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $sql = "INSERT INTO Root (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')";

            if ($conn->query($sql) === TRUE) 
            {
                $response["status"] = "success";
                $response["message"] = "Usuario Root creado correctamente.";
                echoResponse(200, $response);
            } 
            else 
            {
                $response["status"] = "error";
                $response["message"] = "Error al registrar.";
                echoResponse(201, $response);
            }
        }
    }     
});





$app->post('/updateRoot', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    $uid = $r->rootUser->uid;
    $name = $r->rootUser->name;
    $email = $r->rootUser->email;
    $phone = $r->rootUser->phone;
        
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE root SET name = '$name', email='$email', phone = '$phone' WHERE uid = '$uid'";
        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM root WHERE uid = '$uid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root actualizado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});

$app->post('/deleteRoot', function() use ($app) 
{
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());
    $uid = $r->rootUser->uid;
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE root SET actv = '500' WHERE uid = '$uid'";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM root WHERE uid = '$uid'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root eliminado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});









/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/
/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/
/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/

$app->post('/addAdmin', function() use ($app) 
{   
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    require_once 'passwordHash.php';
    $response = array();
    $r = json_decode($app->request->getBody());

    $company = $r->adminUser->company;
    $email = $r->adminUser->email;
    $phone = $r->adminUser->phone;
    $password = $r->adminUser->password;
    $passwordrepeat = $r->adminUser->passwordrepeat;

    if ($password != $passwordrepeat) 
    {
        $response["status"] = "error";
        $response["message"] = "Las Contraseñas no coinciden.";
        echoResponse(201, $response);
    }
    else
    {
        $password = passwordHash::hash($password);      
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $sql = "INSERT INTO admin (Company, Phone, Email, Encrypted_Password) 
            VALUES ('$company', '$phone', '$email', '$password')";

            if ($conn->query($sql) === TRUE) 
            {
                $response["status"] = "success";
                $response["message"] = "Usuario Admin creado correctamente.";
                echoResponse(200, $response);
            } 
            else 
            {
                $response["status"] = "error";
                $response["message"] = "Error al registrar.";
                echoResponse(201, $response);
            }
        }
    }     
});

$app->post('/updateAdmin', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    $admin_id = $r->adminUser->admin_id;
    $company = $r->adminUser->company;
    $email = $r->adminUser->email;
    $phone = $r->adminUser->phone;
        
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE admin SET Company = '$company', Email='$email', Phone = '$phone' WHERE Admin_Id = '$admin_id'";
        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM admin WHERE Admin_Id = '$admin_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root actualizado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});


/*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*/
/*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*/
/*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*//*CRUD REQUEST*/

$app->post('/datosRequest', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $result = $conn->query("SELECT * FROM Request");
    $outp = "";

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"request_id":"'  . $rs["Request_Id"] . '",';
        $outp .= '"date":"'. $rs["Date"]     . '"}'; 
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});

$app->post('/detalleRequest', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $r = json_decode($app->request->getBody());
    $request_id = $r->request_id;

    $result = $conn->query("SELECT * FROM Request WHERE Request_Id = '$request_id'");
    
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
            $response["status"] = "success";
            $response["request_id"] = $rs['Request_Id'];
            $response["date"] = $rs['Date'];
  
            echoResponse(200, $response);
    }
});








/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/
/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/
/*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*//*CRUD ADMIN*/

$app->post('/datosAdmin', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $result = $conn->query("SELECT * FROM admin WHERE actv = 0");
    $outp = "";

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"admin_id":"'  . $rs["Admin_Id"] . '",';
        $outp .= '"company":"'  . $rs["Company"] . '",';
        $outp .= '"email":"'   . $rs["Email"]        . '",';
        $outp .= '"phone":"'. $rs["Phone"]     . '"}'; 
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});

$app->post('/detalleAdmin', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $r = json_decode($app->request->getBody());
    $admin_id = $r->admin_id;

    $result = $conn->query("SELECT * FROM admin WHERE Admin_Id = '$admin_id'");
    
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
            $response["status"] = "success";
            $response["admin_id"] = $rs['Admin_Id'];
            $response["company"] = $rs['Company'];
            $response["email"] = $rs['Email'];
            $response["phone"] = $rs['Phone'];
            echoResponse(200, $response);
    }
});

$app->post('/deleteAdmin', function() use ($app) 
{
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());
    $admin_id = $r->adminUser->admin_id;
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE admin SET actv = '500' WHERE Admin_Id = '$admin_id'";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM admin WHERE Admin_Id = '$admin_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root eliminado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});


$app->post('/paymentAdmin', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

        $response = array();
    $r = json_decode($app->request->getBody());

    $admin_id = $r->admin_id;

    $result = $conn->query("SELECT colony.Name, colony.Json_Admin, admin.Admin_Id FROM colony 
    INNER JOIN radio ON colony.Radio_Id = radio.Radio_Id
    INNER JOIN quadrant ON radio.Quadrant_Id = quadrant.Quadrant_Id
    INNER JOIN town ON quadrant.Town_Id = town.Town_Id 
    INNER JOiN admin ON town.Town_Id = admin.Town_Id WHERE admin.Admin_Id = $admin_id");
    $outp = "";


      

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {

        $json = $rs['Json_Admin'];
        $jadmin = json_decode($json);
        $jadminprice = $jadmin->{$admin_id};
        $jadminprice2 = $jadminprice->{'cost'};


        if ($outp != "") {$outp .= ",";}
        $outp .= '{"name":"'  . $rs["Name"] . '",';
        $outp .= '"admin_id":"'  . $rs["Admin_Id"] . '",';
        $outp .= '"json_admin":"'  . $jadminprice2 . '"}';


    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});


/*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*/
/*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*/
/*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*//*CRUD COLONY*/

$app->post('/datosColony', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

  


    $result = $conn->query("SELECT * FROM Price
        RIGHT JOIN Colony ON Colony.Colony_Id = Price.Colony_Id WHERE actv=0 ");
    $outp = "";




    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {



         if ($outp != "") {$outp .= ",";}
        $outp .= '{"Name":"'  . $rs["Name"] . '",';
        $outp .= '"uid":"'  . $rs["Colony_Id"] . '",';
         $outp .= '"price":"'  . $rs["price"] . '",';
       $outp .= '"price_id":"'  . $rs["Price_Id"] . '"}';
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});





$app->post('/detalleColony', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $r = json_decode($app->request->getBody());
    $uid = $r->uid;

    $result = $conn->query("SELECT * FROM Colony 
        INNER JOIN Price ON Colony.Colony_Id = Price.Colony_Id WHERE Colony.Colony_Id = '$uid'");
    
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
            $response["status"] = "success";
            $response["uid"] = $rs['Colony_Id'];
            $response["Name"] = $rs['Name'];
            $response["price"] = $rs['price'];
            $response["price_id"] = $rs['Price_Id'];
            echoResponse(200, $response);
    }

});



$app->post('/deleteColony', function() use ($app) 
{
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());
    //$uid = $r->colonyUser->uid;
    $uid = $r->uid->uid;
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE Colony SET actv = '500' WHERE Colony_Id = '$uid'";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM Colony WHERE Colony_Id = '$uid'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root eliminado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});


//pendiente
$app->post('/addColony', function() use ($app) 
{   
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    //$uid = $r->datosColony->uid;
    $Name = $r->datosColony->Name;
    $town_id = '5';
    $lat = '0.0';
    $lon = '0.0';
    $actv = '0';
    //$price = $r->colonyUser->price;
    //$price_id = $r->colonyUser->price_id;
         
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $sql = "INSERT INTO Colony (Name, Latitude, Longitude, Town_Id, actv) VALUES ('$Name', 0.0, 0.0, 5, 0)  ";
            if ($conn->query($sql) === TRUE) 
            {
                $response["status"] = "success";
                $response["message"] = "Usuario Colony creado correctamente.";
                echoResponse(200, $response);
            } 
            else 
            {
                $response["status"] = "error";
                $response["message"] = "Error al registrar.";
                echoResponse(201, $response);
            }
        }
        
});




$app->post('/updateColony', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    $uid = $r->colonyUser->uid;
    $Name = $r->colonyUser->Name;
    $price = $r->colonyUser->price;
    $price_id = $r->colonyUser->price_id;

        
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE Colony, Price SET Colony.Name = '$Name', Price.price = '$price'

 WHERE Colony.Colony_Id = '$uid' and Price.Colony_Id = '$uid'";


        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM Colony WHERE Colony.Colony_Id = '$uid'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Cabbie actualizado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});


/*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*/
/*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*/
/*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*//*CRUD CABBIE*/

$app->post('/datosCabbie', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $result = $conn->query("SELECT Cabbie.Cabbie_Id, Cabbie.Name, Cabbie.Phone, Cabbie.Contract, Admin.Company FROM Cabbie INNER JOIN Admin ON Cabbie.Admin_Id = Admin.Admin_Id WHERE Cabbie.actv = 0");
    $outp = "";

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"cabbie_id":"'  . $rs["Cabbie_Id"] . '",';
        $outp .= '"name":"'  . $rs["Name"] . '",';
        $outp .= '"phone":"'  . $rs["Phone"] . '",';
        $outp .= '"contract":"'   . $rs["Contract"]        . '",';
        $outp .= '"company":"'. $rs["Company"]     . '"}'; 
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});

$app->post('/listaCompany', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $result = $conn->query("SELECT Admin_Id, Company FROM Admin  WHERE actv = 0");
    $outp = "";

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"admin_id":"'  . $rs["Admin_Id"] . '",';
        $outp .= '"company":"'. $rs["Company"]     . '"}'; 
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});

$app->post('/detalleCabbie', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $r = json_decode($app->request->getBody());
    $cabbie_id = $r->cabbie_id;

    $result = $conn->query("SELECT Cabbie.Cabbie_Id, Cabbie.Name, Cabbie.Phone, Cabbie.Contract, Admin.Company 
        FROM cabbie 
        INNER JOIN admin ON cabbie.Admin_Id = admin.Admin_Id 
        WHERE Cabbie_Id = '$cabbie_id'");
    
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
            $response["status"] = "success";
            $response["cabbie_id"] = $rs['Cabbie_Id'];
            $response["name"] = $rs['Name'];
            $response["phone"] = $rs['Phone'];
            $response["contract"] = $rs['Contract'];
            $response["company"] = $rs['Company'];
            echoResponse(200, $response);
    }
});

$app->post('/updateCabbie', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    $cabbie_id = $r->cabbieUser->cabbie_id;
    $name = $r->cabbieUser->name;
    $contract = $r->cabbieUser->contract;
    $phone = $r->cabbieUser->phone;
    $company = $r->cabbieUser->company;

    //$admin_id = $r->cabbieUser->admin_id;

        
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE Cabbie SET Cabbie.Name = '$name', Cabbie.Phone = '$phone',  Cabbie.Contract = '$contract', Cabbie.Admin_Id = '$company'
        WHERE Cabbie.Cabbie_Id = '$cabbie_id'";

        

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM Cabbie WHERE Cabbie.Cabbie_Id = '$cabbie_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Cabbie actualizado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});

$app->post('/deleteCabbie', function() use ($app) 
{
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());
    $cabbie_id = $r->datosCabbie->cabbie_id;
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE Cabbie SET actv = '500' WHERE Cabbie_Id = '$cabbie_id'";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM Cabbie WHERE Cabbie_Id = '$cabbie_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root eliminado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});


//pendiete
$app->post('/addCabbie', function() use ($app) 
{   
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());

    //$uid = $r->datosCabbie->uid;
    $name = $r->datosCabbie->name;
    $phone = $r->datosCabbie->phone;
    $contract = $r->datosCabbie->contract;
    $company = $r->datosCabbie->company;
         
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            $sql = "INSERT INTO Cabbie (Name, Phone, Contract, Admin_Id) VALUES ('$name','$phone','$contract','$company') ";
            if ($conn->query($sql) === TRUE) 
            {
                $response["status"] = "success";
                $response["message"] = "Usuario Cabbie creado correctamente.";
                echoResponse(200, $response);
            } 
            else 
            {
                $response["status"] = "error";
                $response["message"] = "Error al registrar.";
                echoResponse(201, $response);
            }
        }
        
});


/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/
/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/
/*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*//*CRUD ROOT*/


$app->post('/datosRoot', function() 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $result = $conn->query("SELECT * FROM root WHERE actv = 0");
    $outp = "";

    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"uid":"'  . $rs["uid"] . '",';
        $outp .= '"name":"'  . $rs["name"] . '",';
        $outp .= '"email":"'   . $rs["email"]        . '",';
        $outp .= '"phone":"'. $rs["phone"]     . '"}'; 
    }
    $outp ='{"status":"success","records":['.$outp.']}';
    echo $outp;
});

$app->post('/detalleRoot', function() use ($app) 
{
    $conn = NULL;
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $r = json_decode($app->request->getBody());
    $uid = $r->uid;

    $result = $conn->query("SELECT * FROM Root WHERE uid = '$uid'");
    
    while($rs = $result->fetch_array(MYSQLI_ASSOC)) 
    {
            $response["status"] = "success";
            $response["uid"] = $rs['uid'];
            $response["name"] = $rs['name'];
            $response["email"] = $rs['email'];
            $response["phone"] = $rs['phone'];
            echoResponse(200, $response);
    }

});

$app->post('/deleteRoot', function() use ($app) 
{
    require_once 'dbConnect.php';
    $db = new dbConnect();
    $conn = $db->connect();

    $response = array();
    $r = json_decode($app->request->getBody());
    $uid = $r->rootUser->uid;
    
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else
    {
        $sql = "UPDATE Cabbie SET actv = '500' WHERE Cabbie_Id = '$cabbie_id'";

        if ($conn->query($sql) === TRUE) 
        {
            $sql = "SELECT * FROM Cabbie WHERE Cabbie_Id = '$cabbie_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $response["status"] = "success";
                    $response["message"] = "Usuario Root eliminado correctamente.";
                    echoResponse(200, $response);
                }
            }
        } 
        else 
        {
            $response["status"] = "error";
            $response["message"] = "Error al registrar.";
            echoResponse(201, $response);
        }
    }
});




?>

