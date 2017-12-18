<?php include "header.php"; ?>
	  <!-- InstanceBeginEditable name="content" -->
      
      <?php
	  		// Include the necessary headers
	  		include_once 'session.php'; 
			include_once 'php_helper/main_helper.php';
			
			/*---------------------------------------*/
			
			// Turn off unecessary warning reporting (which might cause the page to not load and just display a PHP warning message)
			error_reporting( E_ALL ^ E_NOTICE );
			
			// If the user is not logged in, handle Sign Up and Forgot Password requests
			if( !isLoggedIn( ) )
			{
				if($_GET['action'] == 'resetpass')
				{
					echo'
					<table width="100%" class="table_whiteBox2">
      					<form name="passwordReset" method="get" action="index.php?action=sendpass">
      						
            				<tr>
                				<td>Email Address: <input name="emailreset" type="text" />&nbsp;&nbsp;<input type="submit" value=" Reset Password " /><br>This will send an automatically generated password to this email.</td>
						   </tr>  
            				
      					</form>
      					</table>';
						
					die();
				}
				else if($_GET['emailreset'] != '')
				{
					$email = $_GET['emailreset'];
					//echo 'email is ' .$email;
					$query = "";
					$passText = "";
					if(CheckIfStudentEmailExists($email))
					{
						//echo 'email is ' .$email;
						$query = "SELECT id, fname, lname, class, psoft, resume, lastlogin, email
								  FROM students
								  WHERE email = '$email'";
								  
						$result = mssql_query( $query);
						
						$student = mssql_fetch_array( $result);		
						
						$passText = $student['lname'].$student['class'].'007#';
						
						$password = md5( $salt.$passText);				
						
						if( $student['class'] == 0 )
						{
							$query = "UPDATE logins
									  SET password = '$password'
									  WHERE username = '$student[email]'";
						}
						else
						{	
							$query = "UPDATE logins
									  SET password = '$password'
									  WHERE username = '$student[psoft]'";
						}
						
						$uresult = mssql_query( $query);
						
						if( !is_bool( $uresult ) )
							mssql_free_result( $uresult );
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
							
						showSuccessfulNotification( 'New password has been sent to this email: ' . $email.'. Please check your email and try to log in with the new password');	
						
						sendNewPassword( $student['fname'], $student['lname'], $email, $passText);
					}
					else if(CheckIfEmployerEmailExists($email))
					{
						//echo ' inside' ;
						$query = "SELECT fname,lname, company,email
								  FROM employers
								  WHERE email = '$email'";
								  
						$result = mssql_query( $query);
						
						$employer = mssql_fetch_array( $result);		
						
						$passText = $employer['lname'].$student['company'].'007#';
						
						//echo 'pass = '. $passText;
						
						$password = md5( $salt.$passText);						
						
						$query = "UPDATE logins
								  SET password = '$password'
								  WHERE username = '$employer[email]'";						
						
						$uresult = mssql_query( $query);
						
						if( !is_bool( $uresult ) )
							mssql_free_result( $uresult );
						
						if( !is_bool( $result ) )
							mssql_free_result( $result );
							
						showSuccessfulNotification( 'New password has been sent to this email: ' . $email.'. Please check your email and try to log in with the new password');
						
						sendNewPassword( $employer['fname'], $employer['lname'], $email, $passText);
					}
					else
						showError( 'Error: This email address could not be found in our database. Please check your email and try again.');	
				}
				
				echo '
<table width="80%">
<tr>
<td width="70%" style="padding:2%; min-width:250px;">
<a href="http://realestate.business.uconn.edu/"><img width="100%" src="http://www3.business.uconn.edu/reresume/images/resumebook_banner2016.png" /></a><br>
<h4 style="text-align:justify; background-color:#ffffff;"> The Center for Real Estate and Urban Economic Studies is dedicated to cutting edge research and the training of skilled individuals for all segments of the industry. We provide numerous services to Connecticut\'s real estate professionals and to the Department of Consumer Protection. Our activities embrace many disciplines including finance, statistics, economics and geography. Our teaching and research has long been ranked among the very best programs in the US and Internationally.</h4>
</td>
<td width="30%" valign="top" style="padding-top:2%;">
						
						<table width="100%" style="min-width:230px; background-color:#08588c; padding:5px;">
      					<form name="login" method="post" action="login.php">
               				<tr>
                				<td style="color:#ffffff;">Username<br><font class="loginHelp">PeopleSoft number for students, e-mail otherwise</font><br><input name="username" type="text" id="username" /><br/><font class="loginAlert">';								 
				            	
				            	/*Shows login errors*/
				            	if( !isLoggedIn( ) )
								{
									if( $_GET['error'] == 1 )
									{
										showLoginError( 'Error: Incorrect username or password<br>' );
									}
									else if( $_GET['action'] == 'logout'  || $_GET['error'] == 2 )
									{
										showLoginError( 'Error: You are not logged in<br>' );
									}
									else if( $_GET['error'] == 3 )
									{
										showLoginError( 'Error: You do not have access to this page<br>' );
									}
									else if( $_GET['error'] == 4 )
									{
										showLoginError( 'Error: Your account has not been verified yet<br>' );
									}
									else if( $_GET['error'] == 5 )
									{
										showLoginError( 'Error: Unknown<br>' );
									}
									else if( $_GET['error'] == 6 )
									{
										showLoginError( 'Error: Your registration has been rejected. Please contact the admin for any further questions.<br>' );
									}
									else if( $_GET['error'] == 7 )
									{
										showLoginError('Error: NetID (abc12345) entered as username. Use PeopleSoft (1234567) instead.<br>');
									}			
								}
								else
									{
										echo '<br><br>';
									}
            					echo '</font><br>Password<br><input name="password" type="password" id="password" /></td>
            				</tr>
            				<tr>
								<td><input type="submit" name="login" value=" Login " class="loginButton" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#ffffff"><a href="register.php" style="color:#ffffff">Sign Up</a></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?action=resetpass" style="color:#ffffff">Forgot password?</a></td>
							<tr>
      					</form>
      					</table>
</td>
</tr>
</table>
';
			}
			else
			{
				if( $_GET['action'] == 'logout' )
				{
					logout( );
					header( 'Location: index.php' );
					die( );
				}
				else if( $_GET['action'] == 'login' )
				{
					switch( $_SESSION['access'] )
					{
						case 1:
							header( 'Location: student.php' );
							die( );
							break;
						case 2:
							header( 'Location: employer.php' );
							die( );
							break;
						case 3:
							header( 'Location: admin.php' );
							die( );
							break;
						default:
							break;
					}
				}				
				else if( $_GET['error'] == 3 )
				{
					showError( 'Error: You do not have access to this page' );
				}
				else if( $_GET['error'] == 4 )
				{
					showError( 'Error: You are already registered' );
				}
				else if( $_GET['error'] == 5 )
				{
					showError( 'Error: Unknown' );
				}
								
				if( $_SESSION['access'] == 1 )
					header( 'Location: student.php' );
				else if( $_SESSION['access'] == 2 )
					header( 'Location: employer.php' );
				else if( $_SESSION['access'] == 3 )
					header( 'Location: admin.php' );
			}
		?>
	  
	  </td>
    </tr>
  </table>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>
