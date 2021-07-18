<?php  
ob_start(); 
session_start(); 
include "../includes.php"; 
include "Barcode39.php";

$adm_open           = new admission_open();
$areas              = new areas();
$state_obj          = new states(); 
$city_obj           = new cities();
$student_obj        = new student();
$application_obj    = new application();
$admission_type_obj = new admission_type(); 
$prgrmbatchcomb_obj = new programcourse();

if($_GET['action']=='getApplicationCount'){
    $count = array();
    $count['app_tab_1'] = $adm_open->getTotalPending($_GET['app']);
    $count['app_tab_2'] = $adm_open->getTotalShortlisted($_GET['app']);
    $count['app_tab_3'] = $adm_open->getTotalTestSchedule($_GET['app']);
    $count['app_tab_4'] = $adm_open->getTotalTotalTestCleared($_GET['app']);
    $count['app_tab_5'] = $adm_open->getTotalInterviewSchedule($_GET['app']);
    $count['app_tab_6'] = $adm_open->getTotalInterviewCleared($_GET['app']);
    $count['app_tab_7'] = $adm_open->getTotalRejected($_GET['app']);
    echo json_encode($count);
}

if($_GET['action']=='getStudentsIDCards')
{
    $stud_obj = new student;
    $data     = $stud_obj->getStudCourseDetail($_GET['stud_id']); // echo "<pre>"; print_r($data); echo "</pre>";
    $addr     = $stud_obj->getStudAddress($_GET['stud_id']);
    //$idCard   = $stud_obj->getStudentIdCard($_GET['stud_id']); old function
    $idCard   = $stud_obj->getStudentIdCardNew($_GET['stud_id'], $data->stud_batch_id, $data->stud_sess_id, $data->stud_batch_session_comb_id);
    $array    = (array) $data;
    $array['stud_date_of_birth'] = date($_SESSION['DATEFORMAT'],strtotime($array['stud_date_of_birth']));
    $array['address'] = (array) $addr;    
    $array['stud_image'] = trim($array['stud_images'])!='' ? BASE_HREF.'/uploads/sch_'.$_SESSION['school_id'].'/student_pics/thumb_'.$array['stud_images'] : BASE_HREF . 'uploads/default_pic.jpg';
    
    if($idCard!=false)
    {
        $array['id_card_status']  = '<b style="color:green;">Already Created</b>';
        $array['card_issue_date'] = date($_SESSION['DATEFORMAT'],strtotime($idCard->card_issue_date));
        $array['card_valid_upto'] = date($_SESSION['DATEFORMAT'],strtotime($idCard->stud_id_card_valid_upto));
    }
    else
    {
        $array['card_issue_date'] = date($_SESSION['DATEFORMAT'],time());
        $array['id_card_status']  = '';
        $array['card_valid_upto'] = '';
    }
    echo json_encode($array);
}

if($_POST['action']=='get_student_by_course'){
    $sWhere = "";
    if($_POST['b']>0 && $_POST['b']>0 && $_POST['b']>0){
        $sWhere = " AND stud_batch_id='".$_POST['b']."' AND stud_sess_id='".$_POST['s']."' AND stud_batch_session_comb_id='".$_POST['c']."'";
    }
    $new_where = "";
    if($_SESSION['mem_user_login_type']==1 && $_SESSION['mem_user_access_level'] == 0){
        $user_Data = new user;
        $getAllData = $user_Data->getFacultyBatchSessComb($_SESSION["mem_staff_id"]);
        if(is_array($getAllData)){             
            $new_where = "AND stud_batch_id IN(".implode(",",$getAllData["all_batch_ids"]).") AND stud_sess_id IN(".implode(",",$getAllData["all_sess_ids"]).") AND stud_batch_session_comb_id IN(".implode(",",$getAllData["all_comb_ids"]).") ";
        }
    }
    if($_SESSION['school_id'] == 243){
        //$new_where .= " AND stud_adm_fee_pay_status ='paid' ";
    }
    else {
        $new_where .= " AND stud_adm_fee_pay_status ='paid' ";
    }
    $qry = "SELECT * FROM tbl_students WHERE stud_is_deleted=0 AND stud_is_active=1 AND stud_tranfer_cert = 0 ".$sWhere." $new_where ORDER BY stud_first_name";
    $staff_result = mysqli_query($_SESSION["db_conn"],$qry) or die($qry." Error: ".mysqli_error($_SESSION["db_conn"]));
    if(mysqli_num_rows($staff_result)>0){
        echo '<option value=""> -- Select Student -- </option>';
        while($obj = mysqli_fetch_object($staff_result)){
            echo '<option value="'.$obj->stud_id.'">'.ucwords($obj->stud_first_name.' '.$obj->stud_middle_name.' '.$obj->stud_last_name).'</option>';
        }
    }
    else{
        echo '<option value=""> -- No Student Found -- </option>';
    }
}

if($_POST['action']=='get_student_admno'){
    $sWhere = "";
    if($_POST['b'] > 0 && $_POST['s'] > 0 && $_POST['c'] > 0){
        $sWhere = " AND stud_batch_id='".$_POST['b']."' AND stud_sess_id='".$_POST['s']."' AND stud_batch_session_comb_id='".$_POST['c']."'";
    }
    
    $new_where = "";
    if($_SESSION['mem_user_login_type']==1 && $_SESSION['mem_user_access_level'] == 0){
        $user_Data = new user;
        $getAllData = $user_Data->getFacultyBatchSessComb($_SESSION["mem_staff_id"]);
        if(is_array($getAllData)){             
            $new_where = "AND stud_batch_id IN(".implode(",",$getAllData["all_batch_ids"]).") AND stud_sess_id IN(".implode(",",$getAllData["all_sess_ids"]).") AND stud_batch_session_comb_id IN(".implode(",",$getAllData["all_comb_ids"]).") ";
        }
    }
    if($_SESSION['school_id'] == 243){
        //$new_where .= " AND stud_adm_fee_pay_status ='paid' ";
    }
    else {
        $new_where .= " AND stud_adm_fee_pay_status ='paid' ";
    }
    $qry = "SELECT * FROM tbl_students WHERE stud_is_deleted=0 AND stud_is_active=1 AND stud_tranfer_cert = 0 ".$sWhere." ".$new_where;
    $staff_result = mysqli_query($_SESSION["db_conn"],$qry) or die($qry." Error: ".mysqli_error($_SESSION["db_conn"]));
    if(mysqli_num_rows($staff_result)>0){
        echo '<option value=""> -- Admission No -- </option>';
        while($obj = mysqli_fetch_object($staff_result)){
            echo '<option value="'.$obj->stud_id.'">'.$obj->stud_adm_no.'</option>';
        }
    }
    else{
        echo '<option value=""> -- No Student Found -- </option>';
    }
}
function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') == $date;
}
 function secondsToTime($from_date,$upto_date,$dob) {
 	/*$start_year=intval($start);
	$end_year=intval($end);
	$start_year=$start_year>0 ? $start_year : 0;
	$end_year=$end_year>0 ? $end_year : 0;
	
	$start_month=$start-$start_year;
	$end_month=$end-$end_year;
	$start_month=$start_month>0 ? $start_month : 0;
	$end_month=$end_month>0 ? $end_month : 0;
	$qry="SELECT if (('$dob' <= date_sub( DATE_sub('$from',INTERVAL $start_year Year) ,INTERVAL $start_month MONTH) and '$dob' >= date_sub( DATE_sub('$from',INTERVAL $end_year Year) ,INTERVAL $end_month MONTH)),1,0) AS flag";
	*/
	
	$return=array(1);
	if(validateDate($from_date)==true)
	{
		if(validateDate($upto_date)==false)
			$upto_date=date("Y-m-d");	
	
		$qry="SELECT if (('$dob' >= '$from_date' and '$dob' <= '$upto_date'),1,0) AS flag,date_format('$from_date','%d-%b-%Y') as sd,date_format('$upto_date','%d-%b-%Y') as ed";
		//echo $qry;
    	$result = mysqli_query($_SESSION['db_conn'],$qry);
	 	if( $result==true)
	 	{
	 	 	 $obj = mysqli_fetch_object($result);  
		 	 $return=array(($obj->flag),$obj->sd,$obj->ed);
	 	}
	 	else
	 		$return=array(0);
 			
	}
	return $return;
}
	
