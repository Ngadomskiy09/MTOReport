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


    function home($id)
    {
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
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get Data from from
            //$grab = $grab[0];
            $programmer = $_POST['programmer'];
            $assy = $_POST['assy'];
            $model = $_POST['model'];
            $fwc = $_POST['fwc'];
            $media = $_POST['media'];
            $program = $_POST['program'];
            $make = $_POST['make'];
            $date = $_POST['date'];
            $ptime = $_POST['ptime'];
            $ptype = $_POST['ptype'];
            $status = $_POST['status'];
            $reason = $_POST['reason'];
            $buyoff = $_POST['buyoff'];
            $instruction = $_POST['instruction'];
            $pnotes = $_POST['Pnotes'];
            $operator = $_POST['operator'];
            $date2 = $_POST['date2'];
            $po = $_POST['po'];
            $machine = $_POST['machine'];
            $shift = $_POST['shift'];
            $seq = $_POST['seq'];
            $process = $_POST['process'];
            $onotes = $_POST['Onotes'];
            $geometry = $_POST['geometry'];
            $signature = $_POST['signature'];
            $sigdate = $_POST['sigdate'];
            $mtostatus = $_POST['mtostatus'];
            $rpmran = $_POST['rpmran'];
            $mtocomments = $_POST['mtocomments'];
            $lnotes = $_POST['Lnotes'];
            $sig2 = $_POST['sig2'];
            $sig2date = $_POST['sig2date'];

            // Add Data to hive
            $this->_f3->set('programmer', $programmer);
            $this->_f3->set('assy', $assy);
            $this->_f3->set('model', $model);
            $this->_f3->set('fwc', $fwc);
            $this->_f3->set('media', $media);
            $this->_f3->set('program', $program);
            $this->_f3->set('make', $make);
            $this->_f3->set('date', $date);
            $this->_f3->set('ptime', $ptime);
            $this->_f3->set('ptype', $ptype);
            $this->_f3->set('stats', $status);
            $this->_f3->set('reason4', $reason);
            $this->_f3->set('bf', $buyoff);
            $this->_f3->set('instruct', $instruction);
            $this->_f3->set('Pnotes', $pnotes);
            $this->_f3->set('operator', $operator);
            $this->_f3->set('date2', $date2);
            $this->_f3->set('po', $po);
            $this->_f3->set('machine', $machine);
            $this->_f3->set('shi', $shift);
            $this->_f3->set('seq', $seq);
            $this->_f3->set('pro', $process);
            $this->_f3->set('Onotes', $onotes);
            $this->_f3->set('geo', $geometry);
            $this->_f3->set('signature', $signature);
            $this->_f3->set('sigdate', $sigdate);
            $this->_f3->set('mtostatus', $mtostatus);
            $this->_f3->set('rpmran', $rpmran);
            $this->_f3->set('mtocomments', $mtocomments);
            $this->_f3->set('Lnotes', $lnotes);
            $this->_f3->set('sig2', $sig2);
            $this->_f3->set('sig2date', $sig2date);

            // Write Data to session
            $_SESSION['programmer'] = $programmer;
            $_SESSION['assy'] = $assy;
            $_SESSION['model'] = $model;
            $_SESSION['fwc'] = $fwc;
            $_SESSION['media'] = $media;
            $_SESSION['program'] = $program;
            $_SESSION['make'] = $make;
            $_SESSION['date'] = $date;
            $_SESSION['ptime'] = $ptime;
            $_SESSION['ptype'] = $ptype;
            $_SESSION['status'] = $status;
            $_SESSION['reason'] = $reason;
            $_SESSION['buyoff'] = $buyoff;
            $_SESSION['instruction'] = $instruction;
            $_SESSION['Pnotes'] = $pnotes;
            $_SESSION['operator'] = $operator;
            $_SESSION['date2'] = $date2;
            $_SESSION['po'] = $po;
            $_SESSION['machine'] = $machine;
            $_SESSION['shift'] = $shift;
            $_SESSION['seq'] = $seq;
            $_SESSION['process'] = $process;
            $_SESSION['Onotes'] = $onotes;
            $_SESSION['geometry'] = $geometry;
            $_SESSION['signature'] = $signature;
            $_SESSION['sigdate'] = $sigdate;
            $_SESSION['mtostatus'] = $mtostatus;
            $_SESSION['rpmran'] = $rpmran;
            $_SESSION['mtocomments'] = $mtocomments;
            $_SESSION['Lnotes'] = $lnotes;
            $_SESSION['sig2'] = $sig2;
            $_SESSION['sig2date'] = $sig2date;
            $_SESSION['info'] = new formData ($_POST['programmer'], $_POST['assy'], $_POST['model'], $_POST['fwc'],
                $_POST['media'], $_POST['program'], $_POST['make'], $_POST['date'],
                $_POST['ptime'], $_POST['ptype'], $_POST['status'], $_POST['reason'],
                $_POST['buyoff'], $_POST['instruction'], $_POST['Pnotes'], $_POST['operator'], $_POST['date2'], $_POST['po'],
                $_POST['machine'], $_POST['shift'], $_POST['seq'],$_POST['process'], $_POST['Onotes'], $_POST['geometry'], $_POST['signature'],
                $_POST['sigdate'], $_POST['Lnotes'], $_POST['sig2'], $_POST['sig2date']);



            if ($id == 0) {
                $this->_dbh->insertData();
                $this->_dbh->insertOps();
            } else {
                $this->_dbh->DataUpdate($id);
                $this->_dbh->setFirstPartMtoRun($id);
            }
            $this->_f3->reroute('/');


        }
        $views = new Template();
        echo $views->render('views/home.html');
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
                <h2>Sequence #$value</h2>
                
           
                    <div class=\"row\">
                            <label class=\"col-sm-3\" for=\"seq$value\">Seq#
                                <input type=\"text\" data-input=\"3\" class=\"saveInfo form-control shorten\" data-column=\"seq_num\" maxlength=\"5\" id=\"seq$value\" name=\"seqNum\">
                            </label>
    
                        <label class=\"col-sm-12\" for=\"mtocomments$value\"><strong>MTO Comments: </strong>
                            <textarea id=\"mtocomments$value\" data-input=\"0\" data-column=\"mto_comments\" name=\"mtocomments\" rows=\"3\" maxlength=\"2000\" class=\"saveInfo form-control\" placeholder=\"...\"></textarea>
                        </label>
                     </div>

                    <label for=\"rpmran$value\">F/R and RPM ran @100%
                        <input class=\"saveInfo\" data-input=\"1\" type=\"checkbox\" id=\"rpmran$value\" data-column=\"fr_rpm_100\" name=\"rpmran\" value=\"rpmran\">
                    </label>

                    <label><strong>MTO Status: </strong>
                        <select  class=\"form-control saveInfo\" data-column=\"tooling_mto_status\" data-input=\"2\">";

                            foreach( $this->_f3->get("mtostat") as $stat)
                               echo "<option value=\"$stat\">$stat</option>";

                        echo "</select>
                    </label>
                   

                    <input type=\"file\" id=\"image\" name=\"image\" data-column=\"file_url\">
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
}
