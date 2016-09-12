<?php

	$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law', 7 =>'mba|MBA General', 8=> 'clas|CLAS' );
	$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey');//, 6 => 'np|No Preference' );
	$classesOptions = array( 0 => 'f3230|Fnce 3230 (Real Estate Principles)', 1 => 'f3332|Fnce 3332 (Real Estate Investments)', 2 => 'f3333|Fnce 3333 (Real Estate Finance)', 3 => 'f3334|Fnce 3334 (GIS Applications in Real Estate Markets)', 4 => 'b3274|BLaw 3274 (Real Estate Law)', 5 => 'f3302|Fnce 3302 (Investements and Security Analysis)', 6 => 'e3439w|Econ 3439W (Urban and Regional Economics)', 7 => 'e2327|Econ 2327 ( Information Technology for Economics)' , 8 => 'f4895|Fnce 4895 (Real Estate Appraisal)');
	$internshipOptions = array( 0 => 'apval|Appraisal', 1 => 'brok|Brokerage', 2 => 'inv|Investment', 3 => 'mgtfin|Developement', 4 => 'mktan|Marketing', 5 => 'finan|Counseling', 6 => 'pmgmt|Property Management', 7 => 'o|Other' );
	$employeeOptions = array( 0 => 'int|Internship', 1 => 'ftime|Full Time' );
	$experienceOptions = array( 0 => 'na|None', 1 => '123|1-3', 2 => '325|3-5', 3 => '5p|5+', 4 => '10p|10+' );
	// Structured financial products/ mortgage backed securities
	$careerTypeList = array( 0 => 'app|Valuation/Appraisal', 1 => 'bro|Brokerage/Sales (Commercial Property)', 2 => 'Inv|Investments/ Private Equity', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|No Job Function Preference', 8=> 'assetmang|Asset Management', 9=> 'corprealestate|Corporate Real Estate', 10=> 'law|Law', 11=>'lendbank|Banking/Real Estate Lending', 12=> 'structprod|Structured Financial Products/ Mortgage Backed Securities');

	function isEmpty( $string )
	{
		if( $string == '' || $string == NULL )
			return( true );
					
		return( false );
	}
	
	function showError( $error )
	{
		echo '
      			<table width="100%" class="table_whiteBox2">
      				<tr>
           	 		<td bgcolor="#CC0000"><h3><font color="#FFFFFF">' . $error . '</font></h3></td>
           	 	</tr>
      			</table>
     	 
     			<br />';
	}

	function showLoginError( $error )
	{
		echo $error;
	}
	
	function showSuccessfulNotification( $notification )
	{
		echo '
      			<table width="100%" class="table_whiteBox2">
      				<tr>
           	 		<td><h3><font colo="#FFFFFF">' . $notification . '</font></h3></td>
           	 	</tr>
      			</table>
     	 
     			<br />';
	}
	
	function getLabelFromValue( $array, $value )
	{
		for( $x = 0; $x < sizeof( $array ); $x++ )
		{
			$optionsParts = explode( '|', $array[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			if( $optionValue == $value )
				return( $optionLabel );
		}
		
		//return( 'DNE' );
		return ('No Preference');
	}
	
	function getValueFromLabel( $array, $label )
	{
		for( $x = 0; $x < sizeof( $array ); $x++ )
		{
			$optionsParts = explode( '|', $array[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			if( $optionLabel == $label )
				return( $optionValue );
		}
		
		//return( 'DNE' );
		return ('No preference');
	}
	
	function getClasses( $array )
	{
		$classes = '';
		
		for( $x = 0; $x < sizeof( $array ); $x++ )
		{
			$optionsParts = explode( '|', $array[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			if( $_POST[$optionValue] == 'yes' )
				$classes = $classes . $x . '|';
		}
		
		return( $classes );
	}
	
	function getIndexFromDelimitedArrayLabel( $array, $label )
	{
		$index = 0;
		
		for( $x = 0; $x < sizeof( $array ); $x++ )
		{
			$optionsParts = explode( '|', $array[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			if( $label == $optionLabel )
				$index = $x;
		}
		
		return( $index );
	}
	
	function getIndexFromDelimitedArrayValue( $array, $value )
	{
		$index = 0;
		
		for( $x = 0; $x < sizeof( $array ); $x++ )
		{
			$optionsParts = explode( '|', $array[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			
			if( $value == $optionValue )
				$index = $x;
		}
		
		return( $index );
	}
	
	function getValueFromArrayIndex( $array, $n )
	{
		$pair = explode( '|', $array[$n] );
		
		/*if($pair[1] == '')
			return 'No Preference';
		else*/
			return( $pair[1] );
	}
	
	function CheckIfStudentEmailExists( $email )
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
				
			return( false );
		}
		
		mssql_free_result( $result );
		
		return( true );
	}
	
	function CheckIfEmployerEmailExists( $email )
	{
		$query = "SELECT email
				  FROM employers
				  WHERE email = '$email'";
		$result = mssql_query ($query);
		$array = mssql_fetch_array( $result);
		
		if( $array == FALSE )
		{
			if( !is_bool( $result ) )
				mssql_free_result( $result );
				
			return( false );
		}
		
		mssql_free_result( $result );
		
		return( true );
	}
	
	function sendNewPassword( $fname, $lname, $email, $pass )
	{
		$subject  = "Real Estate Resume Book Password Reset";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="320" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming that you recently requested a password reset. Your new password is: <strong>'. $pass .'</strong> <br /><br />Thank you,<br />UConn Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";	
		
	}
	
	function updateEmployer($id, $companyname, $phone, $website,$geopref, $careertype,$openingtype,$experience)
	{
	//	mssql_query( 'SET IDENTITY_INSERT students ON' );
	
	$query = "UPDATE employers
			  SET company = '$companyname', phone = '$phone', website = '$website', geo = '$geopref', careertype = '$careertype', openingtype = '$openingtype', experience = '$experience'
			  WHERE id = '$id'";
			
			$result = mssql_query( $query );
						
			if( !$result )
				showError( 'Error: Failed to update profile' );
			else
			{
				echo '<br />';
				showSuccessfulNotification( 'Profile successfully updated' );
				
				updateCompanyName( $companyname );
				updatePhone($phone);
				updateWebSite( $website);
				updateGeopref($geopref);
				updateCareerType($careertype);
				updateOpeningType( $openingtype);
				updateeExperience( $experience);											
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );	
		
	}
	
	function displayJobPostings()
	{		
		$query = "SELECT *
				  FROM jobs
				  ORDER BY ord ASC";
		$result = mssql_query( $query );
		
		echo '
			<h1>Job Postings</h1>
			<form name="stprof" id="stprof" method="post" action="admin.php?action=savechanges&amp;sub=submit">
			<table width="100%" class="table_topBorder">';
		$emptyEntries = 0;
		$i = 1;
		for( $x = 1; $x <= mssql_num_rows( $result ); $x++ )
		{
			$job= mssql_fetch_array( $result );
			
			$lolo = 'One';
			if($i == 2)
				$lolo = 'Two';
			else if($i == 3)
				$lolo = 'Three';
			else if($i == 4)
				$lolo = 'Four';
			else if($i == 5)
				$lolo = 'Five';		
			else if($i == 6)
				$lolo = 'Six';
			else if($i == 7)
				$lolo = 'Seven';
			else if($i == 8)
				$lolo = 'Eight';
			else if($i == 9)
				$lolo = 'Nine';
			else if($i == 10)
				$lolo = 'Ten';	

			if($job['date'] == ' ' || $job['date'] == '')
			{
				$emptyEntries++;				
			}
			else
			{			
				echo'
				<tr>
					<td style="border-bottom:1px solid #cccccc; line-height:1.5;"><br>
					<strong>Order</strong><br>
					&nbsp;&nbsp;<input type="number" min="1" max="10" name="ord'.$i.'" value="' . $job['ord'] . '" size="2" /><br>
					<strong>Date</strong><br>					
					&nbsp;&nbsp;<input type="text" name="date'.$i.'" value="' . $job['date'] . '" size="7" /><br>
					<strong>Company</strong><br>
					&nbsp;&nbsp;<input type="text" name="companyName'.$i.'" value="' . $job['companyName'] . ' " size="30" /><br>							
					<strong>Position</strong><br>
					&nbsp;&nbsp;<input type="text" name="position'.$i.'" value="' . $job['position'] . '" size="30" /><br>
					<strong>File</strong><br>
					&nbsp;&nbsp;<input type="text" name="link'.$lolo.'" value="' . $job['link'] . '" size="50" /><br><br>				
					</td>
				</tr>';
				$i++;
			}
			
		}		
		
		for($j = $i; $j <=10; $j++)
		{
			$lolo = 'One';
			if($j == 2)
				$lolo = 'Two';
			else if($j == 3)
				$lolo = 'Three';
			else if($j == 4)
				$lolo = 'Four';
			else if($j == 5)
				$lolo = 'Five';		
			else if($j == 6)
				$lolo = 'Six';
			else if($j == 7)
				$lolo = 'Seven';
			else if($j == 8)
				$lolo = 'Eight';
			else if($j == 9)
				$lolo = 'Nine';
			else if($j == 10)
				$lolo = 'Ten';	
			echo'
				<tr>
					<td>
					<strong>Order</strong><input type="number" min="1" max="10" name="ord'.$j.'" value="" size="5" />
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</strong><input type="text" name="date'.$j.'" value="" size="10" />
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Company</strong><input type="text" name="companyName'.$j.'" value="" size="20" />							
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Position</strong><input type="text" name="position'.$j.'" value="" size="30" />
					<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Link</strong><input type="text" name="link'.$lolo.'" value="" size="50" />	
					</td>
				</tr>';
		}
		echo '
			<tr>
				<td><input type="submit" name="submit" class="loginButton" value="Save Changes" /></td>
			</tr>
			</table>
			</form>';
			
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	
	function displayJobPostingsToStudents()
	{		
		$query = "SELECT *
				  FROM jobs
				  ORDER BY ord ASC";
		$result = mssql_query( $query );
		
		echo '
			<h1>Job Postings</h1>
			<h3>Click each listing for more details. Postings will be opened in a new tab.</h3>		
			<table width="100%" class="table_topBorder">';
		
		for( $x = 1; $x <= mssql_num_rows( $result ); $x++ )
		{
			$job= mssql_fetch_array( $result );
			
			//echo 'job[date] = '. $job['date'];
			
			if($job['date'] == ' ')
				continue;
			
				$lolo = 'One';
			if($x == 2)
				$lolo = 'Two';
			else if($x == 3)
				$lolo = 'Three';
			else if($x == 4)
				$lolo = 'Four';
			else if($x == 5)
				$lolo = 'Five';	
			else if($x == 6)
				$lolo = 'Six';
			else if($x == 7)
				$lolo = 'Seven';
			else if($x == 8)
				$lolo = 'Eight';
			else if($x == 9)
				$lolo = 'Nine';
			else if($x == 10)
				$lolo = 'Ten';			
			
			echo'
			<tr>
				<td style="font-size:90%;">Posted '. $job['date'] .' </td>
				<td><a href= "http://www3.business.uconn.edu/reresume/docs/postings/'.$job['link'].'" style="color:#000000; font-weight:normal;" target="_blank"><strong>'.$job['companyName'].'</strong> - '.$job['position'].'</a></td>
			</tr>';
		}		
			
		echo '</table>';
			
			
		if( !is_bool( $result ) )
			mssql_free_result( $result );
			
		die();
	}
	
	function updateJobs($date1,$companyName1,$position1,$link1,$ord1,$remove1,
						$date2,$companyName2,$position2,$link2,$ord2,$remove2,
						$date3,$companyName3,$position3,$link3,$ord3,$remove3,
						$date4,$companyName4,$position4,$link4,$ord4,$remove4,
						$date5,$companyName5,$position5,$link5,$ord5,$remove5,
						$date6,$companyName6,$position6,$link6,$ord6,$remove6,
						$date7,$companyName7,$position7,$link7,$ord7,$remove7,
						$date8,$companyName8,$position8,$link8,$ord8,$remove8,
						$date9,$companyName9,$position9,$link9,$ord9,$remove9,
						$date10,$companyName10,$position10,$link10,$ord10,$remove10)
	{		
		
		//echo 'links'.$link5.$link4.$link3.$link2.$link1;
		$result = '';
		
		$id = 1;
		for( $i = 1; $i <= 10 ; $i++)
		{
			$query = '';
			$date =  'date'. $i;
			//if(${$date} == '' || ${$date} == ' ')
				//continue;		
			$companyName = 'companyName' . $i;
			$position = 'position' . $i;
			$link = 'link' . $i;
			$ord = 'ord' . $i;
			
			$query = "UPDATE jobs
				  SET date = '${$date}', companyName = '${$companyName}', position = '${$position}', link = '${$link}', ord = '${$ord}'
				  WHERE id = '$i'";
			
			$id++;
				
			$result = mssql_query( $query);
				
			if( !is_bool( $result))
				mssql_free_result( $result);
		}
		
		if( !$result )
			showError( 'Error: Failed to update jobs');
		else
		{
			echo '<br />';
			showSuccessfulNotification( 'Job postings successfully updated' );										
		}
		
	}
	
	function updateStudent($id, $argus, $arguscertificate, $classes, $class, $major, $careertype, $geopref, $phone, $email, $permadd, $schooladd,$placement1, $placement2, $placement3,$hidden, $mba, $placed/*,$employee*/)
	{
	//	mssql_query( 'SET IDENTITY_INSERT students ON' );
	
	// if the email does not already exist, update the logins as well
		$lQuery= '';
		//if(!validateEmail($email))
		
		//echo ' inside updateStudent ';
		//echo 'hidden = ' . $hidden;
		$oldemail = retrieveStudentEmail($id);
		//echo $oldemail ;
		$lQuery = "UPDATE logins
		SET username = '$email'
		where username = '$oldemail'";
		// don't update placed, leave it the same
		if($placed == -1) 
			$query = "UPDATE students
				  SET argus = '$argus', arguscertificate = '$arguscertificate', class = '$class', classes = '$classes', major = '$major', careertype = '$careertype', geopref = '$geopref', phone = '$phone', email = '$email' , permadd = '$permadd', schooladd = '$schooladd', placement1 = '$placement1', placement2 = '$placement2', placement3 = '$placement3', hidden = '$hidden', mba = '$mba'/*,employee='$employee'*/
				  WHERE id = '$id'";
		else
		
		$query = "UPDATE students
				  SET argus = '$argus', arguscertificate = '$arguscertificate', class = '$class', classes = '$classes', major = '$major', careertype = '$careertype', geopref = '$geopref', phone = '$phone', email = '$email' , permadd = '$permadd', schooladd = '$schooladd', placement1 = '$placement1', placement2 = '$placement2', placement3 = '$placement3', hidden = '$hidden', mba = '$mba', placed = '$placed'/*,employee='$employee'*/
				  WHERE id = '$id'";
			
			$result = mssql_query( $query );
			
			$lResult = FALSE;
		
			if( $result != FALSE )
				$lResult = mssql_query( $lQuery );
						
			if( !$result )
				showError( 'Error: Failed to update profile' );
			else
			{
				echo '<br />';
				showSuccessfulNotification( 'Profile successfully updated' );
				updateArgus($argus);
				updateArgusCertificate($arguscertificate);				
				updateClass($class);
				updateClasses($classes);
				updateMajor($major);
				updateCareerType($careertype);
				updateGeopref($geopref);
				updatePhone($phone);
				updateEmail($email);
				updatePermAdd($permadd );
				updateSchoolAdd($schooladd );
				updateIntplcmnt($intplcmnt );
				
				updatePlacement1($placement1);
				updatePlacement2($placement2);
				updatePlacement3($placement3);
				
				updateHidden($hidden);
				updateMBA($mba);
				updatePlaced($placed);
				/*updateEmployee($employee);*/
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );	
			if( !is_bool( $lResult ) )
				mssql_free_result( $lResult );		
	}
	
	function updateStudent2($id, $argus, $arguscertificate, $classes, $class, $major, $careertype, $geopref, $phone, $email, $permadd, $schooladd,$placement1, $placement2, $placement3,$hidden, $mba, $placed/*,$employee*/)
	{
	//	mssql_query( 'SET IDENTITY_INSERT students ON' );
	
	// if the email does not already exist, update the logins as well
		$lQuery= '';
		//if(!validateEmail($email))
		//echo ' For testing purposed\n';
		//echo ' inside updateStudent ';
		//echo 'hidden = ' . $hidden;
		$oldemail = retrieveStudentEmail($id);
		//echo $oldemail ;
		$lQuery = "UPDATE logins
		SET username = '$email'
		where username = '$oldemail'";
		// don't update placed, leave it the same
		if($placed == -1) 
			$query = "UPDATE students
				  SET argus = '$argus', arguscertificate = '$arguscertificate', class = '$class', classes = '$classes', major = '$major', careertype = '$careertype', geopref = '$geopref', phone = '$phone', email = '$email' , permadd = '$permadd', schooladd = '$schooladd', placement1 = '$placement1', placement2 = '$placement2', placement3 = '$placement3', hidden = '$hidden', mba = '$mba'/*,employee='$employee'*/
				  WHERE id = '$id'";
		else
		
		$query = "UPDATE students
				  SET argus = '$argus', arguscertificate = '$arguscertificate', class = '$class', classes = '$classes', major = '$major', careertype = '$careertype', geopref = '$geopref', phone = '$phone', email = '$email' , permadd = '$permadd', schooladd = '$schooladd', placement1 = '$placement1', placement2 = '$placement2', placement3 = '$placement3', hidden = '$hidden', mba = '$mba', placed = '$placed'/*,employee='$employee'*/
				  WHERE id = '$id'";
			
			$result = mssql_query( $query );
			
			$lResult = FALSE;
		
			if( $result != FALSE )
				$lResult = mssql_query( $lQuery );
						
			if( !$result )
				showError( 'Error: Failed to update profile' );
			else
			{
				echo '<br />';
				showSuccessfulNotification( 'Profile successfully updated' );
				/*updateArgus($argus);
				updateArgusCertificate($arguscertificate);				
				updateClass($class);
				updateClasses($classes);
				updateMajor($major);
				updateCareerType($careertype);
				updateGeopref($geopref);
				updatePhone($phone);
				updateEmail($email);
				updatePermAdd( $permadd );
				updateSchoolAdd( $schooladd );
				updateIntplcmnt( $intplcmnt );
				
				updatePlacement1( $placement1);
				updatePlacement2( $placement2);
				updatePlacement3( $placement3);
				
				updateHidden($hidden);
				updateMBA($mba);
				updatePlaced($placed);*/
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );	
			if( !is_bool( $lResult ) )
				mssql_free_result( $lResult );		
	}
	
	function displayCheckBoxes($caption,$options,$values)
	{
		echo '
				<tr>
					<td><strong>'.$caption.'</strong><br />';
		
		for( $x = 0; $x < sizeof( $options ); $x++ )
		{	
			$found = false;		
			$optionsParts = explode( '|', $options[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			for($y = 0; $y < sizeof($values); $y++)
			{
				if($values[$y] == '')
					break;
				if( $values[$y] == $x)
				{
					echo '&nbsp;&nbsp;<input type="checkbox" name="' . $optionValue . '" value="yes" ' .  'checked' . ' />&nbsp;&nbsp;&nbsp;' . $optionLabel . '<br>';
					$found = true; 
					break;
				}		
			}
			if(!$found)
					echo '&nbsp;&nbsp;<input type="checkbox" name="' . $optionValue . '" value="yes" ' . ' />&nbsp;&nbsp;&nbsp;' . $optionLabel . '<br>';
		}
	
		echo '
					</td>
				</tr>';
	}
	
	function tableSelectInput2( $name, $label, $options, $value, $error )
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
			
			echo '<option value="' . $optionValue . '" ' . ( ( $value == $x ) ? 'selected="selected"' : '' ) . '>' . $optionLabel . '</option>';
		}
		
		echo '
						</select>
					</td>
				</tr>';
	}
	
	function tableTextInput( $type, $name, $label, $size, $value, $error, $reminder, $required, $pattern )
	{
		echo '
				<tr>
					<td class="formItem"><strong>' . ( ( $error ) ? '<font color="#FF0000">*' . $label . '</font>' : $label ) . '</strong>';
					if($reminder==TRUE) {
						echo '<br>';
					}
					echo '<font class="formReminder">' . $reminder . '</font><br>&nbsp;&nbsp;<input size="' . $size . '" name="' . $name . '" type="' . $type . '" id="' . $name . '" value="' . $value . '"' . ( ( $required ) ? 'required="required"' : '' ) . ' '. ( ( $pattern == '' ) ? '' : 'pattern="' . $pattern . '" title="' . $label . '"' ) . ' /></td>
				</tr>';
	}
	
	function getCareerTypes($options)
	{
		$str = "";
		for( $x = 0; $x < sizeof( $options ); $x++ )
		{			
			$optionsParts = explode( '|', $options[$x] );
			$optionValue = $optionsParts[0];
			$optionLabel = $optionsParts[1];
			//echo $optionLabel;
			//echo $_POST[$optionValue];
			
			if($_POST[$optionValue] == "yes")
				$str = $str. $x . "|"; 	
		}
				
		return $str;
	}
	
	function retrieveStudentEmail( $id )
	{
		$query = "SELECT email
				  FROM students
				  WHERE id = '$id'";
		$result = mssql_query ( $query );
		$array = mssql_fetch_array( $result );		
		
		mssql_free_result( $result );
		
		return $array['email'];
	}
	
?>