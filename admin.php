<?php include 'header.php'; include 'session.php'; include 'php_helper/admin_helper.php'; ?>
	  <!-- InstanceBeginEditable name="content" -->       
      <SCRIPT TYPE="text/javascript">
	  <!--
		function popup( mylink, windowname )
		{
			if( !window.focus )
				return true;
			var href;
			if( typeof( mylink ) == 'string' )
				href = mylink;
			else
   				href = mylink.href;
			window.open( href, windowname, 'width=275, height=50, scrollbars=no' );
			return false;
		}
	 //-->
	 </SCRIPT>
      <?php			
//			<A HREF="popupbasic.html" onClick="return popup(this, 'stevie')">my popup</A>

			//$studentID = 0;
			
			if( !isLoggedIn( ) )
			{
				header( 'Location: index.php?error=2' );				
				die( );
			}
			else
			{
				if( $_GET['error'] == 1 )
					showError( 'Error: Unknown Student ID' );
				
				if( $_SESSION['access'] == 0 || $_SESSION['access'] == 1 || $_SESSION['access'] == 2 )
				{
					header( 'Location: index.php?error=3' );
					die( );
				}
				
				if( $_GET['vsp'] != NULL || $_GET['vsp'] != '' )
				{
					$_SESSION['studentID'] = $_GET['vsp'];
					//displayStudentProfile( $_GET['vsp'] );
					displayStudentProfile2($_GET['vsp'] );
				}
				else if($_GET['emp'] != NULL || $_GET['emp'] != '' )
				{
					$_SESSION['employerID'] = $_GET['emp'];
					//displayEmployerProfile($_GET['emp']);
					displayEmployerProfile2($_GET['emp']);
				}
				else if( $_GET['action'] == 'approve' && $_GET['id'] != '' )
				{
					$query = "SELECT fname, lname, email, psoft, class
							  FROM students
							  WHERE id = '$_GET[id]'";
					$result = mssql_query( $query );					
					$user = mssql_fetch_array( $result );
					$psoft = $user['psoft'];
					$email = $user['email'];
					
					if( !is_bool( $result ) )
						mssql_free_result( $result );
					
					if( $_POST['submit'] == 'Approve' )
					{
						if( $user['class'] == 0 )
						{
							$query = "UPDATE logins
									  SET approved = 1
									  WHERE username = '$email'";
						}
						else
						{
							$query = "UPDATE logins
									  SET approved = 1
									  WHERE username = '$psoft'";
						}
						
						$result = mssql_query( $query );						
						
						
						if( $user['class'] != 0 )
							sendStudentAcceptanceMail( $user['fname'], $user['lname'], $user['email'] );
						else
							sendAlumniAcceptanceMail( $user['fname'], $user['lname'], $user['email'] );					
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );	
					}
					else if( $_POST['submit'] == 'Reject' )
					{
						if( $user['class'] == 0 )
						{
							$query = "UPDATE logins
									  SET approved = 2
									  WHERE username = '$email'";
						}
						else
						{
							$query = "UPDATE logins
									  SET approved = 2
									  WHERE username = '$psoft'";
						}
						
						$result = mssql_query( $query );
						
						if( $user['class'] == 0 )
							sendStudentRejectionMail( $user['fname'], $user['lname'], $user['email'] );
						else
							sendAlumniRejectionMail( $user['fname'], $user['lname'], $user['email'] );
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
					}
					
					displayStudentProfile2( $_GET['id'] );
				}
				else if( $_GET['action'] == 'approve' && $_GET['empid'] != '' )
				{
					//echo 'Inside!!!';
					$query = "SELECT fname, lname, email, company, website
							  FROM employers
							  WHERE id = '$_GET[empid]'";
					$result = mssql_query( $query );					
					$user = mssql_fetch_array( $result );
					
					$email = $user['email'];
					//echo $email;
					
					if( !is_bool( $result ) )
						mssql_free_result( $result );
					
					if( $_POST['submit'] == 'Approve' )
					{
						$query = "UPDATE logins
								  SET approved = 1
								  WHERE username = '$email'";
										
						$result = mssql_query( $query );
						
						
						sendEmployerAcceptanceMail( $user['fname'], $user['lname'], $user['email'] );
									
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );	
					}
					else if( $_POST['submit'] == 'Reject' )
					{
						
						$query = "UPDATE logins
								  SET approved = 2
								  WHERE username = '$email'";						
						
						$result = mssql_query( $query );						
						
						sendEmployerRejectionMail( $user['fname'], $user['lname'], $user['email'] );						
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
					}
					
					//displayEmployerProfile( $_GET['empid'] );
					displayEmployers();
				}
				else if( $_GET['action'] == 'mngst' )
				{
					$mode = $_GET['mode'];
					displayStudents($mode);
				}
				else if( $_GET['action'] == 'mngal' )
				{
					$mode = $_GET['mode'];
					displayAlumni($mode);
				}
				else if( $_GET['action'] == 'mngemp' )
				{
					displayEmployers();	
				}		
				else if($_GET['action'] == 'mngjps' )
				{
					displayJobPostings();
				}
				else if( $_GET['action'] == 'delete' && $_GET['id'] != ''  )
				{
					if( !isset( $_GET['sub'] ) )
					{						
						$query = "SELECT fname, lname
								  FROM students
							  	  WHERE id = '$_GET[id]'";
						$result = mssql_query( $query);
						$student = mssql_fetch_array( $result);
					
						echo '<h3>Are you sure you want to delete <strong>' . $student['fname'] . ' ' . $student['lname'] . '</strong>?
						  	  <br />
						  	  <br />
						  	  <form name="dst" id="dst" method="post" action="admin.php?action=delete&amp;id=' . $_GET['id'] . '&amp;sub=confirm">
						  	  <input type="submit" name="submit" value="Yes" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="No" /></form>';
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
					}
					else if( $_GET['sub'] == 'confirm' )
					{						
						if( $_POST['submit'] == 'Yes' )
						{
							$pQuery = "SELECT psoft, resume, email, class
									   FROM students
									   WHERE id = '$_GET[id]'";
							$pResult = mssql_query( $pQuery );
							$student = mssql_fetch_array( $pResult );
							$pSoft = $student['psoft'];
							$resume = $student['resume'];
							$email = $student['email'];
							
							if( !is_bool( $pResult ) )
								mssql_free_result( $pResult );
							
							$sQuery = "DELETE FROM students
									   WHERE id = '$_GET[id]'";
							$lQuery = "";
							
							if( $student['class'] == 0 )
							{
								$lQuery = "DELETE FROM logins
									   	   WHERE username = '$email'";
							}
							else
							{
								$lQuery = "DELETE FROM logins
									   	   WHERE username = '$pSoft'";
							}
							
							$sResult = mssql_query( $sQuery );
							$lResult = mssql_query( $lQuery );
							
						//	$resumeDir = dirname( $resume );
						//	$bDeleteResume = unlink( $resume );
						//	$bDeleteResumeDir = rmdir( $resumeDir );
							
							if( !$sResult || !$lResult /*|| !$bDeleteResume || !$bDeleteResumeDir*/ )
								showError( 'Error: Failed to delete student' );
							else
								showSuccessfulNotification( 'Student #' . $_GET['id'] . ' successfully deleted' );
							
							displayWelcomeMenu();
				
							displayAdminStudentNotifications( );
							
							if( !is_bool( $sResult ) )
								mssql_free_result( $sResult );
							if( !is_bool( $lResult ) )
								mssql_free_result( $lResult );
						}
						else if( $_POST['submit'] == 'No' )
						{
							displayStudentProfile( $_GET['id'] );
						}
					}
				}
				else if( $_GET['action'] == 'delete' && $_GET['empid'] != '')
				{
					if( !isset( $_GET['sub'] ) )
					{						
						$query = "SELECT fname, lname
								  FROM employers
							  	  WHERE id = '$_GET[empid]'";
						$result = mssql_query( $query);
						$employer = mssql_fetch_array( $result);
					
						echo '<h3>Are you sure you want to delete the employer <strong>' . $employer['fname'] . ' ' . $employer['lname'] . '</strong>?
						  	  <br />
						  	  <br />
						  	  <form name="dst" id="dst" method="post" action="admin.php?action=delete&amp;empid=' . $_GET['empid'] . '&amp;sub=confirm">
						  	  <input type="submit" name="submit" value="Yes" />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="No" /></form>';
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
					}
					else if( $_GET['sub'] == 'confirm' )
					{						
						if( $_POST['submit'] == 'Yes' )
						{
							$pQuery = "SELECT email
									   FROM employers
									   WHERE id = '$_GET[empid]'";
							$pResult = mssql_query( $pQuery );
							$employer = mssql_fetch_array( $pResult );
							//$pSoft = $student['psoft'];
							//$resume = $student['resume'];
							$email = $employer['email'];
							
							if( !is_bool( $pResult ) )
								mssql_free_result( $pResult );
							
							$sQuery = "DELETE FROM employers
									   WHERE id = '$_GET[empid]'";
							$lQuery = "";							
							
							$lQuery = "DELETE FROM logins
									   WHERE username = '$email'";				
							
							
							$sResult = mssql_query( $sQuery );
							$lResult = mssql_query( $lQuery );
							
						//	$resumeDir = dirname( $resume );
						//	$bDeleteResume = unlink( $resume );
						//	$bDeleteResumeDir = rmdir( $resumeDir );
							
							if( !$sResult || !$lResult /*|| !$bDeleteResume || !$bDeleteResumeDir*/ )
								showError( 'Error: Failed to delete employer' );
							else
								showSuccessfulNotification( 'Employer ' . $_GET['empid'] . ' successfully deleted' );
							
							displayWelcomeMenu();
				
							displayAdminStudentNotifications( );
							
							if( !is_bool( $sResult ) )
								mssql_free_result( $sResult );
							if( !is_bool( $lResult ) )
								mssql_free_result( $lResult );
						}
						else if( $_POST['submit'] == 'No' )
						{
							displayEmployerProfile( $_GET['empid'] );
						}
					}
				}
				else if( $_GET['action'] == 'editprof' )
				{
					if( $_GET['sub'] == 'submit' )
					{
						$mba =  $_POST['undergradOrMBA'] == 'yes' ? 1 : 0;
						$hidden =  $_POST['profileHidden'] == 'yes' ? 1 : 0;
						/*$employee = $_POST['isemployee'] == 'yes' ? 1 : 0;*/
						$placed = $_POST['studentPlaced'] == 'yes' ? 1 : 0;
						$argus = $_POST['argustut'] == 'yes' ? 1 : 0;
						$arguscertificate = $_POST['arguscertificate'] == 'yes' ? 1 : 0;
						$classes =  getClasses( $classesOptions);							
						$careertype = getCareerTypes($careerTypeList);						
						$permadd = $_POST['padd'] . ' | ' . $_POST['pcity'] . ' | ' . $_POST['pstate'] . ' | ' . $_POST['pzip'];
						$schooladd = '';
						$intplcmnt = getIndexFromDelimitedArrayValue( $internshipOptions, $_POST['intplcmnt'] );
						$majorIndex = getIndexFromDelimitedArrayValue( $majorOptions, $_POST['major'] );
						if($_POST['geopref'] == '' || $_POST['geopref'] == 'No Preference')
							$geoprefIndex = 6;
						else
							$geoprefIndex = getIndexFromDelimitedArrayValue( $locationOptions, $_POST['geopref']);				
						
						if( !isEmpty( $_POST['sadd'] ) )
						{
							$schooladd = $_POST['sadd'] . ' | ' . $_POST['scity'] . ' | ' . $_POST['sstate'] . ' | ' . $_POST['szip'];
						}
						
						$pl1 = $_POST['companyName1'] . ' | ' . $_POST['startDate1'] . ' | ' . $_POST['jobType1'];
						$pl2 = $_POST['companyName2'] . ' | ' . $_POST['startDate2'] . ' | ' . $_POST['jobType2'];
						$pl3 = $_POST['companyName3'] . ' | ' . $_POST['startDate3'] . ' | ' . $_POST['jobType3'];
						
						//echo $_POST['argus'].$_POST['arguscertificate'];
						
						//echo 'Student ID : '.$_SESSION['studentID'];
						
						updateStudent2($_SESSION['studentID'],$argus,$arguscertificate, $classes/*$_POST['classes']*/, $_POST['class'], $majorIndex, $careertype, $geoprefIndex, $_POST['phone'], $_POST['email'], $permadd, $schooladd, $pl1, $pl2, $pl3, $hidden, $mba,$placed/*,$employee*/);
						echo '<a href="admin.php?action=mngst&amp;mode=all">< Back</a>';
					}
				}
				else if($_GET['action'] == 'editeEmpProf')
				{
					if( $_GET['sub'] == 'submit' )
					{
						$careertype = getCareerTypes($careerTypeList);	
						
						$geoprefIndex = getIndexFromDelimitedArrayValue( $locationOptions, $_POST['geopref'] );	
						$openingtypeIndex = getIndexFromDelimitedArrayValue( $employeeOptions, $_POST['openingtype']);
						$experienceIndex = getIndexFromDelimitedArrayValue( $experienceOptions, $_POST['experience']);							
												
						updateEmployer($_SESSION['employerID'],$_POST['company'],$_POST['phone'],$_POST['website'],$geoprefIndex, $careertype,$openingtypeIndex,$experienceIndex);
					}					
				}
				else if($_GET['action'] == 'savechanges')
				{
					if( $_GET['sub'] == 'submit' )
					{
						
						
						updateJobs(
						$_POST['date1'],$_POST['companyName1'],$_POST['position1'],$_POST['linkOne'],$_POST['ord1'],$removejobOne,
						$_POST['date2'],$_POST['companyName2'],$_POST['position2'],$_POST['linkTwo'],$_POST['ord2'],$removejobTwo,
						$_POST['date3'],$_POST['companyName3'],$_POST['position3'],$_POST['linkThree'],$_POST['ord3'],$removejobThree,
						$_POST['date4'],$_POST['companyName4'],$_POST['position4'],$_POST['linkFour'],$_POST['ord4'],$removejobFour,
						$_POST['date5'],$_POST['companyName5'],$_POST['position5'],$_POST['linkFive'],$_POST['ord5'],$removejobFive,
						$_POST['date6'],$_POST['companyName6'],$_POST['position6'],$_POST['linkSix'],$_POST['ord6'],$removejobSix,
						$_POST['date7'],$_POST['companyName7'],$_POST['position7'],$_POST['linkSeven'],$_POST['ord7'],$removejobSeven,
						$_POST['date8'],$_POST['companyName8'],$_POST['position8'],$_POST['linkEight'],$_POST['ord8'],$removejobEight,
						$_POST['date9'],$_POST['companyName9'],$_POST['position9'],$_POST['linkNine'],$_POST['ord9'],$removejobNine,
						$_POST['date10'],$_POST['companyName10'],$_POST['position10'],$_POST['linkTen'],$_POST['ord10'],$removejobTen
						);
					}					
				}
				else
				{
					displayWelcomeMenu();
				
					displayAdminStudentNotifications( );
				}
			}
		?>
	  
	  <!-- InstanceEndEditable --></td>
    </tr>
  </table>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
<!-- InstanceEnd --></html>