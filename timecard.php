<?php include "header.php"; ?>
<?php
	$hourdrop='<option value="0"> </option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>';
	$mindrop='<option value="0"> </option><option value="25">15</option><option value="50">30</option><option value="75">45</option>';
    echo 
        "<h1>Student Timecard - </h1><br>
        <form name='timeCard' method='POST' action='timepost.php'>
        <table class='timeTable'>
            <tr>
            	<td style='border:0'> </td>
            	<td colspan='4' style='border:0'><b>A.M.</b></td>
            	<td class='timePM' colspan='4' style='border:0'><b>P.M.</b></td>
            </tr>
            <tr>
            	<td style='border:0'> </td>
            	<td style='border:0'><b>IN</b></td>
            	<td style='border:0'><b>OUT</b></td>
            	<td style='border:0'><b>IN</b></td>
            	<td style='border:0'><b>OUT</b></td>
            	<td style='border:0' class='timePM'><b>IN</b></td>
            	<td style='border:0' class='timePM'><b>OUT</b></td>
            	<td style='border:0' class='timePM'><b>IN</b></td>
            	<td style='border:0' class='timePM'><b>OUT</b></td>
            </tr>
            <tr style='background-color:#999999;'>
            	<td style='color:#ffffff;'>FRI </td>
            	<td><select name ='inAMFri1'>${hourdrop}</select> : <select name ='inAMFri11'>${mindrop}</select></td>
            	<td><select name ='outAMFri1'>${hourdrop}</select> : <select name ='outAMFri11'>${mindrop}</select></td>
            	<td><select name ='inAMFri2'>${hourdrop}</select> : <select name ='inAMFri21'>${mindrop}</select></td>
            	<td><select name ='outAMFri2'>${hourdrop}</select> : <select name ='outAMFri21'>${mindrop}</select></td>
            	<td><select name ='inPMFri1'>${hourdrop}</select> : <select name ='inPMFri11'>${mindrop}</select></td>
            	<td><select name ='outPMFri1'>${hourdrop}</select> : <select name ='outPMFri11'>${mindrop}</select></td>
            	<td><select name ='inPMFri2'>${hourdrop}</select> : <select name ='inPMFri21'>${mindrop}</select></td>
            	<td><select name ='outPMFri2'>${hourdrop}</select> : <select name ='outPMFri21'>${mindrop}</select></td>
            </tr>
            <tr>
            	<td>SAT </td>
            	<td><select name ='inAMSat1'>${hourdrop}</select> : <select name ='inAMSat11'>${mindrop}</select></td>
            	<td><select name ='outAMSat1'>${hourdrop}</select> : <select name ='outAMSat11'>${mindrop}</select></td>
            	<td><select name ='inAMSat2'>${hourdrop}</select> : <select name ='inAMSat21'>${mindrop}</select></td>
            	<td><select name ='outAMSat2'>${hourdrop}</select> : <select name ='outAMSat21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMSat1'>${hourdrop}</select> : <select name ='inPMSat11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMSat1'>${hourdrop}</select> : <select name ='outPMSat11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMSat2'>${hourdrop}</select> : <select name ='inPMSat21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMSat2'>${hourdrop}</select> : <select name ='outPMSat21'>${mindrop}</select></td>
            </tr>
            <tr style='background-color:#999999;'>
            	<td style='color:#ffffff;'>SUN </td>
            	<td><select name ='inAMSun1'>${hourdrop}</select> : <select name ='inAMSun11'>${mindrop}</select></td>
            	<td><select name ='outAMSun1'>${hourdrop}</select> : <select name ='outAMSun11'>${mindrop}</select></td>
            	<td><select name ='inAMSun2'>${hourdrop}</select> : <select name ='inAMSun21'>${mindrop}</select></td>
            	<td><select name ='outAMSun2'>${hourdrop}</select> : <select name ='outAMSun21'>${mindrop}</select></td>
            	<td><select name ='inPMSun1'>${hourdrop}</select> : <select name ='inPMSun11'>${mindrop}</select></td>
            	<td><select name ='outPMSun1'>${hourdrop}</select> : <select name ='outPMSun11'>${mindrop}</select></td>
            	<td><select name ='inPMSun2'>${hourdrop}</select> : <select name ='inPMSun21'>${mindrop}</select></td>
            	<td><select name ='outPMSun2'>${hourdrop}</select> : <select name ='outPMSun21'>${mindrop}</select></td>
            </tr>
            <tr>
            	<td>MON </td>
            	<td><select name ='inAMMon1'>${hourdrop}</select> : <select name ='inAMMon11'>${mindrop}</select></td>
            	<td><select name ='outAMMon1'>${hourdrop}</select> : <select name ='outAMMon11'>${mindrop}</select></td>
            	<td><select name ='inAMMon2'>${hourdrop}</select> : <select name ='inAMMon21'>${mindrop}</select></td>
            	<td><select name ='outAMMon2'>${hourdrop}</select> : <select name ='outAMMon21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMMon1'>${hourdrop}</select> : <select name ='inPMMon11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMMon1'>${hourdrop}</select> : <select name ='outPMMon11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMMon2'>${hourdrop}</select> : <select name ='inPMMon21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMMon2'>${hourdrop}</select> : <select name ='outPMMon21'>${mindrop}</select></td>
            </tr>
            <tr style='background-color:#999999;'>
            	<td style='color:#ffffff;'>TUE </td>
            	<td><select name ='inAMTue1'>${hourdrop}</select> : <select name ='inAMTue11'>${mindrop}</select></td>
            	<td><select name ='outAMTue1'>${hourdrop}</select> : <select name ='outAMTue11'>${mindrop}</select></td>
            	<td><select name ='inAMTue2'>${hourdrop}</select> : <select name ='inAMTue21'>${mindrop}</select></td>
            	<td><select name ='outAMTue2'>${hourdrop}</select> : <select name ='outAMTue21'>${mindrop}</select></td>
            	<td><select name ='inPMTue1'>${hourdrop}</select> : <select name ='inPMTue11'>${mindrop}</select></td>
            	<td><select name ='outPMTue1'>${hourdrop}</select> : <select name ='outPMTue11'>${mindrop}</select></td>
            	<td><select name ='inPMTue2'>${hourdrop}</select> : <select name ='inPMTue21'>${mindrop}</select></td>
            	<td><select name ='outPMTue2'>${hourdrop}</select> : <select name ='outPMTue21'>${mindrop}</select></td>
            </tr>
            <tr>
            	<td>WED </td>
            	<td><select name ='inAMWed1'>${hourdrop}</select> : <select name ='inAMWed11'>${mindrop}</select></td>
            	<td><select name ='outAMWed1'>${hourdrop}</select> : <select name ='outAMWed11'>${mindrop}</select></td>
            	<td><select name ='inAMWed2'>${hourdrop}</select> : <select name ='inAMWed21'>${mindrop}</select></td>
            	<td><select name ='outAMWed2'>${hourdrop}</select> : <select name ='outAMWed21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMWed1'>${hourdrop}</select> : <select name ='inPMWed11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMWed1'>${hourdrop}</select> : <select name ='outPMWed11'>${mindrop}</select></td>
            	<td class='timePM'><select name ='inPMWed2'>${hourdrop}</select> : <select name ='inPMWed21'>${mindrop}</select></td>
            	<td class='timePM'><select name ='outPMWed2'>${hourdrop}</select> : <select name ='outPMWed21'>${mindrop}</select></td>
            </tr>
            <tr style='background-color:#999999;'>
            	<td style='color:#ffffff;'>THU </td>
            	<td><select name ='inAMThu1'>${hourdrop}</select> : <select name ='inAMThu11'>${mindrop}</select></td>
            	<td><select name ='outAMThu1'>${hourdrop}</select> : <select name ='outAMThu11'>${mindrop}</select></td>
            	<td><select name ='inAMThu2'>${hourdrop}</select> : <select name ='inAMThu21'>${mindrop}</select></td>
            	<td><select name ='outAMThu2'>${hourdrop}</select> : <select name ='outAMThu21'>${mindrop}</select></td>
            	<td><select name ='inPMThu1'>${hourdrop}</select> : <select name ='inPMThu11'>${mindrop}</select></td>
            	<td><select name ='outPMThu1'>${hourdrop}</select> : <select name ='outPMThu11'>${mindrop}</select></td>
            	<td><select name ='inPMThu2'>${hourdrop}</select> : <select name ='inPMThu21'>${mindrop}</select></td>
            	<td><select name ='outPMThu2'>${hourdrop}</select> : <select name ='outPMThu21'>${mindrop}</select></td>
            </tr>
        </table><br>
        <input type='Submit' name='timeSubmit' value='Submit'>
        </form>";
?>
		</td>
    </tr>
  </table>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>