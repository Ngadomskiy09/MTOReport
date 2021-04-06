<?php

class Routes
{
    private $_f3;
    private $_dbh;

    function __construct($f3)
    {
        $this->_f3 = $f3;
        $this->_dbh = new Database();
    }

    // handles user login
    function loginpage()
    {
        // check if user is already logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            $this->_f3->reroute("/");
            exit;
        }

        // process data when form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Define variables and initialize with empty values
            $username = $password = "";
            $username_err = $password_err = "";

            // Check if username is empty
            if (empty(trim($_POST['username']))) {
                $username_err = "Please enter a username.";
                $this->_f3->set('username_err', $username_err);
            } else {
                $username = trim($_POST['username']);
                $this->_f3->set('username', $username);
            }

            // check if password is empty
            if (empty(trim($_POST['password']))) {
                $password_err = "Please enter a password.";
                $this->_f3->set('password_err', $password_err);
            } else {
                $password = trim($_POST['password']);
            }

            // validate credentials
            if (empty($username_err) && empty($password_err)) {

                // if user exists, if yes then verify password
                $result = $this->_dbh->checkForUser($username);
                if (!empty($result)) {
                    $result = $this->_dbh->login($username, $password);


                    // if the array is not empty
                    if (!empty($result)) {
                        // password is correct, start a new session
                        session_start();

                        // assign session variables
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $result['id'];
                        $_SESSION['username'] = $result['username'];
                        $_SESSION['permission'] = $result['permission'];
                        $_SESSION['name'] = $result['name'];

                        // reroute to /data
                        $this->_f3->reroute('/data');

                    } else {
                        // password is not valid
                        $password_err = "Password was incorrect.";

                        // set error into the Hive
                        $this->_f3->set('password_err', $password_err);
                    }
                } else {
                    // password is not valid
                    $username_err = "Username does not exist.";

                    // set error into the Hive
                    $this->_f3->set('username_err', $username_err);
                }
            }
        }

        $views = new Template();
        echo $views->render("loginpage.html");
    }

    // handles adding users to the database
    function register()
    {


        // process data after form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // validate username
            if (empty(trim($_POST['username']))) {
                $username_err = "Please enter a username.";

                // set username_err into Hive
                $this->_f3->set('username_err', $username_err);
            } else {
                $username = $_POST['username'];

                // set username into Hive
                $this->_f3->set('username', $username);

                // if true, username was in the database. If false, the username was not found
                $usernameResult = $this->_dbh->checkForUser($username);

                if (!empty($usernameResult)) {
                    $username_err = "This username is already taken.";

                    // set username_err into Hive
                    $this->_f3->set('username_err', $username_err);
                } else {
                    $username = trim($_POST['username']);

                    // set username into Hive
                    $this->_f3->set('username', $username);
                }
            }

            // validate password
            if (empty(trim($_POST['password']))) {
                $password_err = "Please enter a password.";

                // set password_err into hive
                $this->_f3->set('password_err', $password_err);
            } else if (strlen(trim($_POST['password'])) < 6) {
                $password_err = "The password must have at least 6 characters.";

                // set password_err into Hive
                $this->_f3->set('password_err', $password_err);
            } else {
                $password = trim($_POST['password']);
            }

            // validate confirm password
            if (empty(trim($_POST['password']))) {
                $confirm_password_err = "Please confirm password.";

                // set confirm_password_err into Hive
                $this->_f3->set('confirm_password_err', $confirm_password_err);
            } else {
                $confirm_password = trim($_POST['confirm_password']);
                if (empty($password_err) && ($password != $confirm_password)) {
                    $confirm_password_err = "Passwords did not match.";

                    // set confirm_password_err into Hive
                    $this->_f3->set('confirm_password_err', $confirm_password_err);
                }
            }

            // validate permission
            if (empty(trim($_POST['permission']))) {
                $permission_err = "Please select a permission level.";

                // set permission_err into Hive
                $this->_f3->set('permission_err', $permission_err);
            } else {
                $permission = $_POST['permission'];

                // set permission into hive
                $this->_f3->set('permissionLevel', $permission);
            }

            // validate name
            if (empty(trim($_POST['name']))) {
                $name_err = "Please enter your name.";

                // Set name_err into Hive
                $this->_f3->set('name_err', $name_err);
            } else {
                $name = $_POST['name'];

                // set name into Hive
                $this->_f3->set('name', $name);
            }

            // check input errors before inserting into database
            if (empty($username_err) && empty($password_err) && empty($confirm_password_err)
                && empty($permission_err) && empty($name_err)) {
                $this->_dbh->register($username, $password, $permission, $name);

                // reroute user to login page
                $this->_f3->reroute('/');
            }
        }

        $views = new Template();
        echo $views->render("views/register.html");
    }


    function home($id)
    {
        $id = intval($id);
        //var_dump($this->_dbh->showSequence($id));
        if ($id !== 0) {

            $grab = $this->_dbh->getUpdate($id);
            $grab = $grab[0];

            // Add Data to hive
            $this->_f3->set('sequences',$this->_dbh->showSequence($id));
            $this->_f3->set('programmer', $grab['Programmer']);
            $this->_f3->set('assy', $grab['Assy']);
            $this->_f3->set('model', $grab['Model']);
            $this->_f3->set('fwc', $grab['FWC']);
            $this->_f3->set('media', $grab['Media']);
            $this->_f3->set('program', $grab['Program_number']);
            $this->_f3->set('make', $grab['Used_to_make']);
            $this->_f3->set('date', $grab['Program_Date']);
            $this->_f3->set('ptime', $grab['Program_Time']);
            $this->_f3->set('ptype', $grab['Program_type']);
            $this->_f3->set('stats', $grab['Part_Status']);
            $this->_f3->set('reason4', $grab['Rev_reason']);
            $this->_f3->set('bf', $grab['Prev_buy_off']);
            $this->_f3->set('instruct', $grab['Programmers_instructions']);
            $this->_f3->set('Pnotes', $grab['programmers_notes']);
            $this->_f3->set('operator', $grab['operator']);
            $this->_f3->set('date2', $grab['date2']);
            $this->_f3->set('po', $grab['po']);
            $this->_f3->set('machine', $grab['machine']);
            $this->_f3->set('shi', $grab['shi']);
            $this->_f3->set('seq', $grab['seq']);
            $this->_f3->set('pro', $grab['Milling_proc']);
            $this->_f3->set('Onotes', $grab['operators_notes']);
            $this->_f3->set('geo', $grab['Geometry']);
            $this->_f3->set('signature', $grab['Signature']);
            $this->_f3->set('sigdate', $grab['Layout_Date']);
            $this->_f3->set('mtostatus', $grab['mtostatus']);
            $this->_f3->set('rpmran', $grab['rpmran']);
            $this->_f3->set('mtocomments', $grab['mtocomments']);
            $this->_f3->set('Lnotes', $grab['layout_notes']);
            $this->_f3->set('sig2', $grab['Shop_signature']);
            $this->_f3->set('sig2date', $grab['Shop_Date']);
            $this->_f3->set('process', $grab['Milling_proc']);

            $views = new Template();
            echo $views->render('views/home.html');


        }

        else {
            $formID = $this->_dbh->createReport();
            $this->_f3->reroute("/home/" .$formID);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($id !== 0) {
            $_SESSION['info'] = new formData ($_POST['programmer'], $_POST['assy'], $_POST['model'], $_POST['fwc'],
                $_POST['media'], $_POST['program'], $_POST['make'], $_POST['date'],
                $_POST['ptime'], $_POST['ptype'], $_POST['status'], $_POST['reason'],
                $_POST['buyoff'], $_POST['instruction'], $_POST['Pnotes'], $_POST['operator'], $_POST['date2'], $_POST['po'],
                $_POST['machine'], $_POST['shift'], $_POST['seq'], $_POST['process'], $_POST['Onotes'], $_POST['geometry'], $_POST['signature'],
                $_POST['sigdate'], $_POST['Lnotes'], $_POST['sig2'], $_POST['sig2date']);

            $this->_dbh->DataUpdate($id);

            $this->_f3->reroute('/');
            }
        }
    }

    function data()
    {
        $this->_f3->set('dataInfo', $this->_dbh->getData());

        $views = new Template();
        echo $views->render("views/data.html");
    }

    function getInfoOperators(){
        $operators = $this->_dbh->getFirstPartMtoRun($_POST['id']);

        foreach($operators as $operator){
            echo "<tr>
                    <td>".$operator['operators_name']."</td>
                    <td>".$operator['date']."</td>
                    <td>".$operator['p_o_num']."</td>
                    <td>".$operator['machine']."</td>
                    <td> ".$operator['shift']."</td>
                    <td>".$operator['seq_from_to']."</td>
            </tr>";
        }
    }

    function SequenceBlock() {
        $value = $_POST['value'];
        $this->_dbh->setToolingSequence($_POST['formID'],$value);
        echo "<div class=\"block\" data-id = \"$value\">
                <div>      
                    <div class=\"row\">
                            <label class=\"col-sm-3\" for=\"seq$value\" style=\"font-size: xx-large; font-weight: bold\"><strong>Seq#</strong>
                                <input type=\"text\" data-input=\"3\" class=\"saveInfo form-control\" data-column=\"seq_num\" maxlength=\"5\" id=\"seq$value\" name=\"seqNum\">
                            </label>
                            
                            <br>
                            <br>
                            
                            <input class='col-sm-12' type=\"file\" id=\"image\" name=\"image\" data-column=\"file_url\" data-seqid=\"$value\" data-formId=\"".$_POST['formID']."\">
    
                            <br>
                            <br>
    
                        <label class=\"col-sm-12\" for=\"mtocomments$value\"><strong>MTO Comments: </strong>
                             <div class=\"editor saveInfo form-control\" data-column=\"mto_comments\" data-input=\"0\" id=\"mtocomments$value\" >
                            <textarea   name=\"mtocomments\" rows=\"3\" maxlength=\"2000\" placeholder=\"...\"></textarea>
                            </div>
                        </label>
                     </div>

                     <br>
                     <br>

                    <label><strong>MTO Status: </strong>
                        <select  class=\"form-control saveInfo\" data-column=\"tooling_mto_status\" data-input=\"2\">";

                            foreach( $this->_f3->get("mtostat") as $stat)
                               echo "<option value=\"$stat\">$stat</option>";

                        echo "</select>
                    </label>
                    
                    <label for=\"rpmran$value\">F/R and RPM ran @100%
                        <input class=\"saveInfo\" data-input=\"1\" type=\"checkbox\" id=\"rpmran$value\" data-column=\"fr_rpm_100\" name=\"rpmran\" value=\"checkbox\">
                    </label>
                   
                    <hr> 
                </div>
            </div>";
    }

    function RemoveSeq() {
        $value = $_POST['value'];
        $this->_dbh->removeToolingSequence($_POST['formID'],$value);
    }

    function saveSeq()
    {
        // index 0: == form id, 1: == the sequence id, 2: == the column where the value goes, 3: == value entered
        /**echo "<pre>";
        var_dump($_POST);
        echo "</pre>";**/

        foreach ($_POST["toolSeqInfo"] as $column) {
            if(!empty($column)){
                foreach ($column as $seqInfo) {
                    $this->_dbh->saveSequence($seqInfo[0], $seqInfo[1], $seqInfo[2], $seqInfo[3]);
                }
            }
        }
    }

    function saveSeqPic()
    {
        $imageName = substr($_FILES['image']['name'], 0, strpos($_FILES['image']['name'], ".")) . ('-').
            $_POST['seqId'] . ('-') . $_POST['formId'].substr($_FILES['image']['name'], strpos($_FILES['image']['name'],
                "."));
        $location = $_SERVER['DOCUMENT_ROOT'] . "/images/" . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $location);
        $this->_dbh->saveSequence($_POST['formId'], $_POST['seqId'], 'file_url', $imageName);
        echo $imageName;
    }

    function removeData()
    {
        $this->_dbh->deleteFullForm($_POST['dataRemoval']);
    }

    function mtoreport($id)
    {
        $value = $this->_dbh->getMtoreport($id);
        $this->_f3->set("seqnotes", $value);
        $views = new Template();
        echo $views->render("views/mtoreport.html");
    }

    function savetext () {
        $this->_dbh->dbsavetext($_POST["lnotes"], $_POST["pnotes"], $_POST['onotes'], $_POST["id"]);
    }
}
