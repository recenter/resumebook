<?php include "header.php"; ?>
<?php
     $inAMFri1=$_POST['inAMFri1'];
     $inAMFri11=$_POST['inAMFri11']/100;
     $outAMFri1=$_POST['outAMFri1'];
     $outAMFri11=$_POST['outAMFri11']/100;
     $inAMFri2=$_POST['inAMFri2'];
     $inAMFri21=$_POST['inAMFri21']/100;
     $outAMFri2=$_POST['outAMFri2'];
     $outAMFri21=$_POST['outAMFri21']/100;
     $inPMFri1=$_POST['inPMFri1'];
     if($inPMFri1!=0)
          $inPMFri1=$inPMFri1+12;
     $inPMFri11=$_POST['inPMFri11']/100;
     $outPMFri1=$_POST['outPMFri1'];
     if($outPMFri1!=0)
          $outPMFri1=$outPMFri1+12;
     $outPMFri11=$_POST['outPMFri11']/100;
     $inPMFri2=$_POST['inPMFri2'];
     if($inPMFri2!=0)
          $inPMFri2=$inPMFri2+12;
     $inPMFri21=$_POST['inPMFri21']/100;
     $outPMFri2=$_POST['outPMFri2'];
     if($outPMFri2!=0)
          $outPMFri2=$outPMFri2+12;
     $outPMFri21=$_POST['outPMFri21']/100;
     $Fri1Total=$outAMFri1+$outAMFri11-$inAMFri1-$inAMFri11+$outAMFri2+$outAMFri21-$inAMFri2-$inAMFri21+$outPMFri1+$outPMFri11-$inPMFri1-$inPMFri11+$outPMFri2+$outPMFri21-$inPMFri2-$inPMFri21;

     // End First Friday

     $inAMSat1=$_POST['inAMSat1'];
     $inAMSat11=$_POST['inAMSat11']/100;
     $outAMSat1=$_POST['outAMSat1'];
     $outAMSat11=$_POST['outAMSat11']/100;
     $inAMSat2=$_POST['inAMSat2'];
     $inAMSat21=$_POST['inAMSat21']/100;
     $outAMSat2=$_POST['outAMSat2'];
     $outAMSat21=$_POST['outAMSat21']/100;
     $inPMSat1=$_POST['inPMSat1'];
     if($inPMSat1!=0)
          $inPMSat1=$inPMSat1+12;
     $inPMSat11=$_POST['inPMSat11']/100;
     $outPMSat1=$_POST['outPMSat1'];
     if($outPMSat1!=0)
          $outPMSat1=$outPMSat1+12;
     $outPMSat11=$_POST['outPMSat11']/100;
     $inPMSat2=$_POST['inPMSat2'];
     if($inPMSat2!=0)
          $inPMSat2=$inPMSat2+12;
     $inPMSat21=$_POST['inPMSat21']/100;
     $outPMSat2=$_POST['outPMSat2'];
     if($outPMSat2!=0)
          $outPMSat2=$outPMSat2+12;
     $outPMSat21=$_POST['outPMSat21']/100;
     $Sat1Total=$outAMSat1+$outAMSat11-$inAMSat1-$inAMSat11+$outAMSat2+$outAMSat21-$inAMSat2-$inAMSat21+$outPMSat1+$outPMSat11-$inPMSat1-$inPMSat11+$outPMSat2+$outPMSat21-$inPMSat2-$inPMSat21;

     // End First Saturday

     $inAMSun1=$_POST['inAMSun1'];
     $inAMSun11=$_POST['inAMSun11']/100;
     $outAMSun1=$_POST['outAMSun1'];
     $outAMSun11=$_POST['outAMSun11']/100;
     $inAMSun2=$_POST['inAMSun2'];
     $inAMSun21=$_POST['inAMSun21']/100;
     $outAMSun2=$_POST['outAMSun2'];
     $outAMSun21=$_POST['outAMSun21']/100;
     $inPMSun1=$_POST['inPMSun1'];
     if($inPMSun1!=0)
          $inPMSun1=$inPMSun1+12;
     $inPMSun11=$_POST['inPMSun11']/100;
     $outPMSun1=$_POST['outPMSun1'];
     if($outPMSun1!=0)
          $outPMSun1=$outPMSun1+12;
     $outPMSun11=$_POST['outPMSun11']/100;
     $inPMSun2=$_POST['inPMSun2'];
     if($inPMSun2!=0)
          $inPMSun2=$inPMSun2+12;
     $inPMSun21=$_POST['inPMSun21']/100;
     $outPMSun2=$_POST['outPMSun2'];
     if($outPMSun2!=0)
          $outPMSun2=$outPMSun2+12;
     $outPMSun21=$_POST['outPMSun21']/100;
     $Sun1Total=$outAMSun1+$outAMSun11-$inAMSun1-$inAMSun11+$outAMSun2+$outAMSun21-$inAMSun2-$inAMSun21+$outPMSun1+$outPMSun11-$inPMSun1-$inPMSun11+$outPMSun2+$outPMSun21-$inPMSun2-$inPMSun21;

     // End First Sunday

     $inAMMon1=$_POST['inAMMon1'];
     $inAMMon11=$_POST['inAMMon11']/100;
     $outAMMon1=$_POST['outAMMon1'];
     $outAMMon11=$_POST['outAMMon11']/100;
     $inAMMon2=$_POST['inAMMon2'];
     $inAMMon21=$_POST['inAMMon21']/100;
     $outAMMon2=$_POST['outAMMon2'];
     $outAMMon21=$_POST['outAMMon21']/100;
     $inPMMon1=$_POST['inPMMon1'];
     if($inPMMon1!=0)
          $inPMMon1=$inPMMon1+12;
     $inPMMon11=$_POST['inPMMon11']/100;
     $outPMMon1=$_POST['outPMMon1'];
     if($outPMMon1!=0)
          $outPMMon1=$outPMMon1+12;
     $outPMMon11=$_POST['outPMMon11']/100;
     $inPMMon2=$_POST['inPMMon2'];
     if($inPMMon2!=0)
          $inPMMon2=$inPMMon2+12;
     $inPMMon21=$_POST['inPMMon21']/100;
     $outPMMon2=$_POST['outPMMon2'];
     if($outPMMon2!=0)
          $outPMMon2=$outPMMon2+12;
     $outPMMon21=$_POST['outPMMon21']/100;
     $Mon1Total=$outAMMon1+$outAMMon11-$inAMMon1-$inAMMon11+$outAMMon2+$outAMMon21-$inAMMon2-$inAMMon21+$outPMMon1+$outPMMon11-$inPMMon1-$inPMMon11+$outPMMon2+$outPMMon21-$inPMMon2-$inPMMon21;

     // End First Monday

     $inAMTue1=$_POST['inAMTue1'];
     $inAMTue11=$_POST['inAMTue11']/100;
     $outAMTue1=$_POST['outAMTue1'];
     $outAMTue11=$_POST['outAMTue11']/100;
     $inAMTue2=$_POST['inAMTue2'];
     $inAMTue21=$_POST['inAMTue21']/100;
     $outAMTue2=$_POST['outAMTue2'];
     $outAMTue21=$_POST['outAMTue21']/100;
     $inPMTue1=$_POST['inPMTue1'];
     if($inPMTue1!=0)
          $inPMTue1=$inPMTue1+12;
     $inPMTue11=$_POST['inPMTue11']/100;
     $outPMTue1=$_POST['outPMTue1'];
     if($outPMTue1!=0)
          $outPMTue1=$outPMTue1+12;
     $outPMTue11=$_POST['outPMTue11']/100;
     $inPMTue2=$_POST['inPMTue2'];
     if($inPMTue2!=0)
          $inPMTue2=$inPMTue2+12;
     $inPMTue21=$_POST['inPMTue21']/100;
     $outPMTue2=$_POST['outPMTue2'];
     if($outPMTue2!=0)
          $outPMTue2=$outPMTue2+12;
     $outPMTue21=$_POST['outPMTue21']/100;
     $Tue1Total=$outAMTue1+$outAMTue11-$inAMTue1-$inAMTue11+$outAMTue2+$outAMTue21-$inAMTue2-$inAMTue21+$outPMTue1+$outPMTue11-$inPMTue1-$inPMTue11+$outPMTue2+$outPMTue21-$inPMTue2-$inPMTue21;

     // End First Tuesday

     $inAMWed1=$_POST['inAMWed1'];
     $inAMWed11=$_POST['inAMWed11']/100;
     $outAMWed1=$_POST['outAMWed1'];
     $outAMWed11=$_POST['outAMWed11']/100;
     $inAMWed2=$_POST['inAMWed2'];
     $inAMWed21=$_POST['inAMWed21']/100;
     $outAMWed2=$_POST['outAMWed2'];
     $outAMWed21=$_POST['outAMWed21']/100;
     $inPMWed1=$_POST['inPMWed1'];
     if($inPMWed1!=0)
          $inPMWed1=$inPMWed1+12;
     $inPMWed11=$_POST['inPMWed11']/100;
     $outPMWed1=$_POST['outPMWed1'];
     if($outPMWed1!=0)
          $outPMWed1=$outPMWed1+12;
     $outPMWed11=$_POST['outPMWed11']/100;
     $inPMWed2=$_POST['inPMWed2'];
     if($inPMWed2!=0)
          $inPMWed2=$inPMWed2+12;
     $inPMWed21=$_POST['inPMWed21']/100;
     $outPMWed2=$_POST['outPMWed2'];
     if($outPMWed2!=0)
          $outPMWed2=$outPMWed2+12;
     $outPMWed21=$_POST['outPMWed21']/100;
     $Wed1Total=$outAMWed1+$outAMWed11-$inAMWed1-$inAMWed11+$outAMWed2+$outAMWed21-$inAMWed2-$inAMWed21+$outPMWed1+$outPMWed11-$inPMWed1-$inPMWed11+$outPMWed2+$outPMWed21-$inPMWed2-$inPMWed21;

     // End First Wednesday

     $inAMThu1=$_POST['inAMThu1'];
     $inAMThu11=$_POST['inAMThu11']/100;
     $outAMThu1=$_POST['outAMThu1'];
     $outAMThu11=$_POST['outAMThu11']/100;
     $inAMThu2=$_POST['inAMThu2'];
     $inAMThu21=$_POST['inAMThu21']/100;
     $outAMThu2=$_POST['outAMThu2'];
     $outAMThu21=$_POST['outAMThu21']/100;
     $inPMThu1=$_POST['inPMThu1'];
     if($inPMThu1!=0)
          $inPMThu1=$inPMThu1+12;
     $inPMThu11=$_POST['inPMThu11']/100;
     $outPMThu1=$_POST['outPMThu1'];
     if($outPMThu1!=0)
          $outPMThu1=$outPMThu1+12;
     $outPMThu11=$_POST['outPMThu11']/100;
     $inPMThu2=$_POST['inPMThu2'];
     if($inPMThu2!=0)
          $inPMThu2=$inPMThu2+12;
     $inPMThu21=$_POST['inPMThu21']/100;
     $outPMThu2=$_POST['outPMThu2'];
     if($outPMThu2!=0)
          $outPMThu2=$outPMThu2+12;
     $outPMThu21=$_POST['outPMThu21']/100;
     $Thu1Total=$outAMThu1+$outAMThu11-$inAMThu1-$inAMThu11+$outAMThu2+$outAMThu21-$inAMThu2-$inAMThu21+$outPMThu1+$outPMThu11-$inPMThu1-$inPMThu11+$outPMThu2+$outPMThu21-$inPMThu2-$inPMThu21;

     // End First Thursday


     echo"
          <h2>Please confirm that the following information is accurate before submitting.</h2><br>
          <b>Name:</b> ";
          echo"<br><br>
          <table class='timeTable'>
            <tr>
                 <td> </td>
                 <td colspan='4'><b>A.M.</b></td>
                 <td colspan='4'><b>P.M.</b></td>
                 <td><b>Daily Total Hours</b></td>
            </tr>
            <tr>
                 <td> </td>
                 <td><b>IN</b></td>
                 <td><b>OUT</b></td>
                 <td><b>IN</b></td>
                 <td><b>OUT</b></td>
                 <td><b>IN</b></td>
                 <td><b>OUT</b></td>
                 <td><b>IN</b></td>
                 <td><b>OUT</b></td>
                 <td> </td>
            </tr>
            <tr style='background-color:#999999;'>
                 <td style='color:#ffffff;'>FRI </td>
                 <td>";
                 print($inAMFri1+$inAMFri11);
                    echo"</td><td>";
                 print($outAMFri1+$outAMFri11);
                   echo"</td><td>";
                   print($inAMFri2+$inAMFri21);
                    echo"</td><td>";
                    print($outAMFri2+$outAMFri21);
                    echo"</td><td>";
                    print($inPMFri1+$inPMFri11);
                    echo"</td><td>";
                    print($outPMFri1+$outPMFri11);
                    echo"</td><td>";
                    print($inPMFri2+$inPMFri21);
                    echo"</td><td>";
                    print($outPMFri2+$outPMFri21);
                    echo"</td><td>";
                    print($Fri1Total);
                 echo"</td>
            </tr>
            <tr>
                 <td>SAT </td>
                 <td>";
                 print($inAMSat1+$inAMSat11);
                    echo"</td><td>";
                 print($outAMSat1+$outAMSat11);
                   echo"</td><td>";
                   print($inAMSat2+$inAMSat21);
                    echo"</td><td>";
                    print($outAMSat2+$outAMSat21);
                    echo"</td><td>";
                    print($inPMSat1+$inPMSat11);
                    echo"</td><td>";
                    print($outPMSat1+$outPMSat11);
                    echo"</td><td>";
                    print($inPMSat2+$inPMSat21);
                    echo"</td><td>";
                    print($outPMSat2+$outPMSat21);
                    echo"</td><td>";
                    print($Sat1Total);
                 echo"</td>
            </tr>
           <tr style='background-color:#999999;'>
                 <td style='color:#ffffff;'>SUN </td>
                 <td>";
                 print($inAMSun1+$inAMSun11);
                    echo"</td><td>";
                 print($outAMSun1+$outAMSun11);
                   echo"</td><td>";
                   print($inAMSun2+$inAMSun21);
                    echo"</td><td>";
                    print($outAMSun2+$outAMSun21);
                    echo"</td><td>";
                    print($inPMSun1+$inPMSun11);
                    echo"</td><td>";
                    print($outPMSun1+$outPMSun11);
                    echo"</td><td>";
                    print($inPMSun2+$inPMSun21);
                    echo"</td><td>";
                    print($outPMSun2+$outPMSun21);
                    echo"</td><td>";
                    print($Sun1Total);
                 echo"</td>
            </tr>
            <tr>
                 <td>MON </td>
                 <td>";
                 print($inAMMon1+$inAMMon11);
                    echo"</td><td>";
                 print($outAMMon1+$outAMMon11);
                   echo"</td><td>";
                   print($inAMMon2+$inAMMon21);
                    echo"</td><td>";
                    print($outAMMon2+$outAMMon21);
                    echo"</td><td>";
                    print($inPMMon1+$inPMMon11);
                    echo"</td><td>";
                    print($outPMMon1+$outPMMon11);
                    echo"</td><td>";
                    print($inPMMon2+$inPMMon21);
                    echo"</td><td>";
                    print($outPMMon2+$outPMMon21);
                    echo"</td><td>";
                    print($Mon1Total);
                 echo"</td>
            </tr>
            <tr style='background-color:#999999;'>
                 <td style='color:#ffffff;'>TUE </td>
                 <td>";
                 print($inAMTue1+$inAMTue11);
                    echo"</td><td>";
                 print($outAMTue1+$outAMTue11);
                   echo"</td><td>";
                   print($inAMTue2+$inAMTue21);
                    echo"</td><td>";
                    print($outAMTue2+$outAMTue21);
                    echo"</td><td>";
                    print($inPMTue1+$inPMTue11);
                    echo"</td><td>";
                    print($outPMTue1+$outPMTue11);
                    echo"</td><td>";
                    print($inPMTue2+$inPMTue21);
                    echo"</td><td>";
                    print($outPMTue2+$outPMTue21);
                    echo"</td><td>";
                    print($Tue1Total);
                 echo"</td>
            </tr>
            <tr>
                 <td>WED </td>
                 <td>";
                 print($inAMWed1+$inAMWed11);
                    echo"</td><td>";
                 print($outAMWed1+$outAMWed11);
                   echo"</td><td>";
                   print($inAMWed2+$inAMWed21);
                    echo"</td><td>";
                    print($outAMWed2+$outAMWed21);
                    echo"</td><td>";
                    print($inPMWed1+$inPMWed11);
                    echo"</td><td>";
                    print($outPMWed1+$outPMWed11);
                    echo"</td><td>";
                    print($inPMWed2+$inPMWed21);
                    echo"</td><td>";
                    print($outPMWed2+$outPMWed21);
                    echo"</td><td>";
                    print($Wed1Total);
                 echo"</td>
            </tr>
            <tr style='background-color:#999999;'>
                 <td style='color:#ffffff;'>THU </td>
                 <td>";
                 print($inAMThu1+$inAMThu11);
                    echo"</td><td>";
                 print($outAMThu1+$outAMThu11);
                   echo"</td><td>";
                   print($inAMThu2+$inAMThu21);
                    echo"</td><td>";
                    print($outAMThu2+$outAMThu21);
                    echo"</td><td>";
                    print($inPMThu1+$inPMThu11);
                    echo"</td><td>";
                    print($outPMThu1+$outPMThu11);
                    echo"</td><td>";
                    print($inPMThu2+$inPMThu21);
                    echo"</td><td>";
                    print($outPMThu2+$outPMThu21);
                    echo"</td><td>";
                    print($Thu1Total);
                 echo"</td>
            </tr>
        </table><br><br>
        <b>Electronic Signature:</b><br><input type='checkbox' name='electronicSig' value='1'>  By checking this box, I confirm that all above information is truthful and accurate.<br><br>
        <input type='submit' value='Submit'>";     
?>
</td>
    </tr>
  </table>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>