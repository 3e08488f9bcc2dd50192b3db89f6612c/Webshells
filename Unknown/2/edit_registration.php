<?php include("../header.php"); ?>
<?php include("../left_nav.php"); ?>
<?php
include "../../aims-front/student_image_upload/imageresize.php";
$marital_status = new marital_status();
$statusObj = new status();
$config_obj = new school_config();
$department = new Department();
$staff_type = new staff_type();
$employment_type = new Employment_type();
$staff_obj = new staff();
$cadre = new cadre();
$role = new role();
$designations = new designations();
$areas_obj = new areas();
$state_obj = new states();
$city_obj = new cities();
$language = new languages();
$core = new core();
$config = $config_obj->getConfigurationRecord();
$current_date = date("Y-m-d", time());
$new_staff_date_of_birth = "";
$new_staff_joining_date = $config_obj->getFormattedDateFromMysql($current_date);
$new_staff_passport_issue_date = "";
$new_staff_passport_expiry_date = "";
$building_obj = new building();
$currency_obj = new currency();
$application_obj = new application();
$occupation_obj = new occupation();
$designations_obj = new designations();
$languages_obj = new languages();
$religions = new religions();
$countries = new countries();
$area_obj = new areas();
$genders = new genders();
$nationality = new nationality();
$adm_open_obj = new admission_open();
$lastexam_obj = new lastexam();
$academic_obj = new academic_record();
$blood_obj = new blood();
$sems = new semester();
$resultstat = new status();

$mod_code    = '00010015';
if(!$config_obj->hasModuleAccess($mod_code))
{
    header("Location:" . BASE_HREF . "error");
}
$stud_id = $_GET['stud_id']>0 ? $_GET['stud_id'] : null;
$app_school_id = $_SESSION["school_id"];
if(!file_exists('../../uploads/sch_' . $app_school_id . '/student_pics'))
{
    mkdir('../../uploads/sch_' . $app_school_id . '/student_pics', 0777);
}
if(!file_exists('../../uploads/sch_' . $app_school_id . '/student_docs'))
{
    mkdir('../../uploads/sch_' . $app_school_id . '/student_docs', 0777);
}
if(!file_exists('../../temp_images'))
{
    mkdir('../../temp_images', 0777);
}
if(!file_exists('../../uploads/sch_' . $app_school_id . '/document_required'))
{
    mkdir('../../uploads/sch_' . $app_school_id . '/document_required', 0777);
}
$_SESSION["timestamp"] = (isset($_SESSION["timestamp"]) == true) ? $_SESSION["timestamp"] : "";

if($_SERVER['REQUEST_METHOD']=="POST" && $_SESSION["timestamp"]!= $_POST["timestamp"])
{    
    //echo '<pre>';   print_r($_POST);    echo '</pre>';  return;                
    extract($_POST);                
    $_SESSION["timestamp"] = $_POST["timestamp"];
    $add_date = $config_obj->getDBDateValue($dateofregis); //date('Y-m-d');
    $admission_date = $config_obj->getDBDateValue($stud_admission_date);
    $app_student_pic = $app_student_picture;
    if(trim($app_student_pic) != '')
    {
        $source_path = '../../temp_images/' . $app_student_pic;
        $desination_path = '../../uploads/sch_' . $app_school_id . '/student_pics/' . $app_student_pic;
        copy($source_path, $desination_path);
        $thumb_width = 150;
        makeimage('../../uploads/sch_' . $app_school_id . '/student_pics/' . $app_student_pic, "thumb_" . $app_student_pic, '../../uploads/sch_' . $app_school_id . '/student_pics/', $thumb_width, $thumb_height);
        $pic_uploaded = true;
    }
    else
    {
        $pic_uploaded = true;
    }
                        
    if(trim($app_student_file) != '')
    {
        $source_path = '../../temp_images/' . $app_student_file;
        $desination_path = '../../uploads/sch_' . $app_school_id . '/student_docs/' . $app_student_file;
        copy($source_path, $desination_path);
        $doc_uploaded = true;
    }
    else
    {
        $doc_uploaded = true;
    }
                        
    if($pic_uploaded == true && $doc_uploaded == true)
    {
        $update_qry = "Update tbl_students set stud_first_name='".$_POST['app_frst_name']."', "
        . "stud_middle_name='".$_POST['app_mid_name']."', "
        . "stud_last_name='".$_POST['app_lst_name']."', "
        . "stud_adm_type='".$_POST['admin_type']."', "
        . "stud_passport_no='".$_POST['app_passport_no']."', "
        . "stud_blood_group='".$_POST['blood_group']."', "
        . "stud_father_name='".$_POST['app_father_name']."', "
        . "stud_mother_name='".$_POST['app_mother_name']."',"
        . "stud_mobile='".$_POST['app_student_present_mob']."',"
        . "stud_telephone='".$_POST['app_student_present_telno']."',"
        . "stud_images='".str_replace("thumb_", "", $_POST['app_student_picture'])."',"        
        . "stud_extra_activity='".$_POST['extra_activity']."',"
        . "stud_physical_challenged_desc='".$_POST['physically_challenged']."',"
        . "stud_sibling_admission_no='".$_POST['siblings']."',"
        . "stud_passport_no='".$_POST['app_passport_no']."',"
        . "stud_marital_status_id='".$_POST['app_marital_status_id']."',"
        . "stud_physical_challenged='".$_POST['physically_challenged']."',"
        . "stud_dismissed_type='".$_POST['dismissed_type']."',"
        . "stud_dismissed_reason='".$_POST['dismissed_reason']."',"
        . "stud_crime_type='".$_POST['crime_convicted']."',"
        . "stud_crime_detail='".$_POST['crime_detail']."',"
        . "stud_emergency_contact='".$_POST['emergency_mob_num']."',"
        . "stud_language_id='".$_POST['checkbox']."',"
        . "stud_lab_certification='".$_POST['app_student_file']."',"
        . "stud_adm_date='".$admission_date."',"
        . "stud_is_active='1' WHERE stud_id='".$_GET['stud_id']."'";
        $stResult=mysqli_query($_SESSION["db_conn"],$update_qry) or die(mysqli_error($_SESSION["db_conn"]));                            
        if($stResult)
        {
            mysqli_query($_SESSION["db_conn"],"UPDATE tbl_applications_forms_field SET app_added_on = '".$add_date."', app_admission_date = '".$admission_date."' WHERE app_form_field_id = '".$_POST['student_form_id']."' ");
            $addrQry1 = "Update tbl_address SET "
                . "addr_1='".$_POST['staff_address1_current']."',"
                . "addr_2='".$_POST['staff_address2_current']."',"
                . "addr_country_id='".$_POST['app_curr_country']."',"
                . "addr_state_id='".$_POST['app_curr_location']."',"
                . "addr_city_id='".$_POST['app_curr_city']."',"
                . "app_area_id='".$_POST['app_student_present_area']."',"
                . "app_postal='".$_POST['app_curr_zipcode']."',"
                . "updatedon=now() WHERE addr_type='Present' AND addr_stud_id='".$_GET['stud_id']."'";

            $addrQry2 = "Update tbl_address SET "
                . "addr_1='".$_POST['staff_address1_perm']."',"
                . "addr_2='".$_POST['staff_address2_perm']."',"
                . "addr_country_id='".$_POST['app_perm_country']."',"
                . "addr_state_id='".$_POST['app_permanent_location']."',"
                . "addr_city_id='".$_POST['app_permanent_city']."',"
                . "app_area_id='".$_POST['app_student_permanent_area']."',"
                . "app_postal='".$_POST['app_permanent_zipcode']."',"
                . "updatedon=now() WHERE addr_type='Permanent' AND addr_stud_id='".$_GET['stud_id']."'";
                              
            if($_POST['app_father_ocuptn'] != '')
            {
                $app_father_ocuptns = $occupation_obj->chkoccupation($_POST['app_father_ocuptn']);
            }
            if($_POST['app_mother_ocuptn1'] != '')
            {
                $app_mother_ocuptn = $occupation_obj->chkoccupation($_POST['app_mother_ocuptn1']);
            }           
            if($_POST['app_father_designation'] != "") 
            {
                $app_father_designations = $designations_obj->chkDesignation($_POST['app_father_designation']);
            }        
            if($_POST['app_mother_designation'] != "") 
            {
                $app_mother_designations = $designations_obj->chkDesignation($_POST['app_mother_designation']);
            }   
            $addrQry3 = "Update tbl_address SET "
                . "name='".$_POST['app_father_name']."',"
                . "relation='father',"
                . "app_parent_ocuptn='".$app_father_ocuptns."',"
                . "app_parent_designation='".$app_father_designations."',"
                . "app_parent_organization='".$_POST['app_father_organization']."',"
                . "addr_1='".$_POST['app_father_address']."',"
                . "addr_2='".$_POST['app_father_address']."',"
                . "addr_country_id='".$_POST['app_father_country']."',"
                . "addr_state_id='".$_POST['app_father_state']."',"
                . "addr_city_id='".$_POST['app_father_city']."',"
                . "app_area_id='".$_POST['app_father_area']."',"
                . "app_parent_cnic='".$_POST['app_father_cnic']."',"
                . "education='".$_POST['father_education']."',"
                . "app_postal='".$_POST['app_father_postal']."',"
                . "addr_zipcode='".$_POST['app_father_postal']."',"
                . "addr_phone='".$_POST['app_father_mobile']."',"
                . "addr_residential_phone='".$_POST['app_father_telephone']."',"
                . "addr_fax_no='".$_POST['app_father_fax']."',"
                . "addr_email='".$_POST['app_father_email']."',"
                . "updatedon=now() WHERE addr_type='Father' AND addr_stud_id='".$_GET['stud_id']."'";
                                
            $addrQry4 = "Update tbl_address SET "
                . "name='".$_POST['app_mother_name']."',"
                . "relation='mother',"
                . "app_parent_ocuptn='".$app_mother_ocuptn."',"
                . "app_parent_designation='".$app_mother_designations."',"
                . "app_parent_organization='".$_POST['app_mother_organization']."',"
                . "addr_1='".$_POST['app_mother_address']."',"
                . "addr_2='".$_POST['app_mother_address']."',"
                . "addr_country_id='".$_POST['app_mother_country']."',"
                . "addr_state_id='".$_POST['app_mother_state']."',"
                . "addr_city_id='".$_POST['app_mother_city']."',"
                . "app_area_id='".$_POST['app_mother_area']."',"
                . "app_parent_cnic='".$_POST['app_mother_cnic']."',"
                . "education='".$_POST['mother_education']."',"
                . "app_postal='".$_POST['app_mother_postal']."',"
                . "addr_zipcode='".$_POST['app_mother_postal']."',"
                . "addr_phone='".$_POST['app_mother_mobile']."',"
                . "addr_residential_phone='".$_POST['app_mother_telephone']."',"
                . "addr_fax_no='".$_POST['app_mother_fax']."',"
                . "addr_email='".$_POST['app_mother_email']."',"
                . "updatedon=now() WHERE addr_type='Mother' AND addr_stud_id='".$_GET['stud_id']."'";
                                
            $addrQry5 = "Update tbl_address SET "
                . "name='".$_POST['emergency_name']."',"
                . "relation='".$_POST['emergency_relation']."',"
                . "addr_1='".$_POST['emergency_address']."',"
                . "addr_2='".$_POST['emergency_address']."',"
                . "addr_country_id='".$_POST['emergency_country']."',"
                . "addr_state_id='".$_POST['emergency_state']."',"
                . "addr_city_id='".$_POST['emergency_city']."',"
                . "app_area_id='".$_POST['emergency_area']."',"
                . "app_postal='".$_POST['emergency_postcode']."',"
                . "addr_zipcode='".$_POST['emergency_postcode']."',"
                . "addr_phone='".$_POST['emergency_mob_num']."',"
                . "addr_residential_phone='".$_POST['emergency_tel_num']."',"
                . "addr_fax_no='".$_POST['emergency_fax_num']."',"
                . "addr_email='".$_POST['emergency_email']."',"
                . "updatedon=now() WHERE addr_type='Emergency' AND addr_stud_id='".$_GET['stud_id']."'";
                            
            $adr1 = mysqli_query($_SESSION['db_conn'], $addrQry1) or die(mysqli_error($_SESSION["db_conn"]));
            $adr2 = mysqli_query($_SESSION['db_conn'], $addrQry2) or die(mysqli_error($_SESSION["db_conn"]));
            $adr3 = mysqli_query($_SESSION['db_conn'], $addrQry3) or die(mysqli_error($_SESSION["db_conn"]));
            $adr4 = mysqli_query($_SESSION['db_conn'], $addrQry4) or die(mysqli_error($_SESSION["db_conn"]));
            $adr5 = mysqli_query($_SESSION['db_conn'], $addrQry5) or die(mysqli_error($_SESSION["db_conn"]));
        }
        else
        {
            $msg = 'Fail : Student Basic info Error.';
        }
        foreach($_POST['acadmid_id'] AS $key=>$acade)
        {
            if($acade > 0 )
            {
                mysqli_query($_SESSION['db_conn'],"UPDATE tbl_admision_academic SET app_degree = '".$_POST['degree'][$key]."', app_major = '".$_POST['major'][$key]."', app_institute_name = '".$_POST['app_institute_name'][$key]."', app_board = '".$_POST['app_board_name'][$key]."', app_year = '".$_POST['app_year_passed'][$key]."', app_percentage = '".$_POST['app_marks_obtained'][$key]."', app_grade = '".$_POST['app_grade'][$key]."', app_result_award = '".$_POST['result_awarded'][$key]."' WHERE app_academic_id = '".$acade."' ")or die(" Error : ". mysqli_error($_SESSION['db_conn']));
            }
            else
            {
                if($_POST['degree'][$key] != '')
                {
                    mysqli_query($_SESSION['db_conn'],"INSERT INTO tbl_admision_academic (app_open_id, app_form_id, app_degree, app_major, app_institute_name, app_board, app_year, app_percentage, app_grade, app_result_award) VALUES('".$_POST['app_open_id']."', '".$_POST['student_form_id']."', '".$_POST['degree'][$key]."', '".$_POST['major'][$key]."', '".$_POST['app_institute_name'][$key]."', '".$_POST['app_board_name'][$key]."', '".$_POST['app_year_passed'][$key]."', '".$_POST['app_marks_obtained'][$key]."', '".$_POST['app_grade'][$key]."', '".$_POST['result_awarded'][$key]."')")or die(" Error : ". mysqli_error($_SESSION['db_conn']));
                }
            }
        }
        $delResult = mysqli_query($_SESSION['db_conn'], "DELETE FROM tbl_language_known WHERE app_form_id='".$_POST['student_form_id']."'");
        if($delResult)
        {
            foreach($_POST['languge_known'] as $key=>$lang)
            {
                if($lang > 0)
                {
                    $langQry = mysqli_query($_SESSION['db_conn'],"INSERT INTO tbl_language_known SET app_form_id='".$_POST['student_form_id']."', language_known='".$lang."', language_reading='".$_POST['lang_reading'][$key]."', language_writing='".$_POST['lang_writing'][$key]."', language_speaking='".$_POST['lang_speaking'][$key]."', langauge_active = 1")or die(" Error : ". mysqli_error($_SESSION['db_conn']));                     
                }
            }                                         
        }  
        
        $doc_type = $_FILES["app_req_document"]["type"];
        $docs_src = $_FILES["app_req_document"]["tmp_name"];
        $docs_size = $_FILES["app_req_document"]["size"];
        $docs = $_FILES["app_req_document"]["name"];
    }
    else
    {
        $msg = 'file uploading fail';
    }
}

