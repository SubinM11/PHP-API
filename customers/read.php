<?php
header('Access-Control-Allow-Orgin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:GET');
header('Access-Control-Allow-Header:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');

include('function.php');

$requestMethod=$_SERVER["REQUEST_METHOD"];
if($requestMethod=="GET"){

    if(isset($_GET['id'])){

        $customer=getCustomer($_GET);
        echo $customer;
    }else{
        $customerList=getcustomerList();
        echo $customerList;
    }
        
}
else{
    $data=[
        'status'=>405,
        'message'=>$requestMethod."Method not allowed",
    ];
    header("HTTP:1.0 405 Method not allowed");
    echo json_encode($data);
}
?>