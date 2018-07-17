<?php
$data=json_decode(file_get_contents("php://input"));

if (isset($data->function_name)) {
   require_once 'connection.php';
     $function_name=$data->function_name;
    if($function_name=='signup')
   {
  $name=$data->name;
  $email=$data->email;
  $password=$data->password;
  $cpassword=$data->cpassword;
  $companyname=$data->companyname;

  $check=mysqli_query($con,"SELECT * FROM rsignup WHERE R_email='$email'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
       if ($password==$cpassword) {
       	    $password=md5($password);
       	    $query=mysqli_query($con,"INSERT INTO rsignup(R_name,R_email,R_password,R_companyname) VALUES('$name','$email','$password','$companyname')");
       	    if($query){
            echo json_encode(
		   	array(
		   		'status'=>true,
		   		'result'=>'Successfully inserted'
		   	)); 
          }
       }
        else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Password and confirm password does not match'
        ));
    }
      }
     else {
		    echo json_encode(
		   	array(
		   		'status'=>false,
		   		'result'=>'already having account'
		   	));
		}
  }
   
   elseif($function_name=='login')
   {
   
   $email=$data->email;
   $password=$data->password;
   $password=md5($password);

   $check=mysqli_query($con,"SELECT * FROM rsignup WHERE R_email='$email'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
     	$query=mysqli_fetch_assoc($check);
      if($password==$query["R_password"]){    
         session_start();
         $_SESSION['id']=$query['R_email'];
         $_SESSION['name']=$query['R_name'];
         echo json_encode(
		   	array(
		   		'status'=>true,
		   		'result'=>'Successfully login'
		   	)); 
     
    }
   	
    else {
		    echo json_encode(
		   	array(
		   		'status'=>false,
		   		'result'=>'password is inncorrect'
		   	));
		}
   }
    else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'invalid account'
        ));
    }
} 
 elseif($function_name=='delete')
   {

  $email=$data->email;
  
  $check=mysqli_query($con,"SELECT * FROM rsignup WHERE R_email='$email'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
    echo json_encode(
    array( 
      'status'=>false,
      'result'=>'invalid email address'

    )); 
    }
else{
  $query=mysqli_query($con,"DELETE FROM rsignup where R_email='$email'");
  if ($query) {
    echo json_encode(
    array( 
      'status'=>true,
      'result'=>'account deleted'

    )); 
      }
    }
       
  } 
  elseif($function_name=='update')
   {
   
   $email=$data->email;
   $name=$data->name;
   $password=$data->password;
   $password=md5($password);

   $check=mysqli_query($con,"SELECT * FROM rsignup WHERE R_email='$email'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
     if ($name!='') {
     $query1=mysqli_query($con,"UPDATE rsignup SET R_name='$name' where R_email='$email'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Successfully updated data name'
        ));
     }
    }
    if ($password!='') {
     $query1=mysqli_query($con,"UPDATE rsignup SET R_password='$password' where R_email='$email'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Successfully updated data password'
        ));
     }
    }
   }
}
 else
{
   echo json_encode(
   	array( 
   		'status'=>false,
   		'result'=>''

   	)); 
}

?>