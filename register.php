<?php include "header.php"; ?>
<!-- InstanceBeginEditable name="content" -->
     
<?php
    include 'session.php';            
    include 'php_helper/reg_helper.php';
        
    error_reporting( E_ALL ^ E_NOTICE );
        
    $salt = "";
            
    $formFilled = false;
    $showError = false;
    $releaseInfoUnchecked = false;
    $duplicatePSoft = false;
    $duplicateEmail = false;
    $errorCode = array( );
    $companyName = "Test";
    //    $careerTypeList = array( 0 => 'app|Appraisal', 1 => 'bro|Brokerage', 2 => 'Inv|Investment', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|Open' );
            
    if( !isLoggedIn( ) )
    {
        if( isEmpty( $_GET['type'] ) )
            showDefaultRegisterPage( );
        else
        {
            do if( ( ($_GET['action'] == 'employer_confirm')||( $_GET['action'] == 'student_confirm' ) || ( $_GET['action'] == 'alumni_confirm' ) ) && ( $_POST['submit'] != 'Edit' ) )
            {
                $student = ( $_GET['action'] == 'student_confirm' ? true : false );
                $alumni = ( $_GET['action'] == 'alumni_confirm' ? true : false );
                $employer = ($_GET['action'] == 'employer_confirm'? true : false );
                if($student == true || $alumni == true)
                {    
                    if( isEmpty( $_POST['class'] ) && $student )
                    {
                        $showError = true;
                        $errorCode['class'] = true;
                    }
                    /*        
                    if( !verifyRegEx( $_POST['phone'], '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/' ) )
                    {
                        $showError = true;
                        $errorCode['phone'] = true;
                    }
                            
                    if( !verifyRegEx( $_POST['psoft'], '/^[0-9]{7}$/' ) )
                    {
                        $showError = true;
                        $errorCode['psoft'] = true;
                    }
                            
                    if( !verifyRegEx( $_POST['psoftconf'], '/^[0-9]{7}$/' ) )
                    {
                        $showError = true;
                        $errorCode['psoftconf'] = true;
                    }
                    */                            
                    if( ( $_POST['psoft'] != $_POST['psoftconf'] ) && $student )
                    {
                        $showError = true;
                        $errorCode['psoft'] = true;
                        $errorCode['psoftconf'] = true;
                    }
                    /*        
                    if( !verifyRegEx( $_POST['email'], '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/' ) )
                    {
                        $showError = true;
                        $errorCode['email'] = true;
                    }
                            
                    if( !verifyRegEx( $_POST['emailconf'], '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/' ) )
                    {
                        $showError = true;
                        $errorCode['emailconf'] = true;
                    }
                    */        
                    if( $_POST['email'] != $_POST['emailconf'] )
                    {
                        $showError = true;
                        $errorCode['email'] = true;
                        $errorCode['emailconf'] = true;
                    }
                    /*    
                    if( !verifyPassword( $_POST['password'] ) )
                    {
                        $showError = true;
                        $errorCode['password'] = true;
                    }
                            
                    if( !verifyPassword( $_POST['cpassword'] ) )
                    {
                        $showError = true;
                        $errorCode['cpassword'] = true;
                    }
                    */        
                    if( $_POST['password'] != $_POST['cpassword'] )
                    {
                        $showError = true;
                        $errorCode['password'] = true;
                        $errorCode['cpassword'] = true;
                    }
                        
                    if( isEmpty( $_POST['major'] ) )
                    {
                        $showError = true;
                        $errorCode['major'] = true;
                    }
                    /*        
                    if( isEmpty( $_POST['geopref'] ) )
                    {
                        $showError = true;
                        $errorCode['geopref'] = true;
                    }
                    */                                    
                }
                /*
                echo $_GET['action'];
                echo $employer;    
                echo $showError;
                */    
                if( !$showError )
                {
                    $formFilled = true;    
                    $major = getLabelFromValue( $majorOptions, $_POST['major'] );
                    $geopref = getLabelFromValue( $locationOptions, $_POST['geopref'] );                    
                	/*
                	$careertypeList = array( 0 => 'app|Appraisal', 1 => 'bro|Brokerage', 2 => 'Inv|Investment', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|Open' );
                	*/
                    if( $student == true)
                    {
                        $class = ( $_POST['class'] == 'alumni' ? 'Alumni' : $_POST['class'] );            

                        showStudentRegistrationConfirmation( $_POST['fname'], $_POST['lname'], $_POST['argustut'], $_POST['argustcertificate'], $class, $major, $careerTypeList, $geopref, $_POST['phone'], $_POST['psoft'], $classesOptions, $_POST['email'] );
                    }
                    else if($alumni == true)
                    {
                        showAlumniRegistrationConfirmation( $_POST['fname'], $_POST['lname'], $major, $geopref, $_POST['phone'], $_POST['email'] );
                    }
                    else if($employer == true)
                    {
                        $geo = getLabelFromValue( $locationOptions, $_POST['geo'] );
                        $companyName = $_POST['company'];
                        
                        showEmployerRegistrationConfirmation($_POST['fname'], $_POST['lname'], $_POST['company'], $_POST['phone'], $_POST['email'],$_POST['website'] , $geo, $careerTypeList, $_POST['openingtype'],$_POST['experience'] );
                    }
                }    
                if( $_POST['submit'] == 'Confirm' )
                {
                    if( validatePSoft( $_POST['psoft'] ) )
                    {
                        $formFilled = true;    
                        echo '<h1>Thank you ' . $_POST['fname'] . '</h1>Your registration has successfully been submited. You will soon receive an e-mail confirming your submission. Upon reviewal from the Real Estate Department, you will recieve another email regarding the status of your acceptance.';
                        $argus = $_POST['argustut'] == 'yes' ? 1 : 0;
                        $arguscertificate = $_POST['arguscertificate'] == 'yes' ? 1 : 0;
                        $classes = getClasses( $classesOptions );
                        $careertype = getCareerTypes($careerTypeList);
                        $major = getIndexFromDelimitedArrayLabel( $majorOptions, $_POST['major'] );
                        $mba = $_POST['undergradmba'] == 'yes' ? 1 : 0;
                        if($_POST['geopref'] == '' || $_POST['geopref'] == 'No Preference' )
                            $gpref = 6;
                        else
                            $gpref = getIndexFromDelimitedArrayLabel( $locationOptions, $_POST['geopref'] );    
                        $password = md5( $salt . $_POST['pword'] );
                        
                        addStudent($_POST['fname'], str_replace( "'", "''", $_POST['lname'] ), $argus,$arguscertificate, $classes, $_POST['class'], $major,$careertype, $gpref, $_POST['phone'], $_POST['psoft'], $_POST['email'], $password, $mba );
                        sendStudentConfirmationMail( $_POST['fname'], $_POST['lname'], $_POST['email'] );
                    }
                    else
                    {
                        $duplicatePSoft = true;
                        $showError = true;    
                        if( validateEmail( $_POST['email'] ) )
                            $duplicateEmail = true;
                    }
                }
                else if( $_POST['submit'] == 'Confirm Alumni' )
                {
                    if( validateEmail( $_POST['email'] ) )
                    {
                        $formFilled = true;
                        echo '<h1>Thank you ' . $_POST['fname'] . '</h1>You registration has successfully been submited. You will soon receive an e-mail confirming your submission. Upon reviewal from the Real Estate Department, you will recieve another email regarding the status of your acceptance.';
                        $major = getIndexFromDelimitedArrayLabel( $majorOptions, $_POST['major'] );
                        $gpref = getIndexFromDelimitedArrayLabel( $locationOptions, $_POST['geopref'] );        
                        $password = md5( $salt . $_POST['pword'] );
                        
                        addAlumni( $_POST['fname'], str_replace( "'", "''", $_POST['lname'] ), $major, $gpref, $_POST['phone'], $_POST['email'], $password );
                        sendAlumniConfirmationMail( $_POST['fname'], $_POST['lname'], $_POST['email'] );
                    }
                    else
                    {
                        $duplicateEmail = true;
                        $showError = true;
                    }
                }    
                if( $_POST['submit'] == 'Confirm Employer' )
                {
                    if( validateEmployerEmail( $_POST['email'] ) )
                    {
                        $formFilled = true;                            
                        echo '<h1>Thank you ' . $_POST['fname'] . '</h1>Your registration has successfully been submited. You will soon receive an e-mail confirming your submission. Upon reviewal from the Real Estate Department, you will recieve another email regarding the status of your acceptance.';    
                        /*
                        $major = getIndexFromDelimitedArrayLabel( $majorOptions, $_POST['major'] );
                        $gpref = getIndexFromDelimitedArrayLabel( $locationOptions, $_POST['geopref'] );
                        $careertypeList = array( 0 => 'app|Appraisal', 1 => 'bro|Brokerage', 2 => 'Inv|Investment', 3 => 'Dev|Development', 4 => 'Mar|Marketing', 5 => 'Cou|Counseling', 6 => 'pro|Property Management', 7 => 'op|Open' );
                        */
                        $careertype = getCareerTypes($careerTypeList);    
                        $password = md5( $salt . $_POST['pword']);
                        /*    
                        echo $_POST['geo'].','.$_POST['openingtype'].','.$_POST['experience'];
                        echo ' Inside!!!!';
                        echo $companyName;
                        */
                        $geoIndex = getIndexFromDelimitedArrayLabel( $locationOptions, $_POST['geo']);
                        $openingType = getIndexFromDelimitedArrayLabel( $employeeOptions, $_POST['openingtype']);
                        $experience = getIndexFromDelimitedArrayLabel($experienceOptions, $_POST['experience']);
                            
                        addEmployer( $_POST['fname'], str_replace( "'", "''", $_POST['lname'] ),$_POST['company']/*$companyName*/ , $_POST['phone'], $_POST['email'], $_POST['website'],$geoIndex, /*$_POST['careertype']*/$careertype,$openingType, $experience, $password );
                            sendEmployerConfirmationMail( $_POST['fname'], $_POST['lname'], $_POST['email'] );    
                    }
                    else
                    {
                        showError( 'Error: The E-mail address you have entered is already registered to another user' );
                        $duplicateEmail = true;
                        $showError = true;
                    }
                }                            
                break;
            } while( false );

            if( ( ( $_GET['type'] == 'student' ) || ( $_GET['type'] == 'alumni' ) ) && !$formFilled )
            {
                $student = ( $_GET['type'] == 'student' ? true : false );
                if( $showError )
                {
                    if( $duplicatePSoft )
                        showError( 'Error: The PeopleSoft number you have entered is already registered to another user' );
                    if( $duplicateEmail )
                        showError( 'Error: The E-mail address you have entered is already registered to another user' );    
                    if($duplicatePSoft == false && $duplicateEmail == false && $releaseInfoUnchecked == true)
                        showError('Error: You must check the personal information release box in order to proceed');
                    if($duplicatePSoft == true || $duplicateEmail == true)
                        showError( 'Error: Please fill all forms correctly' ); 
                }

                if( $student )
                    startTableWithForm( 'register_student', 'register.php?type=student&amp;action=student_confirm', 'Student Registration', 'table_topBorder' );
                else
                    startTableWithForm( 'register_alumni', 'register.php?type=alumni&amp;action=alumni_confirm', 'Alumni Registration', 'table_topBorder' );
                
                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Personal</font></b><br>
                    </th>';

                tableTextInput( 'text', 'fname', 'First Name', 25, $_POST['fname'], $errorCode['fname'], '', true, '^[A-Z][a-z]+' );
                tableTextInput( 'text', 'lname', 'Last Name', 25, $_POST['lname'], $errorCode['lname'], '', true, '^[A-z-\']+([\s]{1}[A-z-\']+)?$' ); 

                if( $student )
                {
                    if( $duplicatePSoft )
                    {
                        tableTextInput( 'text', 'psoft', 'Peoplesoft', '', '', $errorCode['psoft'], '(7-digit numeric)', true, '^[0-9]{7}$' );
                        tableTextInput( 'text', 'psoftconf', 'Confirm Peoplesoft', '', '', $errorCode['psoftconf'], '(7-digit numeric)', true, '^[0-9]{7}$' );
                    }
                    else
                    {
                        tableTextInput( 'text', 'psoft', 'Peoplesoft', '', $_POST['psoft'], $errorCode['psoft'], '(7-digit numeric)', true, '^[0-9]{7}$' );
                        tableTextInput( 'text', 'psoftconf', 'Confirm Peoplesoft', '', $_POST['psoftconf'], $errorCode['psoftconf'], '(7-digit numeric)', true, '^[0-9]{7}$' );
                    }
                }

                tableTextInput( 'text', 'phone', 'Phone', '', $_POST['phone'], $errorCode['phone'], '(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$' );

                if( $duplicateEmail )
                    tableTextInput( 'email', 'email', 'E-mail', 30, '', $errorCode['email'], '', true, '' );
                else
                    tableTextInput( 'email', 'email', 'E-mail', 30, $_POST['email'], $errorCode['email'], '', true, '' );        
                tableTextInput( 'email', 'emailconf', 'Confirm E-mail', 30, $_POST['emailconf'], $errorCode['emailconf'], '', true, '' ); 
                echo '<tr>
                        <td>
                            <strong><i>Please choose a 6-15 long alphanumeric password for login purposes</i></strong>
                        </td>
                    </tr>';              
                if($student)
                {
                    tableTextInput( 'password', 'password', 'Password', '', $_POST['password'], $errorCode['password'], 'NOT your PeopleSoft Password', true, '^[0-9A-z]{6,15}$' );
                    tableTextInput( 'password', 'cpassword', 'Confirm Password', '', $_POST['cpassword'], $errorCode['cpassword'], 'NOT your PeopleSoft Password', true, '^[0-9A-z]{6,15}$' );
                }
                else
                {
                    tableTextInput( 'password', 'password', 'Password', '', $_POST['password'], $errorCode['password'], '', true, '^[0-9A-z]{6,15}$' );
                    tableTextInput( 'password', 'cpassword', 'Confirm Password', '', $_POST['cpassword'], $errorCode['cpassword'], '', true, '^[0-9A-z]{6,15}$' );
                }

                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">About</font></b><br>
                        <i>Please complete the following as they apply to you.</i>
                    </th>';
                
                if( $student )
                {
                    echo '<tr>
                            <td><strong>' . ( ( $errorCode['class'] ) ? '<font color="#FF0000">*Class</font>' : 'Class' ) . '</strong><br />
                                &nbsp;&nbsp;<select name="class" id="class"><option value=""></option>';    
                    $year = idate( 'Y' );
                    for( $i = 0; $i < 4; $i++ )
                    {
                        echo '<option value="' . ( $year + $i ) . '" ' . ( ( $_POST['class'] == ( $year + $i ) ) ? 'selected="selected"' : '' ) . ' >' . ( $year + $i ) . '</option>';
                    }
                    echo '      </select>
                            </td>
                        </tr>';
                }

                if( $_POST['submit'] == 'Edit' )
                {
                    $majorValue = getValueFromLabel( $majorOptions, $_POST['major'] );
                    tableSelectInput( 'major', 'Major/MBA Focus', $majorOptions, $majorValue, $errorCode['major'], '' );
                }

                else
                    tableSelectInput( 'major', 'Major/MBA Focus', $majorOptions, $_POST['major'], $errorCode['major'], '' );
                
                echo '<tr>
                        <td>&nbsp;&nbsp;<input type="checkbox" name="undergradmba" value="yes"/>&nbsp;&nbsp;&nbsp;Are you an MBA student?</td>
                    </tr>';

                if( $student )
                {
                    echo '<tr>
                            <td>&nbsp;&nbsp;<input type="checkbox" name="argustut" value="yes" ' . ( $_POST['argustut'] == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;Are you now, or have you taken the ARGUS class?
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;&nbsp;<input type="checkbox" name="argusCertificate" value="yes" ' . ( $_POST['arguscertifcate'] == "yes" ? 'checked' : '' ) . ' />&nbsp;&nbsp;&nbsp;Are you ARGUS certified?
                            </td>
                        </tr>';
                }  

                if( $student )
                    tableCheckboxInput( 'Check the courses you have or are currently taking:', $classesOptions );

                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Job Preferences</font></b><br>
                        <i>Describe the types of jobs that interest you.</i>
                    </th>';

                tableCheckboxInput("Job Functions (Check all that apply): ", $careerTypeList);    
                if( $_POST['submit'] == 'Edit' )
                {
                    $geoPrefValue = getValueFromLabel( $locationOptions, $_POST['geopref'] );
                    
                    tableSelectInput( 'geopref', 'Geographical Preference', $locationOptions, $geoPrefValue, $errorCode['geopref'], '' );
                }
                else
                    tableSelectInput( 'geopref', 'Geographical Preference', $locationOptions, $_POST['geopref'],$errorCode['geopref'], '' );
                
                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Finish Up</font></b><br>
                    </th>';
                    
                echo '
                    <tr width="50%">
                        <td>
                            <strong><font class="registerAgreement"><br>I hereby agree to release my personal information as well as uploading my resume upon account approval to the Center for Real Estate and Urban Economic Studies according to Connecticut General Statute 4-190 and the Family Educational Rights and Privacy Act of 1974. It is my understanding that the Center, as a service to Real Estate students, will be posting my resume on its website for password-protected access by real estate related firms.</font></strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br><input class="registerSubmitButton" type="submit" name="submit" value="Submit" />
                        </td>
                    </tr>';
                endTableWithForm( );   
            }
            else if( ( $_GET['type'] == 'employer' ) && !$formFilled )
            {
                startTableWithForm( 'register_employer', 'register.php?type=employer&amp;action=employer_confirm', 'Employer Registration', 'table_topBorder' );
                
                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Personal</font></b><br>
                        <i>Please provide some information about yourself.</i>
                    </th>';

                tableTextInput( 'text', 'fname', 'First Name', 25, $_POST['fname'], $errorCode['fname'], '', true, '^[A-Z][a-z]+' );
                tableTextInput( 'text', 'lname', 'Last Name', 25, $_POST['lname'], $errorCode['lname'], '', true, '^[A-z-\']+([\s]{1}[A-z-\']+)?$' );
                tableTextInput( 'text', 'phone', 'Company Phone', '', $_POST['phone'], $errorCode['phone'], '(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$' );
                tableTextInput( 'email', 'email', 'Company E-mail', 30, '', $errorCode['email'], '', true, '' );
                tableTextInput( 'email', 'emailconf', 'Confirm Company E-mail', 30, $_POST['emailconf'], $errorCode['emailconf'], '', true, '' );

                echo '<tr>
                        <td>
                            <strong><i>Please choose a 6-15 long alphanumeric password for login purposes</i></strong>
                        </td>
                    </tr>';
                tableTextInput( 'password', 'password', 'Password', '', $_POST['password'], $errorCode['password'], '', true, '^[0-9A-z]{6,15}$' );
                tableTextInput( 'password', 'cpassword', 'Confirm Password', '', $_POST['cpassword'], $errorCode['cpassword'], '', true, '^[0-9A-z]{6,15}$' );

                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Company</font></b><br>
                        <i>Please provide some information about your company.<br>This information will not be seen by students, but will be used to direct them to you.</i>
                    </th>';

                tableTextInput( 'text', 'company', 'Company Name', 50, $_POST['company'], $errorCode['company'], '', true, '' );
                tableTextInput( 'text', 'website', 'Company Website', 30, $_POST['website'], $errorCode['website'], '', true, '' );
                if( $_POST['submit'] == 'Edit' )
                {
                    $geoValue = getValueFromLabel( $locationOptions, $_POST['geo'] );

                    tableSelectInput( 'geo', 'Geographical Location of the job', $locationOptions, $geoValue, $errorCode['geo'], '' );
                }
                else
                    tableSelectInput( 'geo', 'Geographical Location of the job', $locationOptions, $_POST['geo'], $errorCode['geo'], '' );
                tableCheckboxInput("Primary Company Focus (Check all that apply): ", $careerTypeList);

                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Job Opening Types</font></b><br>
                        <i>Indicate the type of positions you are looking to fill.</i>
                    </th>';

                if( $_POST['submit'] == 'Edit' )
                {
                    $openingType = getValueFromLabel( $employeeOptions, $_POST['openingtype'] );
                            
                    tableSelectInput( 'openingtype', 'Job Opening', $employeeOptions, $openingType, $errorCode['openingtype'], '' );
                }
                else
                    tableSelectInput( 'openingtype', 'Job Opening', $employeeOptions, $_POST['openingtype'], $errorCode['openingtype'], '' ); 

                if( $_POST['submit'] == 'Edit' )
                {
                    $experienceType = getValueFromLabel( $employeeOptions, $_POST['experience'] );
                            
                    tableSelectInput( 'experience', 'Necessary Experience (Years)', $experienceOptions, $experienceType, $errorCode['experience'], '' );
                }
                else
                    tableSelectInput( 'experience', 'Necessary Experience (Years)', $experienceOptions, $_POST['experience'], $errorCode['experience'], '' ); 
                
                echo '
                    <th style="border-bottom:1px solid #cccccc; text-align:left;">
                        <br><b><font size="+1">Finish Up</font></b><br>
                    </th>';

                echo '
                    <tr>
                        <td>
                            <input class="registerSubmitButton" type="submit" name="submit" value="Submit" />
                        </td>
                    </tr>';        
                endTableWithForm( );
            }
        }
    }
    else
        header( 'Location: index.php?error=4' );
?>  
      </td>
    </tr>
  </table>
</div>
<?php include 'footer.php'; ?>
</div>
</body>
</html>