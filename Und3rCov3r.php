<?php

print_r("

                                                                       
 #    # #    # #####  ###### #####   ####   ####  #    # ###### #####  
 #    # ##   # #    # #      #    # #    # #    # #    # #      #    # 
 #    # # #  # #    # #####  #    # #      #    # #    # #####  #    # 
 #    # #  # # #    # #      #####  #      #    # #    # #      #####  
 #    # #   ## #    # #      #   #  #    # #    #  #  #  #      #   #  
  ####  #    # #####  ###### #    #  ####   ####    ##   ###### #    # 
                                                                       




[1] Encode  Ex: > php $argv[0] 1 filename.php  key [1,7]
[2] Decode  Ex: > php $argv[0] 2 filename.php  key [1,7]

");

echo"  > ";

$choice = $argv[1];

   if($choice == 1){
   

      $plainphp=$argv[2];
	  $key=$argv[3];
	  $msg=file_get_contents($plainphp);
      echo "Encoding File ..Please Wait.....";

//=================================================
                      Encode($msg,$key);
//=================================================
   
        }else if($choice == 2){
   
           $encoded_file=$argv[2];
		   $key=$argv[3];
           if((count($argv))<3){
                 exit("Please enter the encoded Filename !\n");
	            }else{
//==================================================
                     Decode($encoded_file,$key);
//==================================================
      }
   }else{exit("MORE ARGS REQUIRED !\n");
}

 


//Encode
//======

function Encode($msg,$key){

  $arr=array(1,2,3,4,5,6,7,8);
  //ROT8
  ROT8($arr,$key);

   $msg=str_replace('<?php','',$msg);
   $msg=str_replace('?>','',$msg);
   $msg=trim($msg);
   $chars=str_split($msg);

   $sec='<?php $_[]++;$_[]=$_._;$_____=$_[(++$__[])][(++$__[])+(++$__[])+(++$__[])];$_=$_[$_[+_]];$___=$__=$_[++$__[]];$____=$_=$_[+_];$_++;$_++;$_++;$_=$____.++$___.$___.++$_.$__.++$___;$__=$_;$_=$_____;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$_++;$___=+_;$___.=$__;$___=++$_^$___[+_];$______________=+_;'. str_repeat('$______++;',$arr[0]). str_repeat('$_______++;',$arr[1]). str_repeat('$________++;',$arr[2]). str_repeat('$_________++;',$arr[3]). str_repeat('$__________++;',$arr[4]). str_repeat('$___________++;',$arr[5]). str_repeat('$____________++;',$arr[6]). str_repeat('$_____________++;',$arr[7]);

   $alpha=array(
               '0'=>'$______________'
               ,$arr[0]=>'$______'
               ,$arr[1]=>'$_______'
               ,$arr[2]=>'$________'
               ,$arr[3]=>'$_________'
               ,$arr[4]=>'$__________'
               ,$arr[5]=>'$___________'
               ,$arr[6]=>'$____________'
               ,$arr[7]=>'$_____________'
        ); 
      //counting chars in all file
   $count=count($chars);
     //opening new file and copying encoder structure to it
   $trans="";
   $fp=fopen('alphax.php','w'); 
   fwrite($fp,$sec."\n");
   fwrite($fp,'$__(\'$_="\'.');
    //characters conversion loop
   for($i=0;$i<=$count;$i++){

          
         fwrite($fp,'$___.');
         $octs = base_convert(ord($chars[$i]), 10, 8);
         $msgs=strval($octs);
		 $charss=str_split($msgs);
		 $countt=count($charss);

		 for($k=0;$k<=$countt;$k++){
		     if (array_key_exists($charss[$k], $alpha)){
			 
                     $trans=$alpha[$charss[$k]];
		              fwrite($fp,$trans.'.');
		  
		        }
		    }   
    }
   fwrite($fp,'\'"\');$__($_);?>');		
   fclose($fp);
   $cont=file_get_contents("alphax.php");
   $filter=str_replace('$___.$______________.','',$cont);
   file_put_contents("alphax.php", $filter);
   echo "\n  > D0ne happy hunting\n"	;
 }
 


   
  
//Decode
//=======	  
function Decode($encoded_file,$key){

  $arr=array(1,2,3,4,5,6,7,8);
  //ROT8
  ROT8($arr,$key);

  $cont=file_get_contents($encoded_file);

  $f2=fopen('alphaxfinal.txt','w');
  $f3=fopen('alphadecoded.txt','w');

  $cont=str_replace('$___.','|',$cont);
  $cont=str_replace("\"'.",'KS',$cont);
  $cont=str_replace("'\"",'KS',$cont);
  $nonalpha=array(
                  '$______________.',
                  '$______.',
                  '$_______.',
                  '$________.',
                  '$_________.',
                  '$__________.',
                  '$___________.',
                  '$____________.',
                  '$_____________.'
  );
  $octal=array(
                '0',
                strval($arr[0]),
                strval($arr[1]),
                strval($arr[2]),
                strval($arr[3]),
                strval($arr[4]),
                strval($arr[5]),
                strval($arr[6]),
                strval($arr[7])
  );
  $filter=str_replace($nonalpha,$octal,$cont);

  file_put_contents("alphaxfinal.txt", $filter);


  $cont2=file_get_contents("alphaxfinal.txt");

  preg_match("#KS(.*?)KS#",$cont2,$save);
  file_put_contents("alphaxfinal.txt", $save[1]);

  $cont3=file_get_contents("alphaxfinal.txt");

  $split=explode('|', $cont3);
  $count=count($split);

   //octal to decimal && decimal to ascii
  for($i=0;$i<=$count;$i++){

      $intoctal=intval($split[$i]);
      $decimal=base_convert($intoctal, 8, 10);
       $ascii=chr($decimal);
	   fwrite($f3, $ascii);
      }
	  echo "D0ne file Decoded";
	  echo "\n";
 }

function ROT8(&$arr,$key)
{
  for($i=0;$i<=7;$i++)
   {
        $arr[$i]=$arr[$i]+$key;
        while($arr[$i]>8) $arr[$i]=$arr[$i]-8;
    }
}