if($_POST["action"]=="del_row"){
    $id = $_POST["id"];
    $shortlisted = $_POST["shortlisted"];
    $table_name = $_POST["table_name"];
    $update_field_name = $_POST["update_field_name"]; 
    $where_field_id = $_POST["where_field_id"];
    $del_id = explode(",",$id);
    $option = $masterdao->deleteMultiple($table_name,$shortlisted,$update_field_name,$id,$where_field_id);
    echo $option;
}
else if($_POST["action"]=="chk_eligblty"){
    
        $ruleid = 0;
        
        if(($_POST["value"]==='SUBMIT' && $_POST["fieldid"]==='CHKALL')){
            
             $creturn = array();
            
            for($j=1;$j<=10;$j++){ 
                 
                $fieldid = "criteria_".$j;
                $value = $_POST["criteria_".$j];
                $appid = $_POST["appid"];
 
                if(strtolower($fieldid)==='criteria_8'){
                    $ruleid = 3;
                }
                else if(strtolower($fieldid)==='criteria_9'){
                    $ruleid = 4;
                }
                else if(strtolower($fieldid)==='criteria_10'){
                    $ruleid = 5;
                }
                if($ruleid > 0){
                    
                    $qry1 = "select * from tbl_admission_additional_criteria where criteria_rule_id='".$ruleid."' and criteria_adm_id='".$appid."' and criteria_is_active=1 and criteria_is_deleted=0";
                    $result1 = mysqli_query($_SESSION['db_conn'],$qry1) or die();
                    
                    if(mysqli_num_rows($result1) > 0 ){
                        
                        $obj = mysqli_fetch_object($result1);   
                        
                        if(is_numeric($value)){
                            
                            $dbv = trim($obj->criteria_value);
                            
                            switch($obj->criteria_operator){
                                
                                case '>': $creturn[] = $value > $dbv && $value!="" ? 'ok' : 'not'; 
                                break;

                                case '<': $creturn[] = $value < $dbv && $value!="" ? 'ok' : 'not'; 
                                break;

                                case '>=': $creturn[]= $value >= $dbv && $value!="" ? 'ok' : 'not'; 
                                break;

                                case '<=': $creturn[] = $value <= $dbv && $value!="" ? 'ok' : 'not'; 
                                break;

                                case '==': $creturn[]= $value == $dbv && $value!="" ? 'ok' : 'not'; 
                                break;

                                case '=': $creturn[] = $value == $dbv && $value!="" ? 'ok' : 'not';
                                break;
                            
                                default: $creturn[] = $obj->criteria_operator.' Case Not Found';
                                    
                            }
                        }
                        else{
                                $dbv_array = explode(",",  strtolower(trim($obj->criteria_value)));
                                $creturn[] = in_array(strtolower($value), $dbv_array) && $value!="" ? 'ok' : 'not';
                        }
                    }          
                }

                $qry2 = "select * from tbl_admission_courses_rules where adm_rule_app_open_id='".$appid."' and adm_rules_is_active=1 and adm_rules_is_deleted=0 LIMIT 1";
                $result2 = mysqli_query($_SESSION['db_conn'],$qry2) or die();

                if(mysqli_num_rows($result2)>0){

                        $obj = mysqli_fetch_object($result2);
                    
                        if(strtolower($fieldid)==='criteria_1'){
                            
                            if(is_numeric($value)){
                                
                                $dbValue = explode("_", $obj->adm_rule_language_result);
                                
                                if(count($dbValue) > 1){
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not'; 
                                }
                                else{
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                }
                                
                            }
                            else{
                                
                                $dbValue = explode("_", $obj->adm_rule_language_result);
                                
                                if(count($dbValue) > 1){
                                    $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                    $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                                
                            }
                                
                        }
                        else if(strtolower($fieldid)==='criteria_2'){
                            
                            if(is_numeric($value)){
                                
                                $dbValue = explode("_", $obj->adm_rule_iq_result);
                                if(count($dbValue) > 1){
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not';   
                                }
                                else{
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                }
                                
                            }
                            else{
                                
                                $dbValue = explode("_", $obj->adm_rule_iq_result);
                                if(count($dbValue) > 1){
                                    $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                    $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                                
                            }
                            
                        }
                        else if(strtolower($fieldid)==='criteria_3'){
                            if(is_numeric($value)){
                                
                                $dbValue = explode("_", $obj->adm_rule_internship_days);
                                if(count($dbValue) > 1){
                                    
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not';   
                                    
                                }
                                else{
                                    
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                    
                                }
                                
                            }
                            else{
                                
                                $dbValue = explode("_", $obj->adm_rule_internship_days);
                                if(count($dbValue) > 1){
                                    $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                    $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                                
                            }
                            
                        }
                        else if(strtolower($fieldid)==='criteria_4'){
                            if(is_numeric($value)){
                                $dbValue = explode("_", $obj->adm_rule_last_result);
                                if(count($dbValue) > 1){
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not';   
                                }
                                else{
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                }
                            }
                            else{
                                $dbValue = explode("_", $obj->adm_rule_last_result);
                                if(count($dbValue) > 1){
                                       $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                       $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                            }
                        }
                        else if(strtolower($fieldid)==='criteria_5'){
                            if(is_numeric($value)){
                               $dbValue = explode("_", $obj->addional_test_1);
                               if(count($dbValue) > 1){
                                   
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not';   
                                    
                                }
                              else{
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                }
                            }
                            else{
                                
                                $dbValue = explode("_", $obj->addional_test_1);
                                
                                if(count($dbValue) > 1){
                                    $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                    $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                            }

                        }
                        else if(strtolower($fieldid)==='criteria_6'){
                            
                            if(is_numeric($value)){
                                
                                $dbValue = explode("_", $obj->addional_test_2);
                                if(count($dbValue) > 1){
                                    $creturn[] = $value>=$dbValue[1] ? 'ok' : 'not';   
                                }
                                else{
                                    $creturn[] = $value>=$dbValue[0] ? 'ok' : 'not';   
                                }
                                
                            }
                            else{
                                $dbValue = explode("_", $obj->addional_test_2);
                                
                                if(count($dbValue) > 1){
                                    
                                     $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                    
                                }
                                else{
                                    
                                     $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                    
                                }
                            }
                        }
                        else if(strtolower($fieldid)==='criteria_7'){
                            if(is_numeric($value)){
                                $dbValue = explode("_", $obj->addional_test_3);
                                if(count($dbValue) > 1){
                                    $creturn[] = $value >= $dbValue[1] ? 'ok' : 'not';   
                                }
                                else{
                                    $creturn[] = $value >= $dbValue[0] ? 'ok' : 'not';   
                                }
                            }
                            else{
                                
                                $dbValue = explode("_", $obj->addional_test_3);
                                if(count($dbValue) > 1){
                                    $creturn[] = strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                                }
                                else{
                                    $creturn[] = strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                                }
                            }
                        }
                }
                
            }

//------------START OF AGE VALIDATION -------------------------
         $birthDate = $_POST["dob"];
        $option = $application_obj->checkValidAge($appid);
        $age_date = $application_obj->ageDate($appid);
        
	$ageRange = explode("---",$option);
         if($ageRange[0]!='' && $ageRange[1] > 0)  
         {
	//$birthDate=$_POST['bday'];
	$school_obj = new school_config();
	//$birthDate1 = explode("/",$birthDate);
        //$dob=$birthDate1[2]."-".$birthDate1[1]."-".$birthDate1[0];    
        
       
        $d1 = strtotime(date("Y-m-d", strtotime(str_replace("/", "-", $birthDate)))); 
        
        $min = strtotime('+'.$ageRange[0].'years',$d1);
        $max = strtotime('+'.$ageRange[1].'years',$d1);
        $d2 = strtotime($age_date); 
        
        if($d2 < $min )
        {
           $ageMsg="not";
        } 
        else if( $d2 > $max )
        {
            $ageMsg="not";
        }
        else{ $ageMsg  = 'ok';  }
       // echo $ageMsg; 
         }
         else
         {
             $ageMsg  = 'ok';
         }
		   
	/*	    $birthDate = $_POST["dob"];
            $school_obj = new school_config();
            $birthDate1 = explode("/", $birthDate);
            $dob = $birthDate1[2] . "-" . $birthDate1[1] . "-" . $birthDate1[0];
            
          //  $d1 = strtotime(date("Y-m-d", strtotime($dob)));
          //  $d2 = strtotime(date("Y-m-d"));
          //  $min_date = min($d1, $d2);
         //   $max_date = max($d1, $d2);
         //   $months = 0;
          //  while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
              //  $months++;
          //  }
          //  $yrs = floor($months / 12);
			//$age = floatval($yrs . "." . ($months - ($yrs * 12)));
			
			
			
           
		  
			
            $ageMsg = "";
             $ageRange = array($obj->adm_rule_age_from,$obj->adm_rule_age_upto);
			$is_age_valid=secondsToTime($ageRange[0],$ageRange[1],date('Y-m-d',strtotime($dob)));	
           // if (($age < floatval($ageRange[0])) && (floatval($ageRange[0]) > 0)) {
               // $ageMsg = 'not';
           // }
           // else if ($age < 0) {
              //  $ageMsg = 'not';
           // }
          //  else if (($age > floatval($ageRange[1])) && (floatval($ageRange[1]) > 0)) {
                //$ageMsg = 'not';
           // }
           // else {
               // $ageMsg = 'ok';
           // }
			
			$ageMsg='not';
			if($is_age_valid[0]==1)
				$ageMsg='ok'; */
			
			
            $creturn[] = $ageMsg;
        //------------END OF AGE VALIDATION -------------------------
            if(in_array('not', $creturn)){
                echo 'stop';
            }
            else{
                $sid=  md5(session_id());
                $qry = "Select * from tbl_adm_eligibilty where session_id='".$sid."' and app_id='".$_POST["appid"]."' and is_deleted=0";
                $result= mysqli_query($_SESSION['db_conn'],$qry) or die("Error: ".mysqli_error($_SESSION['db_conn']));
                if(mysqli_num_rows($result)>0){
                    $qry = "Update tbl_adm_eligibilty set 
                        first_name='".$_POST["first_name"]."',
                            last_name='".$_POST["last_name"]."',
                                father_name='".$_POST["father_name"]."',
                                    dob='".date("Y-m-d",  strtotime(str_replace("/"," ", $_POST["dob"])))."',
                         criteria_1='".$_POST["criteria_1"]."', 
                             criteria_2='".$_POST["criteria_2"]."', 
                                 criteria_3='".$_POST["criteria_3"]."', 
                                     criteria_4='".$_POST["criteria_4"]."', 
                                         criteria_5='".$_POST["criteria_5"]."', 
                                             criteria_6='".$_POST["criteria_6"]."', 
                                                 criteria_7='".$_POST["criteria_7"]."', 
                                                     criteria_8='".$_POST["criteria_8"]."', 
                                                        criteria_9='".$_POST["criteria_9"]."', 
                                                            criteria_10='".$_POST["criteria_10"]."', 
                                                                added_on='".$_SESSION['NOW']."' where session_id='".$sid."' and app_id='".$_POST["appid"]."' and is_deleted=0";
                }
                else{
                 $qry = "Insert into tbl_adm_eligibilty set session_id='".$sid."', 
                     app_id='".$_POST["appid"]."', 
                         first_name='".$_POST["first_name"]."',
                            last_name='".$_POST["last_name"]."',
                                father_name='".$_POST["father_name"]."',
                                    dob='".date("Y-m-d",  strtotime(str_replace("/"," ", $_POST["dob"])))."',
                         criteria_1='".$_POST["criteria_1"]."', 
                             criteria_2='".$_POST["criteria_2"]."', 
                                 criteria_3='".$_POST["criteria_3"]."', 
                                     criteria_4='".$_POST["criteria_4"]."', 
                                         criteria_5='".$_POST["criteria_5"]."', 
                                             criteria_6='".$_POST["criteria_6"]."', 
                                                 criteria_7='".$_POST["criteria_7"]."', 
                                                     criteria_8='".$_POST["criteria_8"]."', 
                                                        criteria_9='".$_POST["criteria_9"]."', 
                                                            criteria_10='".$_POST["criteria_10"]."', 
                                                                added_on='".$_SESSION['NOW']."', is_deleted=0";  
                }
                $result = mysqli_query($_SESSION['db_conn'],$qry) or die("Error: ".mysqli_error($_SESSION['db_conn']));
                if($result){
                    $_SESSION['token']=$sid;
                    $_SESSION['appid']=$_POST["appid"];

                    $_SESSION['first_name']=$_POST["first_name"];
                    $_SESSION['last_name']=$_POST["last_name"];
                    $_SESSION['father_name']=$_POST["father_name"];
                    $_SESSION['dob']=$_POST["dob"];
                    $_SESSION['criteria_1']=$_POST["criteria_1"];
                    $_SESSION['criteria_2']=$_POST["criteria_2"];
                    $_SESSION['criteria_3']=$_POST["criteria_3"];
                    $_SESSION['criteria_4']=$_POST["criteria_4"];
                    $_SESSION['criteria_5']=$_POST["criteria_5"];
                    $_SESSION['criteria_6']=$_POST["criteria_6"];
                    $_SESSION['criteria_7']=$_POST["criteria_7"];
                    $_SESSION['criteria_8']=$_POST["criteria_8"];
                    $_SESSION['criteria_9']=$_POST["criteria_9"];
                    $_SESSION['criteria_10']=$_POST["criteria_10"];
                    echo 'submit:::'.$_SESSION['token'].":::".$_SESSION['appid'];          
                    return;

                }
            }
            //=======================================xxxxxxxxxxxxxxxxxxxxxxxxxxx======================================
        }
        else{
//=======================================xxxxxxxxxxxxxxxxxxxxxxxxxxx======================================
            extract($_POST);
            if(strtolower($fieldid)==='criteria_8'){
                $ruleid=3;
            }
            else if(strtolower($fieldid)==='criteria_9'){
                $ruleid=4;
            }
            else if(strtolower($fieldid)==='criteria_10'){
                $ruleid=5;
            }
            if($ruleid>0){
                $qry1 = "select * from tbl_admission_additional_criteria where criteria_rule_id='".$ruleid."' and criteria_adm_id='".$appid."' and criteria_is_active=1 and criteria_is_deleted=0";
                $result1 = mysqli_query($_SESSION['db_conn'],$qry1) or die();

                if(mysqli_num_rows($result1)>0){
                    $obj = mysqli_fetch_object($result1);   

                    if(is_numeric($value)){
                        $dbv=trim($obj->criteria_value);
                        switch($obj->criteria_operator){
                            case '>': echo $value>$dbv && $value!="" ? 'ok' : 'not'; 
                            break;

                            case '<': echo $value<$dbv && $value!="" ? 'ok' : 'not';
                            break;

                            case '>=': echo $value>=$dbv && $value!="" ? 'ok' : 'not';
                            break;

                            case '<=': echo $value<=$dbv && $value!="" ? 'ok' : 'not';
                            break;

                            case '==': echo $value===$dbv && $value!="" ? 'ok' : 'not';
                            break;

                            case '=': echo $value===$dbv && $value!="" ? 'ok' : 'not';
                            break;
//
                            default: echo $obj->criteria_operator.' Case Not Found';
                        }
                    }
                    else{
                        
                        $dbv_array = explode(",",  trim(strtolower($obj->criteria_value)));
                        echo in_array(strtolower($value), $dbv_array) && $value!="" ? 'ok' : 'not';
                        
                    }
                }          
            }

            $qry2 = "select * from tbl_admission_courses_rules where adm_rule_app_open_id='".$appid."' and adm_rules_is_active=1 and adm_rules_is_deleted=0 LIMIT 1";
            $result2 = mysqli_query($_SESSION['db_conn'],$qry2) or die();

            if(mysqli_num_rows($result2)>0){
                $obj = mysqli_fetch_object($result2);                                
                if(strtolower($fieldid)==='criteria_1'){
                    if(is_numeric($value)){                        
                        $dbValue = explode("_", $obj->adm_rule_language_result);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }                     
                    }
                    else{
                        $dbValue = explode("_", $obj->adm_rule_language_result);                        
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }                        
                    }
                }
                else if(strtolower($fieldid)==='criteria_2'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->adm_rule_iq_result);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->adm_rule_iq_result);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                    
                }
                else if(strtolower($fieldid)==='criteria_3'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->adm_rule_internship_days);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->adm_rule_internship_days);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                }
                else if(strtolower($fieldid)==='criteria_4'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->adm_rule_last_result);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->adm_rule_last_result);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                }
                else if(strtolower($fieldid)==='criteria_5'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->addional_test_1);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->addional_test_1);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                    
                }
                else if(strtolower($fieldid)==='criteria_6'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->addional_test_2);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->addional_test_2);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                }
                else if(strtolower($fieldid)==='criteria_7'){
                    if(is_numeric($value)){
                        $dbValue = explode("_", $obj->addional_test_3);
                        if(count($dbValue) > 1){
                            echo $value>=$dbValue[1] ? 'ok' : 'not';   
                        }
                        else{
                            echo $value>=$dbValue[0] ? 'ok' : 'not';   
                        }
                    }
                    else{
                        $dbValue = explode("_", $obj->addional_test_3);
                        if(count($dbValue) > 1){
                            echo strtolower($value)===strtolower($dbValue[1]) ? 'ok' : 'not';
                        }
                        else{
                            echo strtolower($value)===strtolower($dbValue[0]) ? 'ok' : 'not';
                        }
                    }
                }
                else if(strtolower($fieldid)==='dob'){

                        
                       
	$option = $application_obj->checkValidAge($appid);
        $age_date = $application_obj->ageDate($appid);
        
	$ageRange = explode("---",$option);
        if($ageRange[0]!='' && $ageRange[1] > 0 )
        {
	//$birthDate=$_POST['bday'];
	$school_obj = new school_config();
	//$birthDate1 = explode("/",$birthDate);
        //$dob=$birthDate1[2]."-".$birthDate1[1]."-".$birthDate1[0];    
        
       
        $d1 = strtotime(date("Y-m-d", strtotime(str_replace("/", "-", $value)))); 
        
        $min = strtotime('+'.$ageRange[0].'years',$d1);
        $max = strtotime('+'.$ageRange[1].'years',$d1);
        $d2 = strtotime($age_date); 
        
        if($d2 < $min )
        {
           $ageMsg="not";
        } 
        else if( $d2 > $max )
        {
            $ageMsg="not";
        }
        else{ $ageMsg  = 'ok';  }
        
        }
        else
        {
            $ageMsg  = 'ok';
        }
        echo $ageMsg;          
                    
                    
                    
                    
                 /*   old code start comment only remove * multiline comment 
                    $birthDate=$value;
                        $school_obj=new school_config();
                        $birthDate1 = explode("/",$birthDate);
                        $dob=$birthDate1[2]."-".$birthDate1[1]."-".$birthDate1[0];

                        //$d1 = strtotime(date("Y-m-d",strtotime($dob)));
                       // $d2 = strtotime(date("Y-m-d"));
                       // $min_date = min($d1, $d2);
                       // $max_date = max($d1, $d2);
                       // $months = 0;
                      //  while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
                           // $months++;
                       // }
                       // $yrs = floor($months/12);

                       // $age=  floatval($yrs.".".($months-($yrs*12)));

						
						
						//echo $age,';',$dob,';',strtotime(date("Y-m-d")),';',strtotime($dob);

                      //  $ageMsg="";
                        $ageRange = array($obj->adm_rule_age_from,$obj->adm_rule_age_upto);

                       // if(($age <  floatval($ageRange[0])) && (floatval($ageRange[0]) > 0)){
                          //  $ageMsg.='not';
                        //}
                       // else if($age<0){
                           // $ageMsg='not';
                      //  }
                       // else if(($age>floatval($ageRange[1])) && (floatval($ageRange[1])>0)){
                          //  $ageMsg.='not';
                      //  }
                       // else {
                           // $ageMsg.='ok';
                      //  }
						
						$is_age_valid=secondsToTime($ageRange[0],$ageRange[1],date('Y-m-d',strtotime($dob)));
						$ageMsg='not';
						if($is_age_valid[0]==1)
							 $ageMsg='ok';
						
                        echo $ageMsg; old code end comment only remove * multiline comment */
                }
            }
        
    }
    return;
}
else if($_POST['action']=='upload_pic')
{
        $file_name = $_POST['file_name'];
	$school_id = $_POST['school_id'];
        
	$unique_image=time()."_".$file_name;
	//echo BASE_HREF."uploads/sch_".$school_id."/student_pics/";
	$fo = fopen(BASE_HREF."uploads/sch_".$school_id."/student_pics/name.txt","w");
	fwrite($fo,$unique_image,1000);
	//move_uploaded_file($_FILES['cover_image_file']['tmp_name'],"../../uploads/".$book_cover_image)
}
else if($_POST['action']=='mark_chronic')
{
    $student_obj=new student();
    extract($_POST);
    echo $student_obj->resultMarkChronic($type,$ids);
}
else if($_POST['action']=='remove_chronic')
{
    $student_obj=new student();
    extract($_POST);
    echo $student_obj->resultRemoveChronic($type,$ids);
}
else if($_GET['action']=='search_stud_app')
{
    $result =  mysqli_query($_SESSION['db_conn'],'Select * from tbl_applications_forms_field where app_open_id='.$_GET['open_id']." and app_is_deleted=0");
    if($result){
        $content='<thead>
                <tr valign="top">

                    <td width="8%">Form-Id</td>
                    <td width="10%">Submited On</td>
                    <td width="10%">Name</td>
                    <td width="10%">Gender</td>
                    <td width="10%">Status</td>
                    <td width="10%">Action</td>
                </tr>
            </thead>';
        if(mysqli_num_rows($result)>0){
            $i=1;
            while($arr=mysqli_fetch_array($result)){
                $gender = $arr['app_gender']=='M' ? 'Male' : 'Female';
                $content.='<tbody>
                    <td width="8%">'.$arr['app_form_field_id'].'</td>
                    <td width="10%">'.$config->ConvertGMTToLocal($arr['app_added_on']).'</td>
                    <td width="10%">'.$arr['app_first_name'].'</td>
                    <td width="10%">'.$gender.'</td>
                    <td width="10%">'.$arr['app_form_status'].'</td>
                    <td width="10%">
                    <a href="edit_student_registration.php?app_id='.$arr['app_open_id'].'&v='.$arr['app_form_field_id'].'"><img src="./images/edit.gif" /></a>
                    &nbsp&nbsp<a href="app/admission/applications_reviews.php?pk_id='.$arr['app_form_field_id'].'&action=4"><img src="./images/view.png" /></a>
                    </td>
                    </tbody>';
                //$app_id = $_GET['app_id'];
                //$form_id=$_GET['v'];

            }
        }
        else{
            $content.='<tbody><td>NO RECORD FOUND</td></tbody>';
        }
        echo $content;
    }
    else{
        echo mysqli_error($_SESSION['db_conn']);
    }
}
else if($_GET['action']=='search_stud_app_transfer')
{

    $batch_id = $_GET['batch_id'];
    $session_id = $_GET['session_id'];
    $comb_id = $_GET['prog_comb_id'];
    
    $result =  mysqli_query($_SESSION['db_conn'],'Select * from tbl_students where stud_batch_session_comb_id='.$comb_id.' and stud_batch_id='.$batch_id.' and stud_sess_id='.$session_id.' and stud_is_deleted=0 AND stud_tranfer_cert = 0 ');
    if($result){

        $content='<thead>
                <tr valign="top">
                 <td width="8%">SNo.</td>
                    <td width="8%">Admission No</td>
                    <td width="10%">R.No.</td>
                    <td width="10%">First Name</td>
                    <td width="10%">Last Name</td>
                    <td width="10%">Gender</td>
                    <td width="10%"><input type="checkbox" onclick="checkAll(),CountChecked(0,2)" name="allbox" id="student_trans" /> Check All</td>
                </tr>
            </thead>';
           $i=0;
        if( mysqli_num_rows($result) > 0 ){
            $sn = 1;
            while($arr = mysqli_fetch_array($result)){

               $gender = $arr['stud_gender']=='M' ? 'Male' : 'Female';

                $content.='<tbody>
                    <td width="8%">'.$sn.'</td>
                    <td width="8%">'.$arr['stud_adm_no'].'</td>
                    <td width="10%">'.$arr['stud_roll_no'].'</td>
                    <td width="10%">'.$arr['stud_first_name'].'</td>
                    <td width="10%">'.$arr['stud_last_name'].'</td>
                    <td width="10%">'.$gender.'</td>
                    <td width="10%"><input type="checkbox" name="student_trans['.$i.']" id="student_trans_'.$i.'" value="'.$arr['stud_id'].'" onclick="CountChecked('.$i.',1)" /></td>
                    </tbody>';
                //$app_id = $_GET['app_id'];
                //$form_id=$_GET['v'];
                $i=$i+1;
                $sn=$sn+1;

            }
            $content.='<tr>
                <td>
                    <input type="hidden" name="total_values" id="total_values" value="'.$i.'" />
                    <input type="hidden" name="total_checked" id="total_checked" value="0" />
                </td>
                </tr>';
        }
        else{
                $content.='<tbody><td>NO RECORD FOUND</td></tbody>';
        }
        echo $content;
    }
    else{
        echo mysqli_error($_SESSION['db_conn']);
    }
}
else if($_GET['action']=='tranfer_certificate')
{ 
    $config_obj = new school_config(); 
    $status_obj = new status();
    $batch_id = $_GET['batch_id'];
    $session_id = $_GET['sess_id'];
    $comb_id = $_GET['comb_id'];
    //Array ( [action] => tranfer_certificate [page] => 1 [sort_issue_date] => [per_page] => 50 [] => [] => null [] => null ) 
    if($batch_id > 0 && $session_id > 0 && $comb_id > 0){
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 1;
        $start = ($page - 1) * $per_page;

        $date_clause = trim($_GET['sort_issue_date']) != "" ? " ORDER BY transfer_cert_issue_date " . $_GET['sort_issue_date'] : "";
        if ($date_clause != "") {
            $qry = "SELECT *,CONCAT(stud_first_name,' ',stud_middle_name,' ',stud_last_name) AS fullname FROM tbl_students AS st 
                LEFT JOIN tbl_transfer_certificate as tc ON(st.stud_id = tc.transfer_cert_stud_id) 
                WHERE st.stud_batch_session_comb_id='" . $comb_id . "' AND st.stud_batch_id='" . $batch_id . "' AND 
                st.stud_sess_id='" . $session_id . "' AND st.stud_is_deleted=0 " . $date_clause . " ";
        } 
        else {
            $qry = "SELECT *,CONCAT(stud_first_name,' ',stud_middle_name,' ',stud_last_name) AS fullname FROM tbl_students AS st 
                LEFT JOIN tbl_transfer_certificate AS tc ON(st.stud_id = tc.transfer_cert_stud_id) 
                WHERE st.stud_batch_session_comb_id='" . $comb_id . "' AND st.stud_batch_id='" . $batch_id . "' AND 
                st.stud_sess_id='" . $session_id . "' AND st.stud_is_deleted=0 ORDER BY stud_added_on DESC";
        }
        
//        $qry = "SELECT *,CONCAT(stud_first_name,' ',stud_middle_name,' ',stud_last_name) AS fullname FROM tbl_students AS stud 
//                LEFT JOIN tbl_transfer_certificate AS tc ON(tc.transfer_cert_stud_id = stud.stud_id) 
//                LEFT JOIN tbl_address AS adr ON(adr.addr_stud_id = tc.transfer_cert_stud_id AND adr.addr_type='Present') 
//                WHERE stud.stud_is_active=1 AND stud.stud_is_deleted=0 ORDER BY stud.stud_added_on";
     
$result =  mysqli_query($_SESSION['db_conn'],$qry) or die(mysqli_error($_SESSION['db_conn']));
    if($result){
        
     $content='';
     
           $i=0;
           
        if(mysqli_num_rows($result)>0){
            $sn=1;
            while($obj = mysqli_fetch_object($result)){
//                echo '<pre>';
//                print_r($obj);
//                echo '</pre>';
               $gender = $obj->stud_gender=='M' ? 'Male' : 'Female';
               $action = $obj->stud_tranfer_cert == 1 ? 'Issued' : 'Create Certificate';
                $tcIssueDate = $obj->stud_added_on > 2010 ? date($_SESSION['DATEFORMAT'],strtotime($obj->stud_added_on)) : '---';
                $mod_code    = '00010014';
                if($config_obj->isModuleAllowed('ADD', $mod_code)){
                    $certi_link  = 'href="app/admission/create_certificate.php?stud_id='.$obj->stud_id.'" ';
                }
                else { 
                    $certi_link  = "href='javascript:alert(&#39;You do not have permission.&#39;)' ";
                }
                $content.='<tr height="30">
                    <td width="8%">'.$obj->stud_adm_no.'</td>
                    <td width="10%">'.$obj->stud_roll_no.'</td>
                    <td width="10%">'.ucwords($obj->stud_first_name).'</td>
                    <td width="10%">'.ucwords($obj->stud_last_name).'</td>
                    <td width="10%"><a '.$certi_link.' target="_blank">'.$action.'</a></td>
                    <td width="10%">'.$tcIssueDate.'</td>
                    <td width="10%">'.($obj->transfer_cert_issue_date > 2010 ? date($_SESSION['DATEFORMAT'], strtotime($obj->transfer_cert_issue_date)) : '---').'</td>
                    </tr>';
                $i=$i+1;
                $sn=$sn+1;
            }
            
            $content.='<tr height="30">
                <td>
                    <input type="hidden" name="total_values" id="total_values" value="'.$i.'" />
                    <input type="hidden" name="total_checked" id="total_checked" value="0" />
                </td>
                </tr>';
        }
        else{
            $content='<tbody><td>NO RECORD FOUND</td></tbody>';
        }
    }
    }
    else{
            $content='<tbody><td style="color:red; text-align:center; font-weight:bold;" colspan="6">Select Course Critera</td></tbody>';
        }
        echo $content;
    
}

