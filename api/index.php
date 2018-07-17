<?php
$data=json_decode(file_get_contents("php://input"));

// print_r($data);
// die();

if (isset($data->function_name)) {
   require_once 'connection.php';
     $function_name=$data->function_name;
    if($function_name=='signup')
   {
  $name=$data->name;
  $email=$data->email;
  $password=$data->password;
  $cpassword=$data->cpassword;

  $check=mysqli_query($con,"SELECT * FROM esignup WHERE E_email='$email'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
       if ($password==$cpassword) {
       	    $password=md5($password);
       	    $query=mysqli_query($con,"INSERT INTO esignup(E_name,E_email,E_password) VALUES('$name','$email','$password')");
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
		   		'result'=>'Account already exists'
		   	));
		}
  }
   
   elseif($function_name=='login')
   {
   
   $email=$data->email;
   $password=$data->password;
   $password=md5($password);

   $check=mysqli_query($con,"SELECT * FROM esignup WHERE E_email='$email'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
      $queryData[] = '';   
     	$query=mysqli_fetch_assoc($check);
      if($password == $query["E_password"]){    
        while ($logData=mysqli_fetch_assoc($check)): 
          $queryData[] = $logData;
        endwhile; 
         echo json_encode(
		   	array(
		   		'status'=>true,
		   		'msg'=>'Login successful',
          'result'=>$query
		   	));
    }
   	
    else {
		    echo json_encode(
		   	array(
		   		'status'=>false,
		   		'result'=>$con->error
		   	));
		}
   }
    else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Invalid account details'
        ));
    }
}
 elseif($function_name=='delete')
  {

  $email=$data->email;
  
  $check=mysqli_query($con,"SELECT * FROM esignup WHERE E_email='$email'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
    echo json_encode(
    array( 
      'status'=>false,
      'result'=>'Invalid email address'

    )); 
     }
else{
  $query=mysqli_query($con,"DELETE FROM esignup where E_email='$email'");
  if ($query) {
    echo json_encode(
    array( 
      'status'=>true,
      'result'=>'Account deleted'

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

   $check=mysqli_query($con,"SELECT * FROM esignup WHERE E_email='$email'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
     if ($name!='') {
     $query1=mysqli_query($con,"UPDATE esignup SET E_name='$name' where E_email='$email'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Name successfully updated'
        ));
     }
    }
    if ($password!='') {
     $query1=mysqli_query($con,"UPDATE esignup SET E_password='$password' where E_email='$email'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Password successfully updated'
        ));
     }
    }
   }
    
    else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Invalid account'
        ));
    }
   }
   
}



 else
{
   echo json_encode(
   	array( 
   		'status'=>false,
   		'result'=>'Unsuccessful'

   	)); 
}

?>