if($stud_id > 0)
{
    $stud_data = $application_obj->getAdmittedStudent($stud_id);
    $app_id = $stud_data->stud_app_open_id;
    $update_data = $application_obj->getStudentApplicationData($stud_data->stud_app_form_id);
    if($stud_data->stud_app_form_id > 0)
    {
        $langprof = $application_obj->getAppLanguageKnownProf($stud_data->stud_app_form_id);
        $addr   = $application_obj->getAppAddress($stud_data->stud_app_form_id);
        $uaddr  = explode("///", $addr);
        $upermanent = explode("::", $uaddr[0]);
        $upresent   = explode("::", $uaddr[1]);
        $ufather    = explode("::", $uaddr[2]);   
        $umother    = explode("::", $uaddr[3]);
        $uemrgency  = explode("::", $uaddr[4]);     
    }
    else
    {
        die('Application Form Key not found');
    }
}
else
{
    die('Student Key not found');
}

$i = 0;
$app_docs = "../../uploads/sch_".$app_school_id;
if(count($docs_src) >0)
{
    foreach ($docs_src as $src)
    {
        if (trim($src )!= "")
        {
            if(move_uploaded_file($src, $app_docs."/document_required/".$timestamp."_".$docs[$i]))
            {
                $app_doc_id = $_POST['app_req_document_id'][$i];							
                $doc_qry = "SELECT * FROM tbl_application_docs WHERE app_doc_doc_id='".$app_doc_id."' AND app_doc_app_form_field_id='".$stud_data->stud_app_form_id."' ";
                $doc_res = mysqli_query($_SESSION["db_conn"],$doc_qry) OR die($doc_qry." :Error: ".mysqli_error($_SESSION["db_conn"]));
                if(mysqli_num_rows ($doc_res) > 0)
                {
                    $qry = "UPDATE tbl_application_docs set  app_doc_name ='".$timestamp."_".$docs[$i]."',app_doc_added_date = now() WHERE app_doc_app_form_field_id = '".$stud_data->stud_app_form_id."' AND app_doc_doc_id = '".$app_doc_id."'   ";				
                    mysqli_query($_SESSION["db_conn"],$qry) OR die($qry." :Error: ".mysqli_error($_SESSION["db_conn"]));
                }
                else
                {
                    $qry = "INSERT into tbl_application_docs set app_doc_doc_id = '".$app_doc_id."', app_doc_app_open_id = '".$stud_data->stud_app_open_id."',app_doc_app_form_field_id = '".$stud_data->stud_app_form_id."',  app_doc_name ='".$timestamp."_".$docs[$i]."',app_doc_added_date = now() ";				
                    mysqli_query($_SESSION["db_conn"],$qry) OR die($qry." :Error: ".mysqli_error($_SESSION["db_conn"]));
                }
            }
            else
            {
                echo $docs[$i]."Document Uploaded Error";				 
            }
	} 
        $i++;
    }
}
?>

<style type="text/css">
    .maindiv {
        border:3px solid #CCCCCC;
        width:135px;
        height:135px;
        position: relative;
    }
    .img1 {

        cursor:pointer;
        position: relative;
        z-index: 1;
    }
    .img2 {

        cursor:pointer;
        position: relative;
        z-index: 1;
        top: -34px;
        width:135px;
        font-size:16px;
        text-align:center;
        background:#000;
        opacity:.5;
        margin-left:2px;
        padding:6px 0;
        color:#fff;

    }

    a.tooltip {
        outline:none;
    }
    a.tooltip strong {
        line-height:30px;
    }
    a.tooltip:hover {
        text-decoration:none;
    }
    a.tooltip span {
        z-index:10;
        display:none;
        padding:14px 20px;
        margin-top:-30px;
        margin-left:10px;
        width:250px;
        line-height:16px;
        color:#fff;
    }

    a.tooltip:hover span {
        display:inline;
        position:absolute;
        color:#fff;
        background:#686868;
        opacity:0.9;
        font-size:12px;
    }

    .callout {

        z-index:20;
        position:absolute;
        top:18px;
        border:0;
        left:-10px;
    }

    a.tooltip span {
        border-radius:4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        /*	-moz-box-shadow: 5px 5px 8px #ddd;
        -webkit-box-shadow: 5px 5px 8px #ddd;
        box-shadow: 5px 5px 8px #ddd;*/
    }

    .ui-combobox {
        position: relative;
        display: inline-block;
    }

    .ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        height: 1.7em;
        top: 0.1em;
    }
    .ui-combobox-input {
        margin: 0;
        padding: 0.3em;
    }
    .tp_div{

        margin-top:-12px;
    }