else if($_POST['action']=='get_open_admission_data'){
    $adm_open_obj = new admission_open();
    echo $adm_open_obj->getOpenAdmissions($_POST['open_id'],'ADMIN');
}

else if($_POST['action']=='country')
{

        $state_id = $_POST['state_id'];
	$country_id = $_POST['country_id'];
	$type = $_POST['type'];
	$open_form_id = $_POST['aap_id'];

	$country_rec = mysqli_query($_SESSION['db_conn'],"select * from tbl_countries where country_id='".$country_id."'");
	$country_data = mysqli_fetch_array($country_rec);
	//criteria_adm_id
	$fetch_data = mysqli_query($_SESSION['db_conn'],"select * from tbl_admission_additional_criteria where criteria_adm_id='".$open_form_id."' and criteria_rule_id='3'");
	$data_rec = mysqli_fetch_array($fetch_data);
	$num_of_rec = mysqli_num_rows($fetch_data);
	if($num_of_rec > 0)
	{
		$explode_data = explode(',',$data_rec['criteria_value']);
		for($i=0;$i<count($explode_data);$i++)
		{
			if(strtolower($explode_data[$i])==strtolower($country_data['country_name']))
			{
				$error=0;
				break;
			}
			else
			{
				$error=1;
			}
		}
		if($error==0)
		{
			$option = $state_obj->getStateList($country_id,$state_id);
			echo $option;
		}
		else
		{
			echo $error;
		}
	}
	else
	{
		$option = $state_obj->getStateList($country_id,$state_id);
		echo $option;
	} 
	//}
	//echo $option;
       
}
else if($_POST['action']=='app_validate_test'){
        //echo "app_validate_testxx";
	$app_id=$_POST['app_id'];
	$val=$_POST['val'];
	$values=explode("---",$application_obj->checkValidTests($app_id));
	//print_r($values);
	if(trim($val)!=""){
            
		switch($_POST['type']){
			case 1: echo $values[0]>$val ? 'Minimum Required Value is '.$values[0] : true;
					break;
			case 2:	echo $values[1]>$val ? 'Minimum Required Value is '.$values[1] : true;
					break;
			case 3: echo $values[2]>$val ? 'Minimum Required Value is '.$values[2] : true;
					break;
			case 4:	echo $values[3]>$val ? 'Minimum Required Value is '.$values[3] : true;
					break;
			default : echo $_POST['type']." : Case Not Found";
		}
                
	}
}
else if($_POST['action']=='is_test_exist'){
    	$app_id=$_POST['app_id'];
	echo $application_obj->checkValidTests($app_id);
}
else if($_POST['action']=='calc_age')
{
	$app_id = $_POST['app_id'];
	$option = $application_obj->checkValidAge($app_id);
        $age_date = $application_obj->ageDate($app_id);
        
	$ageRange = explode("---",$option);
        if($ageRange[0]!='' && $ageRange[1] > 0 )
        {
	//$birthDate=$_POST['bday'];
	$school_obj = new school_config();
	//$birthDate1 = explode("/",$birthDate);
        //$dob=$birthDate1[2]."-".$birthDate1[1]."-".$birthDate1[0];
        $d1       = strtotime(date("Y-m-d", strtotime(str_replace("/", "-", $_POST['bday'])))); 
        $agrng    = explode(".",$ageRange[0]);
        $agendrng = explode(".",$ageRange[1]);
        if($agrng[1] > 0 )
        {
            $min = strtotime('+'.$agrng[0].'years',$d1);
            $min = strtotime('+'.$agrng[1].'months',$min); 
        }
        else
        {
            $min = strtotime('+'.$ageRange[0].'years',$d1);            
        }
        if($agendrng[1] > 0 )
        {
            $max = strtotime('+'.$agendrng[0].'years',$d1);
            $max = strtotime('+'.$agendrng[1].'months',$max); 
        }
        else
        {
            $max = strtotime('+'.$ageRange[1].'years',$d1);
        }
        $d2 = strtotime($age_date); 
        if($d2 < $min )
        {
           $ageMsg.="Min Required Age is ".$ageRange[0]." Years till $age_date <br />";
        } 
        else if( $d2 > $max )
        {
            $ageMsg.="Max Required Age is ".$ageRange[1]." Years till $age_date";
        }
        else{    }
        
        }
        else
        {
            
        }
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $months = 0;
        
        /*old code start 
        while (($min_date  = strtotime("+1 MONTH", $min_date)) <= $max_date) {
           $months++;
        } 
       
        $yrs=floor($months/12);                 
        $age =  floatval($yrs.".".($months-($yrs*12)));
	$ageMsg="";        
      
	
//	$is_age_valid=secondsToTime($ageRange[2],$ageRange[3],date('Y-m-d',strtotime($dob)));	
//	
//	if($is_age_valid[0]==0)
//	{
//		if($is_age_valid[1]!="" && $is_age_valid[2]!="")
//		$ageMsg="Date of Birth Should Be  ".$is_age_valid[1]." To $is_age_valid[2] ";
//	}
	
/*old code start	
	if(($age <  floatval($ageRange[0])) && (floatval($ageRange[0]) > 0)){
		$ageMsg.="Min Required Age is ".$ageRange[0]." Years till $age_date <br />";
	}
	else if($age < 0){
		$ageMsg=$birthDate." is Invalid Date of Birth";
	}
	if(($age > floatval($ageRange[1])) && (floatval($ageRange[1]) > 0 )){
		$ageMsg.="Max Required Age is ".$ageRange[1]." Years till $age_date";
	}eof old code*/
	echo $ageMsg; 
}
else if($_POST['action']=='getTimeFormat')
{	$config_obj=new school_config();
	$option=$config_obj->getTimeHourFormat();
	echo substr($option,0,2);

}

