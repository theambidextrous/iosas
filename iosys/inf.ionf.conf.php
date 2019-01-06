<?php 
error_reporting(0);
//<<=================definition of Ks =================================== >>>
define("SYS_PATH", "http://127.0.0.1/iosas/");
define("SYS_DASHBOARD", SYS_PATH."ioinner/");
define("SYS_ADDRESS", "Bruce house, 4th Flr, NRB KE");
define("SYS_SITE", "IOSAS High School");
define("SYS_NAME", "IOSAS");
define("SYS_CONTACTS", "Call: 0705007984/0779301840");
define("SYS_SITE_PHONE", "0705007984");
define("SYS_SITE_EMAIL", "apis@bytebladesystems.com");
define("SYS_DEVELOPER", "Byteblade Systems Inc");
define("SYS_PUBLIC_WEBPAGE", SYS_PATH."iosaspub");
define("SYS_LOGO", SYS_PATH."public/images/logo.svg");
define("SYS_SITE_LOGO", SYS_PATH."public/custom/logo.png");
//<<< ========  databse settings ================================== >>>>
//2. sys db
define("DB_HOST", "127.0.0.1");
define("DB", "iosas");
define("DB_USER", "iosas");
define("DB_PASS", "zKoffds5MuVp[1V");
//2. sys db2//alternative db if any e.g. remote server
define("RDB_HOST", "your_host_address");
define("RDB", "your_db_name");
define("RDB_USER", "your_db_user");
define("RDB_PASS", "your_db_user_password");
//3. MAILERL settings == letsset to SMTP
define("SMTP_HOST", "bytebladesystems.com");
define("SMTP_PORT", "587");
define("SMTP_USER", "apis@bytebladesystems.com");
define("SMTP_PASSWORD", "Greys_anatomy@2017"); 
//4. PAYMENT
define("JENGA_URL", "https://sandbox.epay.io/");
define("JENGA_USERNAME", "0582910862");//merchant code
define("JENGA_PASSWORD", "vLcQDQwDYF1hOU9Xiq3O16DGtJgBlIcT");//merchant key
define("JENGA_AUTH_TOKEN", "Basic QWEzY0dxRVpWOVo5dDFVSnhTR3BwZUF4WEZrcFFyYUk6cU5BYWs5YXcyVDNtSW1uMg=="); // basic authorization bearer
define("MERCHANT_OUTLET_CODE", "0000000000");
define("JENGA_EXP_URL","https://api-test.equitybankgroup.com/v2/checkout/launch");

//CUSTOM UPLOADS
//1. images
define("IMAGES_URL", SYS_PATH."/specimen/imgs/");
// 2. docs
define("DOCS_URL", SYS_PATH."/specimen/docs/");
//3. reports
define("REPORTS_URL", SYS_PATH."/specimen/rpts/");
//system logic functions
function clearApostrophe($data){
    if(is_array($data)){
        $new_data = [];
        foreach( $data as $d ):
            array_push($new_data, str_replace("'", "", $d));
        endforeach;

        return $new_data;
    }else{
        return str_replace("'", "", $data);
    }
}

function hashPassword($pass) {
	return password_hash($pass, PASSWORD_DEFAULT);
}

