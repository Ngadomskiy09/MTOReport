<?php
//turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//require autoload file
require_once('vendor/autoload.php');

//session start
session_start();

//create instance of the base class
$f3 = Base::instance();

$dbh = new Database();

$routes = new Routes($f3);

//Set debug level
$f3->set('DEBUG', 3);

// array setup
$f3->set('stat', array('', 'Marginal', 'No buy-off', 'Needs L/O re-check', 'Waiting for Team Lead signature', 'PRO'));
$f3->set('reasons', array('', 'Improvement', 'change', 'SAT'));
$f3->set('graphics', array('', 'Vericut', 'Deneb', 'NCPSR'));
$f3->set('mcds', array('', 'yes', 'no'));
$f3->set('buyoffs', array('', 'Yes', 'No', 'Marginal (L/O)', 'Marginal (Shop)', 'N/A'));
$f3->set('instructions', array('', 'Programmer presence required', 'Ok to run without programmer'));
$f3->set('shifts', array('', '1', '2', '3'));
$f3->set('processes', array('', 'Yes', 'No', 'Still needs work'));
$f3->set('geometrys', array('', 'Yes', 'No', 'Marginal', 'L/O in process', 'Re-check required'));
$f3->set('mtostat', array('', 'Ran Good!', 'Marginal', 'Not Acceptable', 'Other(Add Comments)'));
$f3->set('permission', array('Select One', 'Operator', 'Programmer', 'Layout', 'Team Lead'));




// route to registration page
$f3->route('GET|POST /register', function () {
    $GLOBALS['routes']->register();
});

//route to home page
$f3->route('GET|POST /home/@id', function ($f3, $params) {
//    $_SESSION = array();
    $id = $params["id"];
    $_SESSION["formID"] = $id;
    $GLOBALS['routes']->home($id);
});

//Define a results summary route
$f3->route('GET|POST /summary', function () {
    //$GLOBALS['dbh']->insertData();
    $GLOBALS['routes']->summary();
});

// route to database
$f3->route('GET /', function () {
    $GLOBALS['routes']->data();
});

// route to database
$f3->route('POST /getops', function () {
    $GLOBALS['routes']->getInfoOperators();
});

$f3->route('POST /seqblock', function () {
    $GLOBALS['routes']->SequenceBlock();
});

$f3->route('POST /deleteSeq', function () {
    $GLOBALS['routes']->RemoveSeq();
});

$f3->route('POST /saveSeq', function () {
    $GLOBALS['routes']->saveSeq();
});

$f3->route('POST /saveSeqPic', function() {
    $GLOBALS['routes']->saveSeqPic();
});

$f3->route('POST /removeData', function() {
    $GLOBALS['routes']->removeData();
});

$f3->route('GET|POST /mtoreport/@id', function ($f3, $params) {
    $id = $params["id"];
    $_SESSION["formID"] = $id;
    $GLOBALS['routes']->mtoreport($id);
});

//run fat free
$f3->run();
