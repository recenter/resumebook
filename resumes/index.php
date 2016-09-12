<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php

	include '../session.php';

	if( !isLoggedIn( ) )
	{
		header( 'Location: www3.business.uconn.edu/reresume/' );
	}

	if( $_SESSION['access'] == 1 )
	{
		if( $_GET['userid'] == '' || $_GET['userid'] == NULL )
			header( 'Location: www3.business.uconn.edu/reresume/index.php' );
	}

	$resume = getResume( $_GET['id'] );
		
	if( $resume == '' || $resume == NULL )
	{
		echo '<h1>Resume not found</h1>';
	}
	else
	{
		if( file_exists( $resume ) )
		{
			header( 'Content-Description: File Transfer' );
   			header( 'Content-Type: application/octet-stream' );
   			header( 'Content-Disposition: attachment; filename=' . basename( $resume ) );
   			header( 'Content-Transfer-Encoding: binary' );
   			header( 'Expires: 0' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
   			header( 'Pragma: public' );
   			header( 'Content-Length: ' . filesize( $resume ) );
  			ob_clean( );
   			flush( );
   			readfile( $resume );
			$resume = NULL;
		}
	}
	
?>

</body>
</html>