function verifyPassword($userinput, $password){
    if(password_verify($userinput, $password)){
        return true;
    }else{
        return false;
    }
}
function getAutoIncreament($table){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".DB."' AND   TABLE_NAME   = '$table'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['AUTO_INCREMENT'];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function hasPdoErr($returned){
    if (strpos($returned, 'Error:') !== false) {
        //has error
        return true;
    }else{
        //has no error
        return false;
    }
}
function createNewSysUsers($data){
    //username,email,pasword,school
    $pass = hashPassword($data[2]);
    $data_set = array($data[3], $data[1]);
    $resp = createNewUsers($data_set);
    if(!hasPdoErr($resp)){
        if($resp == 1){
            $user_id = getAutoIncreament('users') - 1;
            try {
                $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
                $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $io->prepare("INSERT INTO `sys_users`(`username`, `password`, `user_id`) VALUES ('$data[0]', '$pass', '$user_id')");
                    if($stmt->execute()){
                        //notify via sms/email
                        return 1;
                    }else{
                        return 0;
                    }
                }
                catch(PDOException $e) {
                return "Error: " . $e->getMessage();
                }
        }elseif($resp == 0){
            return 0;
        }
    }else{
        return $resp;
    }
    $io = null;
}
function createNewUsers($data){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `users`(`school_id`, `email`) VALUES ('$data[0]', '$data[1]')");
            if($stmt->execute()){
                return 1;
            }else{
                return 0;
            }
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getSchoolName($id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `name` FROM `schools` WHERE `id` = '$id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['name'];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getCurrentUserPermissions($id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `name`, `access` FROM `user_types` WHERE `access_code` = '$id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getUserType($id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `user_type` FROM `sys_users` WHERE `id` = '$id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['user_type'];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getCurrentUserDetails($id, $school = 2){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `user_id`, `school_id`, `fname`, `mname`, `lname`, `email`, `phone`, `alt_phone`, `country`, `county`, `sub_county`, `constituency`, `location_ward`, `village`, `disabilities`, `status`, `created`, `updated` FROM `users` WHERE `user_id` = '$id' AND `school_id` = '$school'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getEnrollChange($now, $then){
    if($now > $then ){
        return $increase = '<i style="font-size:x-large;color:green;" class="mdi mdi-menu-up menu-icon"> </i> '.number_format( ((($now-$then)*100)/$then), 2 )."%";
    }else{
        return $decrease = '<i style="font-size:x-large;color:red;" class="mdi mdi-menu-down menu-icon"> </i> '.number_format( ((($then-$now)*100)/$then), 2 )."%";
    }
}
function getUserGroup( $t = 4444, $w = 1, $school = 2){
    $ids = [];
    try {
    $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($w == 1){
        $stmt = $io->prepare("SELECT `user_id` FROM `sys_users` WHERE `user_type` = '$t'");
    }elseif ($w == 2) {
        $when = date('Y');//current year
        $stmt = $io->prepare("SELECT `user_id` FROM `sys_users` WHERE `user_type` = '$t' AND `created` LIKE '%$when%' ");
    }else {
        $when = date('Y', strtotime('Now - 1 year'));//previvious year
        $stmt = $io->prepare("SELECT `user_id` FROM `sys_users` WHERE `user_type` = '$t' AND `created` LIKE '%$when%' ");
    }
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($result = $stmt->fetchAll()){
    array_push($ids, $result);
    }
    $ids[0] = !empty($ids[0])?$ids[0]:array();
    $group = [];
    foreach( $ids[0] as $i ):
        if(!empty(getCurrentUserDetails($i['user_id'],$school))){
            array_push($group, getCurrentUserDetails($i['user_id'],$school));
        }
    endforeach;
    return $group ;
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function authenticate_user($username, $password, $school){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `user_id`,`password` FROM `sys_users` WHERE `username` = '$username' AND `status` = 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $user_id = $result[0]['user_id'];
        $stored_password = $result[0]['password'];
            if(  verifyPassword($password, $stored_password) ){
                session_start();
                $_SESSION['USRID'] = $user_id;
                $_SESSION['SCH'] = $school;
                $_SESSION['USNM'] = $username;
                header("Location: ioinner/");
            }else{
                return 0;
            }
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function ValidateEmail($email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       return false; 
      }else{
          return true;
      }
}
function flash($msg, $type = 1){
    if($type == 1){
        print '<div class="alert alert-success">'.$msg.'</div>';
    }else{
        print '<div class="alert alert-danger">'.$msg.'</div>';
    }
}
function subscribed_school(){
    $schools = [];
     try {
     $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
     $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $io->prepare("SELECT * FROM `schools` WHERE 1");
     $stmt->execute();
     $stmt->setFetchMode(PDO::FETCH_ASSOC);
     while($result = $stmt->fetchAll()){
     array_push($schools, $result);
     }
     return array_reverse($schools[0]);
     }
     catch(PDOException $e) {
     return "Error: " . $e->getMessage();
     }
     $io = null;
 }
function getAdmitOneScreenings(){
    $films = [];
     try {
     $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
     $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $io->prepare("SELECT * FROM `movies` WHERE `comment` = 'current'");
     $stmt->execute();
     $stmt->setFetchMode(PDO::FETCH_ASSOC);
     while($result = $stmt->fetchAll()){
     array_push($films, $result);
     }
     return array_reverse($films[0]);
     }
     catch(PDOException $e) {
     return "Error: " . $e->getMessage();
     }
     $io = null;
 }
function EventSettings(){
    $settings = array(
        array(
            "setting_name"=>"Ticket Counter",
            "name"=>"Show ticket counter",
            "value"=>"",
            "default_value"=>"Y"
            ),
        array(
            "setting_name"=>"Commission",
            "name"=>"Commission charged in %",
            "value"=>"",
            "default_value"=>"10"
            ),
        array(
            "setting_name"=>"Ticket Bg",
            "name"=>"Set Ticket Background Image",
            "value"=>"",
            "default_value"=> SYS_URL."images/tkt-bg/tkt.jpg"
            )
        );
        return $settings;
}
function curr_order($event, $date, $time, $tickets, $totals, $img = ''){
	$myorder = '
    <div class="modal" id="myModal">
  <div class="modal-dialog" style="background-color: #032642;color: #fff;">
    <div class="modal-content" style="background-color: #032642;color: #fff;">
            <div class="modal-header" style="background-color: #000;color: #fff;">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="fa fa-remove"></span></a>
                <h3 class="modal-title">Order Confirmation</h3>
            </div>
            <div class="modal-body" style="background-color: #032642;color: #fff;">
                <div class="row">
                <div class="col-md-12">
                    <h2><span>'.$event.'</span></h2>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6 product_img">
                        <img src="'.$img.'" class="img-responsive">
                    </div>
                    <div class="col-md-6 product_content">
                        <h3>Order Details: <b>'.$tickets.'</b></h3>
                        <h3 class="cost">Cost: KES '.$totals.' </h3>
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                            <h3>Date: <b>'.$date.'</b></h3>
                            </div>
                            <!-- end col -->
                            <div class="col-md-12 col-sm-6 col-xs-12">
                            <h3>Time: <b>'.$time.'</h3></p>
                            </div>
                            <!-- end col -->
                        </div>
                        <div class="space-ten"></div>
                        <div class="btn-ground">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" ><span class="fa fa-thumbs-up"></span> Yes, That\'s it</button>
                            <a href="'.SYS_URL.'" class="btn btn-primary"><span class="fa fa-thumbs-down"></span> It\'s Not! </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	';
	return $myorder;
}
function updateVistaUser($params){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("UPDATE `root` SET `root_pass` = '$params[0]' WHERE `root_id` = '$params[1]'");
        if($stmt->execute()){
            return true;
        }
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getVistaUser($id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `root` WHERE `root_id` = '$id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0];
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function updateVistaMvs($params){
    try {
        $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("UPDATE `vista_films_info` SET `thumb`='$params[0]',`poster`='$params[1]',`trailer`='$params[2]' WHERE film_id = '$params[3]'");
        if($stmt->execute()){
            return true;
        }
        }
        catch(PDOException $e) {
        return "Error: " . $e->getMessage();
        }
        $io = null;
}
function getSalesAdmitlogs(){
    $errors = [];
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT * FROM `payment_logs` WHERE type='processed' AND api_error !='' ORDER BY ID DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($result = $stmt->fetchAll()){
    array_push($errors, $result);
    }
    return $errors[0];
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function lastSalesAccounting($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT MIN(purchase_date) AS OldDate FROM movie_bookings WHERE account_period=1 AND cinema ='$cin'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['OldDate'];
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getTicketComplementSales($id){
    try {
    $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare(" SELECT `complement_tikcet` FROM `events_ticket_types` WHERE `id` = '$id' ");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    $comple_tkt =  $result[0]['complement_tikcet'];
    //get reservation now that we have comp tkt 
    $stmt = $io->prepare("SELECT SUM(`reserved_ticket_no`) as sm FROM `events_reservations` WHERE `reserved_ticket_type` = '$comple_tkt' AND `reservation_status` = 1 AND `r_type` = 1");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    $sum =  $result[0]['sm'];
    return $sum;
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getSalesRecords($cin){
    $records = [];
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT * FROM `movie_bookings` WHERE account_period=1 AND cinema = '$cin' ORDER BY ID ASC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($result = $stmt->fetchAll()){
    array_push($records, $result);
    }
    return $records[0];
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getAdminUsers(){
    $records = [];
    try {
    $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT * FROM `root`");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($result = $stmt->fetchAll()){
    array_push($records, $result);
    }
    return $records[0];
    }
    catch(PDOException $e) {
    return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getSalesSum($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(ticket_value) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getvTotalCom($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(comm) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getvBladeCom($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(blade_comm) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getvCallitCom($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(callit_comm) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getvDpoCom($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(Dpo) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getvVistaCom($cin){
    try {
    $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
    $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $io->prepare("SELECT SUM(Vista) AS total FROM movie_bookings WHERE account_period=1 AND cinema ='$cin' AND status = 'Booked'");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0]['total'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function QueryRemote($token){
    $url="https://patahapa.com/formke.php?TKN=".$token;
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    //print_r(curl_getinfo($ch));
    return $output;
}
// payment funcs
function toarray($json){
    return json_decode($json, true);
}

function tojson($str){
    return json_encode($str);
}
function OrderExpiry($string = 'next week'){
    //sample 2022-01-01T00:00:00 , showing 2018-10-01T07:48:07+00:00
    $datetime = new DateTime($string);
    return mb_substr($datetime->format('c'), 0, 19);
}
function CreateSignature($token = 0){
    return 'huKUSJ1mKy67ptMCDHgSADgPmN8h6Wm5ZYKfLoTJSHWDtA+i2Ra1e3Wc12Pp3Z/Nk+g2JcTGrvWPVw3BCae9QiFI8YpU+GPvezIOmOJvZupo09khePH2nz8TZGKuR6mRhcXd1RNc4dnE6UQbAeqpqPoXbJwOA+02RtfhSDJeLao9bRat4vGWTAlWe/T+mgzMvudeeIpToZLMvBtUVVlLuZFyQb0GeeW9YOghEqfgyzC+6Gpjtg9lnZfDDdAc3fFnGSZ3S0hgaalK94RZSNuF/7OCFKHm5Rv2Q+X91YSqL3Ka3YKkiDfS8kE2w0/8GsWp5WrZo/n3NUTkFonVvucb6w==';
    //return hash('sha256', $token);
}
function BillPostData($params){
    $body = array(
        "order"=>array(
            "amount"=>$params[0],
            "description"=>$params[1],
            "reference"=>$params[2],
            "expiry"=>$params[3],
            "customer"=>array("name"=>$params[4]),
            "account"=>MERCHANT_OUTLET_CODE)
    );
    return tojson($body);
}
function PaymentPostDataCard($params){
    $body = array(
        "payment"=>array(
            "billAmount"=>$params[0],
            "orderReference"=>$params[1],
            "orderCurrency"=>$params[2],
            "orderChannel"=>$params[3],
            "billReference"=>$params[4],
            "description"=>$params[5],
            "businessNumber"=>$params[6],
            "date"=>OrderExpiry('now'),
            "card"=>array(
                "number"=>$params[7],
                "expiry"=>$params[8],
                "securityCode"=>$params[9]
                ),
            "customer"=>array(
                "name"=>$params[10]
                )
        )
    );
    return tojson($body);
    }
function PaymentPostDataMobile($params){
    $body = array(
        "payment"=>array(
            "billAmount"=>$params[0],
            "orderReference"=>$params[1],
            "orderCurrency"=>$params[2],
            "orderChannel"=>$params[3],
            "billReference"=>$params[4],
            "businessNumber"=>$params[5],
            "description"=>$params[6],
            "date"=>OrderExpiry('now'),
            "customer"=>array(
                "name"=>$params[7],
                "mobileNumber"=>$params[8], // 0763xxx
                "countryCode"=>$params[9]
                )
        )
    );
    return tojson($body);
}
function getAccessToken(){
    $form = 'username='.JENGA_USERNAME.'&password='.JENGA_PASSWORD;
    $url = JENGA_URL.'identity-test/v2/token';
    $headers = array();
    $headers[] = 'Authorization: '.JENGA_AUTH_TOKEN;
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $form);
    curl_setopt($curl, CURLOPT_POST,true);
    $res = curl_exec($curl);
    return 'Bearer '.toarray($res)['access_token'];
}
function getAccessTokenExp(){
    $form = 'username='.JENGA_USERNAME.'&password='.JENGA_PASSWORD;
    $url = JENGA_URL.'identity-test/v2/token';
    $headers = array();
    $headers[] = 'Authorization: '.JENGA_AUTH_TOKEN;
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $form);
    curl_setopt($curl, CURLOPT_POST,true);
    $res = curl_exec($curl);
    return toarray($res)['access_token'];
}
function CreateBill($params){
    $form = BillPostData($params);
    $url = JENGA_URL.'transaction-test/v2/payments-createbill';
    $headers = array();
    $headers[] = 'Authorization: '.getAccessToken();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'signature: '.CreateSignature();
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $form);
    curl_setopt($curl, CURLOPT_POST,true);
    $res = curl_exec($curl);
    return toarray($res);
}
function MakePaymentCard($params){
    $form = PaymentPostDataCard($params);
    $url = JENGA_URL.'transaction-test/v2/payments-card';
    $headers = array();
    $headers[] = 'Authorization: '.getAccessToken();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'signature: '.CreateSignature();
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $form);
    curl_setopt($curl, CURLOPT_POST,true);
    $res = curl_exec($curl);
    return toarray($res);
}
function MakePaymentMobile($params){
    $form = PaymentPostDataMobile($params);
    $url = JENGA_URL.'transaction-test/v2/payments-eazzypush';
    $headers = array();
    $headers[] = 'Authorization: '.getAccessToken();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'signature: '.CreateSignature();
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $form);
    curl_setopt($curl, CURLOPT_POST,true);
    $res = curl_exec($curl);
    return toarray($res);
}
function QueryPayment($billReference){
    $url = JENGA_URL.'transaction-test/v2/query?billReference='.$billReference;
    $headers = array();
    $headers[] = 'Authorization: '.getAccessToken();
    $headers[] = 'Content-Type: application/json';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPGET,true);
    $res = curl_exec($curl);
    return toarray($res);
}
function QueryBill($bill_id){
    $url = JENGA_URL.'transaction-test/v2/bills/'.$bill_id;
    $headers = array();
    $headers[] = 'Authorization: '.getAccessToken();
    $headers[] = 'Content-Type: application/json';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPGET,true);
    $res = curl_exec($curl);
    return toarray($res);
}
function JengaExpressCheckout($params){
    echo '<form 
    id="eazzycheckout-payment-form"
    action="'.JENGA_EXP_URL.'" method="POST">
    <input type="hidden" value="'.$params[0].'" id="token" name="token">
    <input type="hidden" value="'.$params[1].'" id="amount" name="amount">
    <input type="hidden" value="'.$params[2].'" id="orderReference" name="orderReference">
    <input type="hidden" value="'.$params[3].'" id="merchantCode" name="merchantCode">
    <input type="hidden" value="'.$params[4].'" id="outletCode" name="outletCode">
    <input type="hidden" value="'.$params[5].'" id="popupLogo" name="popupLogo">
    <input type="hidden" value="'.$params[6].'" id="ez1_callbackurl" name="ez1_callbackurl">
    <input type="hidden" value="'.$params[7].'" id="ez2_callbackurl" name="ez2_callbackurl">
    <input type="hidden" value="'.$params[8].'" id="expiry" name="expiry">
    <input type="submit" id="submit-cg" role="button" class="btn btn-primary col-md-4"
       value="Checkout"/>
    </form>';
}
function getEventCategories(){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_categories` WHERE 1 ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        return $events;
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvents($limit = 8, $not = 0, $special = 0){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if( $not == 0 && $limit == 0 && $special == 0){
            $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1");
        }elseif($special == 1){
            $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` >= 0");
        }else{
            $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1 AND `id` != $not LIMIT $limit");
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        return array_reverse($events[0]);
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getOwnerEvents($owner){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1 AND `event_owner_id` = '$owner' ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        if(!empty($events[0])){
            return array_reverse($events[0]);
        }else{
            return array();
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventOwners(){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_owners` WHERE `isOwner` = 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        if(!empty($events[0])){
            return array_reverse($events[0]);
        }else{
            return array();
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getUserEvents($user, $limit){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1 AND `event_owner_id` = $user LIMIT $limit");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        return array_reverse($events[0]);
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventID($name){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT id FROM `events` WHERE `name` = '$name' ");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['name'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventCount(){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT COUNT(name) as ename FROM `events` WHERE `event_status` = 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['ename'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getPendingResvCount(){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT count(id) as rcount FROM `events_reservations` WHERE reservation_status = 0");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['rcount'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventSumSales($event_id = 0){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if( $event_id == 0){
            $stmt = $io->prepare("SELECT SUM(cost) as sum FROM `events_pending_bookings` WHERE isProcessed = 1 AND isVerified = 1 AND isError = 0");
        }else{
            $stmt = $io->prepare("SELECT SUM(cost) as sum FROM `events_pending_bookings` WHERE `event` = '$event_id' AND isProcessed = 1 AND isVerified = 1 AND isError = 0");
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['sum'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvents_Bookings($event = 0, $type = 2){
    $bookings = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if( $type == 2){
            $stmt = $io->prepare("SELECT * FROM `events_pending_bookings` WHERE `b_type` = 2 AND `isProcessed` = 1 AND `isVerified` = 1 AND `event_id` = '$event' ");
        }elseif($type == 1){
            $stmt = $io->prepare("SELECT * FROM `events_pending_bookings` WHERE `b_type` = 1 AND `isProcessed` = 1 AND `isVerified` = 1 AND `event_id` = '$event' ");
        }else{
            $stmt = $io->prepare("SELECT * FROM `events_pending_bookings` WHERE `isProcessed` = 1 AND `isVerified` = 1 AND `event_id` = '$event' ");
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($bookings, $result);
        }
        return array_reverse($bookings[0]);
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function ShowAnalyticsCode(){
    echo "
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-126891100-1\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-126891100-1');
</script>
";
}
function getSliderEvents($id = 0){
    $events = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       if( $id == 0){
        $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1");
       }else{
        $stmt = $io->prepare("SELECT * FROM `events` WHERE `event_status` = 1 AND `id` = $id");
       }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($events, $result);
        }
        return array_reverse($events[0]);
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvents_handles($event_id){
    $handles = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_social_handles` WHERE `event_id` = '$event_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($handles, $result);
        }
        if(isset($handles[0][0])){
            return $handles[0][0];
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvent_details($event_id){
    $data = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events` WHERE `id` = '$event_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($data, $result);
        }
        if(isset($data[0][0])){
            return $data[0][0];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getOrder_details($id){
    $data = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_pending_bookings` WHERE `id` = '$id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($data, $result);
        }
        if(isset($data[0][0])){
            return $data[0][0];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventOwner($event_id){
    $ownerid = '';
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `event_owner_id` FROM `events` WHERE `id` = '$event_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0]['event_owner_id'])){
            $ownerid = $result[0]['event_owner_id'];
        }
        ///owners
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `owner`, `owner_contact` FROM `events_owners` WHERE `id` = '$ownerid' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0])){
            return array( $result[0]['owner'], $result[0]['owner_contact']);
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEventName($event_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `name` FROM `events` WHERE `id` = '$event_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0]['name'])){
            return $result[0]['name'];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getMaxId($table){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT MAX(id) as eid FROM $table WHERE 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0]['eid'])){
            return $result[0]['eid']+1;
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getFileExt($file){
    return strtolower(pathinfo($file,PATHINFO_EXTENSION));
}
function FormatTickets($order){
    $final = [];
    foreach( $order as $k => $v):
        if(!empty($v)){
            array_push( $final, getTicketName($k).":".$v);
        }
    endforeach;
    //comma sept
    return implode(", ",$final);
}
function getTicketName($ticket_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `ticket_type_name` FROM `events_ticket_types` WHERE `id` = '$ticket_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0]['ticket_type_name'])){
            return $result[0]['ticket_type_name'];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function CheckReservedTickets($user, $event_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT COUNT(`event_id`) as cnt FROM `events_reservations` WHERE `event_id` = '$event_id' AND `reserving_user` = '$user' AND `total_cost` > 0 AND `reservation_status` = 0");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if(isset($result[0]['cnt'])){
            return $result[0]['cnt'];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvent_venue($venue_id){
    $data = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_venues` WHERE `id` = '$venue_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($data, $result);
        }
        if(isset($data[0][0])){
            return $data[0][0];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvent_owner($owner_id){
    $data = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_owners` WHERE `id` = '$owner_id' limit 1");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($data, $result);
        }
        if(isset($data[0][0])){
            return $data[0][0];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getEvent_ticket_types($event_id, $type= 0){
    $data = [];
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT * FROM `events_ticket_types` WHERE `event_id` = '$event_id' AND `type` = '$type'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($result = $stmt->fetchAll()){
        array_push($data, $result);
        }
        if(isset($data[0])){
            return $data[0];
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
//offline
function RecordOrderLocalOff($params, $eventid = 0){
    //remove duplicate
    RemoveDuplicateOrder($params[5]);
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `events_pending_bookings`(`event_id`, `customer_order`, `customer`, `customer_email`, `customer_phone`, `cost`, `payment_token`, `b_type`) VALUES ('$eventid', '$params[0]', '$params[1]', '$params[2]', '$params[3]','$params[4]','$params[5]', 1)");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function FormatTicketsOffline($order){
    $final = [];
    foreach( $order as $k => $v):
        if($v > 0 ){
            array_push( $final, getTicketName($k).":".$v);
        }
    endforeach;
    //comma sept
    return implode(", ",$final);
}
function HideOldEvents(){
    try {
        $today = date("Y-m-d", strtotime("Today"));
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("UPDATE `events` SET `event_status`= 0 WHERE `event_end_date` < '$today'");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function Reserve_ticketsOff($params){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `events_reservations`(`event_id`, `reserving_user`, `reserved_ticket_type`, `reserved_ticket_no`, `total_cost`, `r_type`) VALUES ('$params[0]','$params[1]','$params[2]','$params[3]','$params[4]', 1)");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function getTicket_Price($ticket_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT ticket_type_price FROM `events_ticket_types` WHERE `id` = '$ticket_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['ticket_type_price'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getTicket_Qty($event_id, $ticket_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT ticket_type_available_qty FROM `events_ticket_types` WHERE `id` = '$ticket_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['ticket_type_available_qty'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function getTicket_Type_Status_online($ticket_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `ticket_status_type` FROM `events_ticket_types` WHERE `id` = '$ticket_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        if($result[0]['ticket_status_type'] == 3){
            $return = array($result[0]['ticket_status_type'], '<h3><center style="color:red;">Online selling closed, get tickets at the venue</center></h3>');
            return $return;
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function updateEventTicketTypeStatus($event_id, $ticket_id, $timer = 90){
    //test 10910 vs 45
    if(getEeventShowTime($event_id, $timer)){
        try {
            $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
            $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $io->prepare("UPDATE `events_ticket_types` SET `ticket_status_type` = 3 WHERE `id` = '$ticket_id'");
            $stmt->execute();
        }
        catch(PDOException $e) {
            echo "error occured";
            return "Error: " . $e->getMessage();
        }
        $io = null;
    }
}
function getEeventShowTime($event_id, $timer){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `event_date`, `event_time` FROM `events` WHERE `id` = '$event_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        //event date = 2018-11-23 00:00:00
        $today = date("Y-m-d", strtotime("Today"));
        $eventday = date("Y-m-d", strtotime($result[0]['event_date']));
        if($today == $eventday){
            $now = date("h:i a", strtotime('now'));
            $now = strtotime($now);
            $event_time = strtotime($result[0]['event_time']);
            $return = ($event_time-$now)/60;
            if($return <= $timer){
                //online sales should be closed
                return true;
            }else{
                 //online sales should not be closed
                return false;
            }
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function Is_Souldout($event_id, $ticket_id){
    if( (getTicket_Qty($event_id, $ticket_id) - getTickets_Reserved($event_id, $ticket_id)) <= 0 ){
        return true;
    }else{
        return false;
    }
}
function getTickets_Reserved($event_id, $ticket_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT sum(reserved_ticket_no) as sum FROM `events_reservations` WHERE `event_id` = '$event_id' AND `reserved_ticket_type` = '$ticket_id'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        $return = $result[0]['sum'] + getTicketComplementSales($ticket_id);
        return $return;
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function Reserve_tickets($params){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `events_reservations`(`event_id`, `reserving_user`, `reserved_ticket_type`, `reserved_ticket_no`, `total_cost`) VALUES ('$params[0]','$params[1]','$params[2]','$params[3]','$params[4]')");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function cleanDuplic_Rsv($user, $event_id){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("DELETE FROM `events_reservations` WHERE `reserving_user` = '$user' AND `event_id` = '$event_id' AND `reservation_status` = 0 ");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function ClearOldReservations(){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("DELETE FROM `events_reservations` WHERE `reservation_status` = 0 AND `logged`  < (NOW() - INTERVAL 15 MINUTE)");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function RemoveDuplicateOrder($payment_token){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("DELETE FROM `events_pending_bookings` WHERE `payment_token` = '$payment_token'");
        if($stmt->execute()){
            return true;
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function RemoveDuplicateOrderRemote($TransactionToken){
    try {
        $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("DELETE FROM `pending_bookings` WHERE `TransactionToken` = '$TransactionToken'");
        if($stmt->execute()){
            print_r($stmt->execute());
        }else{
            print_r($stmt->execute());
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function RecordOrderLocal($params, $eventid = 0){
    //remove duplicate
    RemoveDuplicateOrder($params[5]);
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `events_pending_bookings`(`event_id`, `customer_order`, `customer`, `customer_email`, `customer_phone`, `cost`, `payment_token`) VALUES ('$eventid', '$params[0]', '$params[1]', '$params[2]', '$params[3]','$params[4]','$params[5]')");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function IsBooked($params){
    //remove duplicate
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("UPDATE `events_reservations` SET `reservation_status` = 1 WHERE `event_id` = '$params[0]' AND `reserving_user` = '$params[1]' ");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function SetToOldRecord($date, $action = 0){
    //2018-11-01
    $udate = date("Y-m-d", strtotime($date));
    try {
        $io = new PDO("mysql:host=".RDB_HOST.";dbname=".RDB."", RDB_USER, RDB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($action == 0){
            $stmt = $io->prepare(" UPDATE `movie_bookings` SET `account_period`= 0 WHERE purchase_date < '$udate' ");
        }else{
            $stmt = $io->prepare(" UPDATE `movie_bookings` SET `account_period`= 1 WHERE purchase_date LIKE '%$udate%' ");
        }
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function IsVerified($TransactionToken, $params){
    //remove duplicate
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("UPDATE `events_pending_bookings` SET `search_code` = '$params[0]',`serial_code` = '$params[1]',`event` = '$params[2]',`venue` = '$params[3]',`Date` = '$params[4]', `isProcessed` = 1,`isVerified` = 1 WHERE `payment_token` = '$TransactionToken' ");
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    catch(PDOException $e) {
        return false;
    }
    $io = null;
}
function getOrderID($TransactionToken){
    try {
        $io = new PDO("mysql:host=".DB_HOST.";dbname=".DB."", DB_USER, DB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("SELECT `id` FROM `events_pending_bookings` WHERE `payment_token`= '$TransactionToken'");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0]['id'];
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function RecordOrderRemote($TransactionToken){
    //remove duplicate
    RemoveDuplicateOrderRemote($TransactionToken);
    //record new
    $params = array("Form Ticketing", "0700000000", "info@form.ke","FMTKNG", $TransactionToken);
    try {
        $io = new PDO("mysql:host=".RDB_HOST.";port=".RDB_PORT.";dbname=".RDB."", RDB_USER, RDB_PASS);
        $io->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $io->prepare("INSERT INTO `pending_bookings`(`CustomerName`, `CustomerPhone`, `CustomerEmail`, `TheatreCode`, `TransactionToken`) VALUES ('$params[0]','$params[1]','$params[2]','$params[3]','$params[4]')");
        if($stmt->execute()){
            print_r($stmt->execute());
        }else{
            print_r($stmt->execute());
        }
    }
    catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
    $io = null;
}
function secure($str) {
    $sqlHandle = new mysqli(DB_HOST, DB_USER, DB_PASS,DB);
    $secured = strip_tags($str);
    $secured = trim($secured);
    $secured = htmlspecialchars($secured);
    $secured = mysqli_real_escape_string($sqlHandle,$secured);
    return $secured;
}
function cartButton($id, $type){
    if( $type == 'hidden'){
        echo '<div class="input-group mb-3">
        <input type="'.$type.'" id="qty_input'.$id.'" name="qty'.$id.'" value="0">
        </div>';
    }else{
        echo '<div class="input-group mb-3">
        <div class="input-group-prepend">
            <a class="btn btn-primary btn-sm" id="minus-btn'.$id.'"><i class="fa fa-minus" style="color:#fff;"></i></a>
        </div>
        <input type="'.$type.'" id="qty_input'.$id.'" name="qty'.$id.'" class="form-control form-control-sm" value="0" min="0" max="20">
        <div class="input-group-prepend">
            <a class="btn btn-primary btn-sm" id="plus-btn'.$id.'"><i class="fa fa-plus" style="color:#fff;"></i></a>
        </div>
    </div>';
    }
   
}
function CreateSlug($string){
    $s = strtolower($string);
    return str_replace(" ", "-", $s);
}
function goHome($url = SYS_URL, $timeout = 0){
    if($timeout == 0 ){
        echo '<script>location.href = "'.$url.'" </script>';
    }else{
        echo '<script>
        window.setTimeout(function(){
            window.location.href = "'.$url.'";
        }, '.$timeout.');</script>';
    }
}
function ticketRandCode($length = 100) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
function smsphoneformat($tel){
	$phone =  '';
	$tel = str_replace(' ', '', $tel);
	if( substr( $tel, 0, 2 ) === "07" && strlen($tel) == 10 ){
		return $phone = '254'.(int)$tel;
	}elseif( substr( $tel, 0, 4 ) === "2547" && strlen($tel) == 12 ){
		return $phone = $tel;
	}elseif( substr( $tel, 0, 5 ) === "25407" && strlen($tel) == 13 ){
		$phone = strstr($tel, '0');
		return	$phone = '254'.(int)$phone;
	}elseif( substr( $tel, 0, 6 ) === "+25407" && strlen($tel) == 14 ){
		$phone = strstr($tel, '0');
		return $phone = '254'.(int)$phone;
	}elseif( substr( $tel, 0, 5 ) === "+2547" && strlen($tel) == 13 ){
		$phone = strstr($tel, '7');
		return $phone = '254'.(int)$phone;
	}elseif( substr( $tel, 0, 1 ) === "7" && strlen($tel) == 9 ){
		return $phone = '254'.(int)$phone;
	}elseif( substr( $tel, 0, 5 ) === "2547" && strlen($tel) == 12 ){
		return $phone = $tel;
	}else{
		return 0;
	}
}
function SendMail($email, $name, $body, $attachment, $eventownername, $eventownermail, $subject){
        $mail = new PHPMailer(true); 
        try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP(); 
        $mail->Host = SMTP_HOST; 
        $mail->SMTPAuth = true;                              
        $mail->Username = SMTP_USER;               
        $mail->Password = SMTP_PASSWORD;                       
        $mail->SMTPSecure = 'tls';                           
        $mail->Port = SMTP_PORT;   
        $mail->setFrom(SMTP_USER, 'Form Event Tickets');
        $mail->addAddress($email, $name);
        $mail->addBCC('support@patahapa.com', 'Patahapa Technical Support');
        $mail->addCC(VMAIL, "Form Ticketing Customer care");
        $mail->addCC($eventownername, $eventownermail);
        $mail->addReplyTo(VMAIL, "Form Ticketing Customer care");
        $mail->addAttachment(SYS_DIR.$attachment.'.pdf', 'Form_Event_Tickets', $encoding = 'base64', $type = 'application/pdf');         
        $mail->isHTML(true);
        $mail->Subject = 'Form Ticketing | '.$subject;
        $mail->Body    = $body;
        $mail->AltBody = 'Email verified by Form Ticketing association with google inc';
        $mail->send();
    } catch (Exception $e) {
        $error = $mail->ErrorInfo;
    }
}
function ChatScript(){
	return '
	<style>
	iframe > a{
		display:none;
	}
	</style>
	<script type="text/javascript">function add_chatinline(){var hccid=94522756;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
	add_chatinline(); </script>';
}
function Footer($baseurl){
	 $footer = '
	 <footer class="section">  
	 <div class="container">
	   <div class="row">
		 <div class="col-md-3 col-sm-3 col-xs-12">
		   <h3><img src="'.SYS_URL.'assets/img/footer-logo.png" alt=""></h3>
		   <p>
			Having trouble booking a ticket? Contact support below or use our feedback form at the top for amazingly quick assistance
		   </p>
		   <p>
		   <!-- Histats.com  START (html only)-->
		   <a href="/" alt="page hit counter" target="_blank" >
		   <embed src="http://s10.histats.com/14.swf"  flashvars="jver=1&acsid=4030795&domi=4"  quality="high"  width="200" height="40" name="14.swf"  align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="transparent" /></a>
		   <img  src="//sstatic1.histats.com/0.gif?4030795&101" alt="counter easy hit" border="0">
		   <!-- Histats.com  END  -->
		   </p>

		 </div>
		 <div class="col-md-2 col-sm-3 col-xs-12">
		   <h3>Suncrest TZ</h3>
		   <ul>
		   <li><a href="'.SYS_URL.'suncrest">Suncrest Cineplex</a></li>
		   </ul>
		 </div>
		 <div class="col-md-3 col-sm-3 col-xs-12">
		   <h3>Century</h3>
		   <ul>
		   <li><a href="'.SYS_URL.'">Century Cinemax, Garden city</a></li>
		   <li><a href="'.SYS_URL.'junction">Century Cinemax,Junction mall</a></li>
		   </ul>
		 </div>
		 <div class="col-md-2 col-sm-3 col-xs-12">
		   <h3>Sky Cinema</h3>
		   <ul>
			 <li><a href="'.SYS_URL.'anga">Imax town</a></li>
			 <li><a href="'.SYS_URL.'panari">Anga, Panari</a></li>
			 <li><a href="'.SYS_URL.'diamond">Sky, Diamond Plaza.</a></li>
		   </ul>
		 </div>  
		 <div class="col-md-2 col-sm-3 col-xs-12">
		 <h3>Byteblade Systems</h3>
		 <ul>
            <li><a href="'.VWEB_ORIGIN.'">Theatre Systems</a></li>
            <li><a href="'.VWEB_ORIGIN.'">Ticketing Systems</a></li>
            <li><a href="'.VWEB_ORIGIN.'">Blade Solutions</a></li>
		 </ul>
	   </div>          
	   </div>
	 </div>      
   </footer>
	 ';
	 return $footer;
 }
function CopyRight(){
	$copyright = '
	<section id="copyright">
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
		  <p class="copyright-text text-center">
		Copyright &copy; '.date("Y").'
			<a href="'.VWEB_ORIGIN.'">
			  Patahapa Movies
			</a>
		  </p>
		</div>
   <div class="col-md-12">
		  <p class="copyright-text text-center">Powered by
		<a style="color: #27adf8; font-size: 14px; font-style: underline;" href="#">Blade systems Inc</a>
		  </p>
		</div>
	  </div>
	</div>
  </section> 
	';
	return $copyright;
}
 function Partners($baseurl){
	 $p = '
	 <section id="sponsors" class="section">
	 <div class="container">
	   <div class="row">
		 <div class="col-md-12">
		   <h2 class="section-title wow fadeInUp" data-wow-delay="0s">Our <span> Partners</h2>
		 </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		   <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.1s">
			 <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/logo-01.png" alt=""></a>
		   </div>            
		 </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		   <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.2s">
			 <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/11.png" alt=""></a>
		   </div>            
		 </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		   <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.3s">
			 <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/logo-03.png" alt=""></a>
		   </div>            
		 </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		   <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.3s">
			 <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/22.png" alt=""></a>
		   </div>            
		 </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		 <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.3s">
		   <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/44.png" alt=""></a>
		 </div>            
	   </div>
		 <div class="col-md-2 col-sm-6 col-xs-12">
		   <div class="spnsors-logo wow fadeInUp" data-wow-delay="0.4s">
			 <a href="#"><img style="width: 100%;" src="'.$baseurl.'assets/img/sponsors/33.png" alt=""></a>
		   </div>            
		 </div>
	   </div>
	 </div>
   </section>
	 ';
	 return $p ;
 }

 function PdfTicket($params, $bgurl = ''){
    if(empty($bgurl)){
     $bg = SYS_URL.'images/tkt-bg/tkt.jpg';
    }else{
     $bg = $bgurl;
    }
     $stylesheet = '<style>'.file_get_contents('../css/tkt-css/style.css').'</style>';
     $html = '
     <body style="width:1080px; height:1200px; background-color:#fff; overflow: hidden; ">
     <div class="tail-top" style="max-width: 990px;">
     <div class="tail-bottom" style="">
     <div id="main" style="width:926px; background-image:url('.$bg.'); background-repeat:repeat-x; background-size:cover; border-radius:5px;">
         <div class="div" style="margin-top: 35px;">
         </div>
     <div id="content" style="background-color:transparent;">
         <div id="slogan" style="background-color:transparent;">
         </div>
         <div class="boxx">
             <table style="margin-top:-50px;">
                 <tbody>
                     <tr>
                         <td style="color:yellow; font-size:13px; width:450px;">
                         EVENT: <b style="color:white;">'.$params[0].'</b><br>
                         Date/Time: <b style="color:white;">'.$params[1].'</b> <br>
                         Venue: <b>'.$params[2].'</b><br>
                         Tickets: <b>'.$params[3].'(Free Seating)</b><br>
                         Amount Paid: <b>Ksh '.$params[4].'/=</b><br>
                         Name:<b> '.$params[5].'</b><br>
                         Phone:<b> '.$params[6].'</b><br>
                         Email:<b> '.$params[7].'</b><br><br>
                         <i style="font-size: 11px;">Note: All tickets will be screened at the venue</i><br>
                         </td>
                         <td style="border: solid  1px #007bff; padding:3px; color:white; text-align: left;">
                             <div style="">
                             Terms and conditions apply:<br>
                             <ol>
                             <li>Present print ticket at the venue for ease of access.</li>
                             <li>Keep your tickets secure, once used it cannot be reused.</li>
                             <li>Tickets once purchased are non-refundable/non-exchangeable.</li>
                             <li>Ticket(s) re-selling not allowed.</li>
                             <li>Free seating, first come first served.</li>
                             <li>Management reserves a right of admission.</li>
                             <li>No food and/or drinks allowed from outside.</li></ol>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td>
                             <div style="color:black; background-color: white; padding: 4px;">
                             Serial Number: <b>'.$params[8].'</b>
                             </div>   
                         </td>
                         <td style="text-align:right">
                                 <b style="color:#007bff; text-align:right; font-size:16px; font-family:serif;">
                                         <span style="font-style:italic;">Powered by:</span> '.VNAME.' | '.VWEB.'
                                     </b>
                         </td>
                     </tr>
                 </tbody>
             </table>
         </div>
     </div>
     </div>
     </div>
     </div>
     </body>';
     $rand_code = ticketRandCode();
     $mpdf=new mPDF('c', 'A4-L');
     $mpdf->SetWatermarkImage('../mpdf/wm.png');
     $mpdf->showWatermarkImage = true;
     $mpdf->WriteHTML($stylesheet,1);
     $mpdf->WriteHTML($html,2);
     $_SESSION['file'] = date("Ymdh").$rand_code;
     $mpdf->Output(SYS_DIR.$_SESSION['file'].'.pdf','F');
     $attachment = SYS_DIR.$_SESSION['file'].'.pdf';
     return $attachment;
 }
 function SendSwiftEmail($params, $attachment, $data =array() ){
     $body = 'Thank you for transacting with us. Your ticket(s) ('.$params[3].') for ('.$params[0].') have been reserved.<br/> Your PDF ticket is attached. Event date is <b>'.$params[1].'</b> at the <b>'.$params[2].'</b><br><br> Enjoy!';
     $subject = $data[0];
     $eventownername = $data[1];
     $eventownermail =$data[2];
     //swift mailer
     try{
         $transport = (new Swift_SmtpTransport(SMTP_HOST, SMTP_PORT))
         ->setUsername(SMTP_USER)
         ->setPassword(SMTP_PASSWORD);
         $mailer = new Swift_Mailer($transport);
         $message = (new Swift_Message($subject))
         ->setFrom([SMTP_USER => SYS_NAME])
         ->setTo([$params[7] => $params[5]])
         ->setCc([$eventownermail => $eventownername])
         ->setBcc(["support@patahapa.com" => "Patahapa Support"])
         ->setBody($body)
         ->addPart($body, 'text/html')
         ->attach(
             Swift_Attachment::fromPath($attachment)->setFilename('Form_Events_Tickets.pdf')
         );
         $result = $mailer->send($message);
     }catch(Swift_RfcComplianceException $e){
        echo $e;
     }
 }

?>