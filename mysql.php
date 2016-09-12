<?php
	$mssql_host = 'sb1-sql12-1.business.uconn.edu';
	$mssql_database = 'REResume';
	$mssql_user = 'util.sql.reresume';
	$mssql_password = 'RE$RE$RE$299';
	$connection = mssql_connect( $mssql_host, $mssql_user, $mssql_password );
	mssql_select_db( $mssql_database );
?>