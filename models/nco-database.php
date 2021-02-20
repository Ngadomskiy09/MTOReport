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


        $sql = "INSERT INTO mto.Test VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $statement = $this->_dbh->prepare($sql);

         $statement->execute([$dataObj->getProgrammer(),$dataObj->getAssy(), $dataObj->getRtime(), $dataObj->getModel(), $dataObj->getFwc(), $dataObj->getMedia(),
            $dataObj->getProgram(), $dataObj->getMake(), $dataObj->getDate(), $dataObj->getPtime(), $dataObj->getPtype(), $dataObj->getStatus(),
            $dataObj->getReason(), $dataObj->getGraphic(), $dataObj->getMcd(), $dataObj->getBuyoff(), $dataObj->getInstruction(), $dataObj->getPnotes(),
            $dataObj->getProcess(), $dataObj->getOnotes(), $dataObj->getGeometry(), $dataObj->getSignature(), $dataObj->getSigdate(),
            $dataObj->getLnotes(), $dataObj->getSig2(), $dataObj->getSig2date()]);

        $this->setFirstPartMtoRun($this->_dbh->lastInsertId());

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

        $sql = "UPDATE mto.Test SET Programmer = ?, Assy = ?, Runtime = ?, Model = ?, FWC = ?, Media = ?, 
                Program_number = ?, Used_to_make = ?, Program_Date = ?, Program_Time = ?, 
                Program_type = ?, Part_Status = ?, Rev_reason = ?, Graphic = ?, MCD_compare = ?, 
                Prev_buy_off = ?, Programmers_instructions = ?, programmers_notes = ?,
                Milling_proc = ?, operators_notes = ?, Geometry = ?, Signature = ?, 
                Layout_Date = ?, Layout_notes = ?, 
                Shop_signature = ?, Shop_Date = ? WHERE formID = ?";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute([$dataObj->getProgrammer(), $dataObj->getAssy(), $dataObj->getRtime(), $dataObj->getModel(), $dataObj->getFwc(), $dataObj->getMedia(),
            $dataObj->getProgram(), $dataObj->getMake(), $dataObj->getDate(), $dataObj->getPtime(), $dataObj->getPtype(), $dataObj->getStatus(),
            $dataObj->getReason(), $dataObj->getGraphic(), $dataObj->getMcd(), $dataObj->getBuyoff(), $dataObj->getInstruction(), $dataObj->getPnotes(),
            $dataObj->getProcess(), $dataObj->getOnotes(), $dataObj->getGeometry(), $dataObj->getSignature(), $dataObj->getSigdate(),
            $dataObj->getLnotes(), $dataObj->getSig2(), $dataObj->getSig2date(), $formID]);
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

    //This function sets the given information in the tooling sequence table
    function setToolingSequence($formID, $toolingSeqId)
    {
        $sql = 'INSERT INTO mto.Tooling_sequence
                VALUES(?, ?, default, default, default, default, default, default, default, default, default, default, default)';

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
        $sql = "SELECT seq_num, mto_comments, tooling_mto_status FROM mto.Tooling_sequence WHERE formID = ?";

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
}