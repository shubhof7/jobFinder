<?php
$data=json_decode(file_get_contents("php://input"));


if (isset($data->function_name)) {
   require_once 'connection.php';
     $function_name=$data->function_name;
    if($function_name=='add')
   {
      $companyname=$data->companyname;
      $emailid=$data->emailid;
      $phoneno=$data->phoneno;
      $address=$data->address;

  $check=mysqli_query($con,"SELECT * FROM companies WHERE emailid='$emailid'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
      
            $query=mysqli_query($con,"INSERT INTO companies(company_name,emailid,mobile_no,address) VALUE('$companyname','$emailid','$phoneno','$address')");
            if($query){
            echo json_encode(
        array(
          'status'=>true,
          'result'=>'Successfully inserted'
        )); 
          }
           else{
            echo json_encode(
        array(
          'status'=>true,
          'result'=>'Unsuccessful'
        )); 
          }
        }
     else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Entry already exist'
        ));
    }
  }
   
   elseif($function_name=='select')
   {
      $emailid=$data->emailid;
    

  $check=mysqli_query($con,"SELECT * FROM companies WHERE emailid='$emailid'");
  $count=mysqli_num_rows($check);
   if ($count==1) {
      
           $query=mysqli_fetch_assoc($check);
            if($query){
            echo json_encode(
        array(
          'status'=>true,
          'result'=>$companyname         
        )); 
          }
        }
     else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'No such email exist'
        ));
    }
  }
   
 elseif($function_name=='delete')
   {

  $emailid=$data->emailid;
  
  $check=mysqli_query($con,"SELECT * FROM companies WHERE emailid='$emailid'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
    echo json_encode(
    array( 
      'status'=>false,
      'result'=>'No such email exist'

    )); 
    }
else{
  $query=mysqli_query($con,"DELETE FROM companies where emailid='$emailid'");
  if ($query) {
    echo json_encode(
    array( 
      'status'=>true,
      'result'=>'Category deleted'

    )); 
      }
    }
       
  } 
  elseif($function_name=='update')
   {
   
    $companyname=$data->companyname;
      $emailid=$data->emailid;
      $phoneno=$data->phoneno;
      $address=$data->address;

  
   $check=mysqli_query($con,"SELECT * FROM companies WHERE emailid='$emailid'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
     if ($companyname!='') {
     $query1=mysqli_query($con,"UPDATE companies SET companyname='$companyname' where emailid='$emailid'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Company name successfully updated'
        ));
     }
    }
  
     if ($phoneno!='') {
     $query1=mysqli_query($con,"UPDATE companies SET mobile_no='$phoneno' where emailid='$emailid'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Contact number successfully updated'
        ));
     }
    }
     if ($address!='') {
     $query1=mysqli_query($con,"UPDATE companies SET address='$address' where emailid='$emailid'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Address successfully updated'
        ));
     }
    }
    
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