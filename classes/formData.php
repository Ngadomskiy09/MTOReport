<?php

class formData
{
    private $_programmer;
    private $_rtime;
    private $_model;
    private $_fwc;
    private $_media;
    private $_program;
    private $_make;
    private $_date;
    private $_ptime;
    private $_ptype;
    private $_status;
    private $_reason;
    private $_graphic;
    private $_mcd;
    private $_buyoff;
    private $_instruction;
    private $_operator;
    private $_date2;
    private $_po;
    private $_machine;
    private $_shift;
    private $_seq;
    private $_process;
    private $_geometry;
    private $_signature;
    private $_sigdate;
    private $_sig2;
    private $_sig2date;
    private $_Lnotes;
    private $_Onotes;
    private $_Pnotes;

    function __construct($programmer, $rtime, $model, $fwc, $media, $program, $make, $date, $ptime, $ptype, $status,
                         $reason, $graphic, $mcd, $buyoff, $instruction, $pnotes, $operator, $date2, $po, $machine, $shift,
                         $seq, $process, $onotes, $geometry, $signature, $sigdate, $lnotes, $sig2, $sig2date)
    {

        $this->_programmer = $programmer;
        $this->_rtime = $rtime;
        $this->_model = $model;
        $this->_fwc = $fwc;
        $this->_media = $media;
        $this->_program = $program;
        $this->_make = $make;
        $this->_date = !empty($date) ? date('Y-m-d',strtotime($date)) : null;
        $this->_ptime = $ptime;
        $this->_ptype = $ptype;
        $this->_status = $status;
        $this->_reason = $reason;
        $this->_graphic = $graphic;
        $this->_mcd = $mcd;
        $this->_buyoff = $buyoff;
        $this->_instruction = $instruction;
        $this->_operator = $operator;
        $this->_date2 = !empty($date2) ? date('Y-m-d',strtotime($date2)) : null;
        $this->_po = $po;
        $this->_machine = $machine;
        $this->_shift = $shift;
        $this->_seq = $seq;
        $this->_process = $process;
        $this->_geometry = $geometry;
        $this->_signature = $signature;
        $this->_sigdate = !empty($sigdate) ? date('Y-m-d',strtotime($sigdate)) : null;
        $this->_sig2 = $sig2;
        $this->_sig2date = !empty($sig2date) ? date('Y-m-d',strtotime($sig2date)) : null;
        $this->_Pnotes = $pnotes;
        $this->_Lnotes = $lnotes;
        $this->_Onotes = $onotes;
    }


    function getProgrammer()
    {
        return $this->_programmer;
    }

    function getProgram()
    {
        return $this->_program;
    }

    function getStatus()
    {
        return $this->_status;
    }

    function getDate()
    {
        return $this->_date;
    }

    function getRtime()
    {
        return $this->_rtime;
    }

    function getModel()
    {
        return $this->_model;
    }

    function getFwc()
    {
        return $this->_fwc;
    }

    function getMedia()
    {
        return $this->_media;
    }

    function getMake()
    {
        return $this->_make;
    }

    function getPtime()
    {
        return $this->_ptime;
    }

    function getReason()
    {
        return $this->_reason;
    }

    function getGraphic()
    {
        return $this->_graphic;
    }

    function getMcd()
    {
        return $this->_mcd;
    }

    function getBuyoff()
    {
        return $this->_buyoff;
    }

    function getInstruction()
    {
        return $this->_instruction;
    }

    function getOperator()
    {
        return $this->_operator;
    }

    function getDate2()
    {
        return $this->_date2;
    }

    function getPo()
    {
        return $this->_po;
    }

    function getMachine()
    {
        return $this->_machine;
    }

    function getShift()
    {
        return $this->_shift;
    }

    function getProcess()
    {
        return $this->_process;
    }

    function getGeometry()
    {
        return $this->_geometry;
    }

    function getSignature()
    {
        return $this->_signature;
    }

    function getSigdate()
    {
        return $this->_sigdate;
    }

    function getSig2()
    {
        return $this->_sig2;
    }

    function getSig2date()
    {
        return $this->_sig2date;
    }

    function getPtype()
    {
        return $this->_ptype;
    }

    function getPnotes()
    {
        return $this->_Pnotes;
    }

    function getOnotes()
    {
        return $this->_Onotes;
    }

    function getLnotes()
    {
        return $this->_Lnotes;
    }

    function getSeq()
    {
        return $this->_seq;
    }

    function setSeq($seq)
    {
        $this->_seq = $seq;
    }

    function setProgrammer($programmer)
    {
        $this->_programmer = $programmer;
    }

    function setProgram($program)
    {
        $this->_program = $program;
    }

    function setStatus($status)
    {
        $this->_status = $status;
    }

    function setDate($date)
    {
        $this->_date = $date;
    }

    function setRtime($rtime)
    {
        $this->_rtime = $rtime;
    }

    function setModel($model)
    {
        $this->_model = $model;
    }

    function setFwc($fwc)
    {
        $this->_fwc = $fwc;
    }

    function setMedia($media)
    {
        $this->_media = $media;
    }

    function setMake($make)
    {
        $this->_make = $make;
    }

    function setPtime($ptime)
    {
        $this->_ptime = $ptime;
    }

    function setPtype($ptype)
    {
        $this->_ptype = $ptype;
    }

    function setReason($reason)
    {
        $this->_reason = $reason;
    }

    function setGraphic($graphic)
    {
        $this->_graphic = $graphic;
    }

    function setMcd($mcd)
    {
        $this->_mcd = $mcd;
    }

    function setBuyoff($buyoff)
    {
        $this->_buyoff = $buyoff;
    }

    function setInstruction($instruction)
    {
        $this->_instruction = $instruction;
    }

    function setOperator($operator)
    {
        $this->_operator = $operator;
    }

    function setDate2($date2)
    {
        $this->_date2 = $date2;
    }

    function setPo($po)
    {
        $this->_po = $po;
    }

    function setMachine($machine)
    {
        $this->_machine = $machine;
    }

    function setShift($shift)
    {
        $this->_shift = $shift;
    }

    function setProcess($process)
    {
        $this->_process = $process;
    }

    function setGeometry($geometry)
    {
        $this->_geometry = $geometry;
    }

    function setSignature($signature)
    {
        $this->_signature = $signature;
    }

    function setSigdate($sigdate)
    {
        $this->_sigdate = $sigdate;
    }

    function setSig2($sig2)
    {
        $this->_sig2 = $sig2;
    }

    function setSig2date($sig2date)
    {
        $this->_sig2date = $sig2date;
    }

    function setOnotes($onotes)
    {
        $this->_Onotes = $onotes;
    }

    function setPnotes($pnotes)
    {
        $this->_Pnotes = $pnotes;
    }

    function setLnotes($lnotes)
    {
        $this->_Lnotes = $lnotes;
    }
}
