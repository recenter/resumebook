<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php include_once("analyticstracking.php") ?>

<?php
	include_once 'session.php';
	
	$salt = "32d9210f37d850d8978c817b7a623f79";
	
	if( get_magic_quotes_gpc( ) )
	{
		$_GET = array_map( 'stripslashes', $_GET );
		$_POST = array_map( 'stripslashes', $_POST );
		$_COOKIE = array_map( 'stripslashes', $_COOKIE );
	}
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$query = "SELECT password, access, approved
			  FROM logins
			  WHERE username = '$username'";
	$result = mssql_query( $query );

	if(preg_match("/[A-Z]{3}[0-9]{5}|[a-z]{3}[0-9]{5}/",$username))
	{
		mssql_close( $connection );
		header( 'Location: index.php?error=7' );
		die( );
	}
	
	if( mssql_num_rows( $result ) < 1 )
	{
		if( !is_bool( $result ) )
			mssql_free_result( $result );
		
		mssql_close( $connection );
		header( 'Location: index.php?error=5' );
		die( );
	}
	
	$user = mssql_fetch_array( $result );
	
	$passwordHash = md5( $salt . $password );
	
	if( $passwordHash != trim( $user['password'] ) )
	{
		mssql_free_result( $result );
		mssql_close( $connection );
		header( 'Location: index.php?error=1' );
		die( );
	}
	else
	{
		if( $user['approved'] == 0 )
		{
			mssql_free_result( $result );
			mssql_close( $connection );
			header( 'Location: index.php?error=4' );
			die( );
		}
		else if( $user['approved'] == 2 )
		{
			mssql_free_result( $result );
			mssql_close( $connection );
			header( 'Location: index.php?error=6' );
			die( );
		}
		else
		{
			$table = '';			
			
			if( $user['access'] == 1 )
				$table = 'students';
			else if( $user['access'] == 2 )
				$table = 'employers';
			else if( $user['access'] != 3 )
			{
				mssql_free_result( $result );
				mssql_close( $connection );
				header( 'Location: index.php?error=5' );
			}
			
			$isStudent = ( is_numeric( $username ) ? true : false );
			
			if( $table == 'students' )
			{	
				mssql_free_result( $result );
								
				$query = FALSE;
				
				if( $isStudent )
				{
					$query = "SELECT *
						  	  FROM students
						  	  WHERE psoft = '$username'";
				}
				else
				{
					$query = "SELECT *
						  	  FROM students
						  	  WHERE email = '$username'";
				}
				
				$result = mssql_query( $query );
				
				if( mssql_num_rows( $result ) < 1 )
				{
					mssql_close( $connection );
					header( 'Location: index.php?error=5' );
				}
				
				$student = mssql_fetch_array( $result );
				
				if( $isStudent )
				{
					$query = "UPDATE students
						  	  SET lastlogin = GETDATE( )
						  	  WHERE psoft = '$username'";
				}
				else
				{
					$query = "UPDATE students
							  SET lastlogin = GETDATE( )
							  WHERE email = '$username'";
				}
				
				$result = mssql_query( $query );
				
				if( !$result )
					echo 'Failed to update last login: ' . mssql_error( );
					
				//	$id, $access, $fname, $lname, $argus, $arguscertificate, $classes, $class, $major, $careertype, $geopref, $phone, $email,$permadd, $schooladd, $intplcmnt,$resume
				
				validateStudent( $student['id'], $user['access'], $student['fname'], $student['lname'], $student['argus'], $student['arguscertificate'],$student['classes'], $student['class'], $student['major'],$student['careertype'], $student['geopref'], $student['phone'], $student['email'], $student['permadd'], $student['schooladd'], $student['intplcmnt'],$student['resume'],$student['placement1'],$student['placement2'],$student['placement3'],$student['hidden'], $student['mba'], $student['placed'], $student['employee']);
				
				if( !is_bool( $result ) )
					mssql_free_result( $result );
			}
			else if($table == 'employers')
			{
				mssql_free_result( $result );
								
				$query = FALSE;
				
				$query = "SELECT *
						  FROM employers
						  WHERE email = '$username'";
				
				$result = mssql_query( $query );
				
				if( mssql_num_rows( $result ) < 1 )
				{
					mssql_close( $connection );
					header( 'Location: index.php?error=5' );
				}
				
				$employer = mssql_fetch_array( $result );
				
				$query = "UPDATE employers
					      SET lastlogin = GETDATE( )
						  WHERE email = '$username'";
				
				$result = mssql_query( $query );
				
				if( !$result )
					echo 'Failed to update last login: ' . mssql_error( );
				
				validateEmployer($employer['id'],  $user['access'], $employer['fname'], $employer['lname'], $employer['company'], $employer['phone'], $employer['email'],$employer['website'],$employer['geo'],$employer['careertype'],$employer['openingtype'],$employer['experience']);				
				
				if( !is_bool( $result ) )
					mssql_free_result( $result );
			}
			else if( $table == '' )
				validateAdmin( );
			
			if( !is_bool( $result ) )
				mssql_free_result( $result );	
			
			mssql_close( $connection );
			header( 'Location: index.php?action=login' );
		}
	}
?>

</body>
</html>