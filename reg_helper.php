<?php
	include_once 'main_helper.php';

	define(RE_CENTER_DEPT_HEAD_EMAIL, "debbie.philips@uconn.edu");
	
	function showStudentRegistrationConfirmation( $fname, $lname, $argus, $arguscertificate, $class, $major, $careertypeOptions, $geopref, $phone, $psoft, $classes, $email )
	{
		echo '
				<form name="confreg" id="confreg" method="post" action="register.php?type=student&amp;action=student_confirm">
				<table width="100%" class="table_topBorder">
					<tr>
						<td><strong><font size="+1">Please confirm the following information below and press \'Confirm\'. Otherwise, press \'Edit\' to go back</font></strong></td>
					</tr>
					<tr>
						<td><strong>First Name</strong><br /><input type="text" name="fname" value="' . $fname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Last Name</strong><br /><input type="text" name="lname" value="' . $lname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="argustut" value="yes" onclick="javascript: return false;" ' . ( $argus == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS Tutorial</strong><br /></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="arguscertificate" value="yes" onclick="javascript: return false;" ' . ( $argus == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS Certificate</strong><br /></td>
					</tr>
					<tr>
						<td><strong>Classes</strong><br />';
					
					for( $x = 0; $x < sizeof( $classes ); $x++ )
					{
						$optionsParts = explode( '|', $classes[$x] );
						$optionValue = $optionsParts[0];
						$optionLabel = $optionsParts[1];
						
						if( $_POST[$optionValue] == "yes" )
						{
							echo '<input type="checkbox" name="' . $optionValue . '" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $optionLabel. '&nbsp;&nbsp;&nbsp;';
						}
					}
					
		echo '	
						</td>	
					</tr>
					<tr>
						<td><strong>Class</strong><br /><input type="text" name="class" value="' . $class . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Major</strong><br /><input type="text" name="major" value="' . $major . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Job Functions</strong><br />';
					
					for( $x = 0; $x < sizeof( $careertypeOptions ); $x++ )
					{
						$optionsParts = explode( '|', $careertypeOptions[$x] );
						$optionValue = $optionsParts[0];
						$optionLabel = $optionsParts[1];
						//echo "optionLabel: ".$optionLabel;
						
						if( $_POST[$optionValue] == "yes" )
						{
							echo '<input type="checkbox" name="' . $optionValue . '" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $optionLabel. '&nbsp;&nbsp;&nbsp;';
						}
					}
					
		echo '	
						</td>	
					</tr>
					<tr>
						<td><strong>Geographical Preference</strong><br /><input type="text" name="geopref" value="' . $geopref . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Phone</strong><br /><input type="text" name="phone" value="' . $phone . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Peoplesoft</strong><br /><input type="text" name="psoft" value="' . $psoft . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>E-mail</strong><br /><input type="text" name="email" value="' . $email . '" size="30" readonly /></td>
					</tr>				
					
					<tr>
						<td><strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Confirm" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Edit" /><input type="hidden" name="pword" value="' . $_POST['password'] . '" /></td>
					</tr>
				</table>
				</form>';
	}
	
	function showAlumniRegistrationConfirmation( $fname, $lname, $major, $geopref, $phone, $email )
	{
		echo '
				<form name="confreg" id="confreg" method="post" action="register.php?type=alumni&amp;action=alumni_confirm">
				<table width="100%" class="table_topBorder">
					<tr>
						<td><strong><font size="+1">Please confirm the following information below and press \'Confirm\'. Otherwise, press \'Edit\' to go back</font></strong></td>
					</tr>
					<tr>
						<td><strong>First Name</strong><br /><input type="text" name="fname" value="' . $fname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Last Name</strong><br /><input type="text" name="lname" value="' . $lname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Major</strong><br /><input type="text" name="major" value="' . $major . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Geographical Preference</strong><br /><input type="text" name="geopref" value="' . $geopref . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Phone</strong><br /><input type="text" name="phone" value="' . $phone . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>E-mail</strong><br /><input type="text" name="email" value="' . $email . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Confirm Alumni" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Edit" /><input type="hidden" name="pword" value="' . $_POST['password'] . '" /></td>
					</tr>
				</table>
				</form>';
	}
	
	function showEmployerRegistrationConfirmation( $fname, $lname, $companyname,$phone, $email, $website,$geo, $careertypeOptions,$openingtype,$experience)
	{
		echo '
				<form name="confreg" id="confreg" method="post" action="register.php?type=employer&amp;action=employer_confirm">
				<table width="100%" class="table_topBorder">
					<tr>
						<td><strong><font size="+1">Please confirm the following information below and press \'Confirm\'. Otherwise, press \'Edit\' to go back</font></strong></td>
					</tr>
					<tr>
						<td><strong>First Name</strong><br /><input type="text" name="fname" value="' . $fname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Last Name</strong><br /><input type="text" name="lname" value="' . $lname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Company Name</strong><br /><input type="text" name="company" value="' . $companyname . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Phone</strong><br /><input type="text" name="phone" value="' . $phone . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>E-mail</strong><br /><input type="text" name="email" value="' . $email . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Web Site</strong><br /><input type="text" name="website" value="' . $website . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Geographical Location of the job</strong><br /><input type="text" name="geo" value="' . $geo . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Job Functions</strong><br />';
					
					for( $x = 0; $x < sizeof( $careertypeOptions ); $x++ )
					{
						$optionsParts = explode( '|', $careertypeOptions[$x] );
						$optionValue = $optionsParts[0];
						$optionLabel = $optionsParts[1];
						//echo "optionLabel: ".$optionLabel;
						
						if( $_POST[$optionValue] == "yes" )
						{
							echo '<input type="checkbox" name="' . $optionValue . '" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $optionLabel . '&nbsp;&nbsp;&nbsp;';
						}
					}
					echo'
						</td>	
					</tr>					
					<tr>
						<td><strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Confirm Employer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&raquo;</strong>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Edit" /><input type="hidden" name="pword" value="' . $_POST['password'] . '" /></td>
					</tr>
				</table>
				</form>';
				//die();
	}

	function showDefaultRegisterPage( )
	{
		echo '
				<table style="color:#333333; width:57vw; min-width:480px;">
					<tr>
						<td><font color="#666666" size="+1"><strong>Registration Forms</strong></font></td>
					</tr>
				</table>
				<table style="border:0; width:60vw;">
					<tr>
						<td width="30%" style="text-align:center; min-width:160px;">
							<div class="regcard" onClick="location.href=\'register.php?type=student\'"><img class="regcardicon" src="http://www3.business.uconn.edu/reresume/images/backpack_icon_button.png" /><font color="#666666" size="+0.5"><strong><br><br>Register as<br>Student</strong></font></div>
						</td>
						<td width="30%" style="text-align:center; min-width:160px;">
							<div class="regcard" onClick="location.href=\'register.php?type=alumni\'"><img class="regcardicon" src="http://www3.business.uconn.edu/reresume/images/gradcap_icon_button.png" /><font color="#666666" size="+0.5"><strong><br><br>Register as<br>Alumni</strong></font></div>
						</td>
						<td width="30%" style="text-align:center; min-width:160px;">
							<div class="regcard" onClick="location.href=\'register.php?type=employer\'"><img class="regcardicon" src="http://www3.business.uconn.edu/reresume/images/case_icon_button.png" /><font color="#666666" size="+0.5"><strong><br><br>Register as<br>Employer</strong></font></div>
						</td>
					</tr>
				</table>';
						}
	
	function verifyName( $name )
	{
		$nameValid = true;
		
		if( !isEmpty( $name ) )
		{
			$nameParts = explode( ' ', $name );
							
			for( $x = 0; $x < sizeof( $nameParts ); $x++ )
			{
				if( ctype_alpha( $nameParts[$x] ) ) { /*do nothing*/ }
				else
					$nameValid = false;
			}												
		}
		else
			$nameValid = false;
			
		return( $nameValid );
	}
	
	function verifyRegEx( $value, $regex )
	{
		$valid = true;
		
		if( !isEmpty( $value ) )
		{
			if( preg_match( $regex, $value ) ) { /*do nothing*/ }
			else
				$valid = false;
		}
		else
			$valid = false;
			
		return( $valid );
	}
	
	function verifyPassword( $pass )
	{
		$valid = true;
		
		if( !isEmpty( $pass ) )
		{
			if( /*( ctype_alnum( $pass ) ) && */( strlen( $pass ) >= 6 ) && ( strlen( $pass ) <= 15 ) ) { /*do nothing*/ }
			else
				$valid = false;
		}
		else
			$valid = false;
		
		return( $valid );
	}					
	
	function startTableWithForm( $name, $action, $title, $class )
	{
		echo '
				<form name="' . $name . '" id="' . $name . '" method="post" action="' . $action . '">
				<table width="100%" class="' . $class . '">
				<tr>
					<td><h2>' . $title . '</h2></td>
				</tr>';
	}
	
	function endTableWithForm( )
	{
		echo '
				</table>
				</form>';
	}
	
	function tableSelectInput( $name, $label, $options, $value, $error )
	{
		echo '
				<tr>
					<td><strong>' . ( ( $error ) ? '<font color="#FF0000">*' . $label . '</font>' : $label ) .
						'</strong><br />&nbsp;&nbsp;<select name="' . $name . '" id="' . $name . '">
						 <option value=""></option>';
		
		for( $x = 0; $x < sizeof( $options ); $x++ )
		{
			$optionsParts = explode( '|', $options[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			echo '<option value="' . $optionValue . '" ' . ( ( $value == $optionValue ) ? 'selected="selected"' : '' ) . '>' . $optionLabel . '</option>';
		}
		
		echo '
						</select>
					</td>
				</tr>';
	}	
	
	function tableCheckboxInput( $name, $options )
	{		
		echo '
				<tr>
					<td><strong>' . $name . '</strong><br />';
		
		for( $x = 0; $x < sizeof( $options ); $x++ )
		{			
			$optionsParts = explode( '|', $options[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			echo '&nbsp;&nbsp;<input type="checkbox" name="' . $optionValue . '" value="yes" ' . ( $_POST[$optionValue] == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;' . $optionLabel . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>';
		}
		
		echo '
					</td>
				</tr>';
	}
	
	function validatePSoft( $psoft )
	{
		$query = "SELECT psoft
				  FROM students
				  WHERE psoft = '$psoft'";
		$result = mssql_query( $query );
		$array = mssql_fetch_array( $result );
		
		if( $array == FALSE )
		{
			if( !is_bool( $result ) )
				mssql_free_result( $result );
			
			return( true );
		}
		
		mssql_free_result( $result );
		
		return( false );
	}
	
	function validateEmail( $email )
	{
		$query = "SELECT email
				  FROM students
				  WHERE email = '$email'";
		$result = mssql_query ( $query );
		$array = mssql_fetch_array( $result );
		
		if( $array == FALSE )
		{
			if( !is_bool( $result ) )
				mssql_free_result( $result );
				
			return( true );
		}
		
		mssql_free_result( $result );
		
		return( false );
	}
	
	function validateEmployerEmail( $email )
	{
		$query = "SELECT email
				  FROM employers
				  WHERE email = '$email'";
		$result = mssql_query ( $query );
		$array = mssql_fetch_array( $result );
		
		if( $array == FALSE )
		{
			if( !is_bool( $result ) )
				mssql_free_result( $result );
				
			return( true );
		}
		
		mssql_free_result( $result );
		
		return( false );
	}
	
	function addStudent( $fname, $lname, $argus, $arguscertficate, $classes, $class, $major, $careertype, $geopref, $phone, $psoft, $email, $pass, $mba)
	{
	//	mssql_query( 'SET IDENTITY_INSERT students ON' );
		
		$sQuery = "INSERT INTO students ( fname, lname, argus, arguscertificate, classes, class, major, careertype, geopref, phone, psoft, email, regdate, permadd, schooladd, intplcmnt, mba )
					     VALUES ( '$fname', '$lname', '$argus', '$arguscertficate', '$classes', '$class', '$major', '$careertype', '$geopref', '$phone', '$psoft', '$email', GETDATE( ), '', '', '','$mba' )";
		$lQuery = "INSERT INTO logins ( username, password, access ) VALUES ( '$psoft', '$pass', 1 )";
		
		$sResult = mssql_query( $sQuery );
		$lResult = FALSE;
		
		if( $sResult != FALSE )
			$lResult = mssql_query( $lQuery );
		
		mssql_query( 'SET IDENTITY_INSERT students OFF' );
		
		if( !$sResult )
			echo '<h3>FAILED TO INSERT STUDENT</h3>';
		if( !$lResult )
			echo '<h3>FAILED TO INSERT LOGIN</h3>';
		
		if( !is_bool( $sResult ) )
			mssql_free_result( $sResult );
		if( !is_bool( $lResult ) )
			mssql_free_result( $lResult );
	}
	
	function addAlumni( $fname, $lname, $major, $geopref, $phone, $email, $pass )
	{
	//	mssql_query( 'SET IDENTITY_INSERT students ON' );
		
		$sQuery = "INSERT INTO students ( fname, lname, argus,arguscertificate, classes, class, major, geopref, phone, psoft, email, regdate, permadd, schooladd, intplcmnt )
					     VALUES ( '$fname', '$lname', '1','0', '', '0', '$major', '$geopref', '$phone', '0', '$email', GETDATE( ), '', '', '' )";
		$lQuery = "INSERT INTO logins ( username, password, access ) VALUES ( '$email', '$pass', 1 )";
		
		$sResult = mssql_query( $sQuery );
		$lResult = FALSE;
		
		if( $sResult != FALSE )
			$lResult = mssql_query( $lQuery );
		
		mssql_query( 'SET IDENTITY_INSERT students OFF' );
		
		if( !$sResult )
			echo '<h3>FAILED TO INSERT STUDENT</h3>';
		if( !$lResult )
			echo '<h3>FAILED TO INSERT LOGIN</h3>';
		
		if( !is_bool( $sResult ) )
			mssql_free_result( $sResult );
		if( !is_bool( $lResult ) )
			mssql_free_result( $lResult );
	} 
	
	function addEmployer( $fname, $lname, $companyname, $phone, $email,$website,$geo, $careertype,$openingtype,$experience, $pass)
	{	
		//echo 'Adding Employer.....';
		//echo $email.$pass;	
		//echo 'company name ' . $companyname;
		$sQuery = "INSERT INTO employers ( fname, lname, company, phone, email, website, geo, careertype, openingtype, experience, lastlogin,regdate)
					     VALUES ( '$fname', '$lname', '$companyname', '$phone', '$email', '$website','$geo', '$careertype','$openingtype','$experience', '', GETDATE( ))";
		//$sQuery = "delete from employers where email = 'samora007@hotmail.com'";
		//$lQuery = "delete from logins where username = 'samora007@hotmail.com'";
		$lQuery = "INSERT INTO logins ( username, password, access ) VALUES ( '$email', '$pass', 2 )";
		
		$sResult = mssql_query( $sQuery );
		$lResult = FALSE;
		
		if( $sResult != FALSE )
			$lResult = mssql_query( $lQuery );
		
		mssql_query( 'SET IDENTITY_INSERT employers OFF');
		
		if( !$sResult )
			echo '<h3>FAILED TO INSERT EMPLOYER</h3>';
		if( !$lResult )
			echo '<h3>FAILED TO INSERT LOGIN</h3>';
		
		if( !is_bool( $sResult ) )
			mssql_free_result( $sResult );
		if( !is_bool( $lResult ) )
			mssql_free_result( $lResult );
	} 
	
	function sendStudentConfirmationMail( $fname, $lname, $email )
	{
		$subject  = "Real Estate Resume Book Student Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		$headers .= "Cc: Administrative Coordinator  <RE_CENTER_DEPT_HEAD_EMAIL>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your registration with the Real Estate Resume Book. At this time, the Real Estate department is reviewing your application and will notify you of your acceptance in 1-2 business days. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
		
		$headersAdmin  = 'MIME-Version: 1.0' . "\r\n";
		$headersAdmin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headersAdmin .= "To: Resume Book Admin <recenter@business.uconn.edu>\r\n";
		$headersAdmin .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$messageAdmin = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello Admin,<br /><br/>This is an automated message informing you that a student, <strong>' . $fname . ' ' . $lname . '</strong>, has just registered on the Resume Book. Click <a href="http://www3.business.uconn.edu/reresume/">here</a> to sign into the admin page to verify the students account.<br /><br />Thank you,<br />UCONN Real Estate Department';
		
		if( !mail( "recenter@business.uconn.edu", $subject, $messageAdmin, $headersAdmin ) )
			echo "mail Error";
	}
	
	function sendAlumniConfirmationMail( $fname, $lname, $email )
	{
		$subject  = "Real Estate Resume Book Alumni Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		$headers .= "Cc: Administrative Coordinator  <RE_CENTER_DEPT_HEAD_EMAIL>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your registration with the Real Estate Resume Book. At this time, the Real Estate department is reviewing your application and will notify you of your acceptance in 1-2 business days. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
		
		$headersAdmin  = 'MIME-Version: 1.0' . "\r\n";
		$headersAdmin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headersAdmin .= "To: Resume Book Admin <recenter@business.uconn.edu>\r\n";
		$headersAdmin .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$messageAdmin = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello Admin,<br /><br/>This is an automated message informing you that an alumni, <strong>' . $fname . ' ' . $lname . '</strong>, has just registered on the Resume Book. Click <a href="http://www3.business.uconn.edu/reresume/">here</a> to sign into the admin page to verify the alumni account.<br /><br />Thank you,<br />UCONN Real Estate Department';
		
		if( !mail( "recenter@business.uconn.edu", $subject, $messageAdmin, $headersAdmin ) )
			echo "mail Error";
	}
	
	function sendEmployerConfirmationMail( $fname, $lname, $email )
	{
		$subject  = "Real Estate Resume Book Employer Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		$headers .= "Cc: Administrative Coordinator  <RE_CENTER_DEPT_HEAD_EMAIL>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your registration with the Real Estate Resume Book. At this time, the Real Estate department is reviewing your application and will notify you of your acceptance in 1-2 business days. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
		
		$headersAdmin  = 'MIME-Version: 1.0' . "\r\n";
		$headersAdmin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headersAdmin .= "To: Resume Book Admin <recenter@business.uconn.edu>\r\n";
		$headersAdmin .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$messageAdmin = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello Admin,<br /><br/>This is an automated message informing you that an employer, <strong>' . $fname . ' ' . $lname . '</strong>, has just registered on the Resume Book. Click <a href="http://www3.business.uconn.edu/reresume/">here</a> to sign into the admin page to verify the employers account.<br /><br />Thank you,<br />UCONN Real Estate Department';
		
		if( !mail( "recenter@business.uconn.edu", $subject, $messageAdmin, $headersAdmin ) )
			echo "mail Error";
	}
	
	function queryStudents($careertype, $geopref, $from, $to, $mba, $resume)
	{
		echo '<h1>Search Results</h1>';
		
		echo '<table width="100%" class="table_fullBorder">';
		
		//$currentYear = date('Y');
		
		if($from == '')
			$from = 0;
		if($to == '')
			$to = 2999;
			
		$q = " (mba = 0 OR mba <> 0 ) ";
		//echo 'MBA' . $mba;
		if($mba == 'yes') {
			$q = " (mba <> 0) ";
		}
		$r = " (resume = NULL OR resume <> NULL) ";	
		if($resume == 'yes') {
			$r = " (resume <> NULL) ";
			}
		/*for( $x = 0; $x < sizeof( $classes ); $x++ )
		{
			$careertypename = getValueFromArrayIndex( $careerTypeList, $careertypes[$x] );
		}*/
		
				
		//echo 'geopref : '. $geopref;
		
		if($geopref == 99) {// 99 indicates empty selection 'no prefernce'
			$query = "SELECT * FROM students WHERE class <= '$to' AND class >= '$from' AND hidden = 0 AND $r AND $q ORDER BY class,lname";
		}
		else {		
			$query = "SELECT * FROM students WHERE class <= '$to' AND class >= '$from' AND (geopref = '$geopref' OR geopref = 6 ) AND $r AND $q AND hidden = 0 ORDER BY class,lname";
		}
		
		$result = mssql_query( $query );
		
		for( $x = 0; $x < mssql_num_rows( $result ); $x++ )
		{
			$student = mssql_fetch_array( $result );
			
			$query = "";
			
			if( $student['class'] == 0 )
			{
				$query = "SELECT approved
						  FROM logins
						  WHERE username = '$student[email]'";
			}
			else
			{	
				$query = "SELECT approved
					  	  FROM logins
					      WHERE username = '$student[psoft]'";
			}
			
			$sresult = mssql_query( $query );
			$user = mssql_fetch_array( $sresult );
				
			$class = ( $student['class'] == 0 ? 'Alumni' : 'Class of '.$student['class'] );
			$placed = 'Not Placed';
			if($student['placed'] == 1)
				$placed = '<font color="#0000FF">Placed</font>';
			
			echo '<tr>
					<td><ul><li><a href="employer.php?vsp=' . $student['id'] . '">' . $student['fname'] . ' ' . $student['lname'] . '</a> (<i>' . $class . '</i>)';
					
			$resume = '';
			if($student['placed'] == 0)
				$resume = $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<a href="resumes/index.php?id=' . $student['id'] . '">View Resume</a>';		
			else
				$resume = 'Resume is unavailable at this time';
			
			$mba = $student['mba'] == '1' ? 'MBA student' : 'Undergrad student';
			
			echo '<ul><li>' . $mba . '</li></ul>';	
			
			echo '<ul><li>' . $placed . '</li></ul>';	
			
			echo '<ul><li>' . $resume . '</li></ul></li></ul></td>
				</tr>';
			
			if( !is_bool( $sresult ) )
				mssql_free_result( $sresult );
		}
		
		echo '</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	
	function displayStudentProfile( $id )
	{
		$query = "SELECT *
				  FROM students
				  WHERE id = '$id'";
		$result = mssql_query( $query );
		
		if( mssql_num_rows( $result ) < 1 )
		{
			if( !is_bool( $result ) )
				mssql_free_result( $result );
			
			header( 'Location: admin.php?error=1' );
		}
		else
		{
			echo ' <h2><a href = "employer.php?action=studentsSearch&amp;sub=results">Back to search results</a></h2>';
			$student = mssql_fetch_array( $result );
			
			$isStudent = ( $student['class'] == 0 ? false : true );
			
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law' );
	$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey');//, 6 => 'np|No Preference' );
	$classesOptions = array( 0 => 'f3230|Fnce 3230 (Real Estate Principles)', 1 => 'f3332|Fnce 3332 (Real Estate Investments)', 2 => 'f3333|Fnce 3333 (Real Estate Finance)', 3 => 'f3334|Fnce 3334 (GIS Applications in Real Estate Markets)', 4 => 'b3274|BLaw 3274 (Real Estate Law)', 5 => 'f3302|Fnce 3302 (Investements and Security Analysis)', 6 => 'e3439w|Econ 3439W (Urban and Regional Economics)', 7 => 'e2327|Econ 2327 (Information Technology for Economics)' , 8 => 'f4895|Fnce 4895 (Real Estate Appraisal)', 9 => 'f3335|Fnce 3335 (Appraisal)', 10 => 'f3336|Fnce 3336 (Real Estate a Practical Approach)');	
	$careerTypeList = array( 0 => 'app|Valuation/Appraisal', 1 => 'bro|Brokerage/Sales (Commercial Property)', 2 => 'Inv|Investments/ Private Equity', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|No Job Function Preference', 8=> 'assetmang|Asset Management', 9=> 'corprealestate|Corporate Real Estate', 10=> 'law|Law', 11=>'lendbank|Banking/Real Estate Lending', 12=> 'structprod|Structured Financial Products/ Mortgage Backed Securities');
			
			echo '
				<table width="100%" class="table_fullBorder">
					<tr>
						<td>
						<h2>' . $student['fname'] . ' ' . $student['lname'] . ' (' . ( ( $isStudent ) ? '<i>' . $student['class'] . '</i>' : '<i>Alumni</i>' ) . ') </h2>';
			
			if( $isStudent )
			{
				echo'
							&nbsp;&nbsp;&nbsp;<input type="checkbox" name="argustut" value="yes" onclick="javascript: return false;" ' . ( $student['argus'] ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS Class</strong><br />
							&nbsp;&nbsp;&nbsp;<input type="checkbox" name="arguscertificate" value="yes" onclick="javascript: return false;" ' . ( $student['arguscertificate'] ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS Certificate</strong><br />
							<br><strong>Real Estate Classes</strong><br />';
			
				if( $student['classes'] == NULL || $student['classes'] == '' )
					echo '<i>None</i>';
				else
				{
					$classes = explode( '|', $student['classes'] );
				
					for( $x = 0; $x < sizeof( $classes ); $x++ )
					{
						$classname = getValueFromArrayIndex( $classesOptions, $classes[$x] );
						
						if( $classname != NULL )
							echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" name="class" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $classname . '<br><br>';
					}
				}
			}
			
			$class = ( $student['class'] == 0 ? 'Alumni' : $student['class'] );
			$major = getValueFromArrayIndex( $majorOptions, $student['major'] );
			$geopref = getValueFromArrayIndex( $locationOptions, $student['geopref'] );
			
			echo '
					<strong>Class: </strong>' . $class . '<br>
					<br><strong>Major: </strong>' . $major . '<br>';
			if( $isStudent )
			{
				echo '
					<br><strong>Job Functions</strong><br />';
				if( $student['careertype'] == NULL || $student['careertype'] == '' )
						echo '<i>None</i>';
				else
				{
					$careertypes = explode( '|', $student['careertype'] );
				
					for( $x = 0; $x < sizeof( $classes ); $x++ )
					{
						$careertypename = getValueFromArrayIndex( $careerTypeList, $careertypes[$x] );
						
						if( $careertypename != NULL )
							echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" name="class" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $careertypename . '<br>';
					}
				}
			}
					echo '
					<br><strong>Geographical Preference: </strong>';
					if( $student['geopref'] == '6' )
						echo '<i>No Preference</i>';
					else
					{
						echo'' . $geopref . '';
					}
					echo'<br>
					<br><strong>Phone: </strong>' . $student['phone'] . '<br>
					<br><strong>E-mail: </strong>' . $student['email'] . '<br>
					<br><strong>Resume</strong><br />' . ( $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<font size="+1"><a href="resumes/index.php?id=' . $id . '">View Resume</a></font>' ) . '
					</td>
				</tr>
			</table>';
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );
		}
	}
		
?>