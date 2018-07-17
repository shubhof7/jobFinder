<?php
$data=json_decode(file_get_contents("php://input"));

// print_r($data);

// die();

if (isset($data->function_name)) {
   require_once 'connection.php';
     $function_name = $data->function_name;
    if($function_name == 'add')
   {
      $jid=$data->jid;
      $jobtype=$data->jobtype;
      $jobtitle=$data->jobtitle;
      $jobdesc=$data->jobdesc;
      $location=$data->location;
      $salary=$data->salary;
      $experience=$data->experience;

      $query = mysqli_query($con,"INSERT INTO jobdescription(jid,job_type,job_title,job_description,location,salary,experience) VALUES($jid,$jobtype','$jobtitle','$jobdesc','$location','$salary','$experience')");
            if($query){
            echo json_encode(
        array(
          'status'=>true,
          'result'=>'Successfully inserted'
        )); 
          }
        
     else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Not inserted due to some error'
        ));
    }
  }
   
   elseif($function_name=='select')
   {
    $selectQuery = mysqli_query($con,"SELECT * FROM jobdescription");
    $query=mysqli_num_rows($selectQuery);
    $queryData[] = '';
     if($selectQuery){
        while ($dataQ = mysqli_fetch_assoc($selectQuery)): 
            $queryData[] = $dataQ;
        endwhile;    
            echo json_encode(
        array(
          'status'=>true,
          'msg'=>'Successfully selected',
          'result'=> $queryData
        )); 
          }
        
     else {
        echo json_encode(
        array(
          'status'=>false,
          'result'=>'Some error occurred'
        ));
    }
  }
   
 elseif($function_name=='delete')
   {

  
  } 
  elseif($function_name=='update')
   {
    $jobtype=$data->sellType;
      $jobtitle=$data->jobTitle;
      $jobdesc=$data->jobDesc;
      $location=$data->location;
      $salary=$data->salary;
      $experience=$data->experience;
   }
}

 else
{
   echo json_encode(
    array( 
      'status'=>false,
      'result'=>'error',
      'msg' => $data->function_name

    )); 
}

?>