</style>
<script language="javascript"  src="<?= LIBRARY_JS_DIR ?>image_uploader/ajaxupload.3.5.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#app_nationality_id").attr('disabled',true);
        $("#religion_input").attr('disabled',true);
        $("#app_dob").attr('disabled',true);
        $("#app_place_of_birth").attr('disabled',true);
    });
    $(function()
    {
        var btnUpload = $('#me');
        var mestatus = $('#mestatus');
        var files = $('#files');
        new AjaxUpload(btnUpload, {
            action: 'app/payroll/uploadPhoto.php',
            name: 'uploadfile',
            onSubmit: function(file, ext) {
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                    $('#pic_error').html('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
                $('#student_photo_div').attr("src", "file_ajax.gif");
            },
            onComplete: function(file, response) {
                $("#student_photo_div").attr("src", "./temp_images/" + file);
                $("#app_student_picture").val(file);
            }
        });

    });

    $(function()
    {
        var btnUpload = $('#me1');
        var mestatus = $('#mestatus');
        var files = $('#files');
        new AjaxUpload(btnUpload, {
            action: 'app/payroll/uploadreport.php',
            name: 'uploadfile_1',
            onSubmit: function(file, ext) {
                if (!(ext && /^(docx|doc|pdf|jpg|png|jpeg|gif|txt|xls|xlsx)$/.test(ext))) {
                    $('#student_file_div').html('This extention file is not allowed');
                    return false;
                }
                $('#student_file_div').html('<img src="file_ajax.gif" height="72" width="72">');
            },
            onComplete: function(file, response){
                if (response == "success"){
                    $("#student_file_div").html("<img id='' width='30' height='30' src='./images/file_upload.png' />");
                    $("#app_student_file").val(file);
                }
            }
        });
    });

    function showDIVForValidate()
    {
        $('#personal_info').show();
        $('#contact_detail').show();
        $('#employee_detail').show();
        $('#img_1').attr('src', 'images/reg_minus.png');
        $('#img_2').attr('src', 'images/reg_minus.png');
        $('#img_3').attr('src', 'images/reg_minus.png');
    }
    
    function hideRelationValue(value)
    {
        if (value == 0)
        {
            $('#staff_relation').attr("disabled", "disabled");
            $('#staff_realtive_name').attr("disabled", "disabled");
            $('#staff_relative_emp_code').attr("disabled", "disabled");
        }
        else
        {
            $('#staff_relation').attr("disabled", false);
            $('#staff_realtive_name').attr("disabled", false);
            $('#staff_relative_emp_code').attr("disabled", false);
        }
    }
</script>
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
                    <td class="midbg12"><div class="fr">
                            <div class="top_logo_login"> <span><a href="">
                                        <?php $auth_obj->getLoginName(); ?>
                                    </a></span>
                                <div class="clear"></div>
                                <!--<span class="top_login_btn"><span class="logbutton_icon"><input onclick="location.href='logout'" type="button" value="Logout" /></span></span>-->
                                <div class="fr"> <span class="logbutton_icon">
                                        <input onclick="location.href = 'logout'" type="button" value="Logout" />
                                    </span> <span class="user_settings"><a href=""></a></span> </div>
                            </div>
                            <div class="top_logo_r"> <a href="">
                                    <?php if ($config->conf_school_logo != "") { ?>
                                        <img src="<?= BASE_HREF ?>uploads/sch_<?= $_SESSION['school_id'] ?>/thumb_<?php echo $config_obj->getSchoolLogo(); ?>" />
                                    <?php } ?>
                                </a> 
                            </div>
                        </div>
                        <!-- Header html ends  -->
                        <!-- Content html start -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <?php
                            $admision_data = explode(",", $adm_open_obj->getOpenAdmissions($app_id)); //echo "<pre>"; print_r($update_data); echo "</pre>";
                            $div_style = $msg == "" ? 'style="display:none;"' : 'style="display:block;"';
                            ?>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" >
                                        <thead>
                                        <th colspan="4"><div class="title_head">
                                            <h1>Student Admission Form</h1>
                                        </div>
                                        <?php if(trim($msg) == "Students Transfer Successfully")
                                        { ?>
                                           <div id="succ_div_top"><?=$msg?></div>
                                        <?php } else if(trim($msg) != "Students Transfer Successfully" && trim($msg)!="") { ?>
                                          <div id="err_div_top"><?=$msg?></div>
                                        <?php } ?>
                                        <!--<div id="err_div_top" <?= $div_style ?>><?= $msg ?></div>-->
                                        </th>
                                        </thead>
                                    </table>
                                    <form method="post" id="student_registration_form" name="student_registration_form" class="formee" enctype="multipart/form-data">
                                        <input type="hidden" id="student_form_id" name="student_form_id" value="<?= $stud_data->stud_app_form_id; ?>"/>
                                        <input type="hidden" id="student_id" name="student_id" value="<?= $stud_id; ?>" />
                                        <input type="hidden" id="staff_current_country" value="" />
                                        <input type="hidden" id="staff_current_state" value="" />
                                        <input type="hidden" id="staff_current_city" value="" />
                                        <input type="hidden" name="timestamp" id="timestamp" value="<?= time(); ?>">
                                        <input type="hidden" name="app_open_id" id="app_open_id" value="<?= $app_id ?>" />
                                        <input type="hidden" name="app_open_id" id="app_open_id" value="<?= $app_id ?>" />
                                        <div class="std_regi_div tp_div">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="10%">
                                                    </td>
							<td width="72%">
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabl">
                                                            <tr>
                                                                <?php						
                                                                    $stud_obj = new student;
                                                                    $course_detail = $stud_obj->getStudCourseDetail($stud_id);
                                                                ?>																
                                                                    <td width="17%" class="tablht">Batch :</td>
                                                                    <td width="31%"><?php echo $course_detail->batch_name;?></td>
                                                                  
                                                                    <td class="tablht">Session :</td>
                                                                    <td><?php echo $course_detail->session_name;?></td>                                                                  
                                                            </tr>
                                                            <tr>                                                                
                                                                <td class="tablht">Program :</td>
                                                                <td><?php echo $course_detail->program_name; ?></td>

                                                                <td class="tablht">Course :</td>
								<td><?php echo $course_detail->course_name; ?></td>                                                                  
                                                            </tr>
                                                            <tr>                                                               
                                                                <td class="tablht">Stream :</td>
                                                                <td><?php echo $course_detail->stream_name; ?></td>

                                                                <td width="29%" class="tablht">Shift :</td>
                                                                <td width="23%"><?php echo $course_detail->shift_name; ?></td>                                                                   
                                                            </tr>
                                                            <tr>
                                                                <td class="tablht">Student Type :</td>
                                                                <td>
                                                                    <select name="admin_type" id="admin_type">
                                                                        <?php
                                                                        $admission_type_obj = new admission_type();
                                                                        echo $admission_type_obj->getAdmissiontypeOptions($stud_data->stud_adm_type);
                                                                        ?>
                                                                    </select>

                                                                </td>
                                                                <td class="tablht">DATE OF REGISTRATION :</td>
                                                                <td><div><input type="text" readonly="readonly" class="stud_regis required" name="dateofregis" id="dateofregis" value="<?=date($_SESSION['DATEFORMAT'],strtotime($update_data['app_added_on']));?>" /></div><div></div> <?//=date("Y",strtotime($stud_data->stud_adm_date)) > 2000?date('d M Y',strtotime($stud_data->stud_adm_date)):date('d M Y'); ?></td>
                                                            </tr>
                                                        </table></td>
                                                    <!--<td width="72%" style="display:none;">
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabl">
                                                            <tr>
                                                                <?php
																
																
																$stud_obj = new student;
																$course_detail = $stud_obj->getStudCourseDetail($stud_id);
																
																//print_r($course_detail);
																
																
                                                                if ($admision_data[0] != "") {
                                                                    ?>
                                                                    <td width="17%" class="tablht">Batch :</td>
                                                                    <td width="31%"><?php echo ucwords($admision_data[0]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($admision_data[4] != "") {
                                                                    ?>
                                                                    <td class="tablht">Session :</td>
                                                                    <td><?php echo ucwords($admision_data[4]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                if ($admision_data[5] != "") {
                                                                    ?>
                                                                    <td class="tablht">Program :</td>
                                                                    <td><?php echo ucwords($admision_data[5]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($admision_data[1] != "") {
                                                                    ?>
                                                                    <td class="tablht">Course :</td>
                                                                    <td><?php echo ucwords($admision_data[1]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <?php if ($admision_data[2] != "") { ?>
                                                                    <td class="tablht">Stream :</td>
                                                                    <td><?php echo ucwords($admision_data[2]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($admision_data[3] != "") {
                                                                    ?>
                                                                    <td width="29%" class="tablht">Shift :</td>
                                                                    <td width="23%"><?php echo ucwords($admision_data[3]); ?></td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <tr>
                                                                <td class="tablht">Info Source edit :<?=$stud_data->stud_adm_type;?></td>
                                                                <td>
                                                                    <select name="admin_type" id="admin_type">
                                                                        <?php
                                                                        $admission_type_obj = new admission_type();
                                                                        echo $admission_type_obj->getAdmissiontypeOptions($stud_data->stud_adm_type);
                                                                        ?>
                                                                    </select>

                                                                </td>
                                                                <td class="tablht">DATE OF REGISTRATION :</td>
                                                                <td><?= date('d M Y'); ?></td>
                                                            </tr>
                                                        </table></td>-->
                                                    <td width="10%" style="padding-left:10px;"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-------------------------------------End Picture Form----------------------------------------------->
                                        <div class="std_regi_div">
                                            <div class="newStatus"></div>
                                            <input type="hidden" id="timestamp" value="<?= time(); ?>" name="timestamp">
                                            <input type="hidden" id="CONFIG_SHORT_DATE_FORMAT" value="<?= $config_obj->getShotDateFormat() ?>"/>
                                            <input type="hidden" name="permanent_address" id="permanent_address" value=""/>
                                            <input type="hidden" name="app_id" id="app_id" value="<?php echo $_GET['app_id']; ?>"/>
                                            <div class="table_block_td regheading" onclick="ShowdIV('img_1', 'personal_info')"><img src="images/reg_minus.png" onclick="ShowdIV('img_1', 'personal_info')" id="img_1" />&nbsp;1. Personal Information</div>
                                            <div class="align-td" id="personal_info">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                        <tr valign="top">
                                                            <td><strong>First Name<span class="red">*</span></strong>
                                                                <?php if ($helpData[0]['help_content'] != "") { ?>
                                                                    <a class="tooltip">
                                                                        <img src="images/help_icon.png" border="0" height="15" />
                                                                        <span class="custom help">
                                                                            <img class="callout" src="callout.gif" />
                                                                            <strong><?= $helpData[0]['help_content']; ?></strong>	</span>
                                                                    </a>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_frst_name" value="<?=trim($stud_data->stud_first_name)!=''?$stud_data->stud_first_name:''; ?>" maxlength="20"  id="app_frst_name"/>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td><strong>Middle Name</strong>
                                                                <?php if ($helpData[1]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[1]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_mid_name" value="<?=trim($stud_data->stud_middle_name)!=''?$stud_data->stud_middle_name:''; ?>" maxlength="20" id="app_mid_name"  />
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td><strong>Last Name<span class="red"></span></strong>
                                                                <?php if ($helpData[2]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[2]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_lst_name" value="<?=trim($stud_data->stud_last_name)!=''?$stud_data->stud_last_name:''; ?>" maxlength="20" id="app_lst_name" />
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td rowspan="5"><div class="effect" id="user_logo"></div>
                                                                <!-- <div class="loading"></div>-->
                                                                <div class="maindiv" id="me" >
                                                                    <?php 
                                                                        $imgsrc = "images/default.jpg";
                                                                        if(trim($stud_data->stud_images)){
                                                                           $imgsrc = BASE_HREF."/uploads/sch_".$_SESSION["school_id"]."/student_pics/thumb_".$stud_data->stud_images;
                                                                        }                                                                    
                                                                    ?>
                                                                    <img class="img1" id="student_photo_div" src="<?= $imgsrc; ?>" width="135" height="135" />
                                                                    <input type="hidden" name="app_student_picture" id="app_student_picture" value="<?=$stud_data->stud_images;?>">
                                                                </div>
                                                                <div class="img2" id="upload_photo_text">Upload Image</div>
                                                                <div id="pic_error"></div>                  </td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td><strong>Gender<span class="red">*</span></strong>
                                                                <?php if ($helpData[3]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?=$helpData[3]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <?php echo $genders->getGenderList('app_gender',$stud_data->stud_gender); ?>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td><strong>Date of Birth<span class="red">*</span></strong>
                                                                <?php if ($helpData[4]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[4]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" disabled="disabled" value="<?=trim($stud_data->stud_date_of_birth)!=''?$stud_data->stud_date_of_birth:''; ?>"id="app_dob" name="app_dob" onchange="return calcAge(this.value,<?= $app_id ?>);"/>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td><strong>Place of Birth</strong>
                                                                <?php if ($helpData[5]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[5]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <select name="app_place_of_birth" id="app_place_of_birth">
                                                                        <?php // echo $application_obj->getAllowedCountryList($_GET['app_id']);  ?>
                                                                        <?php echo $countries->getCountryList($stud_data->stud_birth_place); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td><strong>Nationality<span class="red">*</span></strong>
                                                                <?php if ($helpData[8]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[8]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover"> <?php echo $nationality->getNationalityListing('app_nationality_id', $stud_data->stud_nationality_id); ?> </div>
                                                                <div class="newStatus"></div></td>
                                                            <td id="region">
                                                                <strong>Religion<span class="red">*</span></strong>
                                                                <?php if ($helpData[7]['help_content'] != "") { ?>
                                                                    <span> 
                                                                        <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> 
                                                                            <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[7]['help_content']; ?>
                                                                                </strong> 
                                                                            </span> 
                                                                        </a> 
                                                                    </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <?php echo $religions->getReligionList('app_Religion_id',$stud_data->stud_religion_id); ?>
                                                                </div>					
                                                            </td>
                                                            <td><strong>Martial Status<span class="red">*</span></strong>
                                                                <?php if ($helpData[6]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[6]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <?php $marital_status->getMartitalStatus('app_marital_status_id',$stud_data->stud_marital_status_id); ?>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td><strong>Mobile No.<span class="red"></span>&nbsp;&nbsp;<img id="pmobloader" style="display:none;" src="images/ajax-loader.gif"/></strong>
                                                                <?php if ($helpData[10]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[10]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_student_present_mob" maxlength="12" id="app_student_present_mob" value="<?=trim($stud_data->stud_mobile)!=''?$stud_data->stud_mobile:''; ?>" />
                                                                </div>
                                                                <div class="newStatus"></div>					</td>
                                                            <td>
                                                                <strong>Telephone No.</strong>
                                                                <?php if ($helpData[11]['help_content'] != "") { ?>
                                                                    <span> 
                                                                        <a class="tooltip">
                                                                            <img src="images/help_icon.png" border="0" maxlength="20" height="15" /> 
                                                                            <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?=$helpData[11]['help_content']; ?>
                                                                                </strong> 
                                                                            </span> 
                                                                        </a> 
                                                                    </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_student_present_telno" value="<?=trim($stud_data->stud_telephone)!=''?$stud_data->stud_telephone:''; ?>" maxlength="20" id="app_student_present_telno"  />
                                                                </div>
                                                                <div class="newStatus"></div>					</td>
                                                            <td><strong>Email<span class="red"></span>&nbsp;&nbsp;<img id="pemailloader" style="display:none;" src="images/ajax-loader.gif"/></strong>
                                                                <?php if ($helpData[13]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[13]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" name="app_student_present_email" <?=$_GET['stud_id']>0?'disabled="disabled"':'';?> maxlength="100" value="<?=trim($stud_data->stud_email)!=''?$stud_data->stud_email:''; ?>" id="app_student_present_email" />
                                                                </div><div class="newStatus"></div></td>
                                                                <!--<td><strong>Fax No</strong>
                                                            <?php if ($helpData[12]['help_content'] != "") { ?>
                                                                        <span>
                                                                        <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" />
                                                                        <span>
                                                                        <img class="callout" src="callout.gif" />
                                                                        <strong><?= $helpData[12]['help_content']; ?></strong>
                                                                        
                                                                        </span>
                                                                        </a>
                                                                        </span>
                                                            <?php } ?>
                                                                <div class="cover">
                                                                <input type="text" name="app_student_present_fax" id="app_student_present_fax" class="" />
                                                                </div>
                                                                <div class="newStatus"></div></td>-->
                                                            <td><strong>Date Of Admission</strong>                                                            
                                                                <div class="cover">
                                                                    <input type="text" class="stud_regis required" readonly="readonly" name="stud_admission_date" id="stud_admission_date" value="<?=date($_SESSION['DATEFORMAT'],strtotime($stud_data->stud_adm_date));?>" class="stud_regis" />
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="10" colspan="4"></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td><strong>CNIC/Passport No.</strong>
                                                                <?php if ($helpData[9]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[9]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <input type="text" id="app_passport_no" maxlength="30" name="app_passport_no" value="<?=trim($stud_data->stud_passport_no)!=''?$stud_data->stud_passport_no:''; ?>" />
                                                                </div>
                                                                <div class="newStatus"></div>				  </td>
                                                            <td><strong>Language Spoken<span class="red"></span></strong>
                                                                <?php if ($helpData[14]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[14]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <select name="checkbox" id="app_language">
                                                                    <!--<select name="checkbox[]" id="app_language" multiple="multiple">-->
                                                                        <?php echo $languages_obj->getLanguage(); ?>
                                                                    </select>
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td id="blood_grp"><strong>Blood Group</strong>
                                                                <?php if ($helpData[17]['help_content'] != "") { ?>
                                                                    <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                <img class="callout" src="callout.gif" />
                                                                                <strong>
                                                                                    <?= $helpData[17]['help_content']; ?>
                                                                                </strong> </span> </a> </span>
                                                                <?php } ?>
                                                                <div class="cover">
                                                                    <?php echo $blood_obj->getBloodOptions('blood_group',$stud_data->stud_blood_group); ?>
                                                                <!-- <input type="text" name="blood_group" maxlength="10" id="blood_group" />
                                                                <input type="checkbox" value="" />-->
                                                                </div></td>
                                                            <td>
                                                                <span class="logbutton_grey">
                                                                    <input type="button"  id="me1" value="Blood Group Lab Cert:" />
                                                                </span>
                                                                <div class="clear"></div>
                                                                <span id="student_file_div"></span>
                                                                <input type="hidden" name="app_student_file" id="app_student_file" value="" />
                                                            </td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="12" colspan="4"></td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td id="col_lang_test"><strong>Language Test Result</strong>
                                                                <div class="cover">
                                                                    <input type="text" id="app_lang_test" maxlength="6" name="app_lang_test" <?= $_SESSION['criteria_1'] != "" ? 'disabled="disabled"' : ''; ?> onblur="validateTest(this.id, this.value, 1,<?= $app_id ?>);" value="<?= $_SESSION['criteria_1'] ?>" />
                                                                </div>
                                                                <div class="newStatus"></div>				  </td>
                                                            <td id="col_iq_test"><strong>IQ Test<span class="red"></span></strong>
                                                                <div class="cover">
                                                                    <input type="text" id="app_iq_test" maxlength="6" name="app_iq_test" <?= $_SESSION['criteria_2'] != "" ? 'disabled="disabled"' : ''; ?> onblur="validateTest(this.id, this.value, 2,<?= $app_id ?>);" value="<?= $_SESSION['criteria_2'] ?>" />
                                                                </div>
                                                                <div class="newStatus"></div></td>
                                                            <td id="col_intr_days"><strong>Internship Days</strong>
                                                                <div class="cover">
                                                                    <input type="text" id="app_intership_days" maxlength="6" name="app_intership_days" <?= $_SESSION['criteria_3'] != "" ? 'disabled="disabled"' : ''; ?> onblur="validateTest(this.id, this.value, 3,<?= $app_id ?>);" value="<?= $_SESSION['criteria_3'] ?>" />
                                                                </div><div class="newStatus"></div>		</td>
                                                            <td id="col_last_result"><strong>Last Result</strong>
                                                                <div class="cover">
                                                                    <input type="text" id="app_last_result" maxlength="6" name="app_last_result" <?= $_SESSION['criteria_4'] != "" ? 'disabled="disabled"' : ''; ?> onblur="validateTest(this.id, this.value, 4,<?= $app_id ?>);" value="<?= $_SESSION['criteria_4'] ?>" />
                                                                </div><div class="newStatus"></div>		</td>
                                                        </tr>
                                                        <tr valign="top">
                                                            <td height="12" colspan="4"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><h2>Language Proficiency
                                                                    <?php if ($helpData[15]['help_content'] != "") { ?>
                                                                        <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span>
                                                                                    <img class="callout" src="callout.gif" />
                                                                                    <strong>
                                                                                        <?= $helpData[15]['help_content']; ?>
                                                                                    </strong> </span> </a> </span>
                                                                    <?php } ?>
                                                                </h2>

                                                                <table id="langtbl" width="100%" cellpadding="0" cellspacing="0" class="regester-table">
                                                                    <tr>
                                                                        <th>Language</th>
                                                                        <th>Reading</th>
                                                                        <th>Writing</th>
                                                                        <th>Speaking</th>
                                                                    </tr>
                                                                    <?php 
                                                                        if($_GET['stud_id'] > 0)
                                                                        {   
                                                                            $c=1;
                                                                            $result = mysqli_query($_SESSION['db_conn'], 'SELECT * FROM tbl_language_known WHERE app_form_id="'.$stud_data->stud_app_form_id.'" AND language_deleted = 0 ORDER BY app_language_id');
                                                                            if(mysqli_num_rows($result) > 0) 
                                                                            {                                                                                
                                                                                while($arr = mysqli_fetch_array($result))
                                                                                {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <select name="languge_known[]" class="language_selectbox">
                                                                                                <option value="">Select Language</option>
                                                                                                <?=$languages_obj->getLanguage($arr['language_known']); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select name="lang_reading[]" class="language_selectbox">
                                                                                                <?php echo $academic_obj->getAcademicData('Reading', $arr['language_reading']); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select name="lang_writing[]" class="language_selectbox">
                                                                                                <?php echo $academic_obj->getAcademicData('Writing', $arr['language_writing']); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                        <td>
                                                                                            <select name="lang_speaking[]" class="language_selectbox">
                                                                                                <?php echo $academic_obj->getAcademicData('Speaking', $arr['language_speaking']); ?>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php $c++;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <select name="languge_known[]" class="language_selectbox">
                                                                                            <option value="">Select Language</option>
                                                                                            <?= $languages_obj->getLanguage(); ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="lang_reading[]" class="language_selectbox">
                                                                                            <?php echo $academic_obj->getAcademicData('Reading'); ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="lang_writing[]" class="language_selectbox">
                                                                                            <?php echo $academic_obj->getAcademicData('Writing'); ?>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select name="lang_speaking[]" class="language_selectbox">
                                                                                            <?php echo $academic_obj->getAcademicData('Speaking'); ?>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                      <?php }
                                                                        }                                                                        
                                                                    ?>
                                                                </table>
                                                            </td>
                                                            <td class="padd_tp_left" valign="bottom">
                                                                <span style="float:left;"><a href="javascript:ShowlangRow('L')"><img src="images/addmarks.png"  /></a></span>
                                                                <span style="float:left;padding-left:7px;"><a href="javascript:DeletelangRow('L')"><img src="images/main_minus.png"  /></a></span>
                                                                <input type="hidden" name="lang_tatal" id="lang_tatal" value="<?=$c;?>" />
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!----------------------------------------STUDENT CONTACT START----------------------------------------------------------->
                                            <div class="table_block_td regheading" onclick="ShowdIV('img_2', 'contact_detail')"><img src="images/sut_reg_add.png" onclick="ShowdIV('img_2', 'contact_detail')" id="img_2" /> &nbsp;2. Contact Details</div>
                                            <div class="align-td" id="contact_detail" <?=$style_type?>>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tr>
                            <td colspan="4"><b>Present</b> </td>
                          </tr>
                          <tr>
                            <td height="10" colspan="4"></td>
                          </tr>
                          <tr valign="top">
                            <td colspan=""><strong>Address 1. <span class="red">*</span></strong>
                              <div class="cover">
                                <input type="text" name="staff_address1_current" id="staff_address1_current" class="int_wid"  value="<?= $upresent[1]; ?>"/>
                              </div>
                              <div class="newStatus"></div></td>
                             <td><strong>Address 2.</strong>
                              <div class="cover">
                                <input type="text" name="staff_address2_current" id="staff_address2_current" class="int_wid"  value="<?= $upresent[2]; ?>"/>
                              </div>
                             <div class="newStatus"></div></td>
                            <td><strong>Country<span class="red">*</span></strong>
                              <div class="cover">
                                <select class="int_wid" name="app_curr_country" id="app_curr_country1" onChange="selectState(this.value,'current')">
                                  <option value="">Select Country</option>
                                  <?php echo $countries->getCountryList($upresent[3]); ?>
                                </select>
                              </div>
                              <div class="error_class newStatus" id="country_id"></div></td>
                            <td><strong>State<span class="red">*</span></strong>
                              <div class="cover">
                                <select name="app_curr_location" class="int_wid" id="app_curr_location1" onChange="selectCity(this.value,'app_curr_city1','','')">
                                  <?php
                                    if($_GET['stud_id']>0){

                                          echo $state_obj->getStateList($upresent[3],$upresent[4]);

                                    }else{
                                    ?>
                                        <option value="">Select State</option>
                                  <?php
                                    }
                                    ?>
                                </select>
                              </div>
                              <div class="error_class newStatus" id="state_error"></div></td>
                          </tr>
                          <tr>
                            <td height="10" colspan="4"></td>
                          </tr>
                          <tr>
                            <td><strong>City<span class="red">*</span></strong>
                              <div class="cover">
                                <select name="app_curr_city" id="app_curr_city1" class="int_wid"  onChange="">
                                  <?php
                                if($_GET['stud_id']>0){
                                    $city_obj->getCityList($upresent[4],$upresent[5]);
                                }else{
                                ?>
                                  <option value="">Select City</option>
                                  <?php
                                }
                                ?>
                                </select>
                              </div>
                              <div class="error_class newStatus" id="city_error"></div></td>
                            <td><strong>Area <span class="red">*</span></strong>
                              <div class="cover">
                                  <?php
                                    if($_GET['stud_id']>0){
                                        echo $areas_obj->getAreaListing('app_student_present_area',$upresent[6]);
                                        //$areas_obj->getAreaList($get_staff_present_addr->addr_city_id,$get_staff_present_addr->app_area_id);
                                    }else{
                                        echo $areas_obj->getAreaListing('app_student_present_area');
                                    }
                                    ?>
                              </div>
                              <div class="newStatus"></div></td>
                            <td><strong>Postal Code <span class="red"></span></strong>
                              <div class="cover">                                 
                                <input type="text" name="app_curr_zipcode" id="app_curr_zipcode" class="int_wid"  value="<?=$upresent[8]; ?>"/>
                              </div>
                              <div class="newStatus"></div></td>
                          </tr>
                          <tr>
                            <td height="20" colspan="4"></td>
                          </tr>
                          <tr>
                            <td colspan="4"><b>Permanent</b> <span id="isparent">
                              <input type="checkbox" id="is_same_as_present" name="is_same_as_present" onclick="showPermanentAddr();" />
                              </span> Same as Present Address</td>
                          </tr>
                          <tr>
                            <td height="10" colspan="4"></td>
                          </tr>
                          <!-----------------------------------------------------PERMANENT Address Start ------------------------------------------------------------->
                          <tr>
                            <td colspan="4"><div id="permanent_div">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                  <tr>
                                    <td colspan=""><strong>Address 1.</strong><span class="red">*</span>
                                      <div class="cover">
                                        <input type="text" name="staff_address1_perm" id="staff_address1_perm" class="int_wid"  value="<?= $upermanent[1]; ?>"/>
                                      </div>
                                      <div class="newStatus"></div></td>
                                    <td><strong>Address 2.</strong>
                                      <div class="cover">
                                        <input type="text" name="staff_address2_perm" id="staff_address2_perm" class="int_wid"  value="<?= $upermanent[2]; ?>"/>
                                      </div>
                                      <div class="newStatus"></div>
                                    </td>
                                    <td id="td_permanent_country"><strong>Country</strong> <span class="red">*</span>
                                      <div class="cover">
                                        <select name="app_perm_country" class="int_wid" id="app_perm_country" onChange="selectState(this.value,'permanent')">
                                          <option value="">Select Country</option>
                                      <?php echo $countries->getCountryList($upermanent[3]); ?>
                                        </select>
                                      </div>
                                    <div class="newStatus"></div></td>
                                    <td id="td_permanent_state"><strong>State</strong> <span class="red">*</span>
                                      <div class="cover">
                                        <select name="app_permanent_location" class="int_wid" id="app_permanent_location" onChange="selectCity(this.value,'app_permanent_city')">
                                          <?php
                                        if($_GET['stud_id']>0){
                                            $state_obj->getStateList($upermanent[3],$upermanent[4]);
                                        }else{
                                        ?>
                                            <option value="">Select State</option>
                                          <?php
                                        }
                                        ?>
                                        </select>
                                      </div>
                                      <div class="newStatus"></div></td>
                                  </tr>
                                  <tr>
                                    <td height="10" colspan="4"></td>
                                  </tr>
                                  <tr>
                                    <td id="td_permanent_city"><strong>City</strong> <span class="red">*</span>
                                      <div class="cover">
                                        <select name="app_permanent_city" class="int_wid" id="app_permanent_city" onChange="">
                                          <?php
                                        if($_GET['stud_id']>0){
                                            $city_obj->getCityList($upermanent[4],$upermanent[5]);
                                        }else{
                                        ?>
                                          <option value="">Select City</option>
                                          <?php
                                        }
                                        ?>
                                        </select>
                                      </div>
                                    <div class="newStatus"></div></td>
                                    <td id="td_permanent_area"><strong>Area</strong>
                                      <div class="cover">
                                        
                                          <?php
                                            if($_GET['stud_id']>0){
                                                echo $areas_obj->getAreaListing('app_student_permanent_area',$upermanent[6]);
                                                //$areas_obj->getAreaList($get_staff_present_addr->addr_city_id,$get_staff_present_addr->app_area_id);
                                            }else{
                                                echo $areas_obj->getAreaListing('app_student_permanent_area');
                                            }
                                            ?>

                                      </div>
                                      <div class="newStatus"></div></td>
                                    <td><strong>Postal Code</strong>
                                      <div class="cover">
                                        <input type="text" name="app_permanent_zipcode" id="app_permanent_zipcode" class="int_wid"  value="<?= $upermanent[8]; ?>" />
                                      </div>
                                      <div class="newStatus"></div></td>
                                  </tr>
                                </table>
                              </div></td>
                          </tr>
                        </table>
                      </div>
                                            <!----------------------------------------STUDENT CONTACT END---------------------------------------------------------------------------->
                                            <div class="table_block_td regheading" onclick="ShowdIV('img_3', 'academic_detail')">
                                                <img src="images/sut_reg_add.png" id="img_3" onclick="ShowdIV('img_3', 'academic_detail')" />&nbsp;3. Academic Information
                                            </div>
                                            <div class="align-td" id="academic_detail" <?=$style_type?>>
                                                <table id="acadetbl" width="100%" cellspacing="0" cellpadding="0" class="regester-table new-tb">                            
                                                    <?php
                                                    $t=1;
                                                    if($_GET['stud_id']>0)
                                                    { 
                                                        $acad_result = mysqli_query($_SESSION['db_conn'], $q="SELECT * FROM tbl_admision_academic WHERE app_form_id='".$update_data['app_form_field_id']."' ORDER BY app_academic_id ASC")or die(" Error : ".mysqli_error($_SESSION['db_conn'])); 
                                                        if(mysqli_num_rows($acad_result) > 0)
                                                        { 
                                                            while($record = mysqli_fetch_object($acad_result))
                                                            { 
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" cellspacing="0" cellpadding="0" class="regester-table table1">
                                                                            <tr>
                                                                                <th><strong>Degree/Certificate</strong></th>
                                                                                <th><strong>Major</strong></th>
                                                                                <th><strong>Institute's Name</strong>
                                                                                    <?php if ($helpData[18]['help_content'] != "") { ?>
                                                                                        <span> 
                                                                                            <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> 
                                                                                                <span><img class="callout" src="callout.gif" /><strong><?= $helpData[18]['help_content']; ?></strong></span>
                                                                                            </a>
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                </th>
                                                                                <th><strong>Board/University</strong>
                                                                                    <?php if ($helpData[19]['help_content'] != "") { ?>
                                                                                        <span> 
                                                                                            <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" />
                                                                                                <span><img class="callout" src="callout.gif" /><strong><?= $helpData[19]['help_content']; ?></strong> </span>
                                                                                            </a> 
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                </th>
                                                                                <th><strong>Year</strong>
                                                                                    <?php if ($helpData[20]['help_content'] != "") { ?>
                                                                                        <span> 
                                                                                            <a class="tooltip">
                                                                                                <img src="images/help_icon.png" border="0" height="15" />
                                                                                                <span><img class="callout" src="callout.gif" /><strong> <?=$helpData[20]['help_content']; ?></strong> </span>
                                                                                            </a> 
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                </th>
                                                                                <th><strong>Percentage/CGPA</strong>
                                                                                    <?php if ($helpData[21]['help_content'] != "") { ?>
                                                                                        <span> 
                                                                                            <a class="tooltip">
                                                                                                <img src="images/help_icon.png" border="0" height="15" />
                                                                                                <span><img class="callout" src="callout.gif" /><strong><?= $helpData[21]['help_content']; ?></strong> </span>
                                                                                            </a> 
                                                                                        </span>
                                                                                    <?php } ?>
                                                                                </th>
                                                                                <th><strong>Grade/ Division</strong>
                                                                                    <?php if ($helpData[23]['help_content'] != "") { ?>
                                                                                        <span> 
                                                                                            <a class="tooltip">
                                                                                                <img src="images/help_icon.png" border="0" height="15" />
                                                                                                <span><img class="callout" src="callout.gif" /><strong><?= $helpData[23]['help_content']; ?></strong> </span>
                                                                                            </a>
                                                                                        </span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </th>
                                                                                <th width="15%"><strong>Result Status</strong></th>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>
                                                                                    <input type="hidden" name="acadmid_id[]" value="<?=$record->app_academic_id;?>" />
                                                                                    <input type="text" name="degree[]" value="<?=$record->app_degree;?>" size="8" style="width:81px !important;" />
                                                                                </td>
                                                                                <td><input type="text" value="<?=$record->app_major?>" name="major[]" id="major" size="6" style="width:114px !important;" /></td>
                                                                                <td>
                                                                                    <div class="cover">
                                                                                        <input type="text" value="<?=$record->app_institute_name?>" size="6" name="app_institute_name[]" style="width:114px !important;" />
                                                                                    </div><div class="newStatus"></div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="cover">
                                                                                        <input type="text" value="<?=$record->app_board;?>" size="6" name="app_board_name[]" style="width:86px !important;" />
                                                                                    </div><div class="newStatus"></div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="cover">
                                                                                        <select name="app_year_passed[]" style="width:77px !important;">
                                                                                            <option value="">Year</option>
                                                                                            <?php
                                                                                                $y=(int)date(Y);
                                                                                                for($i=($y-112);$i<=$y;$i++)
                                                                                                {  $selected = '';
                                                                                                    if($record->app_year==$i)
                                                                                                    {
                                                                                                        $selected = "selected=selected";
                                                                                                    }
                                                                                                    echo'<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                                                                }
                                                                                             ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="cover">
                                                                                        <input type="text" value="<?=$record->app_percentage;?>" name="app_marks_obtained[]" style="width:95px !important;"/>
                                                                                    </div><div class="newStatus"></div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="cover">
                                                                                        <input type="text" value="<?=$record->app_grade;?>" size="5" name="app_grade[]" style="width:69px !important;" />
                                                                                    </div><div class="newStatus"></div>
                                                                                </td>
                                                                                <td width="15%">
                                                                                    <select name="result_awarded[]" style="min-width:150px;">
                                                                                        <?php  echo $resultstat->getResultStatus($record->app_result_award); ?>
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            <?php $t++;
                                                            }
                                                        }
                                                        else
                                                        {  ?>
                                                            <tr>
                                                        <td>
                                                            <table width="100%" cellspacing="0" cellpadding="0" class="regester-table table1">
                                                                <tr>
                                                                    <th><strong>Degree/Certificate</strong></th>
                                                                    <th><strong>Major</strong></th>
                                                                    <th><strong>Institute's Name</strong>
                                                                        <?php if ($helpData[18]['help_content'] != "") { ?>
                                                                        <span> 
                                                                            <a class="tooltip">
                                                                                <img src="images/help_icon.png" border="0" height="15" /> 
                                                                                <span><img class="callout" src="callout.gif" /><strong><?=$helpData[18]['help_content']; ?></strong></span>
                                                                            </a>
                                                                        </span>
                                                                        <?php } ?>
                                                                    </th>
                                                                    <th><strong>Board/University</strong>
                                                                        <?php if ($helpData[19]['help_content'] != "") { ?>
                                                                        <span> 
                                                                            <a class="tooltip">
                                                                                <img src="images/help_icon.png" border="0" height="15" /> 
                                                                                <span><img class="callout" src="callout.gif" /><strong><?=$helpData[19]['help_content']; ?></strong> </span>
                                                                            </a>
                                                                        </span>
                                                                        <?php } ?>
                                                                    </th>
                                                                    <th><strong>Year</strong>
                                                                        <?php if ($helpData[20]['help_content'] != "") { ?>
                                                                        <span> 
                                                                            <a class="tooltip">
                                                                                 <img src="images/help_icon.png" border="0" height="15" />
                                                                                 <span><img class="callout" src="callout.gif" /><strong><?=$helpData[20]['help_content']; ?></strong> </span>
                                                                            </a>
                                                                        </span>
                                                                        <?php } ?>
                                                                    </th>
                                                                    <th><strong>Percentage/CGPA</strong>
                                                                        <?php if ($helpData[21]['help_content'] != "") { ?>
                                                                        <span> 
                                                                            <a class="tooltip">
                                                                                <img src="images/help_icon.png" border="0" height="15" /> 
                                                                                <span><img class="callout" src="callout.gif" /><strong><?=$helpData[21]['help_content']; ?></strong> </span> 
                                                                            </a>
                                                                        </span>
                                                                        <?php } ?>
                                                                    </th>
                                                                    <th><strong>Grade/ Division</strong>
                                                                        <?php if ($helpData[23]['help_content'] != "") { ?>
                                                                        <span> 
                                                                            <a class="tooltip">
                                                                                <img src="images/help_icon.png" border="0" height="15" />
                                                                                <span><img class="callout" src="callout.gif" /><strong><?= $helpData[23]['help_content']; ?></strong> </span>
                                                                            </a>
                                                                        </span>
                                                                        <?php } ?>
                                                                    </th>
                                                                    <th width="15%"><strong>Result Status</strong></th>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="hidden" name="acadmid_id[]" value="" />
                                                                    <input type="text" name="degree[]" value="" size="8" style="width:81px !important;" /></td>
                                                                    <td><input type="text" value="" name="major[]" id="major" size="6" style="width:114px !important;" /></td>
                                                                    <td>
                                                                        <div class="cover">
                                                                            <input type="text" value="<?=$record->emp_ac_inst_name;?>" size="6" name="app_institute_name[]" style="width:114px !important;" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="cover">
                                                                            <input type="text" value="" size="6" name="app_board_name[]" style="width:86px !important;" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="cover">
                                                                            <select name="app_year_passed[]" style="width:77px !important;">
                                                                                <option value="">Year</option>
                                                                                <?php
                                                                                    $y=(int)date(Y);
                                                                                    for($i=($y-112);$i<=$y;$i++)
                                                                                    {
                                                                                        echo'<option value="'.$i.'" >'.$i.'</option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="cover">
                                                                            <input type="text" value="" name="app_marks_obtained[]" style="width:95px !important;" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="cover">
                                                                            <input type="text" value="" size="5" name="app_grade[]>" style="width:69px !important;" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td>
                                                                        <select name="result_awarded[]" style="min-width:150px !important;">
                                                                            <?php  echo $resultstat->getResultStatus(); ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                           </table>
                                                        </td>
                                                    </tr>  
                                                  <?php }
                                                    } ?>
                                                                    
                                                                                                        
                                                </table>
                                                
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td height="15" colspan="6" align="right" style="text-align:right;">
                                                            <input type="hidden" name="max_acadmec" id="max_acadmec" value="<?=$t?>" />
                                                            <a href="javascript:ShowlangRow('A')"><img src="images/addmarks.png"  /></a>&nbsp;&nbsp;<a href="javascript:DeletelangRow('A')"><img src="images/main_minus.png"  /></a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" height="13"></td>
                                                    </tr>
                                                   
                                                  <tr valign="top">
                                                      <td><strong>Extra Curricular Activities</strong></td>
                                                        <td>
                                                          <div class="cover">
                                                              <textarea name="extra_activity" rows="2" cols="15" id="extra_activity"><?=$stud_data->stud_extra_activity;?></textarea>
                                                          </div>
                                                          <div class="newStatus"></div>
                                                      </td>
                                                    <td><strong>Physically Challenged</strong> </td>
                                                    <td><textarea name="physically_challenged" id="physically_challenged" rows="2" cols="15"><?=$stud_data->stud_physical_challenged_desc;?>
                        </textarea></td>
                                                    <td><strong>Siblings</strong> </td>
                                                    <td><input type="text" name="siblings" id="siblings" value="<?=$stud_data->stud_sibling_admission_no;?>" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td height="13"></td>
                                                  </tr>
                                                  <tr valign="top"> </tr>
                                                </table>
                      </div>
                                            <!----------------------------------------Parents Detail ----------------------------------------------------------->

                                            <div class="table_block_td regheading" onclick="ShowdIV('img_4', 'parents_detail')">
                                                <img src="images/sut_reg_add.png" id="img_4" onclick="ShowdIV('img_4', 'parents_detail')" />&nbsp;4. Parents Detail</div>
                                            <div class="align-td" id="parents_detail">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td width="9%" class="heading-1">Father Name
                                                            <?php if ($helpData[35]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[35]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="9%" class="heading-1">Occupation
                                                            <?php if ($helpData[37]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[37]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1" width="9%">Designation
                                                            <?php if ($helpData[38]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[38]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="8%" class="heading-1">Organization
                                                            <?php if ($helpData[39]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[39]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="9%" class="heading-1">Address</td>
                                                        <td width="8%" class="heading-1">Country
                                                            <?php if ($helpData[31]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[31]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="8%" class="heading-1">State
                                                            <?php if ($helpData[32]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[32]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="9%" class="heading-1">City
                                                            <?php if ($helpData[33]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[33]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td width="9%" class="heading-1">Area
                                                            <?php if ($helpData[34]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[34]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>



                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <table width="100%" cellpadding="0" cellspacing="0" class="new_css_reg">
                                                                <tr valign="top">
                                                                    <td width="10%">
                                                                        <div class="cover">
                                                                            <input type="text" name="app_father_name" id="app_father_name" value="<?=$stud_data->stud_father_name; ?>" size="6" />
                                                                        </div><div class="newStatus"></div>

                                                                    </td>
                                                                    <td width="10%" id="father_ocup">
                                                                        <div class="cover">
                                                                            <?=$occupation_obj->getOccupationListing('app_father_ocuptn',$ufather[12]); ?>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%" id="father_design">
                                                                        <div class="cover">
                                                                            <?=$designations_obj->getDesignationList('app_father_designation',$ufather[13]); ?>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%"><input type="text" id="app_father_organization" value="<?=$ufather[14];?>" name="app_father_organization" /></td>
                                                                    <td width="10%"><input type="text" id="app_father_address" value="<?=$ufather[1];?>" name="app_father_address" /></td>
                                                                    <td width="10%">
                                                                        <div>
                                                                            <select name="app_father_country" id="app_father_country" class="" onchange="selectState_1(this.value, 'app_father_state')">
                                                                                <option value="">Select Country</option>
                                                                                <?php echo $countries->getCountryList($ufather[3]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%">
                                                                        <div>
                                                                            <select name="app_father_state" class="" id="app_father_state" onChange="loadCities(this.value, 'app_father_city')">
                                                                                <option value="">Select State</option>
                                                                                <?php echo $state_obj->getStateList($ufather[3],$ufather[4]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="9%">
                                                                        <div>
                                                                            <select  name="app_father_city" id="app_father_city" class="" >
                                                                                <option value="">Select City</option>
                                                                                <?php echo $city_obj->getCityList($ufather[4],$ufather[5]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="9%">
                                                                        <div>
                                                                            <?php echo $area_obj->getAreaListing('app_father_area',$ufather[6]); ?>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="10%" class="heading-1">Postal Code
                                                                        <?php if ($helpData[41]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[41]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td width="16%" class="heading-1">Social Security No./CNIC
                                                                        <?php if ($helpData[40]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[40]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td width="20%" class="heading-1">Education</td>
                                                                    <td width="10%" class="heading-1">Tel: No.
                                                                        <?php if ($helpData[11]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[11]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td width="11%" class="heading-1">Fax No.
                                                                        <?php if ($helpData[12]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[12]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td width="11%" class="heading-1">Mobile No.
                                                                        <?php if ($helpData[10]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[10]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td width="11%" class="heading-1">Email Address
                                                                        <?php if ($helpData[13]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[13]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <table width="100%" cellpadding="0" cellspacing="0" class="new_css_reg">
                                                                <tr valign="top">
                                                                    <td width="10%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_father_postal" value="<?=$ufather[7];?>" name="app_father_postal" />
                                                                        </div>
                                                                        <div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="16%">
                                                                        <div>
                                                                            <input type="text" id="father_cnic" value="<?=$ufather[15];?>" name="app_father_cnic" style="width:140px!important;" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="11%" id="fath_edu"><?php echo $lastexam_obj->getsLastExamList('father_education',$ufather[16]); ?></td>
                                                                    <td width="11%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_father_telephone" value="<?=$ufather[9] > 0?$ufather[9]:'';?>" name="app_father_telephone" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="11%">
                                                                        <div>
                                                                            <input type="text" id="app_father_fax" value="<?=$ufather[10] > 0?$ufather[10]:'';?>" name="app_father_fax" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="11%">
                                                                        <div>
                                                                            <input type="text" id="app_father_mobile" value="<?=$ufather[8];?>" name="app_father_mobile" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="1%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_father_email" name="app_father_email" value="<?=$ufather[11];?>" size="21" class="email_reg" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#DEDEDE" height="1" colspan="9"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9" height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="heading-1">Mother Name
                                                            <?php if ($helpData[36]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[36]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">Occupation
                                                            <?php if ($helpData[37]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[37]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">Designation
                                                            <?php if ($helpData[38]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[38]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">Organization
                                                            <?php if ($helpData[39]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[39]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">Address </td>
                                                        <td class="heading-1">Country
                                                            <?php if ($helpData[32]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[32]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">State
                                                            <?php if ($helpData[32]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[32]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">City
                                                            <?php if ($helpData[33]['help_content'] != "") { ?>
                                                                <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[33]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>
                                                        <td class="heading-1">Area
                                                            <?php if ($helpData[34]['help_content'] != "") { ?>
                                                                <span><a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                <?= $helpData[34]['help_content']; ?>
                                                                            </strong> </span> </a> </span>
                                                            <?php } ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <table width="100%" cellpadding="0" cellspacing="0" class="new_css_reg">
                                                                <tr valign="top">
                                                                    <td width="10%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_mother_name" value="<?=$stud_data->stud_mother_name; ?>" name="app_mother_name" />
                                                                        </div>
                                                                        <div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%" id="mother_occup"><?=$occupation_obj->getOccupationListing('app_mother_ocuptn1',$umother[12]); ?></td>
                                                                    <td width="10%" id="mother_designation"><?=$designations_obj->getDesignationList('app_mother_designation',$umother[13]); ?></td>
                                                                    <td width="10%">
                                                                        <div>
                                                                            <input type="text" id="app_mother_organization" value="<?=$umother[14];?>" name="app_mother_organization" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%">
                                                                        <div>
                                                                            <input type="text" id="app_mother_address" value="<?=$umother[1];?>" name="app_mother_address" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="10%">
                                                                        <div>
                                                                            <select name="app_mother_country" id="app_mother_country" onChange="selectState_1(this.value, 'app_mother_state')">
                                                                                <option value="">Select Country</option>
                                                                                <?php echo $countries->getCountryList($umother[3]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>

                                                                    <td width="9%">
                                                                        <div>
                                                                            <select name="app_mother_state" id="app_mother_state" onChange="loadCities(this.value, 'app_mother_city')">
                                                                                <option value="">Select State</option>
                                                                                <?php echo $state_obj->getStateList($umother[3],$umother[4]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>

                                                                    <td width="9%">
                                                                        <div>
                                                                            <select  name="app_mother_city" id="app_mother_city" >
                                                                                <option value="">Select City</option>
                                                                                <?php echo $city_obj->getCityList($umother[4],$umother[5]); ?>
                                                                            </select>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="9%">
                                                                        <div>
                                                                            <?php echo $area_obj->getAreaListing('app_mother_area',$umother[6]); ?>
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9"><table width="100%" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="heading-1" width="10%">Postal Code
                                                                        <?php if ($helpData[41]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[41]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td class="heading-1" width="16%">Social Security No./CNIC
                                                                        <?php if ($helpData[40]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[40]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td class="heading-1" width="20%">Education </td>
                                                                    <td class="heading-1" width="10%">Tel: No.
                                                                        <?php if ($helpData[11]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[11]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td class="heading-1" width="11%">Fax No.
                                                                        <?php if ($helpData[12]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[12]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td class="heading-1" width="11%">Mobile No.
                                                                        <?php if ($helpData[10]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[10]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                    <td class="heading-1" width="11%"> Email Address
                                                                        <?php if ($helpData[13]['help_content'] != "") { ?>
                                                                            <span> <a class="tooltip"><img src="images/help_icon.png" border="0" height="15" /> <span> <img class="callout" src="callout.gif" /> <strong>
                                                                                            <?= $helpData[13]['help_content']; ?>
                                                                                        </strong> </span> </a> </span>
                                                                        <?php } ?></td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <table width="100%" cellpadding="0" cellspacing="0" class="new_css_reg">
                                                                <tr valign="top">
                                                                    <td width="11%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_mother_postal" value="<?=$umother[7];?>" name="app_mother_postal" />
                                                                        </div>
                                                                        <div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="14%"><input type="text" id="mother_cnic" value="<?=$umother[15];?>" name="app_mother_cnic" /></td>
                                                                    <td width="11%" id="moth_edu"><?php echo $lastexam_obj->getsLastExamList('mother_education',$umother[16]); ?></td>
                                                                    <td width="11%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_mother_telephone" value="<?=$umother[9] > 0?$umother[9]:'';?>" name="app_mother_telephone" />
                                                                        </div>
                                                                        <div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="11%">
                                                                        <div>
                                                                            <input type="text" id="app_mother_fax" value="<?=$umother[10] > 0?$umother[10]:'';?>" name="app_mother_fax" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="11%">
                                                                        <div>
                                                                            <input type="text" id="app_mother_mobile" value="<?=$umother[8] > 0 ?$umother[8]:'';?>" name="app_mother_mobile" />
                                                                        </div><div class="newStatus"></div>
                                                                    </td>
                                                                    <td width="1%">
                                                                        <div class="cover">
                                                                            <input type="text" id="app_mother_email" value="<?=$umother[11];?>" name="app_mother_email" />
                                                                        </div>
                                                                        <div class="newStatus"></div>
                                                                    </td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                </table>
                                            </div>


                                            <div class="table_block_td regheading" onclick="ShowdIV('img_5', 'emergency_detail')"><img src="images/sut_reg_add.png" id="img_5" onclick="ShowdIV('img_5', 'emergency_detail')"/>&nbsp;5. Emergency Contact Details</div>
                                            <div class="align-td" id="emergency_detail" <?=$style_type?>>
                        <table width="100%" cellspacing="0" cellpadding="0" class="emg_css regester-table table1">
                          <tr>
                            <th width="18%" class="heading-1"><strong>Name</strong></th>
                            <th width="18%" class="heading-1"><strong>Relation</strong></th>
                            <th width="18%" class="heading-1"><strong>Mobile No.</strong></th>
                            <th width="18%" class="heading-1"><strong>Tel: No.</strong></th>
                          </tr>
                          <tr>
                            <td><input type="text" name="emergency_name" id="emergency_name" value="<?= $uemrgency[0]; ?>" size="10" /></td>
                            <td><input type="text" name="emergency_relation" id="emergency_relation" value="<?= $uemrgency[1]; ?>" /></td>
                            <td><input type="text" value="<?= $uemrgency[10]; ?>" name="emergency_mob_num" id="emergency_mob_num" size="10" /></td>
                            <td><input type="text" value="<?= $uemrgency[11]; ?>" size="10" name="emergency_tel_num" id="emergency_tel_num"  /></td>
                          </tr>
                          <tr>
                            <th width="18%" class="heading-1"><strong>Fax No.</strong></th>
                            <th width="14%" class="heading-1"><strong>Email Address</strong></th>
                            <th width="18%" class="heading-1"></th>
                            <th width="14%" class="heading-1"></th>
                          </tr>
                          <tr>                            
                            <td><input type="text" value="<?= $uemrgency[12]; ?>" size="10" name="emergency_fax_num" id="emergency_fax_num" /></td>
                            <td><input type="text" value="<?= $uemrgency[13]; ?>" size="10" name="emergency_email" id="emergency_email" /></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <th class="heading-1">Address</th>
                            <th class="heading-1">Country</th>
                            <th class="heading-1">State</th>
                            <th class="heading-1">City</th>
                          </tr>
                          <tr>
                            <td><input type="text" name="emergency_address" id="emergency_address" value="<?= $uemrgency[3]; ?>" size="4" /></td>
                            <td>
                            <select name="emergency_country" id="emergency_country" onChange="selectState_1(this.value,'emergency_state_1')">
                            <?php echo $countries->getCountryList($uemrgency[5]); ?>
                            </select>
                            </td>
                            <td>
                            <select name="emergency_state" id="emergency_state_1" onChange="selectCity(this.value,'emergency_city')">
                             <?php
                                    if($_GET['stud_id']>0){
                                    $state_obj->getStateList($uemrgency[5],$uemrgency[6]);
                                    }else{
                                    ?>
                                <option value="">Select State</option>
                                <?php
                                    }
                                    ?>
                            </select>
                            </td>
                            <td>
                                <select name="emergency_city" id="emergency_city"  onChange="selectArea(this.value,'emergency_area')">
                            <?php
                                    if($_GET['stud_id']>0){
                                    $city_obj->getCityList($uemrgency[6],$uemrgency[7]);
                                    }else{
                                    ?>
                                <option value="">Select City</option>
                                <?php
                                    }
                                    ?>
                            </select></td>
                          </tr>
                          <tr>
                            <th class="heading-1">Area</th>
                            <th class="heading-1">Postal Code</th>
                            <th class="heading-1"></th>
                            <th class="heading-1"></th>
                          </tr>
                          <tr>
                              <td width="9%">
                                <?php
                                if($_GET['stud_id']>0){
                                    echo $areas_obj->getAreaListing('emergency_area',$uemrgency[8]);

                                }else{
                                    echo $areas_obj->getAreaListing('emergency_area');
                                }
                                ?>
                              </td>
                                
                                <td><input type="text" name="emergency_postcode" id="emergency_postcode" value="<?= $uemrgency[9]; ?>" size="4" /></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </table>
                      </div>
                                            <div class="padd_di_cls">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                       <td><table width="100%" cellspacing="0" cellpadding="0" border="0" class="reg_ad">
                                                                <tr>
                                                                    <td width="51%">Have you ever been dismissed / expelled and / or required to withdraw from School for any reason? Please explain if Yes</td>
                                                                    <td width="48%" valign="middle">
    <span class="red-div">Yes <input type="radio" value="Yes" <?=$stud_data->stud_dismissed_type=='Yes'?"checked='checked'":"";?> name="dismissed_type" onclick="hide_dismissed_reason(this.value)" /></span>
    <span class="green-div">No <input type="radio" value="No" name="dismissed_type" <?=$stud_data->stud_dismissed_type=='No'?"checked='checked'":"";?> onclick="hide_dismissed_reason(this.value)" /></span>
                    <div>
<input type="text" class="lt" <?=$stud_data->stud_dismissed_type=='Yes'?"":"style='display:none'";?> value="<?=$stud_data->stud_dismissed_reason;?>" placeholder="Reason" name="dismissed_reason" id="dismissed_reason"/>
                                                                        </div><div></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="10" colspan="2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Have you ever been convicted of crime? Please explain if Yes</td>
                                                                    <td><span class="red-div">Yes
                                                                            <input type="radio" value="Yes" name="crime_convicted" id="crime_convicted" <?=$stud_data->stud_crime_type=='Yes'?"checked='checked'":"";?> onclick="hide_crime_convicted(this.value)" /></span>

                                                                        <span class="green-div">No
                                                                            <input type="radio" value="No" name="crime_convicted" id="crime_convicted"  <?=$stud_data->stud_crime_type=='No'?"checked='checked'":"";?> onclick="hide_crime_convicted(this.value)" /></span>
                                                                        <div>
                                                                            <input type="text" placeholder="Detail" value="<?=$stud_data->stud_crime_detail;?>"  <?=$stud_data->stud_crime_type=='Yes'?"":"style='display:none'";?> class="lt" name="crime_detail" id="crime_detail"/>
                                                                        </div><div></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="20" colspan="2"></td>
                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><table width="100%" cellpadding="0" cellspacing="0"><?php $stud_id = $_GET['stud_id']; $application_obj->getRequiredDocumentList($app_id,$stud_id); ?></table></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <?php if($config_obj->isModuleAllowed('EDIT', $mod_code)){ ?> 
                                                            <span class="logbutton_black">
                                                                <input type="submit" name="Submit" value="Submit" onclick="showDIVForValidate()" /> 
                                                            </span>
                                                            <?php } ?>
                                                            <span class="logbutton_grey">
                                                                <input name="cancel" type="button"onClick="window.location.href = '<?php echo BASE_HREF; ?>'" value="Cancel" />
                                                            </span></td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <!-- Content html ends -->
                                            <!--  footer content start  -->
                                            <div class="clear"></div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                        <!-- Content html ends -->
                        <!--  footer content start  -->
                        <div class="clear"></div></td>
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
<table style="display: none;">
    <tbody id="lang_html_append">
        <tr>
            <td>
                <select name="languge_known[]" class="language_selectbox">
                    <option value="">Select Language</option>
                    <?= $languages_obj->getLanguage(); ?>
                </select>
            </td>
            <td>
                <select name="lang_reading[]" class="language_selectbox">
                    <?php echo $academic_obj->getAcademicData('Reading'); ?>
                </select>
            </td>
            <td>
                <select name="lang_writing[]" class="language_selectbox">
                    <?php echo $academic_obj->getAcademicData('Writing'); ?>
                </select>
            </td>
            <td>
                <select name="lang_speaking[]" class="language_selectbox">
                    <?php echo $academic_obj->getAcademicData('Speaking'); ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>

<table style="display: none;">
    <tbody id="acad_html_append">
        <tr>
            <td>
                <table width="100%" cellspacing="0" cellpadding="0" class="regester-table table1">
                    <tr>
                        <th><strong>Degree/Certificate</strong></th>
                        <th><strong>Major</strong></th>
                        <th><strong>Institute's Name</strong>
                            <?php if ($helpData[18]['help_content'] != "") { ?>
                            <span> 
                                <a class="tooltip">
                                    <img src="images/help_icon.png" border="0" height="15" /> 
                                    <span><img class="callout" src="callout.gif" /><strong><?=$helpData[18]['help_content']; ?></strong></span>
                                </a>
                            </span>
                            <?php } ?>
                        </th>
                        <th><strong>Board/University</strong>
                            <?php if ($helpData[19]['help_content'] != "") { ?>
                            <span> 
                                <a class="tooltip">
                                    <img src="images/help_icon.png" border="0" height="15" /> 
                                    <span><img class="callout" src="callout.gif" /><strong><?=$helpData[19]['help_content']; ?></strong> </span>
                                </a>
                            </span>
                            <?php } ?>
                        </th>
                        <th><strong>Year</strong>
                            <?php if ($helpData[20]['help_content'] != "") { ?>
                            <span> 
                                <a class="tooltip">
                                     <img src="images/help_icon.png" border="0" height="15" />
                                     <span><img class="callout" src="callout.gif" /><strong><?=$helpData[20]['help_content']; ?></strong> </span>
                                </a>
                            </span>
                            <?php } ?>
                        </th>
                        <th><strong>Percentage/CGPA</strong>
                            <?php if ($helpData[21]['help_content'] != "") { ?>
                            <span> 
                                <a class="tooltip">
                                    <img src="images/help_icon.png" border="0" height="15" /> 
                                    <span><img class="callout" src="callout.gif" /><strong><?=$helpData[21]['help_content']; ?></strong> </span> 
                                </a>
                            </span>
                            <?php } ?>
                        </th>
                        <th><strong>Grade/ Division</strong>
                            <?php if ($helpData[23]['help_content'] != "") { ?>
                            <span> 
                                <a class="tooltip">
                                    <img src="images/help_icon.png" border="0" height="15" />
                                    <span><img class="callout" src="callout.gif" /><strong><?= $helpData[23]['help_content']; ?></strong> </span>
                                </a>
                            </span>
                            <?php } ?>
                        </th>
                        <th width="15%"><strong>Result Status</strong></th>
                    </tr>
                    <tr>
                        <td><input type="hidden" name="acadmid_id[]" value="" />
                        <input type="text" name="degree[]" value="" size="8" style="width:81px !important;" /></td>
                        <td><input type="text" value="" name="major[]" id="major" size="6" style="width:114px !important;" /></td>
                        <td>
                            <div class="cover">
                                <input type="text" value="<?=$record->emp_ac_inst_name;?>" size="6" name="app_institute_name[]" style="width:114px !important;" />
                            </div><div class="newStatus"></div>
                        </td>
                        <td>
                            <div class="cover">
                                <input type="text" value="" size="6" name="app_board_name[]" style="width:86px !important;" />
                            </div><div class="newStatus"></div>
                        </td>
                        <td>
                            <div class="cover">
                                <select name="app_year_passed[]" style="width:77px !important;">
                                    <option value="">Year</option>
                                    <?php
                                        $y=(int)date(Y);
                                        for($i=($y-112);$i<=$y;$i++)
                                        {
                                            echo'<option value="'.$i.'" >'.$i.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="cover">
                                <input type="text" value="" name="app_marks_obtained[]" style="width:95px !important;" />
                            </div><div class="newStatus"></div>
                        </td>
                        <td>
                            <div class="cover">
                                <input type="text" value="" size="5" name="app_grade[]>" style="width:69px !important;" />
                            </div><div class="newStatus"></div>
                        </td>
                        <td>
                            <select name="result_awarded[]" style="min-width:150px !important;">
                                <?php  echo $resultstat->getResultStatus(); ?>
                            </select>
                        </td>
                    </tr>
               </table>
            </td>
        </tr>  
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $("#err_div_top").fadeOut(5000);
        $("#app_id").val('<?php echo $app_id; ?>');
    });

    function ShowDropDown(dropID)
    {
        $("#" + dropID).slideToggle();
    }

    $("#language_div").mouseover(function() {
        $("#religion_div").show();
    }).mouseout(function() {
        $("#religion_div").hide();
    });

    function fillId_1(value, fieldID, val_id, hiddenfID, DIVID)
    {
        $("#" + fieldID).val(value);
        $("#" + hiddenfID).val(val_id);
        $("#" + DIVID).hide();
        $("#" + fieldID).trigger('blur');
    }

    function suggest(inputString, action, fID, mertialstatus, hiddenfID) {

        $.ajax({
            url: "app/masters/admession_suggetion.php",
            data: 'act=' + action + '&queryString=' + inputString + '&feild=' + fID,
            success: function(msg) {
                if (msg.length > 0) {
                    $('#' + hiddenfID).val(inputString);
                    $('#' + mertialstatus).html(msg);
                    $("#" + fID).show();
                }
            }
        });
    }
    function fill(thisValue) {
        $('#country').val(thisValue);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
    function fillId(thisValue) {
        $('#country_id').val(thisValue);
        setTimeout("$('#suggestions').fadeOut();", 600);
    }
    function ShowHideDiv()
    {
        $('.slidingDiv').hide();
    }
    
    function ShowlangRow(type)
    { 
        if(jQuery.trim(type)=='L')
        {
            var val = $('#lang_tatal').val();
            if(parseInt(val) < 5)
            {
                $('#langtbl').append(jQuery("#lang_html_append").html());           
                var tot_val = parseInt(val)+1;
                $('#lang_tatal').val(tot_val);
            }
            else
            {
                alert("Do not add more then 5 languages");
            }            
        }
        else if(jQuery.trim(type)=='A')
        {
            var val = $('#max_acadmec').val();
            if(parseInt(val) < 15)
            {
                $('#acadetbl > tbody > tr:last').after(jQuery("#acad_html_append").html());            
                var tot_val = parseInt(val)+1;
                $('#max_acadmec').val(tot_val);
            }
            else
            {
                alert("Do not add more then 15 records");
            }            
        }
    }
        
    function DeletelangRow(type)
    {
        if(jQuery.trim(type)=='L')
        {
            var val = $('#lang_tatal').val();
            if(parseInt(val) > 1)
            {
                $('#langtbl tr:last').remove();           
                var tot_val = parseInt(val)-1;
                $('#lang_tatal').val(tot_val);
            }                   
        }
        else if(jQuery.trim(type)=='A')
        {
            var val = $('#max_acadmec').val();
            if(parseInt(val) > 1)
            {
                $('#acadetbl > tbody > tr:last').remove();            
                var tot_val = parseInt(val)-1;
                $('#max_acadmec').val(tot_val);
            }           
        }
    }
    function ShowdIV(imgID, divID)
    {
        if ($('#' + divID).css('display') == 'none')
        {
            $('#' + divID).show();
            $('#' + imgID).attr('src', 'images/reg_minus.png');
        }
        else
        {
            $('#' + divID).hide();
            $('#' + imgID).attr('src', 'images/sut_reg_add.png');
        }
    }
</script>
<?php include("../footer.php"); ?>
<!-- footer content ends -->
