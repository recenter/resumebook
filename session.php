<?php
    session_start( );
    
    include 'mysql.php';
    
    
    error_reporting( E_ALL ^ E_NOTICE );
    
    function validateStudent( $id, $access, $fname, $lname, $argus, $arguscertificate, $classes, $class, $major, $careertype, $geopref, $phone, $email,$permadd, $schooladd, $intplcmnt,$resume, $placement1, $placement2, $placement3, $hidden,$mba,$placed/*,$employee*/)
    {
        session_regenerate_id( );
        
        $_SESSION['id']            = $id;
        $_SESSION['valid']         = 1;
        $_SESSION['access']     = $access;
        $_SESSION['fname']         = $fname;
        $_SESSION['lname']        = $lname;        
        $_SESSION['argus']        = $argus;
        $_SESSION['arguscertificate']    = $arguscertificate;
        $_SESSION['classes']    = $classes;        
        $_SESSION['class']        = $class;
        $_SESSION['major']        = $major;        
        $_SESSION['careertype'] = $careertype;        
        $_SESSION['geopref']     = $geopref;
        $_SESSION['phone']        = $phone;
        $_SESSION['email']         = $email;        
        $_SESSION['permadd']    = $permadd;
        $_SESSION['schooladd']    = $schooladd;
        $_SESSION['intplcmnt']    = $intplcmnt;
        $_SESSION['resume']        = $resume;
        $_SESSION['placement1']    = $placement1;
        $_SESSION['placement2']    = $placement2;
        $_SESSION['placement3']    = $placement3;    
        $_SESSION['hidden']     = $hidden;    
        $_SESSION['mba']        = $mba;
        $_SESSION['placed']     = $placed;
        /*$_SESSION['employee']   = $employee;*/
        
        $_SESSION['showHiddenUsers'] = 1;
    }
    
    function validateEmployer( $id, $access, $fname, $lname, $company, $phone, $email,$website,$geo,$careertype,$openingtype,$experience)
    {
        session_regenerate_id( );
        
        $_SESSION['id']            = $id;
        $_SESSION['valid']         = 1;
        $_SESSION['access']     = $access;
        $_SESSION['fname']         = $fname;
        $_SESSION['lname']        = $lname;        
        $_SESSION['company']    = $company;
        $_SESSION['phone']        = $phone;
        $_SESSION['email']         = $email;        
        $_SESSION['website']    = $website;
        $_SESSION['geo']    = $geo;
        $_SESSION['careertype']    = $careertype;
        $_SESSION['openingtype'] = $openingtype;
        $_SESSION['experience'] = $experience;    
        
        $_SESSION['Search_CareerType'] = '';
        $_SESSION['Search_Geo'] = '';
        $_SESSION['Search_From'] = '';
        $_SESSION['Search_To'] = '';        
    }
    
    function validateAdmin( )
    {
        session_regenerate_id( );
        
        $_SESSION['valid']     = 1;
        $_SESSION['access'] = 3;
        $_SESSION['studentID'] = 0;
        
        $_SESSION['removejobTen'] = 0;
    }
    
    function isLoggedIn( )
    {
        if( $_SESSION['valid'] )
            return true;
        
        return false;
    }
    
    function logout( )
    {
        if( isset( $_SESSION ) )
            $_SESSION = array( );
            
        @session_destroy( );
        mssql_close( );
    }
    function updateArgus( $argus)
    {
        $_SESSION['argus'] = $argus;
    }
    function updateArgusCertificate( $arguscertificate )
    {
        $_SESSION['arguscertificate'] = $arguscertificate;
    }
    function updateClass( $class )
    {
        $_SESSION['class'] = $class;
    }
    function updateClasses( $classes )
    {
        $_SESSION['classes'] = $classes;
    }
    function updateMajor( $major )
    {
        $_SESSION['major'] = $major;
    }
    function updateCareerType( $careertype )
    {
        $_SESSION['careertype'] = $careertype;
    }
    function updateGeopref( $geopref )
    {
        $_SESSION['geopref'] = $geopref;
    }    
    function updatePhone( $phone )
    {
        $_SESSION['phone'] = $phone;
    }    
    function updateEmail( $email )
    {
        $_SESSION['email'] = $email;
    }    
    function updateResume( $resume )
    {
        $_SESSION['resume'] = $resume;
    }
    
    function updatePermAdd( $permadd )
    {
        $_SESSION['permadd'] = $permadd;
    }
    
    function updateSchoolAdd( $schooladd )
    {
        $_SESSION['schooladd'] = $schooladd;
    }
    
    function updateIntplcmnt( $intplcmnt )
    {
        $_SESSION['intplcmnt'] = $intplcmnt;
    }
    
    function updateCompanyName( $companyName )
    {
        $_SESSION['company'] = $companyName;
    }
    
    function updateWebSite( $webSite)
    {
        $_SESSION['website'] = $webSite;
    }
    
    function updateOpeningType( $openingtype)
    {
        $_SESSION['openingtype'] = $openingtype;
    }
    
    function updateeExperience( $experience)
    {
        $_SESSION['experience'] = $experience;
    }    
    
    function updatePlacement1( $placement1)
    {
        $_SESSION['placement1'] = $placement1;
    }    
    
    function updatePlacement2( $placement2)
    {
        $_SESSION['placement2'] = $placement2;
    }
    
    function updatePlacement3( $placement3)
    {
        $_SESSION['placement3'] = $placement3;
    }
    
    function updateHidden( $hidden)
    {
        $_SESSION['hidden'] = $hidden;
    }
    
    function updateMBA( $mba)
    {
        $_SESSION['mba'] = $mba;
    }
    
    function updatePlaced( $placed)
    {
        $_SESSION['placed'] = $placed;
    }

    /*function updateEmployee($employee)
    {
        $_SESSION['employee'] = $employee;
    }*/
    
    function getResume( $userid )
    {
        if( $_SESSION['resume'] != '' || $_SESSION['resume'] != NULL )
            return( $_SESSION['resume'] );
        else
        {
            $query = mssql_query( "SELECT resume FROM students WHERE id='$userid'" );
            
            $user = mssql_fetch_row( $query );
            
            if( !is_bool( $query ) )
                mssql_free_result( $query );
                
            return( $user[0] );
        }
        
        return NULL;
    }
?>