else if($_POST['action']=='area')
{
	$city_id   = $_POST['city_id'];
	$area_id   = $_POST['area_id'];
	$open_form_id = $_POST['app_id'];

	$country_rec = mysqli_query($_SESSION['db_conn'],"select * from tbl_cities where city_id='".$city_id."'");
	$country_data = mysqli_fetch_array($country_rec);
	//criteria_adm_id
	$fetch_data = mysqli_query($_SESSION['db_conn'],"select * from tbl_admission_additional_criteria where criteria_adm_id='".$open_form_id."' and criteria_rule_id='5'");
	$data_rec = mysqli_fetch_array($fetch_data);
	$num_rec = mysqli_num_rows($fetch_data);
	if($num_rec > 0)
	{
		$explode_data = explode(',',$data_rec['criteria_value']);
		for($i=0;$i<count($explode_data);$i++)
		{
			if(strtolower($explode_data[$i])==strtolower($country_data['city_name'])){
				$error=0;
				break;
			}
			else{
				$error=1;
			}
		}
		if($error==0){
                    
			$option = $areas->getAreaList($city_id,$area_id);
			echo $option;
                        
		}
		else
		{
			echo $error;
		}

	}
	else
	{
		$option = $areas->getAreaList($city_id,$area_id);
		echo $option;

	}


}

