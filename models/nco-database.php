<?php

require('DB/config.php');

/**
 * Class NcoDatabase
 * This class will provide the connection to the database and have pre-scripted functions for secure database
 * writing and retrieval.
 */
class Database
{
    // pdo object
    private $_dbh;

    function __construct()
    {
        /*try {
            // create database connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            echo "connected!";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }*/
        $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    }

    // this function inserts all the data from the form to the database
    //TODO: Needs rework to work with new db revision.
    function insertData()
    {
        $dataObj = $_SESSION['info'];


        $sql = "INSERT INTO mto.Test VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->_dbh->prepare($sql);

         $statement->execute([$dataObj->getProgrammer(), $dataObj->getAssy(), $dataObj->getModel(), $dataObj->getFwc(), $dataObj->getMedia(),
            $dataObj->getProgram(), $dataObj->getMake(), $dataObj->getDate(), $dataObj->getPtime(), $dataObj->getPtype(), $dataObj->getStatus(),
            $dataObj->getReason(), $dataObj->getBuyoff(), $dataObj->getInstruction(), $dataObj->getPnotes(),
            $dataObj->getProcess(), $dataObj->getOnotes(), $dataObj->getGeometry(), $dataObj->getSignature(), $dataObj->getSigdate(),
            $dataObj->getLnotes(), $dataObj->getSig2(), $dataObj->getSig2date()]);

        $this->_dbh->lastInsertId();
    }

    function createReport ()
    {

        $sql = "INSERT INTO mto.Test VALUES (DEFAULT, NULL , NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        return $this->_dbh->lastInsertId();
    }

