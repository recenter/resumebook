<html>
<head>
</head>
<body>
<?php

//included helper files
	include 'main_helper.php';	

//checks for inactive users, then creates admin dashboard links (does not include Pending Users section)
	function displayWelcomeMenu()
	{
		checkInactiveUsers();
		echo '<h1>Welcome Admin</h1>
		<p>Server is running PHP version '.phpversion().'
		<form>
		<br />
		<h3 style="margin-bottom: -10px;"><a href="admin.php?action=mngst&amp;mode=all">All Students</a></h3>
		<h4><a href="admin.php?action=mngst&amp;mode=visible"><strong>&raquo;</strong> Visible Students Only</a></h4>
		<h3 style="margin-bottom: -10px;"><a href="admin.php?action=mngal&amp;mode=all">All Alumni</a></h3>
		<h4><a href="admin.php?action=mngal&amp;mode=visible"><strong>&raquo;</strong> Visible Alumni Only</a></h4>
		<h3><a href="admin.php?action=mngemp">Employers</a></h3><br />	
		<h3><a href="admin.php?action=mngjps">Job Postings</a></h3><br />
		</form>';
	}	

//handles displaying student info tables to admin, both visible and all, and sets $currentYear variable
	function displayStudents($mode)
	{		
		$currentYear = date('Y');

		if($mode == 'all')
		{
			echo '<h1>All Students</h1><br />';
			$query = "SELECT *
					  FROM students
					  WHERE class <> 0 AND class >= '$currentYear' AND hidden <= 1
					  ORDER BY class,lname";
		}
		else
		{
			echo '<h1>Visible Students Only</h1><br />';
			$query = "SELECT *
					  FROM students
					  WHERE class <> 0 AND class >= '$currentYear' AND hidden <= 0
					  ORDER BY class,lname";
		}
		
		echo '<table width="100%" class="table_fullBorder">';
	
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
			
			$major = '';			
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law', 7 =>'mba|MBA General', 8=> 'clas|CLAS' );
			
			for( $i = 0; $i < sizeof( $majorOptions ); $i++ )
			{
				$optionsParts = explode( '|', $majorOptions[$i] );
				$optionValue = $optionsParts[0];
				$optionLabel = $optionsParts[1];			
				
				if($student['major'] == $i)
				{
					//echo $student['major'].$optionValue;
					$major = $optionLabel;
					break;
				}
			}		
			
			
			echo '<tr>
					<td><ul><li><a href="admin.php?vsp=' . $student['id'] . '">' . $student['fname'] . ' ' . $student['lname'] . '</a> (<i>' . $class .' '.$major. '</i>)<ul><li><strong>Last Login</strong>: ';
			
			if( $student['lastlogin'] == '1000-01-01 00:00:00' || $student['lastlogin'] == NULL )
				echo 'Never</li>';
			else
				echo $student['lastlogin'] . '</li>';
				
			echo '<li><strong>PeopleSoft</strong>: ' . $student['psoft']. '</li>';
				
			$resume = $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<a href="resumes/index.php?id=' . $student['id'] . '">View Resume</a>';
			$confirmed = '';
			
			if( $user['approved'] == 2 )
				$confirmed = '<font color="#FF0000"><i>Rejected</i></font>';
			else if( $user['approved'] == 0 )
				$confirmed = '<font color="#CC9900"><i>Unconfirmed</i></font>';
			else if( $user['approved'] == 1 )
				$confirmed = '<font color="#347C17"><i>Approved</i></font>';
			
			echo '<li>' . $resume . '</li><li><strong>Status</strong>: ' . $confirmed . '</li>';
							
			$placement = $student['placement1']; //. ' ' . $student[''] . ' ' . $$student[''];
			$visibility = 'Visible';
			if($student['hidden'] == 1)
				$visibility = '<font color="#FF0000">Hidden</font>';
			$placed = 'Not Placed';
			if($student['placed'] == 1)
				$placed = '<font color="#0000FF">Placed</font>';
				
			echo '<li><strong>Placed?</strong>: ' . $placed . '</li>';
			echo '<li><strong>Latest Placement</strong>: ' . $placement . '</li>';
			echo '<li><strong>Profile Visibility</strong>: ' . $visibility . '</li>			
			</ul></li></ul>
			</td>
				</tr>';
			
			if( !is_bool( $sresult ) )
				mssql_free_result( $sresult );
		}
		
		echo '</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	
	function displayAlumni($mode)
	{		
		$currentYear = date('Y');
		
		//echo 'mode : ' . $mode;
		
		if($mode == 'all')
		{		
			echo '<h1>All Alumni</h1><br />';
			$query = "SELECT *
					  FROM students
					  WHERE (class = 0 OR class < '$currentYear') AND hidden <= 1
					  ORDER BY lname";
		}
		else
		{
			echo '<h1>Visible Alumni Only</h1><br />';
			$query = "SELECT *
					  FROM students
					  WHERE (class = 0 OR class < '$currentYear') AND hidden <= 0
					  ORDER BY lname";
		}
		$result = mssql_query( $query );
		
		echo '<table width="100%" class="table_fullBorder">';
		
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
				
			$class = ( $student['class'] == 0 ? 'Alumni' : 'Class of ' . $student['class'] );
			$major = '';			
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law', 7 =>'mba|MBA General', 8=> 'clas|CLAS' );
			
			for( $i = 0; $i < sizeof( $majorOptions ); $i++ )
			{
				$optionsParts = explode( '|', $majorOptions[$i] );
				$optionValue = $optionsParts[0];
				$optionLabel = $optionsParts[1];			
				
				if($student['major'] == $i)
				{
					$major = $optionLabel;
					break;
				}
			}		
			
			
			echo '<tr>
					<td><ul><li><a href="admin.php?vsp=' . $student['id'] . '">' . $student['fname'] . ' ' . $student['lname'] . '</a> (<i>' . $class .' '.$major. '</i>)<ul><li><strong>Last Login</strong>: ';		
			
			
			if( $student['lastlogin'] == '1000-01-01 00:00:00' || $student['lastlogin'] == NULL )
				echo 'Never</li>';
			else
				echo $student['lastlogin'] . '</li>';
				
			$resume = $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<a href="resumes/index.php?id=' . $student['id'] . '">View Resume</a>';
			$confirmed = '';
			
			if( $user['approved'] == 2 )
				$confirmed = '<font color="#FF0000"><i>Rejected</i></font>';
			else if( $user['approved'] == 0 )
				$confirmed = '<font color="#CC9900"><i>Unconfirmed</i></font>';
			else if( $user['approved'] == 1 )
				$confirmed = '<font color="#347C17"><i>Approved</i></font>';
			
			echo '<li>' . $resume . '</li><li><strong>Status</strong>: ' . $confirmed . '</li>';
							
			$placement = $student['placement1']; //. ' ' . $student[''] . ' ' . $$student[''];
			$visibility = 'Visible';
			if($student['hidden'] == 1)
				$visibility = '<font color="#FF0000">Hidden</font>';
				
			echo '<li><strong>Latest Placement</strong>: ' . $placement . '</li>';
			echo '<li><strong>Profile Visibility</strong>: ' . $visibility . '</li>			
			</ul></li></ul>
			</td>
				</tr>';
			
			if( !is_bool( $sresult ) )
				mssql_free_result( $sresult );
		}
		
		echo '</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	
	function displayEmployers( )
	{
		echo '<h1>Employers</h1><br />';
		
		echo '<table width="100%" class="table_fullBorder">';
		
		$currentYear = date('Y');
		
		$query = "SELECT *
				  FROM employers
				  ORDER BY lname";
		$result = mssql_query( $query );
		
		for( $x = 0; $x < mssql_num_rows( $result ); $x++ )
		{
			$employer = mssql_fetch_array( $result );
			
			$query = "SELECT approved
					  FROM logins
					  WHERE username = '$employer[email]'";			
			
			$sresult = mssql_query( $query );
			$user = mssql_fetch_array( $sresult );
			
			echo '<tr>
					<td><ul><li><a href="admin.php?emp=' . $employer['id'] . '">' . $employer['fname'] . ' ' . $employer['lname'] . '</a> (<i>' . $employer['company'] . '</i>)<ul><li><strong>Last Login</strong>: ';
			
			if( $employer['lastlogin'] == '1000-01-01 00:00:00'  || $employer['lastlogin'] == NULL)
				echo 'Never</li>';
			else
				echo $employer['lastlogin'] . '</li>';	
				
			echo '<li><strong>Registred Date</strong>: ' . $employer['regdate']. '</li>';				
			
			$confirmed = '';
			
			if( $user['approved'] == 2 )
				$confirmed = '<font color="#FF0000"><i>Rejected</i></font>';
			else if( $user['approved'] == 0 )
				$confirmed = '<font color="#CC9900"><i>Unconfirmed</i></font>';
			else if( $user['approved'] == 1 )
				$confirmed = '<font color="#347C17"><i>Approved</i></font>';
			
			echo '<li><strong>Status</strong>: ' . $confirmed . '</li></ul></li></ul></td>
				</tr>';
			
			if( !is_bool( $sresult ) )
				mssql_free_result( $sresult );
		}
		
		echo '</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	
	function displayAdminStudentNotifications( )
	{
		$query = "SELECT *
				  FROM logins
				  WHERE approved = 0 AND access < 3";
		
		$result = mssql_query( $query );
		
		
		echo '
				<table width="100%" class="table_topBorder">
				<th><h2>Pending Users</h2></th>';
		
		if( mssql_num_rows( $result ) < 1 )
		{	
			echo '
					<tr>
						<td><strong><i>No pending requests at this time</i></strong></td>
					</tr>';
		}
		else
		{			
			for( $x = 0; $x < mssql_num_rows( $result ); $x++ )
			{				
				$user = mssql_fetch_array( $result );
				$username = $user['username'];
				$query = "";
				
				
				if( preg_match( "/^[0-9]{7}$/", $user['username'] ) )
				{
					//echo $username."inside";
					$query = "SELECT id, fname, lname, class, regdate
							  FROM students
							  WHERE psoft = '$username'";
				}
				else if($user['access'] == 2)
				{
					$query = "SELECT id, fname, lname, company, regdate
							  FROM employers
							  WHERE email = '$username'";
				}
				else
				{
					$query = "SELECT id, fname, lname, class, regdate
							  FROM students
							  WHERE email = '$username'";
				}
				
				$sresult = mssql_query( $query );
				
				if( mssql_num_rows( $sresult ) >= 1 )
				{
					if($user['access'] == 2)
					{
						$employer = mssql_fetch_array( $sresult );								
						
						echo '
								<tr>
									<td><strong>' . $employer['regdate'] . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?emp=' . $employer['id'] . '">' . $employer['fname'] . ' ' . $employer['lname'] . '</a> (<i>' . $employer['company'] . '</i>)</td>
								</tr>';
					}
					else
					{
						$student = mssql_fetch_array( $sresult );			
						
						$class = ( $student['class'] == 0 ? 'Alumni' : $student['class'] );					
						
						echo '
								<tr>
									<td><strong>' . $student['regdate'] . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php?vsp=' . $student['id'] . '">' . $student['fname'] . ' ' . $student['lname'] . '</a> (<i>' . $class . '</i>)</td>
								</tr>';
					}
				}
						
				if( !is_bool( $sresult ) )
					mssql_free_result( $sresult );
			}
		}
		
		echo '
				</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}
	// editable fields
	function displayStudentProfile2( $id )
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
			$student = mssql_fetch_array( $result );
			
			$isStudent = ( $student['class'] == 0 ? false : true );
			$mba = $student['mba'];
			$hidden = $student['hidden'];
			$studentPlaced = $student['placed'];
			$argus = $student['argus'];
			$arguscertificate = $student['arguscertificate'];					
			$class = $student['class'];
			$classes = explode( '|',$student['classes']);
			$major = $student['major'];
			$careertype = explode( '|',$student['careertype']);
			//echo 'career'.$careertype[0];
			$geopref = $student['geopref'];
			$phone = $student['phone'];
			$email = $student['email'];
			$padd = explode( '|', $student['permadd'] );
			$permadd_add = $padd[0];
			$permadd_city = $padd[1];
			$permadd_state = $padd[2];
			$permadd_zip = $padd[3];
			
			$placement1 =  explode( '|', $student['placement1']);	
			$placement1_companyName = $placement1[0];
			$placement1_startDate = $placement1[1];
			$placement1_jobType = $placement1[2];
			$placement1_jobClass = $placement1[3];
			$placement2 =  explode( '|', $student['placement2']);
			$placement2_companyName = $placement2[0];
			$placement2_startDate = $placement2[1];
			$placement2_jobType = $placement2[2];
			$placement2_jobClass = $placement2[3];
			$placement3 =  explode( '|', $student['placement3']);				
			$placement3_companyName = $placement3[0];
			$placement3_startDate = $placement3[1];
			$placement3_jobType = $placement3[2];
			$placement3_jobClass = $placement3[3];
			
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law', 7 =>'mba|MBA General', 8=> 'clas|CLAS' );
	$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey');//, 6 => 'np|No Preference' );
	$classesOptions = array( 0 => 'f3230|Fnce 3230 (Real Estate Principles)', 1 => 'f3332|Fnce 3332 (Real Estate Investments)', 2 => 'f3333|Fnce 3333 (Real Estate Finance)', 3 => 'f3334|Fnce 3334 (GIS Applications in Real Estate Markets)', 4 => 'b3274|BLaw 3274 (Real Estate Law)', 5 => 'f3302|Fnce 3302 (Investements and Security Analysis)', 6 => 'e3439w|Econ 3439W (Urban and Regional Economics)', 7 => 'e2327|Econ 2327 ( Information Technology for Economics)' , 8 => 'f4895|Fnce 4895 (Real Estate Appraisal)');		
	$careerTypeList = array( 0 => 'app|Valuation/Appraisal', 1 => 'bro|Brokerage/Sales (Commercial Property)', 2 => 'Inv|Investments/ Private Equity', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|No Job Function Preference', 8=> 'assetmang|Asset Management', 9=> 'corprealestate|Corporate Real Estate', 10=> 'law|Law', 11=>'lendbank|Lending/Banking', 11=> 'structprod|Structured Financial Products/ Mortgage Backed Securities');
	
						echo '
						<table width="100%" class="table_topBorder">
							<tr>
								<td><h2>'.$student['fname'] . ' ' . $student['lname'] . '</h2>';

						if($class == 0 || $class < date('Y'))
							echo'<a href="admin.php?action=mngal&amp;mode=all">< Back</a></td>';
						else
							echo'<a href="admin.php?action=mngst&amp;mode=all">< Back</a></td>';

						echo '	
							</tr>
						</table>
						<form name="stprof" id="stprof" method="post" action="admin.php?action=editprof&amp;sub=submit&amp;id=' . $id . '">
						<table width="100%" class="table_topBorder">
							<tr>
								<td>&nbsp;&nbsp;<input type="checkbox" name="profileHidden" value="yes" ' . ( $hidden == "1" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<font color="#FF0000">Hide profile from employers search</font></td>
							</tr>
							<th style="border-bottom:1px solid #cccccc;">
                  				<br><b><font size="+1">About</font></b><br>
                			</th>
							<tr>
								<td>&nbsp;&nbsp;<input type="checkbox" name="studentPlaced" value="yes" ' . ( $studentPlaced == "1" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;Student is placed</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<input type="checkbox" name="argustut" value="yes" ' . ( $argus == "1" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;Student is taking or has taken the ARGUS class</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<input type="checkbox" name="arguscertificate" value="yes" ' . ( $arguscertificate == "1" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;Student is ARGUS certified</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;<input type="checkbox" name="undergradOrMBA" value="yes" ' . ( $mba == "1" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;MBA student</td>
							</tr>';

						tableSelectInput2( 'major', 'Major', $majorOptions, $major, NULL );

						echo '
							<th style="border-bottom:1px solid #cccccc;">
                  				<br><b><font size="+1">Job Perferences & History</font></b><br>
                			</th>';

						displayCheckBoxes("Desired Job Functions:", $careerTypeList, $careertype);
						tableSelectInput2( 'geopref', 'Geographical Preference', $locationOptions, $geopref, NULL );

						echo '
							
							<th><h2>Placement (most recent first)</h2></th>
							<tr>
								<td><strong>Company Name</strong>
								<input type="text" name="companyName1" value="' . $placement1_companyName . ' " size="25" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							
								<strong>Start Date</strong>
								<input type="text" name="startDate1" value="' . $placement1_startDate . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>Job Type</strong>
								<input type="text" name="jobType1" value="' . $placement1_jobType . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    			<input type="checkbox" name="jobClass1" value="yes" '.($placement1_jobClass=='1' ? 'checked' : '').'/>
                    			<strong>Internship?</strong>
								</td>
							</tr>							
							<tr>
								<td><strong>Company Name</strong>
								<input type="text" name="companyName2" value="' . $placement2_companyName . '" size="25" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;							
								<strong>Start Date</strong>
								<input type="text" name="startDate2" value="' . $placement2_startDate . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>Job Type</strong>
								<input type="text" name="jobType2" value="' . $placement2_jobType . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    			<input type="checkbox" name="jobClass2" value="yes" '.($placement2_jobClass=='1' ? 'checked' : '').'/>
                    			<strong>Internship?</strong>
                    			</td>
							</tr>
							<tr>
								<td><strong>Company Name</strong>
								<input type="text" name="companyName3" value="' . $placement3_companyName . '" size="25" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;						
								<strong>Start Date</strong>
								<input type="text" name="startDate3" value="' . $placement3_startDate . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>Job Type</strong>
								<input type="text" name="jobType3" value="' . $placement3_jobType . '" size="10" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			                    <input type="checkbox" name="jobClass3" value="yes" '.($placement3_jobClass=='1' ? 'checked' : '').'/>
			                    <strong>Internship?</strong>
								</td>
							</tr>
							<th style="border-bottom:1px solid #cccccc;">
                  					<br><b><font size="+1">Personal</font></b><br>
                			</th>';

						tableTextInput( 'text', 'phone', 'Phone', '', $phone, $errorCode['phone'], '(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$' );
						tableTextInput( 'email', 'email', 'E-mail', 30, $email, $errorCode['email'], '', true, '' );
							
						echo '
							<th><h2>Permanent Address</h2></th>
							<tr>
								<td><strong>Address</strong><br />
								&nbsp;&nbsp;<input type="text" name="padd" value="' . $permadd_add . '" size="50" /></td>
							</tr>
							<tr>

								<td><strong>City</strong><br />
								&nbsp;&nbsp;<input type="text" name="pcity" value="' . $permadd_city . '" size="10" /></td>
							</tr>
							<tr>
								<td><strong>State</strong><br />
								&nbsp;&nbsp;<input type="text" name="pstate" value="' . $permadd_state . '" size="2" /></td>
							</tr>
							<tr>
								<td><strong>Zip Code</strong><br />
								&nbsp;&nbsp;<input type="text" name="pzip" value="' . $permadd_zip . '" size="5" /></td>
							</tr>';
						
						if( $student['class'] != 0 )
						{
							$schooladd_add = '';
							$schooladd_city = '';
							$schooladd_state = '';
							$schooladd_zip = '';

						if( $student['class'] != 0 && $student['class'] >= date('Y') )
							{
								echo '
								<th style="border-bottom:1px solid #cccccc;">
                  					<br><b><font size="+1">Student Info</font></b><br>
                				</th>
								<tr>
									<td><strong>Class</strong><br />
									&nbsp;&nbsp;<input type="text" name="class" value="' . $class . '" size="25" /></td>
								</tr>';	
								displayCheckBoxes("Check the courses you have or are currently taking:",$classesOptions,$classes);

								echo '
								<th><h2>School Address</h2></th>
								<tr>
									<td><strong>Address</strong><br />
									&nbsp;&nbsp;<input type="text" name="sadd" value="' . $schooladd_add . '" size="50" /></td>
								</tr>
								<tr>
									<td><strong>City</strong><br />
									&nbsp;&nbsp;<input type="text" name="scity" value="' . $schooladd_city . '" size="10" /></td>
								</tr>
								<tr>
									<td><strong>State</strong><br />
									&nbsp;&nbsp;<input type="text" name="sstate" value="' . $schooladd_state . '" size="2" /></td>
								</tr>
								<tr>
									<td><strong>Zip Code</strong><br />
									&nbsp;&nbsp;<input type="text" name="szip" value="' . $schooladd_zip . '" size="5" /></td>
								</tr>';								
							}
						
							if( $student['schooladd'] != '' )
							{
								$sadd = explode( '|', $student['schooladd'] );
								$schooladd_add = $sadd[0];
								$schooladd_city = $sadd[1];
								$schooladd_state = $sadd[2];
								$schooladd_zip = $sadd[3];
							}
							
						}
						/*
						$intplcmnt = getValueFromArrayIndex( $internshipOptions, $_SESSION['intplcmnt'] );
						
						tableSelectInput( 'intplcmnt', '<h2>Internship Placement Preference</h2>', $internshipOptions, $intplcmnt, NULL );*/
						
						echo '
							<tr>
								<td><br><input type="submit" name="submit" class="loginButton" value="Save Changes" /></td>
							</tr>
							</table>
							</form>';
							
						if( $student['class'] != 0 )
						{
							$query = "SELECT approved
									  FROM logins
									  WHERE username = '$student[psoft]'";
						}
						else
						{
							$query = "SELECT approved
									  FROM logins
									  WHERE username = '$student[email]'";
						}
						
						$result = mssql_query( $query );
						$user = mssql_fetch_array( $result );
						
						if( $user['approved'] == 0 )
						{
							echo '<br /><form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;id=' . $id . '"><input type="submit" name="submit" class="loginButton" value="Approve" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>';
						}
						else if( $user['approved'] == 2 )
						{
							echo '<hr><br />Status: <font color="#FF0000"><strong><i>Rejected</i></strong></font><br>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" class="loginButton" action="admin.php?action=approve&amp;id=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Approve" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;id=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Student" /></form>';
						}
						else if( $user['approved'] == 1 )
						{
							echo '<hr><br />Status: <font color="#347C17"><strong><i>Approved</i></strong></font><br>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;id=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;id=' . $id . '">&nbsp;&nbsp;<input type="submit" class="loginButton" name="submit" value="Delete Student" /></form>';
						}
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
		}
	
	}
	
	// read only fields
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
			$student = mssql_fetch_array( $result );
			
			$isStudent = ( $student['class'] == 0 ? false : true );
			
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law' );
	$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey');//, 6 => 'np|No Preference' );
	$classesOptions = array( 0 => 'f3230|Fnce 3230 (Real Estate Principles)', 1 => 'f3332|Fnce 3332 (Real Estate Investments)', 2 => 'f3333|Fnce 3333 (Real Estate Finance)', 3 => 'f3334|Fnce 3334 (GIS Applications in Real Estate Markets)', 4 => 'b3274|BLaw 3274 (Real Estate Law)', 5 => 'f3302|Fnce 3302 (Investements and Security Analysis)', 6 => 'e3439w|Econ 3439W (Urban and Regional Economics)', 7 => 'e2327|Econ 2327 ( Information Technology for Economics)' , 8 => 'f4895|Fnce 4895 (Real Estate Appraisal)');		
	$careerTypeList = array( 0 => 'app|Valuation/Appraisal', 1 => 'bro|Brokerage/Sales (Commercial Property)', 2 => 'Inv|Investments/ Private Equity', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|No Job Function Preference', 8=> 'assetmang|Asset Management', 9=> 'corprealestate|Corporate Real Estate', 10=> 'law|Law', 11=>'lendbank|Lending/Banking', 11=> 'structprod|Structured Financial Products/ Mortgage Backed Securities');
		/*	
			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law' );
			$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey', 6 => 'np|No Preference' );
			$classesOptions = array( 0 => 'f3230|Fnce 3230', 1 => 'f3332|Fnce 3332', 2 => 'f3333|Fnce 3333', 3 => 'f3334|Fnce 3334', 4 => 'b3274|BLaw 3274', 5 => 'f3302|Fnce 3302', 6 => 'e3439w|Econ 3439W', 7 => 'e2327|Econ 2327' );
			$careertypeOptions = array( 0 => 'app|Appraisal', 1 => 'bro|Brokerage', 2 => 'Inv|Investment', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|Open' );*/
			
			echo '
					<table width="100%" class="table_topBorder">
					<th><h2>' . $student['fname'] . ' ' . $student['lname'] . ' (' . ( ( $isStudent ) ? '<i>' . $student['class'] . '</i>' : '<i>Alumni</i>' ) . ') </h2></th>';
			
			if( $isStudent )
			{
				echo'
					<tr>
						<td><input type="checkbox" name="argustut" value="yes" onclick="javascript: return false;" ' . ( $student['argus'] ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS class</strong><br /></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="arguscertificate" value="yes" onclick="javascript: return false;" ' . ( $student['arguscertificate'] ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong>ARGUS Certificate</strong><br /></td>
					</tr>
					<tr>
						<td><strong>Real Estate Classes</strong><br />';
			
				if( $student['classes'] == NULL || $student['classes'] == '' )
					echo '<i>None</i>';
				else
				{
					$classes = explode( '|', $student['classes'] );
				
					for( $x = 0; $x < sizeof( $classes ); $x++ )
					{
						$classname = getValueFromArrayIndex( $classesOptions, $classes[$x] );
						
						if( $classname != NULL )
							echo '<input type="checkbox" name="class" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $classname . '&nbsp;&nbsp;&nbsp;';
					}
				}
				echo '
				</td>
					</tr>';
			}
			
			$class = ( $student['class'] == 0 ? 'Alumni' : $student['class'] );
			$major = getValueFromArrayIndex( $majorOptions, $student['major'] );
			$geopref = getValueFromArrayIndex( $locationOptions, $student['geopref'] );
			
			echo '
						
					<tr>
						<td><strong>Class</strong><br /><input type="text" name="class" value="' . $class . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Major</strong><br /><input type="text" name="major" value="' . $major . '" size="30" readonly /></td>
					</tr>';
			if( $isStudent )
			{
				echo '
				<tr>
						<td><strong>Job Functions</strong><br />';
				if( $student['careertype'] == NULL || $student['careertype'] == '' )
						echo '<i>None</i>';
				else
				{
					$careertypes = explode( '|', $student['careertype'] );
				
					for( $x = 0; $x < sizeof( $classes ); $x++ )
					{
						$careertypename = getValueFromArrayIndex( $careerTypeList, $careertypes[$x] );
						
						if( $careertypename != NULL )
							echo '<input type="checkbox" name="class" value="yes" onclick="javascript: return false;" checked />&nbsp;&nbsp;&nbsp;' . $careertypename . '&nbsp;&nbsp;&nbsp;';
					}
				}
				echo '
				</td>
					</tr>';
			}
					echo '
					<tr>
						<td><strong>Geographical Preference</strong><br /><input type="text" name="geopref" value="' . $geopref . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Phone</strong><br /><input type="text" name="phone" value="' . $student['phone'] . '" size="30" readonly /></td>
					</tr>';
			
			if( $isStudent )
			{
				echo'
					<tr>
						<td><strong>Peoplesoft</strong><br /><input type="text" name="psoft" value="' . $student['psoft'] . '" size="30" readonly /></td>
					</tr>';
			}
			
			echo '
					<tr>
						<td><strong>E-mail</strong><br /><input type="text" name="email" value="' . $student['email'] . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>Resume</strong><br />' . ( $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<font size="+1"><a href="resumes/index.php?id=' . $id . '">View Resume</a></font>' ) . '</td>
					</tr>
					</table>';
					
			if( $isStudent )
			{
				$query = "SELECT approved
					  	  FROM logins
					  	  WHERE username = '$student[psoft]'";
			}
			else
			{
				$query = "SELECT approved
						  FROM logins
						  WHERE username = '$student[email]'";
			}
			
			$result = mssql_query( $query );
			$user = mssql_fetch_array( $result );
			
			if( $user['approved'] == 0 )
			{
				echo '<br /><form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;id=' . $id . '"><input type="submit" name="submit" class="loginButton" value="Approve" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>';
			}
			else if( $user['approved'] == 2 )
			{
				echo '<br /><font color="#FF0000"><strong><i>Rejected</i></strong></font><hr>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;id=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Approve" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;id=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Student" /></form>';
			}
			else if( $user['approved'] == 1 )
			{
				echo '<br /><font color="#347C17"><strong><i>Approved</i></strong></font><hr>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;id=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;id=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Student" /></form>';
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );
		}
	}
	
	// editable fields
	function displayEmployerProfile2( $id )
	{
		$query = "SELECT *
				  FROM employers
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
			$employer = mssql_fetch_array( $result );	
			
			$company = $employer['company'];
			$phone = $employer['phone'];
			$email = $employer['email'];
			$website = $employer['website'];
			$geopref = $employer['geopref'];
			$careertype = explode( '|',$employer['careertype']);
			$openingtype =  $employer['openingtype'];
			$experience = $employer['experience'];		
						
			echo '
				<br />
				<form name="stprof" id="stprof" method="post" action="admin.php?action=editeEmpProf&amp;sub=submit&amp;id=' . $id . '">
				<table width="100%" class="table_topBorder">
				<th><h2>' . $employer['fname'] . ' ' . $employer['lname'] .'</h2></th>
				<tr>
					<td><a href="admin.php?action=mngemp&amp;mode=all">< Back</a></td>
				</tr>
				<th style="border-bottom:1px solid #cccccc;">
                	<br><b><font size="+1">Company Info</font></b><br>
                </th>';
				
			tableTextInput( 'text', 'company', 'Company Name', 50, $company, $errorCode['company'], '', true, '' );
			tableTextInput( 'text', 'phone', 'Company Phone', '', $phone, $errorCode['phone'], '(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$' );						
			tableTextInput( 'text', 'website', 'Company Website', 30, $website, $errorCode['website'], '', true, '' );	
			tableTextInput( 'text', 'email', 'Company Contact E-mail', 30, $email, $errorCode['email'], '', true, '' );

			echo '
				<th style="border-bottom:1px solid #cccccc;">
                	<br><b><font size="+1">Job Opening</font></b><br>
                </th>';	

			$majorOptions = array( 0 => 'acct|Accounting', 1 => 'fin|Finance', 2 => 're|Real Estate', 3 => 'mgmt|Management', 4 => 'mark|Marketing', 5 => 'econ|Economics', 6 => 'blaw|Business Law', 7 =>'mba|MBA General', 8=> 'clas|CLAS' );
	$locationOptions = array( 0 => 'ny|New York', 1 => 'stfrd|Stamford', 2 => 'nh|New Haven', 3 => 'bost|Boston', 4 => 'htfrd|Hartford', 5 => 'nj|New Jersey');//, 6 => 'np|No Preference' );
	$classesOptions = array( 0 => 'f3230|Fnce 3230 (Real Estate Principles)', 1 => 'f3332|Fnce 3332 (Real Estate Investments)', 2 => 'f3333|Fnce 3333 (Real Estate Finance)', 3 => 'f3334|Fnce 3334 (GIS Applications in Real Estate Markets)', 4 => 'b3274|BLaw 3274 (Real Estate Law)', 5 => 'f3302|Fnce 3302 (Investements and Security Analysis)', 6 => 'e3439w|Econ 3439W (Urban and Regional Economics)', 7 => 'e2327|Econ 2327 ( Information Technology for Economics)' , 8 => 'f4895|Fnce 4895 (Real Estate Appraisal)');	
	$internshipOptions = array( 0 => 'apval|Appraisal', 1 => 'brok|Brokerage', 2 => 'inv|Investment', 3 => 'mgtfin|Developement', 4 => 'mktan|Marketing', 5 => 'finan|Counseling', 6 => 'pmgmt|Property Management', 7 => 'o|Other' );
	$employeeOptions = array( 0 => 'int|Internship', 1 => 'eftime|Entry Level Full Time', 2 => 'ftime|Full Time' );
	$experienceOptions = array( 0 => 'na|None', 1 => '123|1-3', 2 => '325|3-5', 3 => '5p|5+', 4 => '10p|10+' );
	// Structured financial products/ mortgage backed securities
	$careerTypeList = array( 0 => 'app|Valuation/Appraisal', 1 => 'bro|Brokerage/Sales (Commercial Property)', 2 => 'Inv|Investments/ Private Equity', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|No Job Function Preference', 8=> 'assetmang|Asset Management', 9=> 'corprealestate|Corporate Real Estate', 10=> 'law|Law', 11=>'lendbank|Banking/Real Estate Lending', 12=> 'structprod|Structured Financial Products/ Mortgage Backed Securities');
			
			tableSelectInput2( 'openingtype', 'Opening Type', $employeeOptions, $openingtype, $errorCode['openingtype'], '' );
			tableSelectInput2( 'experience', 'Necessary Experience (Years)', $experienceOptions, $experience, $errorCode['experience'], '' );
			tableSelectInput2( 'geopref', 'Geographical Location of the job', $locationOptions, $geopref, $errorCode['geo'], '' );

			displayCheckBoxes("Job Functions (Check all that apply):", $careerTypeList, $careertype);													
						
			echo '
			<tr>
				<td><br><input type="submit" name="submit" class="loginButton" value="Save Changes" /></td>
			</tr>
			</table>
			</form>';
			
			$query = "SELECT approved
					  FROM logins
					  WHERE username = '$employer[email]'";
			$result = mssql_query( $query );
			$user = mssql_fetch_array( $result );
			
			if( $user['approved'] == 0 )
			{
				echo '<br /><form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '"><input type="submit" name="submit" class="loginButton" value="Approve" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>';
			}
			else if( $user['approved'] == 2 )
			{
				echo '<hr><br />Status: <font color="#FF0000"><strong><i>Rejected</i></strong></font><br>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Approve" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;empid=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Employer" /></form>';
			}
			else if( $user['approved'] == 1 )
			{
				echo '<hr><br />Status: <font color="#347C17"><strong><i>Approved</i></strong></font><br>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;empid=' . $id . '">&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Employer" /></form>';
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );
		}
	}
	
	// read only fields
	function displayEmployerProfile( $id )
	{
		$query = "SELECT *
				  FROM employers
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
			$employer = mssql_fetch_array( $result );	
			
			echo '
					<table width="100%" class="table_topBorder">
					<th><h2>' . $employer['fname'] . ' ' . $employer['lname'] .'</h2></th>';
			
			echo '
						</td>
					</tr>
					<tr>
						<td><strong>Company Name</strong><br /><input type="text" name="class" value="' . $employer['company'] . '" size="30" readonly /></td>
					</tr>	
					<tr>
						<td><strong>Website</strong><br /><input type="text" name="phone" value="' . $employer['website'] . '" size="30" readonly /></td>
					</tr>				
					<tr>
						<td><strong>Phone</strong><br /><input type="text" name="phone" value="' . $employer['phone'] . '" size="30" readonly /></td>
					</tr>
					<tr>
						<td><strong>E-mail</strong><br /><input type="text" name="email" value="' . $employer['email'] . '" size="30" readonly /></td>
					</tr>					
					</table>';
			
				$query = "SELECT approved
						  FROM logins
						  WHERE username = '$employer[email]'";
			$result = mssql_query( $query );
			$user = mssql_fetch_array( $result );
			
			if( $user['approved'] == 0 )
			{
				echo '<br /><form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '"><input type="submit" name="submit" class="loginButton" value="Approve" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>';
			}
			else if( $user['approved'] == 2 )
			{
				echo '<br /><font color="#FF0000"><strong><i>Rejected</i></strong></font><hr>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Approve" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;empid=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Employer" /></form>';
			}
			else if( $user['approved'] == 1 )
			{
				echo '<br /><font color="#347C17"><strong><i>Approved</i></strong></font><hr>&nbsp;&nbsp;&nbsp;<form name="approve" id="approve" method="post" action="admin.php?action=approve&amp;empid=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Reject" /></form>&nbsp;&nbsp;&nbsp;<form name="delst" id="delst" method="post" action="admin.php?action=delete&amp;empid=' . $id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" class="loginButton" value="Delete Employer" /></form>';
			}
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );
		}
	}
	
	function sendStudentAcceptanceMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Student Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your acceptance into the Real Estate Resume Book. At this time, you may log into the website by using your PeopleSoft number as your username, along with the password you chose during registration. Please follow this <a href="http://www3.business.uconn.edu/reresume/RealEstate/ResumeBook/Resume_template.docx">template</a> when you prepare your resume to be uploaded. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}
	
	function sendAlumniAcceptanceMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Alumni Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your acceptance into the Real Estate Resume Book. At this time, you may log into the website by using your email address as your username, along with the password you chose during registration. Please follow this <a href="http://www3.business.uconn.edu/reresume/RealEstate/ResumeBook/Resume_template.docx">template</a> when you prepare your resume to be uploaded. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}
	
	function sendEmployerAcceptanceMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Employer Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message confirming your acceptance into the Real Estate Resume Book. At this time, you may log into the website by using your email address as your username, along with the password you chose during registration. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}
	
	function sendStudentRejectionMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Student Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message notifying you that your registration for the Real Estate Resume Book was rejected. At this time, we are not able to extend our services to you. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}	
	
	function sendAlumniRejectionMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Alumni Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message notifying you that your registration for the Real Estate Resume Book was rejected. At this time, we are not able to extend our services to you. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}	
	
	function sendEmployerRejectionMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Employer Registration";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>This is an automated message notifying you that your registration for the Real Estate Resume Book was rejected. At this time, we are not able to extend our services to you. If you have any questions or concerns, please reply back to this e-mail.<br /><br />Thank you,<br />UCONN Real Estate Department';
							
		if( !mail( $email, $subject, $message, $headers ) )
			echo "mail Error";
	}
	
	function sendStudentInactivityMail( $fname, $lname, $email )
	{
		$subject = "Real Estate Resume Book Inactivity Notification";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "To: " . $fname . " " . $lname . "<" . $email . ">\r\n";
		$headers .= "From: Real Estate Resume Book <recenter@business.uconn.edu>\r\n";
		
		$message = '<a href="http://www3.business.uconn.edu/reresume/"><img src="http://www3.business.uconn.edu/reresume/images/banner.png" width="700" height="78"></a><br /><br />Hello <strong>' . $fname . '</strong>,<br /><br/>Your resume on the Real Estate Center resume book web site is no longer visible, as you have not logged into your account in the past six months.  Please be sure to update your resume and log into your resume book account in order to reactivate your account.  We continually have potential employers check this site and the Real Estate Center uses it as a reference for other employment opportunities.<br><br>Please Debbie if you have any questions or concerns regarding your resume posting.<br><br>Thank you,<br />UCONN Real Estate Department';
							
		mail($email, $subject, $message, $headers);
	}

	function checkInactiveUsers()
	{
		$currentYear = date('Y');
		
		$query = "SELECT *
				  FROM students
				  WHERE hidden = 0 AND ((lastlogin = NULL  AND (GETDATE() - regdate) >= 180) OR ((GETDATE() -  lastlogin) >= 180))
				  ORDER BY class,lname";		
	
		$result = mssql_query( $query );
		
		//echo '<table width="100%" class="table_fullBorder">';
		
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
			
			$query = "UPDATE students
						SET hidden = 1
						WHERE id = '$student[id]'";
						
			$uresult = mssql_query( $query );
			
			
			sendStudentInactivityMail($student['fname'],$student['lname'],$student['email']);
			//sendStudentInactivityMail('samir', 'elsayed', 'samir.a.mohamed@gmail.com');
				
			/*$class = ( $student['class'] == 0 ? 'Alumni' : 'Class of '.$student['class'] );
			
			echo '<tr>
					<td><ul><li><a href="admin.php?vsp=' . $student['id'] . '">' . $student['fname'] . ' ' . $student['lname'] . '</a> (<i>' . $class . '</i>)<ul><li><strong>Last Login</strong>: ';
			
			if( $student['lastlogin'] == '1000-01-01 00:00:00' || $student['lastlogin'] == NULL )
				echo 'Never</li>';
			else
				echo $student['lastlogin'] . '</li>';
				
			$resume = $student['resume'] == '' ? '<font color="#FF0000">Resume Not Uploaded</font>' : '<a href="resumes/index.php?id=' . $student['id'] . '">View Resume</a>';
			$confirmed = '';
			
			if( $user['approved'] == 2 )
				$confirmed = '<font color="#FF0000"><i>Rejected</i></font>';
			else if( $user['approved'] == 0 )
				$confirmed = '<font color="#CC9900"><i>Unconfirmed</i></font>';
			else if( $user['approved'] == 1 )
				$confirmed = '<font color="#347C17"><i>Approved</i></font>';
			
			echo '<li>' . $resume . '</li><li><strong>Status</strong>: ' . $confirmed . '</li>';
							
			$placement = $student['placement1']; //. ' ' . $student[''] . ' ' . $$student[''];
			$visibility = 'Visible';
			if($student['hidden'] == 1)
				$visibility = '<font color="#FF0000">Hidden</font>';
				
			echo '<li><strong>Latest Placement</strong>: ' . $placement . '</li>';
			echo '<li><strong>Profile Visibility</strong>: ' . $visibility . '</li>			
			</ul></li></ul>
			</td>
				</tr>';*/
			
			if( !is_bool( $sresult ) )
				mssql_free_result( $sresult );
				
			if( !is_bool( $uresult ) )
				mssql_free_result( $uresult );
		}
		
		//echo '</table>';
		
		if( !is_bool( $result ) )
			mssql_free_result( $result );
	}

?>
</body>
</html>