else if($_POST['action']=='seacrh_admn_no')
{
    $keyword=trim($_POST['key']);
    echo $option=$student_obj->getSearchResult(trim($keyword));
}

else if($_POST['action']=='seacrh_location')
{
	$keyword=$_POST['key'];
	$str=explode(",",$keyword);
	$i=count($str)-1;
	if($keyword!=""){
            
		switch($_POST['fieldid']){

			case 5: $option = $student_obj->getCountrySearchResult($str[$i]);//echo $_POST['fieldid'];
					break;
			case 6: $option = $student_obj->getStateSearchResult($str[$i]);//echo $_POST['fieldid'];
					break;
			case 7: $option = $student_obj->getCitySearchResult($str[$i]);//echo $_POST['fieldid'];
					break;
			case 8: $option = $student_obj->getAreaSearchResult($str[$i]);//echo $_POST['fieldid'];
					break;
                                    
		}
		echo $option;
	}
}
else if($_POST['action']=='delete_admission_open'){
	$ids=explode(",",$_POST['admission_id']);
	$chk=array();
	$msg="";
	foreach($ids as $id){
		$status=$adm_open->chkAppOpenDependency($id);
		if($status){
			$msg="<b>".$adm_open->deleteAdmissionOpen($id)."</b>";
		}
		else{
			$chk[]="Not";
		}
	}
	if(in_array("Not",$chk)){
		$msg.="<br />You cannot delete admission rules,<br /> First delete all Students of these rule, then try again..";
	}
	echo $msg;
}

else if($_POST['action']=='chk_app_open_dependency'){
	$ids=$_POST['ids'];
	switch($_POST['option']){
		case 'admision_rule': echo $adm_open->chkAppOpenDependency($ids); break;
	}
}
else if($_POST['action']=='state')
{
	  $state_id=$_POST['id'];
	  $city_id = $_POST['city_id'];
	  $edit_state_id="";

 	 $open_form_id = $_POST['app_id'];

	$country_rec = mysqli_query($_SESSION['db_conn'],"select * from tbl_states where state_id='".$state_id."'");
	$country_data = mysqli_fetch_array($country_rec);
	//criteria_adm_id
	$fetch_data = mysqli_query($_SESSION['db_conn'],"select * from tbl_admission_additional_criteria where criteria_adm_id='".$open_form_id."' and criteria_rule_id='4'");
	$data_rec = mysqli_fetch_array($fetch_data);
	$num_rec = mysqli_num_rows($fetch_data);
	if($num_rec > 0)
	{
		$explode_data = explode(',',$data_rec['criteria_value']);
		for($i=0;$i<count($explode_data);$i++)
		{
			if(strtolower($explode_data[$i])==strtolower($country_data['state_name']))
			{
				$error=0;
				break;
			}
			else
			{
				$error=1;
			}
		}
   		if($error==0)
		{
			$option=$city_obj->getCityList($state_id,$city_id);
			echo $option;
		}
		else
		{
			echo $error;
		}
	}
	else
	{
			$option=$city_obj->getCityList($state_id,$city_id);
			echo $option;
	}
 }

else if($_POST['action']=='course')
{
	$program_id=$_POST['id'];
        $table_name=$_POST['table_name'];
	$option=$adm_open->get_course($program_id,$table_name);
	echo $option;

}
else if($_POST['action']=='session')
{
	$batch_id=$_POST['id'];
	$option=$adm_open->get_session($batch_id);
	echo $option;

}
else if($_POST['action']=='semester')
{
	$pro_sem_id=$_POST['id'];
	$option=$adm_open->get_semester1($pro_sem_id);
	echo $option;
}
else if($_POST['action']=='shift')
{
	$prog_shift_id=$_POST['id'];
	$option=$adm_open->get_shift($prog_shift_id);
	echo $option;
}
else if($_POST['action']=='stream')
{
	$prog_stream_id=$_POST['id'];
	$option=$adm_open->get_stream($prog_stream_id);
	echo $option;

}
else if($_POST['action']=='clear_test_review')
{
	$testReview = new testReview();
	$clear_student_id = $_POST['clear_student'];
	$test_review_status = $_POST['test_review_status'];
	$option=$testReview->addTestReview($clear_student_id,$test_review_status);
	echo $option;

}
else if($_POST['action']=='clear_interview_review')
{
	$interviewReview = new interviewReview();
	$clear_stud_interview_id=$_POST['clear_stud_interview_id'];
	$interview_review_status=$_POST['interview_review_status'];
	$vlaue = $interviewReview->addInterviewReview($clear_stud_interview_id,$interview_review_status);
	echo $vlaue;
}
else if($_POST['action']=='delete_challan')
{
	$admissionChallan=new admissionChallan();
	$challan_id = $_POST['challan_id'];
	$option = $admissionChallan->deleteAdmissionChallan($challan_id);
	echo $option;
}
else if($_POST['action']=='calculation_total')
{
	extract($_POST);
	$admissionFees=new admissionFees();
	$option=$admissionFees->admissionGrandTotal($adm_fees,$adm_hostel,$adm_transport,$adm_tution,$adm_school_expense,$adm_discount);
	echo $option;

}
else if($_POST['action']=='delete_admission_fees')
{
	$admissionFees=new admissionFees();
	$admission_id = $_POST['admission_id'];
	$option = $admissionFees->deleteAdmissionFees($admission_id);
	echo $option;

}
else if($_POST['action']=='submitCriteriaList'){
    $criteria_list_obj = new criteria_list();
	//extract($_POST);
	
	$total_cnt= $_POST["tr_cnt"];

if($_SERVER['REQUEST_METHOD']=="POST" && $_SESSION["timestamp"]!= $_POST["timestamp"]){

	$_SESSION["timestamp"]=$_POST["timestamp"];

        //echo 'totalcnt: '.$total_cnt.'<br/>';
	$criteria_ids = $_POST["db_c_ids"];

	if($criteria_ids==""){
		for($i=1;$i<=$total_cnt;$i++){
                    $criteria_name = $_POST['criteria_'.$i];
                    if(trim($criteria_name)!=""){
                            $final_msg = $criteria_list_obj->addCriteria($criteria_name);
                    }
		}

	}
        else{
               $c_arr = explode(':',substr($criteria_ids,0,-1));
               $update_cnt = count($c_arr);
               
		for($n=0;$n<$update_cnt;$n++){
                    $id=$c_arr[$n];
                    //echo 'update_id: '.$id.' :: ';
                    $criteria_name = $_POST['criteria_'.$id];
                    if(trim($criteria_name)!=""){
                            //echo ' :id updated: '.$id.' :: ';
                       //new code start     
                            $qry = mysqli_query($_SESSION['db_conn'],"UPDATE tbl_criteria_lists SET criteria_name ='".$criteria_name."' WHERE criteria_id = '".$id."'  ")or die('error : '.mysqli_error($_SESSION['db_conn']));
                            if($qry)
                            {
                                $final_msg = "Updated Successfully";
                            }
                            
                            //new code eof
                           
                            //$final_msg= $criteria_list_obj->editCriteria($id,$criteria_name);  //old code change by bishnu
                    }
                                
		}
                //$new_row = $total_cnt - $update_cnt;
                $max_id= $criteria_list_obj->getMaxCriteriaId();
                //echo ' max_id:'.$update_cnt;
		for($k=$max_id+1;$k<=$total_cnt;$k++){
                    $criteria_name = $_POST['criteria_'.$k];
                            if(trim($criteria_name)!=""){
                            $final_msg= $criteria_list_obj->addCriteria($criteria_name);
                    }
		}
	}

	echo $final_msg;
}


}else if($_POST['action']=='deleteCriteriaList'){

	$criteria_id=$_POST['criteria_id'];
	$criteria_list_obj = new criteria_list();
	$msg=$criteria_list_obj->deleteCriteria($criteria_id);
	echo $msg;

}else if($_POST['action']=='shortlist_app'){

	$student_obj= new student();
	$stu_id=trim($_POST['stu_ids']);
	$option=$student_obj->shortlistStudents($stu_id);
	echo $option;
}
else if($_POST['action']=='reject_app'){

	$stu_id=$_REQUEST['stu_ids'];
	$option=$student_obj->rejectStudents($stu_id);
	echo $option;
}

