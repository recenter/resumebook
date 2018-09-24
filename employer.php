<?php 
include "header.php";
include_once 'session.php';
include_once 'php_helper/reg_helper.php';
			
			if( !isLoggedIn( ) )
			{
				header( 'Location: index.php?error=2' );
				die( );
			}
			else
			{
				if( $_SESSION['access'] == 0 || $_SESSION['access'] == 1 || $_SESSION['access'] == 3 )
				{
					echo 'inside';
					header( 'Location: index.php?error=3' );
					die( );
				}
				
				echo '
						<div><h2>'.'Welcome, ' . $_SESSION['fname'] . ' ' . $_SESSION['lname'] . '</h2></div>';
				
				/*if( $_FILES['userfile']['name'] != NULL || $_FILES['userfile']['name'] != '' )
				{
					if( file_exists( $_SESSION['resume'] ) )
						unlink( $_SESSION['resume'] );
					
					$uploaddir = 'E:/Inetpub/wwwroot/reresume/resumes/';
					$userdir = md5( $_SESSION['psoft'] . $_SESSION['fname'] . $_SESSION['lname'] ) . '/';
					$resumedir = $uploaddir . $userdir;
					$resumefile = $resumedir . basename( $_FILES['userfile']['name'] );
					$resumeInfo = pathinfo( $resumefile );
					$resumeRename = $resumeInfo['dirname'] . '/' . $_SESSION['fname'] . '_' . $_SESSION['lname'] . '_Resume.' . $resumeInfo['extension'];
					
					$dircreated = false;
					$bResume = true;
					
					if( !is_dir( $resumedir ) )
					{
						if( !mkdir( $uploaddir . DIRECTORY_SEPARATOR . $userdir ) )
						{
							echo '<br />';
							showError( 'Error: Failed to make folder for resume' );
							$bResume = false;
						}
						else
							$dircreated = true;
					}
					else
						$dircreated = true;
					
					if( $dircreated && !move_uploaded_file( $_FILES['userfile']['tmp_name'], $resumeRename ) )
					{
						echo '<br />';
						showError( 'Error: Failed to upload the resume' );
						$bResume = false;
					}
					
					if( $dircreated && ( $_FILES['userfile']['error'] != 0 ) )
					{
						echo '<br />';
						showError( 'File upload error: ' . $_FILES['userfile']['error'] );
						$bResume = false;
					}
					
				//	if( !rename( $resumefile, $resumeRename ) )
				//	{
				//		echo '<br />';
				//		showError( 'Error: Failed to rename resume' );
				//	}
					
					
					if( $bResume )
					{
						$userid = $_SESSION['id'];
						
						mssql_query( "UPDATE students SET resume = '$resumeRename' WHERE id = '$userid'" );
					
						updateResume( $resumeRename );
						
						echo '<br />';
						showSuccessfulNotification( 'Resume successfully uploaded' );
					}
				}*/
				if( $_GET['action'] == 'jps')
				{
					displayJobPostingsToStudents();
				}
				else if( $_GET['action'] == 'editprof' )
				{
					if( $_GET['sub'] == '' )
					{						
						//if( $_SESSION['permadd'] != '' )
						{			
							$company = $_SESSION['company'];
							$phone = $_SESSION['phone'];
							$email = $_SESSION['email'];
							$website = $_SESSION['website'];
							$geopref = $_SESSION['geopref'];
							$careertype = explode( '|',$_SESSION['careertype']);
							$openingtype =  $_SESSION['openingtype'];
							$experience = $_SESSION['experience'];					
						}
						
						//echo 'company :'.$company;
						
						echo '
							<br />
							<form name="stprof" id="stprof" method="post" action="employer.php?action=editprof&amp;sub=submit&amp;id=' . $_GET['id'] . '">
							<table width="100%" class="table_topBorder">
							<th style="border-bottom:1px solid #cccccc;">
                  				<br><b><font size="+1">Company Info</font></b><br>
                			</th>';	
						
						tableTextInput( 'text', 'company', 'Company Name', 50, $company, $errorCode['company'], '', true, '' );
						tableTextInput( 'text', 'phone', 'Company Phone', '', $phone, $errorCode['phone'], '(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$' );						
						tableTextInput( 'text', 'website', 'Company Website', 30, $website, $errorCode['website'], '', true, '' );	

						echo '
							<th style="border-bottom:1px solid #cccccc;">
                  				<br><b><font size="+1">Job Opening</font></b><br>
                			</th>';				
						
						tableSelectInput2( 'openingtype', 'Opening Type', $employeeOptions, $openingtype, $errorCode['openingtype'], '' );
						tableSelectInput2( 'experience', 'Necessary Experience (Years)', $experienceOptions, $experience, $errorCode['experience'], '' );
						tableSelectInput2( 'geopref', 'Geographical Location of the job', $locationOptions, $geopref, $errorCode['geo'], '' );
						displayCheckBoxes("Job Functions (Check all that apply):", $careerTypeList, $careertype);						
						
						echo '
							<tr>
								<td><input type="submit" name="submit" class="loginButton" value="Save Changes" /></td>
							</tr>
							</table>
							</form>';
					}
					else if( $_GET['sub'] == 'submit' )
					{
							
						$careertype = getCareerTypes($careerTypeList);	
						
						$geoprefIndex = getIndexFromDelimitedArrayValue( $locationOptions, $_POST['geopref'] );	
						$openingtypeIndex = getIndexFromDelimitedArrayValue( $employeeOptions, $_POST['openingtype']);
						$experienceIndex = getIndexFromDelimitedArrayValue( $experienceOptions, $_POST['experience']);							
												
						updateEmployer($_SESSION['id'],$_POST['company'],$_POST['phone'],$_POST['website'],$geoprefIndex, $careertype,$openingtypeIndex,$experienceIndex);						
						
					}
				}
				
				if( $_GET['action'] == 'studentsSearch' && $_GET['sub'] == 'submit' )
				{
					if($_POST['geopref'] == '') {
						$geopref = 99;
					}
					else {
						$geopref = getIndexFromDelimitedArrayValue( $locationOptions, $_POST['geopref'] );
					}
					if($_POST['careertype']!=''){
						$careertype = getCareerTypes($careerTypeList);
					}

					$_SESSION['Search_CareerType'] = $careertype;
					$_SESSION['Search_Geo'] = $geopref;
					$_SESSION['Search_From'] = $_POST['from'];
					$_SESSION['Search_To'] = $_POST['to'];	
					$_SESSION['Search_MBA'] = $_POST['mba'];		
					$_SESSION['Search_Resume'] = $_POST['resume'];	
		
					//echo 'careertype: '. $careertype. 'geopref: '. $geopref;
					queryStudents($careertype, $geopref, $_POST['from'], $_POST['to'], $_POST['mba'], $_POST['resume']);
					
					die();
				}
				
				if( $_GET['action'] == 'studentsSearch' && $_GET['sub'] == 'results' )
				{
					queryStudents($_SESSION['Search_CareerType'], $_SESSION['Search_Geo'], $_SESSION['Search_From'], $_SESSION['Search_To'], $_SESSION['Search_MBA'], $_SESSION['Search_Resume']);
					
					die();
				}
				
				if( $_GET['vsp'] != NULL || $_GET['vsp'] != '' )
				{
					displayStudentProfile( $_GET['vsp'] );
					
					die();
				}
				
				if( $_GET['action'] == '' || $_GET['sub'] == 'submit' )
				{
					$careertype = $_SESSION['careerType'];
					$geopref = $_SESSION['geopref'];

					/*begin employer dash*/
					echo '
						<form name="studentsSearch" id="studentsSearch" method="post" action="employer.php?action=studentsSearch&amp;sub=submit">
						<br /><h2><a href="employer.php?action=editprof&amp;id=' . $_SESSION['id'] . '">Edit Profile</a></h2>
						<br /><h2><a href="employer.php?action=jps">Job Postings</a></h2>Please <a href="help.php">contact us</a> to post positions here.<br />
						<br /><h2>Student Search</h2>
						<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = "employer.php?action=studentsSearch&amp;sub=submit">Search All Students</a></h3>
						<table style="padding:1%; margin-left:3%;" bgcolor="#fafafa">
							<tr>
								<td style="top:0;"><h3 style="margin-bottom: 0px;">Detailed Search</h3></td>
							</tr>';
						/*	tableCheckboxInput("Career Type: ", $careerTypeList, $careerType); */
					echo '
							<tr>
								<td>
									<strong> Graduation year range </strong><br/><strong>' . ( ( $errorCode['from'] ) ? '<font color="#FF0000">*From</font>' : 'From' ) .'</strong>&nbsp;&nbsp;<select name="from" id="from"><option value=""></option>';
						
									$year = idate( 'Y' );
									for( $i = 0; $i < 4; $i++ )	{
										echo '<option value="' . ( $year + $i ) . '" ' . ( ( $_POST['from'] == ( $year + $i ) ) ? 'selected="selected"' : '' ) . ' >' . ( $year + $i ) . '</option>';
									}
									echo '</select>&nbsp;&nbsp;<strong>' . ( ( $errorCode['to'] ) ? '<font color="#FF0000">*To</font>' : 'To' ) .'</strong>&nbsp;&nbsp;<select name="to" id="to"><option value=""></option>';
									$year = idate( 'Y' );
									for( $i = 0; $i < 4; $i++ ) {
										echo '<option value="' . ( $year + $i ) . '" ' . ( ( $_POST['to'] == ( $year + $i ) ) ? 'selected="selected"' : '' ) . ' >' . ( $year + $i ) . '</option>';
									}
									echo '</select>
								</td>
							</tr>	
							<tr>
								<td>';
									tableSelectInput( 'geopref', 'Geographical Preference', $locationOptions, $_POST['geopref'], $errorCode['geopref'], '' );
									//tableSelectInput( 'careerType', 'Career Type', $careerTypeList, $_POST['careerType'],$errorCode['careerType'],'');
					echo '		</td>
							</tr>			
							<tr>
								<td>
									<input type="checkbox" name="mba" value="yes" ' . ( $_SESSION['Search_MBA'] == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong><i>Show MBA students ONLY?</i></strong>
								</td>
							</tr>			
							<tr>
								<td>
									<input type="checkbox" name="resume" value="yes" ' . ( $_SESSION['Search_Resume'] == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;<strong><i>Show students with uploaded resume ONLY?</i></strong>
								</td>
							</tr>';
				 	
				 	echo'	<tr>
								<td><strong></strong><input type="submit" name="Search" value="Search" class="loginButton" /></td>
							</tr>
						</table>
						</form>';
				}				
			}
		?>
		<?php echo '
	  </td>
    </tr>
  </table>
</div>';
include 'footer.php';
echo '</div></body></html>'; ?>