    function insertOps()
    {
        $dataObj = $_SESSION['info'];

        $sql = "INSERT INTO mto.First_part_mto_run VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$this->_dbh->lastInsertId(), $dataObj->getOperator(), $dataObj->getDate2(), $dataObj->getPo(), $dataObj->getMachine(), $dataObj->getShift(),
            $dataObj->getSeq()]);
    }

    function getOperators($formID)
    {
        $sql = "SELECT * FROM mto.Test INNER JOIN first_part_mto_run ON Test.formID = first_part_mto_run.formID";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // this function retrieves all data from the Test table joined with the top operators
    function getData()
    {
        $sql = "SELECT * FROM mto.Test";
        /*INNER JOIN nco.First_part_mto_run
                ON nco.Test.formID = nco.First_part_mto_run.formID
                ORDER BY nco.Test.formID*/

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // this function gets all data from test where the form ID matches the given ID
    function getUpdate($formID)
    {
        $sql = "SELECT * FROM mto.Test WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function DataUpdate($formID)
    {
        $dataObj = $_SESSION['info'];

        $sql = "UPDATE mto.Test SET Programmer = ?, Assy = ?, Model = ?, FWC = ?, Media = ?, 
                Program_number = ?, Used_to_make = ?, Program_Date = ?, Program_Time = ?, 
                Program_type = ?, Part_Status = ?, Rev_reason = ?,  
                Prev_buy_off = ?, Programmers_instructions = ?, 
                Milling_proc = ?,  Geometry = ?, Signature = ?, 
                Layout_Date = ?,  
                Shop_signature = ?, Shop_Date = ? WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$dataObj->getProgrammer(), $dataObj->getAssy(), $dataObj->getModel(), $dataObj->getFwc(), $dataObj->getMedia(),
            $dataObj->getProgram(), $dataObj->getMake(), $dataObj->getDate(), $dataObj->getPtime(), $dataObj->getPtype(), $dataObj->getStatus(),
            $dataObj->getReason(), $dataObj->getBuyoff(), $dataObj->getInstruction(),
            $dataObj->getProcess(),  $dataObj->getGeometry(), $dataObj->getSignature(), $dataObj->getSigdate(),
             $dataObj->getSig2(), $dataObj->getSig2date(), $formID]);

        $this->setFirstPartMtoRun($_SESSION['formID']);
    }

    //GET tooling_sequence
    function getToolingSequence($id)
    {
        $sql = "SELECT * FROM mto.Tooling_sequence
                WHERE `formID` = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$id]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getSingleToolingSequence($formId, $id)
    {
        $sql = "SELECT * FROM mto.Tooling_sequence
                WHERE `formID` = ? AND tooling_sequence_id = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formId, $id]);

        return $statement->rowCount();
    }

    //This function sets the given information in the tooling sequence table
    function setToolingSequence($formID, $toolingSeqId)
    {
        $sql = 'INSERT INTO mto.Tooling_sequence
                VALUES(?, ?, default, default, default, default, default, default)';

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$toolingSeqId, $formID]);
    }

    //This function sets the given information in the tooling sequence table
    function removeToolingSequence($formID, $toolingSeqId)
    {
        $sql = 'DELETE FROM mto.Tooling_sequence WHERE formID = ? AND tooling_sequence_id = ?';

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID, $toolingSeqId]);
    }

    // this function will query already saved sequences
    function showSequence($formID)
    {
        $sql = "SELECT * FROM mto.Tooling_sequence WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function saveSequence($formID, $seqID, $columnName, $value) {
        $sql = "UPDATE mto.Tooling_sequence SET " .$columnName. " = ? WHERE formID = ? AND tooling_sequence_id = ?";

        $statement = $this->_dbh->prepare($sql);

        return $statement->execute([$value, $formID, $seqID]);

    }

    function getMtoreport($formID) {
        $sql = "SELECT seq_num, mto_comments, tooling_mto_status,fr_rpm_100, date_created FROM mto.Tooling_sequence WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // this function retrieves all information from the first_part_mto_run table for the given id
    function getFirstPartMtoRun($formID)
    {
        $sql = "SELECT * FROM mto.First_part_mto_run
                WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function setFirstPartMtoRun ($formID)
    {
        $dataObj = $_SESSION['info'];
        $sql = "INSERT INTO mto.First_part_mto_run VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formID, $dataObj->getOperator(), $dataObj->getDate2(), $dataObj->getPo(), $dataObj->getMachine(),
            $dataObj->getShift(), $dataObj->getSeq()]);
    }

    function deleteFullForm($formId)
    {
        $sql = "DELETE FROM mto.Test WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$formId]);

    }

    // this function will take a username and password and attempt to log a user into the website
    function login($username, $password)
    {
        // define sql query
        $sql = "SELECT id, username, password, permission, name FROM mto.User WHERE username = :username";

        // prepare statement
        $statement = $this->_dbh->prepare($sql);

        // bind params
        $statement->bindParam(':username', $username);

        // execute statement
        $statement->execute();

        // get array of values
        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        // TRUE if string $password matches string $array['0']['password'] (hash)
        if(password_verify($password, $array['0']['password'])) {
            return array (
                'id' => $array['0']['id'],
                'username' => $array['0']['username'],
                'permission' => $array['0']['permission'],
                'name' => $array['0']['name']
            );
        } else {
            // return an empty array
            return array();
        }
    }

    // this function will take a username and check to see if they are already in the database.
    function checkForUser($username)
    {
        // define sql query
        $sql = "SELECT id FROM mto.User WHERE username = ?";

        // prepare statement
        $statement = $this->_dbh->prepare($sql);

        // execute statement
        $statement->execute([$username]);

        // return return array of results
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // this function will take a username and password and attempt to create a user in the database
    function register($username, $password, $permission, $name)
    {
        // prepare sql statement
        $sql = "INSERT INTO mto.User VALUES (DEFAULT, ?, ?, ?, ?)";

        // prepare statement
        $statement = $this->_dbh->prepare($sql);

        // execute statement
        $statement->execute([$username, password_hash($password, PASSWORD_DEFAULT), $permission, $name]);

        // nothing to return
    }

    function dbsavetext($lnotes, $pnotes, $onotes, $formID)
    {
        // prepare sql statement
        $sql = "UPDATE mto.Test SET programmers_notes = ?, operators_notes = ?, layout_notes = ? WHERE formID = ?;";

        // prepare statement
        $statement = $this->_dbh->prepare($sql);

        // execute statement
        $statement->execute([$pnotes, $onotes, $lnotes, $formID]);

        // nothing to return
    }
}