else if($_POST['action']=='id_card_data'){
//    $student_obj = new student();
//    $adm_number = trim($_POST['adm_num']);
//    $bc = new Barcode39($adm_number);

//    $dir = "../../uploads/sch_" . $_SESSION['school_id'] . "/barcode/student/";
//    $dh = opendir($dir);
//    while ($file = readdir($dh)) {
//        if ($file != '.' && $file != '..') {
//            unlink($dir . $file);
//        }
//    }
//    closedir($dh);
//
//    if ($bc->draw("../../uploads/sch_" . $_SESSION['school_id'] . "/barcode/student/" . $adm_number . "_barcode.gif") == 1) {
//        $record = $student_obj->getStudentDetailByAdmNum($adm_number);
//        echo $record.=":::SEPARATOR:::sch_" . $_SESSION['school_id'] . "/barcode/student/" . $adm_number . "_barcode.gif";
//    }
}
else if($_POST['action']=='save_id_card'){

	$student_obj= new student();
	$adm_no=$_POST['adm_no'];
	$stud_img=$_POST['stud_image'];
	$valid=$_POST['validity'];
	echo $record=$student_obj->saveStudentIdCard($adm_no,$stud_img,$valid);

}
else if($_POST['action']=='display_id_card'){

	$student_obj= new student();
	$adm_no=trim($_POST['value']);
	echo $id_card=$student_obj->getStudentIdCard($adm_no);
}
else if($_POST['action']=='admit_student')
{
  //==================================================================================================================================================================
    $student_obj = new student();
    $batch_sess_obj = new batchsession();
    $app_review_obj = new application_review();
    $adm_open_obj = new admission_open();
    $prgrm_obj = new program();
    $stream_obj = new stream();
    $semester_obj = new semester();
    $course_obj = new course(); 
    $batch_obj = new batch();
    $config_obj = new school_config();
    $feeType_obj = new feeType;
                
    $stu_ids=explode(",",$_POST['stu_ids']);
    if(isset($_SESSION['miss_docs_name']))
    {	
        unset($_SESSION['miss_docs_name']);	
    }
    //print_r($stu_ids);
    $skip = 0;
    $done = 0;
    foreach($stu_ids as $form_id)
    {
        $options       = $app_review_obj->getAppReview($form_id);
        $app_open_data = $adm_open_obj->getAdmissionRecord($options->app_open_id);

        /* Get all the codes that are set in configration */
        $cource_code   = $course_obj->getCourseCode($app_open_data->app_course_id);
        $prgrm_code    = $prgrm_obj->getProgramCode($app_open_data->app_program_id);
        $stream_code   = $stream_obj->getStreamCode($app_open_data->app_stream_id);
        /* End All Records */
        if($feeType_obj->isFeeConfigured($app_open_data->app_batch_id, $app_open_data->app_session_id, $app_open_data->app_comb_id))
        {
            /* Fetch admission number configration */
            $config_data = $config_obj->getConfigurationRecord();                                        
            $admArray = array();

            /* Genrate the admission by the configration */
            if(trim($config_data->admission_no_prefix)!='')
            {
                $admArray[] = trim($config_data->admission_no_prefix);
            }

            if(trim($config_data->admission_program_code)!='')
            {
                $admArray[] = trim($config_data->admission_program_code);
            }

            if(trim($config_data->admission_course_code)!='')
            {
                $admArray[] = trim($config_data->admission_course_code);
            }

            if(trim($config_data->admission_stream_code)!='')
            {
                $admArray[] = trim($config_data->admission_stream_code);
            }

            $result = mysqli_query($_SESSION["db_conn"],"SHOW TABLE STATUS LIKE 'tbl_students'");
            if($result)
            {
                $row = mysqli_fetch_array($result);
                $nextId = $row['Auto_increment'];   
            }
            else
            {
                $nextId = 'NA';   
            }

            if(intval($config_data->admission_no_student_id)>0)
            {
                $admArray[] = str_pad($nextId, $config_data->admission_no_student_id, '0', FALSE);
            }
            else
            {
                $admArray[] = $nextId;
            }

            if(trim($config_data->admission_no_suffix)!='')
            {
                $admArray[] = trim($config_data->admission_no_suffix);
            }

            $seprator = trim($config_data->admission_no_sapretor)!='' ? $config_data->admission_no_sapretor : '-';
            $adm_no   = implode($seprator, $admArray);

            /* End************************************************************ */

            $app_open_id = $options->app_open_id;
            $comb_id = 0;
            $addresses  = $app_review_obj->getAddress($form_id);
            $addrs      = explode("///", $addresses);
            $permanent  = explode("::", $addrs[0]);
            $present    = explode("::", $addrs[1]);
            $father     = explode("::", $addrs[2]);
            $mother     = explode("::", $addrs[3]);

            $d        = $app_review_obj->getUploadedDocs($form_id);
            $doc      = explode("/", $d);
            $req_docs = explode(",", $doc[0]);
            $status   = explode(",", $doc[1]);


            $i              = 0;
            $lmt            = count($status) - 1;
            $miss_docs_name = array();
            while ($lmt) {

                if ($status[$i] == "") {
                    $miss_docs_name[] = "'" . $req_docs[$i] . "'";
                }
                $lmt--;
                $i++;
            }
            $_SESSION['miss_docs_name'] = implode(",", $miss_docs_name);

            $app_images = $options->app_image;
            $school_id = $options->app_school_id;
            $birthDate = explode("-", $options->app_dob);
            $stud_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
            $mobile = $present[8];
            $telephone = $present[9];
            $email_add = $present[11];
            //print_r($present);
            //Array ( [0] => Present [1] => Laxmi Nagar [2] => gfg [3] => India [4] => Uttar Pradesh [5] => Bareilly [6] => Railway Station [7] => 244001 [8] => 9076755633 [9] => 0124435665 [10] => 0 [11] => uatdev@gmail.com [12] => 21 )
            $father_income = 0;
            $batch_id = $app_open_data->app_batch_id;
            $sess_id = $app_open_data->app_session_id;
            $comb_id = $app_open_data->app_comb_id;

            if($feeType_obj->createAccountsGroup($batch_id, $sess_id, $comb_id))
            {
                if($student_obj->checkStudentExist($adm_no))
                {
                    if($rollno = $student_obj->makeRollNo($comb_id, $batch_id, $sess_id))
                    {
                        $adm_type = $options->app_admin_type > 0?$options->app_admin_type:1;
                        $stud_admission_date = date("Y",strtotime($options->app_admission_date)) > '1990'?$options->app_admission_date:date("Y-m-d");
                        $msg = $student_obj->addEditApplicationReview($form_id, $app_open_id, $adm_no, $options->app_first_name, $options->app_middle_name, $options->app_last_name, $rollno, $options->app_father_name, $options->app_mother_name, $adm_type, $options->app_image, $stud_age, $options->app_gender, $options->app_dob, $options->app_place_of_birth, $options->app_religion_id, $options->app_nationality_id, $options->app_passport_no, $options->app_marital_status_id, $options->app_language_known, $mobile, $telephone, $email_add, $options->app_blood_group, $batch_id, $sess_id, $comb_id, $dismissed_type, $dismissed_reason, $crime_type, $crime_detail, $lab_certification, $app_extra_activity, $app_leaving_reason, $app_sibling_admission_no, $app_physical_challenged, $app_physical_challenged_desc, $app_language_test_result, $app_iq_test, $app_last_result, $stud_admission_date);
                    }// End if of "Student Roll Number"
                }
                else
                {
                    $msg = "Student is already Admitted";
                }// End if else of "checkStudentExist"
                $done++;
            }
        }
        else
        {
            $skip++;
            continue;
        }
    }    

    if(($skip == 0) && ($done > 0))
    {
        echo true;
    }
    else if(($skip > 0) && ($done > 0))
    {
        echo $done." Students are Admited Successfully..<br /> and ".$skip." Students are unable to admit due to there course fees not configured.";
    }
    else if($skip > 0 && ($done == 0))
    {
        echo "No Student Admitted, Course fees is not Configured.";
    }
    else
    {
        echo $msg;
    } 
//==============================================================================================================================================================
}

