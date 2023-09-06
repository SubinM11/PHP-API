<?php

require '../inc/dbcon.php';

function error422($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP:1.0 422 Unprocess entity");
    echo json_encode($data);
    exit();
}


function storeCustomer($customerInput){
 global $con;

 $name=mysqli_real_escape_string($con,$customerInput['name']);
 $email=mysqli_real_escape_string($con,$customerInput['email']);
 $phone=mysqli_real_escape_string($con,$customerInput['phone']);

 if(empty(trim($name))){
       return error422('enter your name');
 }elseif(empty(trim($email))){
    return error422('enter your email');
 }elseif(empty(trim($phone))){
    return error422('enter your phone');
 }
 else{
    $query="insert into customers(name,email,phone) values('$name','$email','$phone')";
    $result=mysqli_query($con,$query);

    if($result){
        $data=[
            'status'=>201,
            'message'=>"cutomer created",
        ];
        header("HTTP:1.0 201 created ");
        return json_encode($data);
    }else{
        $data=[
            'status'=>500,
            'message'=>"Internal server error",
        ];
        header("HTTP:1.0 500 Internal server error ");
        return json_encode($data);
    }
 }
}


function getcustomerList(){

    global $con;
    $query='select * from customers';
    $query_run=mysqli_query($con,$query);

    if($query_run){
        if(mysqli_num_rows($query_run)>0){

            $res=mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data=[
                'status'=>200,
                'message'=>"Customer list fetched successful",
                'data'=> $res
            ];
            header("HTTP:1.0 200 ok ");
            return json_encode($data);

        }else{
            $data=[
                'status'=>404,
                'message'=>"No customer found",
            ];
            header("HTTP:1.0 404 No customer found ");
            return json_encode($data);
        }

    }else{
        $data=[
            'status'=>500,
            'message'=>"Internal server error",
        ];
        header("HTTP:1.0 500 Internal server error ");
        return json_encode($data);
    }

}

function getCustomer($custmerparam){
    global $con;
    if($custmerparam['id']==null){
        return error422('enter your customer id');

    }
    $customerId=mysqli_real_escape_string($con,$custmerparam['id']);
    $query="select * from customers where id='$customerId' limit 1";
    $result=mysqli_query($con,$query);

    if($result){
 if(mysqli_num_rows($result)==1){
    $res=mysqli_fetch_assoc($result);
    $data=[
        'status'=>200,
        'message'=>"No customer fetched successfully",
        'data'=>$res
    ];
    header("HTTP:1.0 200 ok ");
    return json_encode($data);
 }else{
    $data=[
        'status'=>404,
        'message'=>"No customer found",
    ];
    header("HTTP:1.0 404 not found ");
    return json_encode($data);
 }
    }else{
        $data=[
            'status'=>500,
            'message'=>"Internal server error",
        ];
        header("HTTP:1.0 500 Internal server error ");
        return json_encode($data);
    }
}
function updateCustomer($customerInput,$customerparam){
    global $con;

    if(!isset($customerparam['id'])){
           return error422('customer id not found in Url ');
    }elseif($customerparam['id']===null){
             return error422('Enter customer id');
    }

    $customerId=mysqli_real_escape_string($con,$customerparam['id']);
   
    $name=mysqli_real_escape_string($con,$customerInput['name']);
    $email=mysqli_real_escape_string($con,$customerInput['email']);
    $phone=mysqli_real_escape_string($con,$customerInput['phone']);
   
    if(empty(trim($name))){
          return error422('enter your name');
    }elseif(empty(trim($email))){
       return error422('enter your email');
    }elseif(empty(trim($phone))){
       return error422('enter your phone');
    }
    else{
      $query="update customers set name='$name',email='$email',phone='$phone' where id=$customerId limit 1 ";
      // $query = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id=$customerId LIMIT 1";

       $result=mysqli_query($con,$query);
   
       if($result){
           $data=[
               'status'=>200,
               'message'=>"cutomer update created",
           ];
           header("HTTP:1.0 200 success ");
           return json_encode($data);
       }else{
           $data=[
               'status'=>500,
               'message'=>"Internal server error",
           ];
           header("HTTP:1.0 500 Internal server error ");
           return json_encode($data);
       }
    }
   }

   function deleteCustomer($customerparam){
    global $con;

    if(!isset($customerparam['id'])){
           return error422('customer id not found in Url ');
    }elseif($customerparam['id']===null){
             return error422('Enter customer id');
    }

    $customerId=mysqli_real_escape_string($con,$customerparam['id']);

    $query="delete from customers where id='$customerId' limit 1";
    $result=mysqli_query($con,$query);
    if($result){
        $data=[
            'status'=>200,
            'message'=>"Customer deleted succesfully",
        ];
        header("HTTP:1.0 200 ok ");
        return json_encode($data);
    }else{
        $data=[
            'status'=>404,
            'message'=>"Internal server error",
        ];
        header("HTTP:1.0 404 Internal server error ");
        return json_encode($data);
    }
   
   }
?>