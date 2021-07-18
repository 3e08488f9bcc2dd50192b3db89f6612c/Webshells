<?php include("../header.php"); ?>
<?php
/*
 * Created on Jun 8, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<!-- Header html start  -->
  <?php include("../left_nav.php"); ?>
  

  
  <?php
  $application= new application();
  $marital_status=new marital_status();
$costcenter=new costcenter();
$statusObj = new status(); 
$masterdao=new masterdao();
$department=new Department();
$staff_type=new staff_type();
$employment_type=new Employment_type();
$cadre=new cadre();
$role=new role();
$religions= new religions();
$designations= new designations();
$countries=new countries();
$genders = new genders();
$nationality = new nationality();
$language= new language();

$prog=new program();
$course=new course();
$sem=new semester();
$shift=new shift();
$stream=new stream(); 
$sec=new section();
$batch=new batch();
$session=new session();
$statusObj = new status();
$result_criteria_obj=new result_criteria();

$div_style='style="display:none;"';

$_SESSION["timestamp"]=(isset($_SESSION["timestamp"])==true)?$_SESSION["timestamp"]:"";

$pk_id=$_GET['pk_id'];
if($pk_id>0){

$result_obj=$result_criteria_obj->getResultRecord($pk_id);
$batch_id=$result_obj->batch_sess_batch_id;
$sess_id=$result_obj->batch_sess_session_id;
$cour_id=$result_obj->batch_sess_cour_id;
$sem_id=$result_obj->batch_sess_sem_id;
$stream_id=$result_obj->batch_sess_stream_id;
$sec_id=$result_obj->batch_sess_sec_id;
$shift_id=$result_obj->batch_sess_shift_id;

$prog_id=$result_obj->batch_sess_prog_id;
$match_id=$result_obj->rsl_criteria_match_id;
$interim=$result_obj->rsl_criteria_interim;
$final=$result_obj->rsl_criteria_final;
$reexam=$result_obj->rsl_criteria_re_exam;
$status=$result_obj->rsl_criteria_is_active ;

//echo "$interim,$final,$reexam,$match_id,$status,$batch_id,$prog_id";
}
if($_SERVER['REQUEST_METHOD']=="POST")
{
//extract($_POST);
		extract($_POST);
		$registration_form=$application->addRegistration($app_frst_name,$app_gender,$app_mid_name,$app_language_known,$app_lst_name,$app_Religion_id,$app_father_name,$app_nationality_id,$app_place_of_birth,$app_marital_status_id,$app_passport_no,$app_address1_current,$app_address2_current,$app_curr_country,$app_curr_location,$app_curr_city,$app_curr_area,$app_postal_code,$app_tel_no,$app_mobile_no,$app_fax_no,$app_email,$app_last_exam_passed,$app_institute_name,$app_year_passed,$app_board_id,$app_marks_obtained,$app_area_study,$app_grade,$app_registration,$app_leaving_reason,$app_extra_activity,$app_language_known,$app_father_name,$app_father_ocuptn,$app_father_designation,$app_father_organization,$app_father_cnic,$app_father_address,$app_father_address2,$app_father_country,$app_father_state,$app_father_city,$app_father_area,$app_father_postal,$app_father_telephone,$app_father_fax,$app_father_mobile,$app_father_email,$app_mother_name,$app_mother_ocuptn,$app_mother_designation,$app_mother_organization,$app_mother_cnic,$app_mother_address,$app_mother_address2,$app_mother_country,$app_mother_state,$app_mother_city,$app_mother_area,$app_mother_postal,$app_mother_telephone,$app_mother_fax,$app_mother_mobile,$app_mother_email,$app_filled_by);
		echo $registration_form;
		}	
		
			
?>
<?php 
$msg="";
$div_style = $msg=="" ?'style="display:none;"' : 'style="display:block;"';
?>
 
<!--- DIV START -->  
<div id="contentcolumn">
	<div class="innertube">
		<div class="mid_mid_img">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
        <td width="6" background="images/left_top_img_new.png" align="left"></td>
        <td class="midbg1" background="images/mid_top_img_new.png" align="left" ></td>
        <td width="6" background="images/right_top_img_new.png" align="right"></td>
        </tr>
		<tr>
        <td width="6" background="images/mid_left_img.png" align="left"></td>
		<td class="midbg12">
		<div class="fr">
	<div class="top_logo_login"> 
                    <span><a href=""><?php $auth_obj->getLoginName(); ?></a></span>
        <div class="clear"></div>
					<!--<span class="top_login_btn"><span class="logbutton_icon"><input onclick="location.href='logout'" type="button" value="Logout" /></span></span>-->
        <div class="fr">
			<span class="logbutton_icon"><input onclick="location.href='logout'" type="button" value="Logout" /></span>
			<span class="user_settings"><a href=""></a></span>
        </div>
    </div>
		<div class="top_logo_r">
		<a href=""><img src="<?php $config_obj->getSchoolLogo(); ?>" border="0" alt="logo" title="logo"  /></a>
		</div>
   		</div>

<!-- Header html ends  -->
<!-- Content html start --> 
<div id="err_div_top" <?=$div_style?> ><?php echo $msg; ?></div>
<table width="100%"  border="0" cellspacing="0" cellpadding="0"> 
  	<tr>
	<td>
	<form name="student_registration_form" id="student_registration_form"  action="" method="post" enctype="multipart/form-data">
  								<input type="hidden" name="combination_id" value="<?php ?>"  id="combination_id"/>
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
 <thead >
<th colspan="4"><div class="title_head"><h1>Student Registration Form</h1></div> </th>

</thead>
<tbody>

<tr>

    <td colspan="4">
    <div class="padd_di_cls">
     <table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td class="text_sty12" height="31"><strong>First Name</strong><span class="style1">*</span></td>
<td>
<div class="cover">
<input type="text" name="app_frst_name" value="<?php ?>"  id="app_frst_name"/>
</div>                                 
								<div class="newStatus"></div>
</td>
  <td class="text_sty12" height="31"><strong>
Gender:*</strong>
</td>
<td width="196">
<div class="cover">
 <?php  $genders->getGenderList('app_gender',$getvalue[19]); ?>
</div>                                 
								<div class="newStatus"></div>
</td>
</tr>  
 <tr><td colspan="6" height="10"></td></tr>
<tr>
  <td class="text_sty12" height="31"><strong>
Middle Name:*
</strong>
</td>
<td width="200">
<div class="cover">
<input type="text" name="app_mid_name" value="<?php ?>" id="app_mid_name"  />
</div>                                 
								<div class="newStatus"></div>
</td>
<td class="text_sty12" height="31"><strong> Medium of Instruction:</strong><span class="style1"></span></td>
    <td><div class="cover">
    <?php  echo $language->getLanguageList('app_language_known',$getvalue[36]);?>
    </div>                                 
                                    <div class="newStatus"></div>
    </td>
    </tr> 
    
     <tr><td colspan="6" height="10"></td></tr>
    
      <tr>
  <td class="text_sty12" height="31"><strong>
Last Name:*</strong>
</td>
<td>
<div class="cover">
<input type="text" name="app_lst_name" value="<?php ?>" id="app_lst_name" />
</div>                                 
								<div class="newStatus"></div>
</td>
 <td class="text_sty12" height="31"><strong> Religion</strong><span class="style1"></span></td>
    
    <td><div class="cover"><?php  echo $religions->getReligionList('app_Religion_id',$getvalue[27]); ?></div>                                 
    <div class="newStatus"></div>
    </td>
</tr>  
 <tr><td colspan="6" height="10"></td></tr>
<tr>
<td width="200">
Father Name:*</td>
<td width="200">
<div class="cover">
<input type="text" name="app_father_name" value="<?php ?>" id="app_father_name" />
</div>                                 
								<div class="newStatus"></div>
</td>
 <td class="text_sty12" height="31"><strong> Nationality</strong><span class="style1"></span></td>
    
    <td><div class="cover"><?php  echo $nationality->getNationalityListing('app_nationality_id',$getvalue[26]); ?></div>                                 
	<div class="newStatus"></div>
    </td>
   </tr> 
							 <tr><td colspan="6" height="10"></td></tr>
                                   <tr>
                                  
                                        <td width="127" height="31" class="text_sty12"><strong>Place of Birth.</strong><span class="style1"></span></td>
    
    <td width="357"><div class="cover"><input class="int_wid" type="text" id="app_place_of_birth" name="app_place_of_birth" value="<?php echo $getvalue[9]; ?>" /></div><div class="newStatus"></div></td>
     <td class="text_sty12" height="31"><strong> Martial Status</strong><span class="style1"></span></td>
                                <td><div class="cover">
                                <?php  $marital_status->getMartitalStatus('app_marital_status_id',$getvalue[42]); ?>
                                </div>                                 
                                <div class="newStatus"></div>
                                </td>
                                </tr> 
                                  <tr><td colspan="6" height="10"></td></tr> 
                                  <tr>
                               
                                <td class="text_sty12" height="31"><strong>CNIC/ Passport No.</strong><span class="style1"></span></td>
                                <td><div class="cover"><input class="int_wid" type="text" id="app_passport_no" name="app_passport_no" value="<?php echo $getvalue[30]; ?>" /></div><div class="newStatus"></div>
                                </td>
</tr>
<tr><td colspan="6" height="10"></td></tr> 
    
    <tr>
    <td colspan="6" class="table_block_td" >Contact Detail</td>
    </tr>
    
    <tr><td colspan="6" height="10"></td></tr> 
  <tr>
  <td class="text_sty12" height="31"><strong> Address1</strong><span class="style1"></span></td>
    <td><div class="cover"><textarea  name="app_address1_current" id="app_address1_current" class="required int_wid" ><?php echo $getvalue[54]; ?></textarea></div><div class="newStatus"></div>
    </td>
	<td class="text_sty12" height="31"><strong> Address2</strong><span class="style1"></span></td>
    <td><div class="cover"><textarea name="app_address2_current" id="app_address2_current" class="int_wid" ><?php echo $getvalue[55]; ?></textarea></div><div class="newStatus"></div>
    </td>
    </tr>
     <tr><td colspan="6" height="10"></td></tr> 
    <tr>
   <td class="text_sty12" height="31"><strong> Country</strong><span class="style1"></span></td>
    <td><div class="cover"><select class="int_wid" name="app_curr_country" id="app_curr_country" onChange="selectState(this.value,'current')">
<option value="">Select Country</option><?php  echo $countries->getCountryList($getvalue[56]); ?></select>
    </div><div class="newStatus"></div>
    </td>
    <td class="text_sty12" height="31"><strong> State</strong><span class="style1"></span></td>
    <td><div class="cover"><select name="app_curr_location" class="int_wid" id="app_curr_location" onChange="selectCity(this.value,'current')">
    <option value="">Select state</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
     <tr><td colspan="6" height="10"></td></tr> 
    <tr>
    <td class="text_sty12" height="31"><strong> City</strong><span class="style1"></span></td>
    <td><div class="cover"><select name="app_curr_city" id="app_curr_city" class="int_wid" onchange="selectArea(this.value,'app_curr_city')" >
<option value="">Select city</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>
        <td class="text_sty12" height="31"><strong> Area</strong><span class="style1"></span></td>
    <td><div class="cover"><select name="app_curr_area" id="app_curr_area" class="int_wid">
<option value="">Select Area</option>

    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
        <tr><td colspan="6" height="10"></td></tr> 
    <tr>
    <td class="text_sty12" height="31"><strong> Postal Code</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_postal_code" id="app_postal_code" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
        <td class="text_sty12" height="31"><strong> Teliphone No:</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_tel_no" id="app_tel_no" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
        <tr><td colspan="6" height="10"></td></tr> 
        
            <tr>
    <td class="text_sty12" height="31"><strong> Mobile No.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_mobile_no" id="app_mobile_no" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
        <td class="text_sty12" height="31"><strong> Fax No:</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_fax_no" id="app_fax_no" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
        <tr><td colspan="6" height="10"></td></tr> 
            <tr>
    <td class="text_sty12" height="31"><strong> Email.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_email" id="app_email" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
        <tr><td colspan="6" height="10"></td></tr> 
    <tr>
    <td colspan="6" class="table_block_td" >Academic Record</td>
    </tr>
<tr><td colspan="6" height="10"></td></tr> 
<tr>
 <td class="text_sty12" height="31"><strong> Last Exam Passed.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_last_exam_passed" id="app_last_exam_passed" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    
 <td class="text_sty12" height="31"><strong> Name of Institution.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_institute_name" id="app_institute_name" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>

<tr><td colspan="6" height="10"></td></tr> 
<tr>
 <td class="text_sty12" height="31"><strong> Year of Passing.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_year_passed" id="app_year_passed" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    
 <td class="text_sty12" height="31"><strong> Name of Board/ University.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_board_id" id="app_board_id" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>

<tr><td colspan="6" height="10"></td></tr> 
<tr>
 <td class="text_sty12" height="31"><strong> Marks obtained.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_marks_obtained" id="app_marks_obtained" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    
 <td class="text_sty12" height="31"><strong> Area of Study .</strong><span class="style1"></span></td>
    <td><div class="cover"><select  name="app_area_study" id="app_area_study" class="int_wid" >
    <option value="">Select Area </option>
     <option value="1">Indore</option>
      <option value="2">Indore </option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>
    <tr><td colspan="6" height="10"></td></tr> 
<tr>
 <td class="text_sty12" height="31"><strong>Grade/ Division.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_grade" id="app_grade" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    
 <td class="text_sty12" height="31"><strong> Registration Of Last Institute .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_registration" id="app_registration" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>
    <tr><td colspan="6" height="10"></td></tr> 
    <tr>
 <td class="text_sty12" height="31"><strong>Reason for leaving.</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text" name="app_leaving_reason" id="app_leaving_reason" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>
    
 <td class="text_sty12" height="31"><strong>Extra Curricular Activities .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_extra_activity" id="app_extra_activity" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>
    <tr><td colspan="6" height="10"></td></tr> 

    <tr>
 <td class="text_sty12" height="31"><strong>Language Spoken.</strong><span class="style1"></span></td>
    <td><div class="cover"><?php  echo $language->getLanguageList('app_language_known',$getvalue[36]);?>
    </div>                                 
    <div class="newStatus"></div>
    </td>
    </tr>
    <tr><td colspan="6" height="10"></td></tr> 
 <tr>
    <td colspan="6" class="table_block_td" >Parent Information</td>
    </tr>
        <tr><td colspan="6" height="10"></td></tr> 


    <tr>
    <td colspan="6" >Father Information</td>
    </tr>
    <tr>
     <td class="text_sty12" height="31"><strong>Name .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_name" id="app_father_name" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    <td class="text_sty12" height="31"><strong>Occupation .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_ocuptn" id="app_father_ocuptn" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>
     <tr><td colspan="6" height="10"></td></tr> 
    <tr>
     <td class="text_sty12" height="31"><strong>Designation .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_designation" id="app_father_designation" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Organization .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_organization" id="app_father_organization" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Social Security/CNIC .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_cnic" id="app_father_cnic" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Address .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_address" id="app_father_address" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
          <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Address2 .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_address2" id="app_father_address2" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Country .</strong><span class="style1"></span></td>
    <td><div class="cover"><select name="app_father_country" id="app_father_country" class="int_wid" onchange="selectState(this.value,'app_father_country')">
<option value="">Select Country</option><?php  echo $countries->getCountryList($getvalue[56]); ?></select>

    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>State .</strong><span class="style1"></span></td>
    <td><div class="cover">
    <select name="app_father_state" class="int_wid" id="app_father_state" onChange="selectCity(this.value,'app_father_state')">
    <option value="">Select state</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>City .</strong><span class="style1"></span></td>
    <td><div class="cover"><select  name="app_father_city" id="app_father_city" class="int_wid" onchange="selectArea(this.value,'app_father_city')" >
    <option value="">Select City</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Area .</strong><span class="style1"></span></td>
    <td><div class="cover"><select name="app_father_area" id="app_father_area" class="int_wid" >
    <option value="">Select Area</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Postal Code .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_postal" id="app_father_postal" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Telephone Number .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_telephone" id="app_father_telephone" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Fax .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_fax" id="app_father_fax" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Mobile Number .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_mobile" id="app_father_mobile" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Email Id .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_father_email" id="app_father_email" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
      
    <tr>
    <td colspan="6" ><strong>Mother Information</strong></td>
    </tr>
    <tr>
     <td class="text_sty12" height="31"><strong>Name .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_motherr_name" id="app_mother_name" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    <td class="text_sty12" height="31"><strong>Occupation .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_ocuptn" id="app_father_ocuptn" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>   
    </tr>
     <tr><td colspan="6" height="10"></td></tr> 
    <tr>
     <td class="text_sty12" height="31"><strong>Designation .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_designation" id="app_mother_designation" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Organization .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_organization" id="app_mother_organization" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Social Security/CNIC .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_cnic" id="app_mother_cnic" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Address .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_address" id="app_mother_address" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
          <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Address2 .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_address2" id="app_mother_address2" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Country .</strong><span class="style1"></span></td>
    <td><div class="cover"> <select name="app_mother_country" class="int_wid" id="app_mother_country" onChange="selectState(this.value,'app_mother_country')">
<option value="">Select Country</option>
<?php  echo $countries->getCountryList( $getvalue[127]); ?>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>State .</strong><span class="style1"></span></td>
    <td><div class="cover"> <select name="app_mother_state" class="int_wid" id="app_mother_state" onChange="selectCity(this.value,'app_mother_state')">
<option value="">Select state</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>City .</strong><span class="style1"></span></td>
    <td><div class="cover"><select  name="app_mother_city" id="app_mother_city" class="int_wid" onChange="selectArea(this.value,'app_mother_city')" >
    <option value="">Select City</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Area .</strong><span class="style1"></span></td>
    <td><div class="cover"><select  name="app_mother_area" id="app_mother_area" class="int_wid" >
   <option value="">Select Area</option>
    </select>
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Postal Code .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_postal" id="app_mother_postal" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Telephone Number .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_telephone" id="app_mother_telephone" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Fax .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_fax" id="app_mother_fax" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>
     <tr>
     <td class="text_sty12" height="31"><strong>Mobile Number .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_mobile" id="app_mother_mobile" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"><strong>Email Id .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_mother_email" id="app_mother_email" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
    </tr>
      <tr><td colspan="6" height="10"></td></tr>

     <tr>
     <td class="text_sty12" height="31"><strong>Form Filled By .</strong><span class="style1"></span></td>
    <td><div class="cover"><input type="text"  name="app_filled_by" id="app_filled_by" class="int_wid" />
    </div>                                 
    <div class="newStatus"></div>
    </td>  
     <td class="text_sty12" height="31"></td>
    <td>
    </td>  
    </tr>



<tr>
 <td colspan="4" >
<span class="logbutton_black"><input type="submit" name="<? if($pk_id>0) echo 'Update'; else echo 'Add'; ?>" value="<? if($pk_id>0) echo 'Update'; else echo 'Add'; ?>"   /></span>
<span class="logbutton_grey"><input name="cancel" type="button"onClick="window.location.href='<?php echo BASE_HREF.app_ADMISSION_DIR;?>manage_student_registration.php'" value="Cancel" /></span>
</td>
</tr>
</table>
</div>
</td>
</tr>
</tbody>
</table>

</form>
	</td>
	</tr>
</table>

<!-- Content html ends --> 

<!--  footer content start  -->
<div class="clear"></div>        
        </td>
        
        <td width="6" background="images/mid_right_img.png" align="right"></td>
        </tr>
		<tr>
        <td width="6" height="12" background="images/left_bottom_img.png" align="left"></td>
        <td class="midbg1" height="12" background="images/mid_bottom_img.png" align="left" ></td>
        <td width="6" height="12"  background="images/right_bottom_img.png" align="right"></td>
        </tr>
	</table>
        </div>
	</div>
</div>
<!--- DIV END --> 

<?php include("../footer.php"); ?>
<!-- footer content ends -->