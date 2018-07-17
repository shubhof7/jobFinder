<?php
$data=json_decode(file_get_contents("php://input"));


if (isset($data->function_name)) {
   require_once 'connection.php';
     $function_name=$data->function_name;
    if($function_name=='add')
   {
      $category=$data->category;
      $pid=$data->pid;

  $check=mysqli_query($con,"SELECT * FROM jobs WHERE category='$category'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
      
            $query=mysqli_query($con,"INSERT INTO jobs(category,parent) VALUE('$category','$pid')");
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
          'result'=>'Already exist'
        ));
    }
  }
   
   elseif($function_name=='select')
   {
      $category=$data->category;
    

  $check=mysqli_query($con,"SELECT * FROM jobs WHERE category='$category'");
  $count=mysqli_num_rows($check);
   if ($count==1) {
      
           $query=mysqli_fetch_assoc($check);
            if($query){
            echo json_encode(
        array(
          'status'=>true,
          'result'=>$category.$parent          
        )); 
          }
        }
     else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'No such category'
        ));
    }
  }
   
 elseif($function_name=='delete')
   {

  $category=$data->category;
  
  $check=mysqli_query($con,"SELECT * FROM jobs WHERE category='$category'");
  $count=mysqli_num_rows($check);
   if ($count==0) {
    echo json_encode(
    array( 
      'status'=>false,
      'result'=>'No such category'

    )); 
    }
else{
  $query=mysqli_query($con,"DELETE FROM jobs where category='$category'");
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
   
  $category=$data->category;
  $parent=$data->parent;
   $check=mysqli_query($con,"SELECT * FROM jobs WHERE category='$category'");
   $count=mysqli_num_rows($check);
   if($count==1)
   {
     if ($name!='') {
     $query1=mysqli_query($con,"UPDATE rsignup SET R_name='$name' where R_email='$email'");
     if($query1){
        echo json_encode(
        array(
          'status'=>true,
          'result'=>'Name successfully updated'
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