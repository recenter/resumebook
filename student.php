<?php //5.3
include 'header.php';
include_once 'session.php';
include_once 'php_helper/reg_helper.php';

if (!isLoggedIn()) {
    header('Location: index.php?error=2');
    die();
} else {
    if (in_array($_SESSION['access'], array(0, 2, 3)) {
        header('Location: index.php?error=3');
        die();
    }
    echo "<div><h2>Welcome, {$_SESSION['fname']} {$_SESSION['lname']}</h2></div>";
    
    if ($_FILES['userfile']['name'] != NULL || $_FILES['userfile']['name'] != '') {
        $allowedExts = array('pdf');
        $temp = explode('.', $_FILES['userfile']['name']);
        $extension = end($temp);

        if ($_FILES['userfile']['type'] == 'application/pdf'
            && ($_FILES['userfile']['size'] < 512000)
            && in_array($extension, $allowedExts)
        ) {
            if(file_exists($_SESSION['resume']))
                unlink($_SESSION['resume']);

            $uploaddir = 'E:/Inetpub/wwwroot/reresume/resumes/';
            $userdir = md5($_SESSION['psoft'].$_SESSION['fname'].$_SESSION['lname']).'/';
            $resumedir = $uploaddir.$userdir;
            $resumefile = $resumedir.basename($_FILES['userfile']['name']);
            $resumeInfo = pathinfo($resumefile);
            $rlname = preg_replace('/\W+/', '_', $_SESSION['lname']);
            $resumeRename = $resumeInfo['dirname'].'/'.$_SESSION['fname'].'_'.$rlname.'_Resume.'.$resumeInfo['extension'];
            $dircreated = false;
            $bResume = true;

            if (!is_dir($resumedir)) {
                if(!mkdir($uploaddir.DIRECTORY_SEPARATOR.$userdir)) {
                    echo '<br />';
                    showError('Error: Failed to make folder for resume');
                    $bResume = false;
                } else
                    $dircreated = true;
            } else
                $dircreated = true;

            if($dircreated && !move_uploaded_file($_FILES['userfile']['tmp_name'], $resumeRename)) {
                echo '<br />';
                showError( 'Error: Failed to upload the resume' );
                $bResume = false;
            }

            if($dircreated && ($_FILES['userfile']['error'] != 0)) {
                echo '<br />';
                showError('File upload error: '.$_FILES['userfile']['error']);
                $bResume = false;
            }
        }

        if($bResume) {
            $userid = $_SESSION['id'];
            $nameasvar = (string)
            $resumeRename1 = $nameasvar.$resumeRename;
            mssql_query("
            	UPDATE students
            	SET resume = '$resumeRename1'
            	WHERE id = '$userid'");
            updateResume($resumeRename);
            echo '<br />';
            showSuccessfulNotification('Resume successfully uploaded');
        } else
            showError( 'Error: Please upload a PDF document.' );
    }

    if ($_GET['action'] == 'jps') {
        displayJobPostingsToStudents();
    } elseif ($_GET['action'] == 'editprof') {
        if($_GET['sub'] == '') {
            $hidden = '';
            $mba = '';
            // $employee = '';
            $argus = '';
            $arguscertificate = '';
            $class = '';
            $classeslabels = array(
            	0 => 'f3230',
            	1 => 'f3332',
            	2 => 'f3333',
            	3 => 'f3334',
            	4 => 'b3274',
            	5 => 'f3302',
            	6 => 'e3439w',
            	7 => 'e2327',
            	8 => 'f4895');
            // array(0 => 'no', 1 => 'no', 2 => 'no', 3 => 'no', 4 => 'no', 5 => 'no', 6 => 'no', 7 => 'no');
            $major = '';
            $permadd_add = '';
            $permadd_city = '';
            $permadd_state = '';
            $permadd_zip = '';
            $placement1_companyName = '';
            $placement2_companyName = '';
            $placement3_companyName = '';
            $placement1_startDate = '';
            $placement2_startDate = '';
            $placement3_startDate = '';
            $placement1_jobType = '';
            $placement2_jobType = '';
            $placement3_jobType = '';

            if ($_SESSION['permadd'] != '') {
                $mba = $_SESSION['mba'];
                $hidden = $_SESSION['hidden'];
                // $employee = $_SESSION['employee'];
                $argus = $_SESSION['argus'];
                $arguscertificate = $_SESSION['arguscertificate'];
                $class = $_SESSION['class'];
                $classes = explode('|', $_SESSION['classes']);
                $major = $_SESSION['major'];
                $careertype = explode('|', $_SESSION['careertype']);
                // echo 'career'.$careertype[0];
                $geopref = $_SESSION['geopref'];
                $phone = $_SESSION['phone'];
                $email = $_SESSION['email'];
                $padd = explode('|', $_SESSION['permadd']);
                $permadd_add = $padd[0];
                $permadd_city = $padd[1];
                $permadd_state = $padd[2];
                $permadd_zip = $padd[3];
                $placement1 =  explode('|', $_SESSION['placement1']);
                $placement1_companyName = $placement1[0];
                $placement1_startDate = $placement1[1];
                $placement1_jobType = $placement1[2];
                $placement2 =  explode('|', $_SESSION['placement2']);
                $placement2_companyName = $placement2[0];
                $placement2_startDate = $placement2[1];
                $placement2_jobType = $placement2[2];
                $placement3 =  explode('|', $_SESSION['placement3']);
                $placement3_companyName = $placement3[0];
                $placement3_startDate = $placement3[1];
                $placement3_jobType = $placement3[2];
            }
            echo '
            <br />
            <form name="stprof" id="stprof" method="post" action="student.php?action=editprof&amp;sub=submit&amp;id='.$_GET['id'].'">
              <table width="100%" class="table_topBorder">
                <tr>
                  <td>
                    <input type="checkbox" name="profileHidden" value="yes" '.($hidden == '1' ? 'checked' : '').' />
                    &nbsp;&nbsp;&nbsp;
                    <font color="#FF0000">Hide profile from employers search</font>
                  </td>
                </tr>
                <th style="border-bottom:1px solid #cccccc;">
                  <br><b><font size="+1">About</font></b><br>
                  <i>Please indicate which of the following apply to you.</i>
                </th>
                <tr>
                  <td>
                    <input type="checkbox" name="argustut" value="yes" '.($argus == '1' ? 'checked' : '').' />
                    &nbsp;&nbsp;&nbsp;Currently taking or have taken the ARGUS class
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="arguscertificate" value="yes" '.($arguscertificate == '1' ? 'checked' : '').'/>
                    &nbsp;&nbsp;&nbsp;ARGUS Certified
                  </td>
                </tr>
                <tr>
                  <td>
                    <input type="checkbox" name="undergradOrMBA" value="yes" '.($mba == '1' ? 'checked' : '').' />
                    &nbsp;&nbsp;&nbsp;MBA Student
                  </td>
                </tr>';
            tableSelectInput2('major', 'Major', $majorOptions, $major, NULL);
            echo '
                <th style="border-bottom:1px solid #cccccc;">
                  <br><b><font size="+1">Job Preferences & History</font></b>
                </th>';
            displayCheckBoxes("Desired Job Functions (Check all that apply):", $careerTypeList, $careertype);
            tableSelectInput2('geopref', "Geographical Preference", $locationOptions, $geopref, NULL);
            echo '
                <th>
                  <h2>Placement (most recent first)</h2>
                </th>
                <tr>
                  <td>
                    <strong>Company Name</strong>
                    <input type="text" name="companyName1" value="'.$placement1_companyName.'" size="25">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Start Date</strong>
                    <input type="text" name="startDate1" value="'.$placement1_startDate.'" size="10">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Job Type</strong>
                    <input type="text" name="jobType1" value="'.$placement1_jobType.'" size="10">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Company Name</strong>
                    <input type="text" name="companyName2" value="'.$placement2_companyName.'" size="25">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Start Date</strong>
                    <input type="text" name="startDate2" value="'.$placement2_startDate.'" size="10">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Job Type</strong>
                    <input type="text" name="jobType2" value="'.$placement2_jobType.'" size="10">
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Company Name</strong>
                    <input type="text" name="companyName3" value="'.$placement3_companyName.'" size="25">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Start Date</strong>
                    <input type="text" name="startDate3" value="'.$placement3_startDate.'" size="10">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Job Type</strong>
                    <input type="text" name="jobType3" value="'.$placement3_jobType.'" size="10">
                  </td>
                </tr>
                <th style="border-bottom:1px solid #cccccc;">
                  <br><b><font size="+1">Personal</font></b>
                </th>';
            tableTextInput(
            	'text', 'phone', 'Phone', '', $phone, $errorCode['phone'],
            	'(xxx-xxx-xxxx)', true, '^[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}$');
            tableTextInput('email', 'email', 'E-mail', 30, $email, $errorCode['email'], '', true, '');
            echo '
                <tr>
                  <td>
                    <h2>Permanent Address</h2>
                    <strong>Address</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="padd" value="'.$permadd_add.'" size="50" required="true" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>City*</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="pcity" value="'.$permadd_city.'" size="10" required="true" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>State*</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="pstate" value="'.$permadd_state.'" size="2" required="true" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Zip Code*</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="pzip" value="'.$permadd_zip.'" size="5" required="true" />
                  </td>
                </tr>';

            if ($_SESSION['class'] != 0) {
                echo '
                <th style="border-bottom:1px solid #cccccc;">
                  <br><b><font size="+1">Student Info</font></b>
                </th>
                <tr>
                  <td>
                    <strong>Class</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="class" maxlength="4" size="1" value="'.$class.'" size="25" />
                  </td>
                </tr>';    
                displayCheckBoxes("Check the courses you have or are currently taking:", $classesOptions, $classes);

                $schooladd_add = '';
                $schooladd_city = '';
                $schooladd_state = '';
                $schooladd_zip = '';
            
                if ($_SESSION['schooladd'] != '') {
                    $sadd = explode('|', $_SESSION['schooladd']);
                    $schooladd_add = $sadd[0];
                    $schooladd_city = $sadd[1];
                    $schooladd_state = $sadd[2];
                    $schooladd_zip = $sadd[3];
                }

                echo '
                <tr>
                  <td>
                    <h2>School Address</h2>
                    <strong>Address</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="sadd" value="'.$schooladd_add.'" size="50" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>City</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="scity" value="'.$schooladd_city.'" size="10" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>State</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="sstate" value="'.$schooladd_state.'" size="2" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <strong>Zip Code</strong><br />
                    &nbsp;&nbsp;
                    <input type="text" name="szip" value="'.$schooladd_zip.'" size="5" />
                  </td>
                </tr>';
            }
            echo'
                <tr>
                  <td>
                    <br><input type="submit" name="submit" value="Save Changes" class="loginButton" />
                  </td>
                </tr>
              </table>
            </form>';
            die();
        } elseif ($_GET['sub'] == 'submit') {
            $mba =  $_POST['undergradOrMBA'] == 'yes' ? 1 : 0;
            $hidden =  $_POST['profileHidden'] == 'yes' ? 1 : 0;
            $argus = $_POST['argustut'] == 'yes' ? 1 : 0;
            $arguscertificate = $_POST['arguscertificate'] == 'yes' ? 1 : 0;
            $classes =  getClasses( $classesOptions);
            /* $careerTypeList = array(
                0 => 'app|Appraisal',
                1 => 'bro|Brokerage',
                2 => 'Inv|Investment',
                3 => 'Dev|Development',
                4 => 'Mar|Marketing',
                5 => 'Cou|Counseling',
                6 => 'pro|Property Management',
                7 => 'op|Open');
            */
            $careertype = getCareerTypes($careerTypeList);
            $permadd = $_POST['padd'].'|'.$_POST['pcity'].'|'.$_POST['pstate'].'|'.$_POST['pzip'];
            $schooladd = '';
            $intplcmnt = getIndexFromDelimitedArrayValue($internshipOptions, $_POST['intplcmnt']);
            $majorIndex = getIndexFromDelimitedArrayValue($majorOptions, $_POST['major']);

            if ($_POST['geopref'] == '' || $_POST['geopref'] == 'No Preference')
                $geoprefIndex = 6;
            else
                $geoprefIndex = getIndexFromDelimitedArrayValue($locationOptions, $_POST['geopref']);

            if (!isEmpty( $_POST['sadd']))
                $schooladd = $_POST['sadd'].'|'.$_POST['scity'].'|'.$_POST['sstate'].'|'.$_POST['szip'];

            $pl1 = $_POST['companyName1'].'|'.$_POST['startDate1'].'|'.$_POST['jobType1'];
            $pl2 = $_POST['companyName2'].'|'.$_POST['startDate2'].'|'.$_POST['jobType2'];
            $pl3 = $_POST['companyName3'].'|'.$_POST['startDate3'].'|'.$_POST['jobType3'];

            // echo $_POST['argus'].$_POST['arguscertificate'];
            // -1 for placed means "leave the placed flag as it is (i.e. don't update it)"
            updateStudent(
            	$_SESSION['id'], $argus, $arguscertificate, $classes/*$_POST['classes']*/,
            	$_POST['class'], $majorIndex, $careertype, $geoprefIndex,
            	$_POST['phone'], $_POST['email'], $permadd, $schooladd,
            	$pl1, $pl2, $pl3, $hidden, $mba, -1/*, $_SESSION['employee']*/);
        }
    }

    if ($_GET['action'] == '' || $_GET['sub'] == 'submit') {
        echo '
            <br><h2><a href="student.php?action=editprof&amp;id='.$_SESSION['id'].'">Edit Profile</a></h2>
            <br><h2><a href="student.php?action=jps">Job Postings</a></h2>
            <ul>
              <li><font size="+1">Resume</font>: ';
    } else {
        echo '
            <table width="100%" class="table_topBorder">
              <tr>
                <td>
                  <ul>
                     <li><font size="+1">Resume</font>: ';
    }

    if ($_SESSION['resume'] != NULL) {
        echo '
            <font size="+1" color="green"><strong>On file</strong></font>';

        if ($_GET['action'] == 'update') {
            echo '
                <h4>Please follow this <a href="http://www3.business.uconn.edu/reresume/docs/Resume_template.pdf">
                template</a> to prepare your resume.<br>For best results, make sure to upload your resume as a
                <font color = blue> PDF DOCUMENT.</font></h4><br />';
            // MAX_FILE_SIZE must precede the file input field
            // Name of input element determines name in $_FILES array
            echo '
                <form enctype="multipart/form-data" action="student.php" method="POST">
                  <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
                  Resume: <input size="75" name="userfile" type="file" />
                  &nbsp;
                  <input type="submit" value="Upload" />
                  (MAX FILE SIZE: 300KB)
                </form>
              </ul>
            </td>
          </tr>
        </table>';
        } elseif ($_GET['action'] == 'delete') {
            $bDeletedResume = true;

            if (file_exists($_SESSION['resume'])) {
                $resumeInfo = pathinfo( $_SESSION['resume'] );
                    
                if (!unlink($_SESSION['resume'] ) || !rmdir( $resumeInfo['dirname'])) {
                    $bDeletedResume = false;
                    showError('Error: Failed to delete resume');
                }
            } else
                $bDeletedResume = false;
                        
            if ($bDeletedResume) {
                $userid = $_SESSION['id'];
                mssql_query("
                	UPDATE students
                	SET resume = NULL
                	WHERE id = '$userid'");
                updateResume(NULL); // 0 );
                header('Location: student.php');
            }
        } else {
            echo '
                <ul>
                  <li><a href="resumes/index.php?userid='.$_SESSION['id'].'" target="_blank">View / Download</a>
                  <li><a href="student.php?action=update">Replace</a>
                  <li><a href="student.php?action=delete">Delete</a>
                </ul>
                <br><b>Please note:</b> for your resume to be recommended to employers, you must have either:
                <ul>
                  <li>completed two Real Estate courses or</li>
                  <li>completed one Real Estate course and be in the process of taking a second.</li>
                </ul>
              </ul>
            </td>
          </tr>
        </table>';
        }
    } else {
        echo '
            <font size="+1" color="red"><strong>Not On File</strong></font>';
        echo '
            <h4>Please follow this <a href="http://www3.business.uconn.edu/reresume/docs/Resume_template.pdf">
            template</a> to prepare your resume.<br>For best results, make sure to upload your resume as a
            <font color = blue> PDF DOCUMENT.</font></h4><br />';
        // MAX_FILE_SIZE must precede the file input field
        // Name of input element determines name in $_FILES array
        echo '
            <form enctype="multipart/form-data" action="student.php" method="POST">
              <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
              Resume: <input size="75" name="userfile" type="file" />
              &nbsp;
              <input type="submit" value="Upload" /> (MAX FILE SIZE: 300KB)
            </form>
          </ul>
        </td>
      </tr>
    </table>';
    }
}
?>


<?php

echo '
      </td>
    </tr>
  </table>
</div>';
include 'footer.php';
echo '</div></body></html>';
?>