else if($_POST['action']=='delete_application')
{

	$application_obj= new application();
	$app_id=$_POST['application_id'];
	$option=$application_obj->deleteRejApplication($app_id);
	echo $option;
}
else if($_POST['action']=='delete_students')
{
	$application_obj= new application();
	$app_id=$_POST['application_id'];
	$option=$application_obj->deleteStudents($app_id);
	echo $option;
}
else if($_POST['action']=='delete_id_card')
{
	extract($_POST);        
        $application_obj= new application();
	echo $application_obj->deleteStudentIDCard($icard_id);
}
else if($_POST['action']=='validate_app'){

	$student_obj= new student();
	$app_ids=explode(",",$_POST['app_ids']);
	$msg=array();
	$open_id1=$student_obj->getStudentAppOpenId($app_ids[0]);
	foreach($app_ids as $id){
		$open_id2=$student_obj->getStudentAppOpenId($id);
		if($open_id1==$open_id2){
			$msg[]="Matched";
		}
		else if($open_id1!=$open_id2){
			$msg[]="Not";
		}
	}
	if(in_array("Not",$msg)){
		echo "Please Select Same Programme Students only.";
	}
	else{
		echo $open_id1;
	}
}
else if($_GET['action']=='add_schedule'){   //print_r($_GET); return;
        $config_obj=new school_config();
    $schTime=  $config->ConvertGMTToLocal(strtotime($_GET['time'],true,false));
    $configRecord = $config_obj->getConfigurationRecord();

    if(strtotime($schTime) < strtotime($configRecord->config_start_time)){
        echo "Selected Time must be a School Start Time or Greater";
        return false;
    }
    else if((strtotime($schTime) >= strtotime($configRecord->config_recess_start_time)) && strtotime($schTime) < strtotime($configRecord->config_recess_end_time)){
        echo "Selected Time Cannot be a School Recess Time ";
        return false;
    }
    else if(strtotime($schTime) >= strtotime($configRecord->config_end_time)){
        echo "Selected Time Cannot be a School Closing Time or Greater";
        return false;
    }
    else{
        return;
            extract($_GET);
            /*Array
            (
                [action] => validate_schedule_time
                [time] => 01:00 am
                [atatime] => 2
                [eachtime] => 45
            )*/
            //    echo $configRecord->config_start_time;
            //    echo $configRecord->config_recess_start_time;
            //    echo $configRecord->config_recess_end_time;
            //    echo $configRecord->config_end_time;
            //    echo strtotime($schTime)."<".strtotime($configRecord->config_start_time);

            //08:00 AM12:30 PM01:00 PM02:00 PM1380569400<1380594600

//            $inaday = 2;
//            $time1=$time;
//            $time2=date("h:i A",strtotime($time1." +".$eachtime." minutes"));
//            $time_slots_in_day = ceil(($inaday/$atatime));
//            $start_time = array();
//            $end_time = array();
//            $test_time = array();
        //=== BEGIN Calculating Time Slotes of student====
//            for ($i = 0; $i < $time_slots_in_day; $i++) {
//                if ((strtotime($time1) >= strtotime($configRecord->config_recess_start_time)) && (strtotime($time1) <= strtotime($configRecord->config_recess_end_time))) {
//                    $start_time[$i] = $configRecord->config_recess_end_time;
//                    $end_time[$i] = date("h:i A", strtotime($start_time[$i]." +".$eachtime." minutes"));
//                } else {
//                    $start_time[$i] = $time1;
//                    $end_time[$i] = $time2;
//                }
//                $time1 = $end_time[$i];
//                $time2 = date("h:i A", strtotime($time1." +".$eachtime." minutes"));
//                if((strtotime($start_time[$i]) >= strtotime($configRecord->config_end_time)) || (strtotime($end_time[$i]) > strtotime($configRecord->config_end_time))){
//                   // echo $inaday." Candidates cannot be scheduled at this time, School wil be closed at ".$configRecord->config_end_time;
//                    //return false;
//                }
//                $test_time[$i] = $start_time[$i] . " - " . $end_time[$i]; //Test Timing of each slot in a day.
//            }
            //print_r($test_time);
            

        //=== END Calculating Time Slotes of student====
    }
}
else if($_POST['action']=='schedule_end_time'){                                                             
    extract($_POST);     
    $config_obj=new school_config();
    $configRecord = $config_obj->getConfigurationRecord();
    $recessSec = (strtotime($configRecord->config_recess_end_time) - strtotime($configRecord->config_recess_start_time));
   
    if(strtotime($schedule_start_time)<=strtotime($configRecord->config_recess_start_time)){
        $ExamSeconds = (strtotime($configRecord->config_end_time) - strtotime($schedule_start_time)) - $recessSec;
    }
    else{
        $ExamSeconds = (strtotime($configRecord->config_end_time) - strtotime($schedule_start_time));
    }
    
    $AvilMin = $ExamSeconds/60;
    
    if($schedule_each_time>$AvilMin){
        echo "invalid_each_time";
        return;
    }
    
    $slots = floor($AvilMin/$schedule_each_time);   
    $studPerDay = ($slots * $schedule_in_time);
    $studPerDay = $totcount < $studPerDay ? $totcount : $studPerDay ;
    
    $periods = (int) ceil($totcount/$schedule_in_time);    
    $ExamMinutes = $periods <= $slots ? ($schedule_each_time * $periods) : ($schedule_each_time*$slots); 
    if($configRecord->config_time_format == "12 Hr")
    { 
        $end_time = date("h:i A",strtotime($schedule_start_time." +".$ExamMinutes." minutes"));
    }
    else
    {
        $end_time = date("H:i ",strtotime($schedule_start_time." +".$ExamMinutes." minutes"));
    }
    //$end_time = date("h:i A",strtotime($schedule_start_time." +".$ExamMinutes." minutes"));
             
    if((strtotime($end_time)>strtotime($configRecord->config_recess_start_time)) && (strtotime($end_time)<= strtotime($configRecord->config_recess_end_time))){
        //$end_time = date("h:i A",strtotime($end_time." -".($recessSec/60)." minutes")); //by me
        
        if($configRecord->config_time_format == "12 Hr")
        { 
            $end_time = date("h:i A",strtotime($schedule_start_time." +".$ExamMinutes." minutes"));
        }
        else
        {
            $end_time = date("H:i ",strtotime($schedule_start_time." +".$ExamMinutes." minutes"));
        }
    }
    
    echo "B:::".$end_time.":::".$studPerDay;
    return;    
}
else if ($_POST['action'] == 'schedule_end_date'){
    $student_obj = new student();
    $config_obj = new school_config();
    $date_type = explode("/", $_POST['date']);
    
    if($date_type[0] < 10){
        $strt_date = "0" . $date_type[0] . "/" . $date_type[1] . "/" . $date_type[2];
    }
    else{
        $strt_date = $_POST['date'];
    }
    $start_date = date("Y-m-d",strtotime(str_replace("/", "-", $strt_date)));//$config_obj->getDBDateValue(trim($strt_date));

    $start_day = date("D", strtotime($start_date));
    $days = trim($_POST['days']);
    $open_id = trim($_POST['open_id']);
    $holiday = explode(",", $student_obj->getHoliday());

    if(in_array($start_day, $holiday)){
        echo "Holiday::WF::" . implode(",", $holiday);
    } 
    else{
        $app_msg = $student_obj->getAppEndDate($open_id, $start_date, $_POST['type'], $_POST['app_ids']);
        if($app_msg == 1){
            $i = 1;
            $c = 0;
            while($days > 0){
                $end_day = date("D", strtotime($start_date . "+" . $i . " days"));
                if(in_array($end_day, $holiday)){
                    $c++;
                    $days++;
                }
                $days--;
                $i++;
            }
            echo trim($end_date = date($_SESSION['DATEFORMAT'], strtotime($start_date . " +" . (trim($_POST['days']) + $c) . " days")));
        } 
        else{
            echo $app_msg;
        }
    }
}
else if ($_POST['action'] == 'add_schedule'){
    extract($_POST);
    $student_obj = new student();
    $config_obj = new school_config();
    $ids = explode(",", $_POST['app_ids']);

    $schedule_start_date = date("Y-m-d", strtotime(str_replace("/", " ", $schedule_start_date)));
    $schedule_end_date   = date("Y-m-d", strtotime(str_replace("/", " ", $schedule_end_date)));

    $schedule_start_time = date("h:i A", strtotime($schedule_start_time));
    $schedule_end_time   = date("h:i A", strtotime($schedule_end_time));

    switch (trim($_POST['schdl_type'])){
        case 'Test': $status = $student_obj->addAdmTestSchedule('Test',$app_open_id, $schedule_in_day, $schedule_in_time, $schedule_each_time, $schedule_start_date, $schedule_end_date, $schedule_start_time, $schedule_end_time, $ids, $schedule_total_days);
            break;
        
        case 'Test-Scheduled': $status = $student_obj->addAdmTestSchedule('Test-Scheduled',$app_open_id, $schedule_in_day, $schedule_in_time, $schedule_each_time, $schedule_start_date, $schedule_end_date, $schedule_start_time, $schedule_end_time, $ids, $schedule_total_days);
            break;
        
        case 'Interview': $status = $student_obj->addAdmInterviewSchedule('Interview',$app_open_id, $schedule_in_day, $schedule_in_time, $schedule_each_time, $schedule_start_date, $schedule_end_date, $schedule_start_time, $schedule_end_time, $ids, $schedule_total_days);
            break;
        
        case 'Interview-Scheduled': $status = $student_obj->addAdmInterviewSchedule('Interview-Scheduled',$app_open_id, $schedule_in_day, $schedule_in_time, $schedule_each_time, $schedule_start_date, $schedule_end_date, $schedule_start_time, $schedule_end_time, $ids, $schedule_total_days);
            break;
    }
    echo $status;
}
else if($_POST['action']=='schedule_app'){
    extract($_POST);
    $student_obj = new student();
    $app_ids = trim($_POST['app_ids']);
    $schedule_start_date = date("Y-m-d",strtotime(str_replace("/"," ", $schedule_start_date)));
    $schedule_start_time = date("h:i A",strtotime($schedule_start_time));
    $schedule_end_time   = date("h:i A",strtotime($schedule_end_time));

    switch(trim($_POST['schdl_type'])){
        case 'Test': $status = $student_obj->scheduleStudents($app_ids, "Test_Scheduled", $schedule_start_date, $schedule_start_time, $schedule_end_time);
            break;

        case 'Interview': $status = $student_obj->scheduleStudents($app_ids, "Interview_Scheduled", $schedule_start_date, $schedule_start_time, $schedule_end_time);
            break;
    }
    echo $status;
}
else if (trim($_POST['action']) == 'add_marks'){

    extract($_POST);
    
    if ($case == "update") {
        $test_regn_no = $test_regn_no_1;
        $intw_regn_no = $intw_regn_no_1;
    }

    $percentage = 0;

    switch (strtoupper(trim($type))){
        case "TEST": $percentage = intval($test_max_marks) > 0 ? (intval($test_obtain_marks) / intval($test_max_marks)) * 100 : '0';
            break;

        case "INTW": $percentage = intval($intw_max_marks) > 0 ? (intval($intw_obtain_marks) / intval($intw_max_marks)) * 100 : '0';
            break;
    }

    $student_obj = new student();

    switch(strtoupper($type)){
        case "TEST": if ($app_open_id > 0) {
                $obj = $student_obj->getPassMarks(1, $app_open_id);
            }
            break;

        case "INTW": if ($app_open_id > 0) {
                $obj = $student_obj->getPassMarks(2, $app_open_id);
            }
            break;
    }

    $required_marks = 0;
    $operator = '';
    $status = '';
    $operator = trim($obj->criteria_operator);
    $required_marks = intval($obj->criteria_value);

    switch ($operator) {

        case "<": if ($percentage < $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;

        case ">": if ($percentage > $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;

        case "=": if ($percentage == $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;

        case "==": if ($percentage == $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;

        case "<=": if ($percentage <= $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;

        case ">=": if ($percentage >= $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;
        case "!=": if ($percentage != $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
            break;
        default : if ($percentage >= $required_marks) {
                $status = "PASS";
            } else {
                $status = "FAIL";
            }
    }

    switch (trim($_POST['type'])){
        case "TEST": $msg = $student_obj->addAdmissionTestMarks($test_regn_no_1, $test_max_marks, $test_obtain_marks, $percentage, $status);
            break;

        case "INTW": $msg = $student_obj->addAdmissionIntwMarks($intw_regn_no_1, $intw_max_marks, $intw_obtain_marks, $percentage, $status);
            break;
    }

    echo $msg;
}
if($_POST['action']=='add_admission_type')
{

	  	extract($_POST);

		$ad_type_id=$_POST['ad_type_id'];

	  	$exist_msg=$admission_type_obj->checkAdmissionTypeExist($ad_type_title,$ad_type_id);
		 if($exist_msg!=""){ echo $exist_msg; }

		  else if($ad_type_id>0){

				echo $admission_type_obj->updateAdmissionType($ad_type_id,$ad_type_title,$ad_type_description,$ad_type_status,$addmission_type_added_by);

			}else if($ad_type_id==0){
				echo $admission_type_obj->addAdmissionType($ad_type_title,$ad_type_description,$ad_type_status,$addmission_type_added_by);

			}

}
else if($_POST['action']=='delete_ad_type')
 {
	 $admission_type_id=$_POST['ad_type_id'];
	 echo $admission_type_obj->deleteAdmissionType($admission_type_id);
 }

else if($_POST["action"]=="dialog_edit_record")
{
    $pk_id = $_POST['pk_id'];
    $table_name = $_POST['table'];
    $primary_key = $_POST['prm_key'];

    $select_query = "select * from ".$table_name."  WHERE ".$primary_key." ='$pk_id'";

    $rec_obj=mysqli_fetch_object(mysqli_query($_SESSION["db_conn"],$select_query));

    switch($table_name){
        
                         case TBL_ADMISSION_TYPE:
                         echo $rec_obj->ad_type_title.SEPARATOR_SYMBOL.$rec_obj->ad_type_desc.SEPARATOR_SYMBOL.$rec_obj->ad_type_status.SEPARATOR_SYMBOL;
           }

 }
else if($_POST['action']=='fetch_test')
{
	$student_id = $_REQUEST['studID'];
	$student_qry = mysqli_query($_SESSION['db_conn'],"select * from  tbl_applications_forms_field where app_form_regis_no ='".$student_id."'");
	$student_rec = mysqli_fetch_array($student_qry);
	echo $student_rec['app_open_id'];
}
else if($_POST['action']=='fetch_interview')
{
	$student_id = $_REQUEST['studID'];
	$student_qry = mysqli_query($_SESSION['db_conn'],"select * from  tbl_applications_forms_field where app_form_regis_no ='".$student_id."'");
	$student_rec = mysqli_fetch_array($student_qry);
	echo $student_rec['app_open_id'];
}
else if($_POST['action']=='FetchComb')
{
	$batch_id = $_POST['batch_id'];
        $sess_id  = $_POST['sess_id'];
        $selectID = $_POST['combID'];
        echo $prgrmbatchcomb_obj->getBatchSessCombinationNames($batch_id,$sess_id,$selectID);

}

else if ($_POST["action"] == "get_student_document_status") {
    
     extract($_POST);
    
     $student_obj = new student();
     $gender_obj = new genders();
     $result = $student_obj->getStudentList($batch_id, $session_id, $comb_id);
    //=============== Begin Fetching Required Documents=============
     $app_review_obj = new application_review();
     $app_id = $app_review_obj->getAppId($batch_id, $session_id, $comb_id);
     
     $req_doc = explode(",",$app_review_obj->getRequiredDocs($app_id));
     
        //===============End of Fetching Required Documents=============
    if ($result) {
        
        $html_str = '';
        $html_str.= '<thead><tr valign="top">
            <td width="20%">Roll No.</td><td width="20%">Student Name</td>';
            foreach($req_doc as $d){
                
                $html_str.= '<td width="20%">'.$d.'</td>';
                
            }
            
        $html_str.= '</tr></thead>';
        
        $class_cnt = 0;
        
        if (mysqli_num_rows($result) > 0) {
            
            while ($obj = mysqli_fetch_object($result)) {
                
            //=============== Begin Fetching Uploaded Documents=============
            $found_docs = $app_review_obj->getUploadedDocs($obj->stud_app_form_id);
            $doc = explode("/",$found_docs);
            $uploaded_docs_name = explode(",",$doc[0]);        
            $status = explode(",",$doc[1]);
            
                //===============End of Fetching Uploaded Documents=============
                $tr_class = $class_cnt % 2 == 0 ? "class='even'" : "class='odd'";

                $html_str.='<tr ' . $tr_class . ' valign="top">
                        <td><a href=' . APP_ADMISSION_DIR . 'student_view.php?pk_id=' . $obj->stud_id . ' target="_blank">' . strtoupper($obj->stud_roll_no) . '</a></td>
                        <td>'.trim(ucwords($obj->stud_first_name . " " . $obj->stud_middle_name . " " . $obj->stud_last_name)) . '</td>';

                for($i = 0; $i < count($req_doc); $i++){
                    
                    if(in_array($req_doc[$i],$uploaded_docs_name)){
                        
                        $key=array_keys($uploaded_docs_name,$req_doc[$i]);
                        $Doc_Status = trim($status[$key[0]])!="" ? '<img src="./images/active.png"/>' : '<img src="./images/delete_cross.gif"/>';
                        $html_str.= '<td width="10%">'.$Doc_Status.'</td>';
                        
                    }
                    else{
                        $html_str.= '<td width="10%">N/A</td>';
                    }
                    
                }
               
                $html_str.='</tr>';
                $class_cnt++;
            }
        } else {
            $html_str.='<tr valign="top">
<td colspan="5"><div align="center">No Student Found</div></td>
</tr>';
        }
//        print_r($uploaded_docs_name);
        echo $html_str;
        //Array ( [0] => Domicile Certificate [1] => Medical Certificate [2] => ) 
        //Array ( [0] => Marksheet [1] => Medical Certificate [2] => Domicile Certificate [3] => Test ) 
    }
}
else if ($_POST["action"] == "get_student_academic_report") {
    
     extract($_POST);
    
     $student_obj = new student();
     $gender_obj = new genders();
     $result = $student_obj->getStudentList($batch_id, $session_id, $comb_id);
  
    if ($result) {
        
        $html_str = '';
        $html_str.= '<thead><tr valign="top">
            <td width="20%">Roll No.</td><td width="20%">Student Name</td>
            <td width="20%">Language</td><td width="20%">Writing</td>
            <td width="20%">Reading</td><td width="20%">Speaking</td>
            <td width="20%">Degree </td><td width="20%">Major</td>
            <td width="20%">Institure Name</td><td width="20%">University/Board</td>
            <td width="20%">Year</td><td width="20%">%Marks</td>
            <td width="20%">Grade/div</td><td width="20%">result awaited</td>';
            
            
        $html_str.= '</tr></thead>';
        
        $class_cnt = 0;
        
        if (mysqli_num_rows($result) > 0) {
            while ($obj = mysqli_fetch_object($result)) {
                
            $q="SELECT * FROM  tbl_admision_academic as aca 
left join tbl_language_known as lan on (aca.app_form_id=lan.app_form_id)
left join tbl_students as stu on (stu.stud_app_form_id=aca.app_form_id) ";
         
                $query=mysqli_query($_SESSION['db_conn'],$q);
               $row = mysqli_fetch_object($query);
                    $lan="select * from tbl_languages where '".$row->stud_language_id ."'";
                    $row1 = mysqli_fetch_object(mysqli_query($_SESSION['db_conn'],$lan)); 
                 $result_status=$objj->app_result_award==0?'Pending':'Pass';
                $tr_class = $class_cnt % 2 == 0 ? "class='even'" : "class='odd'";

                $html_str.='<tr ' . $tr_class . ' valign="top">
                        <td><a href=' . APP_ADMISSION_DIR . 'student_view.php?pk_id=' . $obj->stud_id . ' target="_blank">' . strtoupper($obj->stud_roll_no) . '</a></td>
                        <td>'.trim(ucwords($obj->stud_first_name . " " . $obj->stud_middle_name . " " . $obj->stud_last_name)) . '</td>';
                  $html_str.=  '<td>'.$row1->language_name . '</td>
                      <td>'.$row->language_writing.'</td>
                      <td>'.$row->language_reading.'</td>
                      <td>'.$row->language_speaking.'</td>
                      <td>'.$row->app_degree.'</td>
                      <td>'.$row->app_major.'</td>
                      <td>'.$row->app_institute_name .'</td>
                      <td>'.$row->app_board.'</td>
                          <td>'.$row-> 	app_year.'</td>
                              <td>'.$row->app_percentage .'</td>
                                  <td>'.$row->app_grade.'</td>
                                      
                                      <td>'.$result_status.'</td>';
                   $html_str.='</tr>';
                
                
                
                       
               
                $class_cnt++;
            }
        } else {
            $html_str.='<tr valign="top">
<td colspan="5"><div align="center">No Student Found</div></td>
</tr>';
        }
        echo $html_str;
      
    }
}
else if($_POST['action']=='show_doc_lists')
{       
        
        $qry_student = mysqli_query($_SESSION['db_conn'],"select * from tbl_document_required order by docs_req_name asc");
        
       $html='<table width="95%" align="center" cellpadding="0" cellspacing="0" class="display">
                            <thead>
                            <tr height="40">
                            <th width="8%">Name</th>';
      
                        while($fetch_rec = mysqli_fetch_object($qry_student)){
                                
                                $headings.='<th>'.$fetch_rec->docs_req_name.'</th>';
                                
                        }
                        
            $html.=$headings; 
                        
            $html.='</tr>
                    </thead>';
            
              $student_list = mysqli_query($_SESSION['db_conn'],"select * from  tbl_students where stud_batch_session_comb_id='".$_POST['comb_id']."'"); 
              while($students_list = mysqli_fetch_array($student_list))
              { 
                
                  $create_names.='<tr height="25" class="$rwclass">
                  <td>'.$students_list['stud_first_name'].'</td>';
                    
                      while($fetch_rec = mysqli_fetch_object($qry_student)){
                                
                                $create_names.='<td><input type="checkbox" name="batch" id="batch" /></td>';
                                
                        }
                
                $create_names.='</tr>';
                
              }     
             
             // $html.=$create_names;
              $html.=$create_names;
             $html.='</table>';   
            
            
            
                       
            
                    
            
              
        echo $html;
   

}



function time_difference($start_time, $end_time) {
    list($h1, $m1, $s1) = split(':', $start_time);
    $startTimeStamp = mktime($h1, $m1, $s1, 0, 0, 0);

    list($h2, $m2, $s2) = split(':', $end_time);

//check end time is in 12 hrs format:
    if ($h2 < $h1)
        $h2+=12;

    $endTimeStamp = mktime($h2, $m2, $s2, 0, 0, 0);
    $time = abs($endTimeStamp - $startTimeStamp);

    $value = array(
        "hours" => "00",
        "minutes" => "00",
        "seconds" => "00"
    );

    if ($time >= 3600) {
        $value["hours"] = sprintf("%02d", floor($time / 3600));
        $time = ($time % 3600);
    }
    if ($time >= 60) {
        $value["minutes"] = sprintf("%02d", floor($time / 60));
        $time = ($time % 60);
    }

    $value["seconds"] = sprintf("%02d", floor($time));

    return implode(":", $value);
}

?>