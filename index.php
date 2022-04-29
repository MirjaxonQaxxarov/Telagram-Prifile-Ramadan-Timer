<?php

    if (!file_exists('madeline.php')) {
        copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
    }
    include 'madeline.php'; 

    $MadelineProto = new \danog\MadelineProto\API('session.madeline');
    $MadelineProto->start();
    $time=date("H:i",strtotime("0 hour"));
    $dayc=date("d-m-20y",strtotime("0 hour"));
    $nik = ["•YOU_NAME•","☆YOU_NAME☆","◇YOU_NAME◇"];
      $nikrand=array_rand($nik);
      $niktxt="$nik[$nikrand]";
    $MadelineProto->account->updateProfile(['first_name'=>"$niktxt | $time"]); //Update Profile First Name
    $info = $MadelineProto->get_full_info('me');                                //Get Profile Full Info
    $inputPhoto = ['_' => 'inputPhoto', 'id' => $info['User']['photo']['photo_id'], 'access_hash' => $info['User']['access_hash'], 'file_reference' => 'bytes']; //Get Profile Last Photo Info
    $deletePhoto = $MadelineProto->photos->deletePhotos(['id'=>[$inputPhoto]]); //Delete Last Photo
    $MadelineProto->account->updateStatus(['offline' => false, ]);  //take Offline status
    $yil = date("Y", strtotime("0 hour"));
    $sana = date("d/m/Y", strtotime("0 hour"));
    $text = "the daily iftar and sahar times of your area  first time iftar";  // You json File


    function getTime($day)
    {
      global $text;
      $json = json_decode($text);
      $day = 1;
      $hour1 = $json->$day->hour1;
      $hour2 = $json->$day->hour2;
      $minut1 = $json->$day->minut1;
      $minut2 = $json->$day->minut2;
      $ret = [];
      $ret+=["hour2"=>$hour2];
      $ret+=["minut2"=>$minut2];
      $ret+=["hour1"=>$hour1];
      $ret+=["minut1"=>$minut1];
      return json_encode($ret);
    }

    $day = date('d',strtotime('0 hour')); 
    $hour = date('H',strtotime('0 hour'));
    $min = date('i',strtotime('0 hour')); 

    $qiy = json_decode(getTime($day));

    if ( ($qiy->hour2>$hour or ($qiy->hour2==$hour and $qiy->minut2>$min )) and ($qiy->hour1<$hour or ($qiy->hour2==$hour and $qiy->minut2<$min )) ){
      $xhour = $qiy->hour2-$hour;
      $xmin = $qiy->minut2-$min;
      if ($xmin<0) {
        $xmin+=60;
        $xhour-=1;
      }
      $mmtxt="An $xhour and a half $xmin before Iftar";
    }
    else{
        $qiy2 = json_decode(getTime($day));
        if ($hour>$qiy->hour1 or ($qiy->hour1==$hour and $qiy->minut1<$min )) {
          $xhour = $qiy2->hour1+23-$hour;
          $xmin = $qiy2->minut1+60-$min;
          if ($xmin>59) {
            $xmin-=60;
            $xhour+=1;
          }

        }
        else{
          $xhour = $qiy->hour1-$hour;
          $xmin = $qiy->minut1-$min;
          if ($xmin<0) {
            $xmin+=60;
            $xhour-=1;
          }
        }
      $mmtxt="An $xhour and a half $xmin before Sahar";
      }


    ///////////////WRITE PHOTO START\\\\\\\\\\\\
    header('content-type: image/jpg');
    $img = imagecreatefromjpeg('Photo.jpg');          //get Photo
    $font = "font/tema.ttf";                           //Get Font 
    $white = imagecolorallocate($img, 0, 0, 0);
    $time = date("H:i",strtotime("0 hour"));
    $txt = $time;

    $x = 30; //Start of recording OX
    $y = 195; //Start of recording OY
    imagettftext($img, 100, 0, $x,$y, $white, $font, $txt); //Write Photo
    imagejpeg($img,"goto.jpg");


    header('content-type: image/jpg');
    $img = imagecreatefromjpeg('goto.jpg');
    $font = "font/temaaa.ttf"; 
    $white = imagecolorallocate($img, 0, 0, 0);
    $time = date("H:i",strtotime("0 hour"));
    $txt = $mmtxt;

    $x = 30; //Start of recording OX
    $y = 195; //Start of recording OY
    imagettftext($img, 40, 0, $x,$y, $white, $font, $txt);
    imagejpeg($img,"goto.jpg");

    ///////////////WRITE PHOTO START\\\\\\\\\\\\
    $logo = ["goto.jpg"];
    $logorand=array_rand($logo);
      $logopic="$logo[$logorand]";

      
    $MadelineProto->photos->updateProfilePhoto(['file' => "$logopic" ]); //Update Profile Photo


?>