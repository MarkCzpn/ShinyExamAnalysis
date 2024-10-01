<?php

require_once 'library/Language/LanguageFactory.php';
require_once 'library/Language/Translation.php';
require_once 'library/Soap/SoapFunctions.php';
require_once 'library/Soap/SoapFunctionsExam.php';
require_once 'curlFunctions.php';

require_once 'library/Soap/Classes/Exam/Exam.php';
use Language\LanguageFactory as LanguageFactory;

//make Soap Functions available
use Soap\SoapFunctionsExam as SoapFunctionsExam;
use Soap\SoapFunctions as SoapFunctions;

use Soap\Exam as Exam;

$oSoapFunctions = new SoapFunctions();
$oSoapFunctionsExam = new SoapFunctionsExam();

$ini = parse_ini_file('Config.ini');

//at first check session
// DO not work, get PHPSPeppPluginESSION???
// $oUserSessionInfoExam = $oSoapFunctionsExam->getUserSessionInfo($_GET['PHPSESSID'], true);
// var_dump($oUserSessionInfo); // is NULL, but WHYYY 
// //TODO ; change User type to normal User
// if(!isset($oUserSessionInfo) || !in_array($oUserSessionInfo -> getUserType(), [3,13,1,2,8]))
// {
//     echo('No Access : Session' );
//     die();
// }

// check Hash 
$sHMAC = $_GET['hmac'];
$sHashPassword = ConfigReader::getConfigValue('hashPassword', ConfigReader::PART_PROJECT, ConfigReader::INI_PROJECT);
$sParamsPart = mb_substr($_SERVER["REQUEST_URI"], mb_stripos($_SERVER["REQUEST_URI"],'?') + 1);
$sParamsPart = mb_substr($sParamsPart, 0,  mb_strpos($sParamsPart, '&hmac='));
$sHASH = hash_hmac('sha256', $sParamsPart, $sHashPassword);

if ($sHASH != $sHMAC)
{
    echo('No Access; HASH');
    die();
}


$oUserID = (int)$_GET['userid'];
$oUser = $oSoapFunctions->getUser($oUserID);

//echo ($oUser -> getFirstName() . $oUser -> getId() . '<br>');
$oSurveyId  = (int)$_GET['surveyid'];
//$oSurveyId  = (int)$_GET['examid'];

//get CSV make it inot UTF-8 string 
//$oCSVLink = $oSoapFunctions-> getCSVRawData($oSurveyId);

$oCSVLink = $oSoapFunctionsExam -> getExamResults($oSurveyId,'csv');



//do curl instead of file get contents
//$oCSV = file_get_contents($oCSVraw);
$oCSV = file_get_contents_curl($oCSVLink);

//echo('<br> 1 <br>');

//Why does first line Work second not?
$oCSV = iconv(mb_detect_encoding($oCSV, mb_detect_order(), true), "UTF-8", $oCSV);
//$oCSV = mb_convert_encoding($oCSV, 'UTF-8');


#build json
$token = hash('sha256', (string)$oSurveyId+(string)$oUserID);
$data->csv_link = $oCSVLink;
$data->id = $oSurveyId;

$data->user = $oUserID;
$data->token = $token;
$data->source = "evaexam";

$json_data= json_encode($data);

$ch = curl_init();


$endpoint = $ini['ip_adress'];

curl_setopt($ch, CURLOPT_URL, $endpoint );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
#curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');


curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo 'Error occured:' . curl_error($ch);
}
if ($httpCode == 200){
    echo "<iframe src= 'http://$endpoint/?token=$token' style=\"border: 1; position:fixed; top:0; left:0; right:0; bottom:0; width:100%; height:100%\"></iframe>";
    echo "<a href= 'http://$endpoint/?token=$token'>Analysis</a>";
}
else{
    echo curl_error($ch);
    echo 'Error occured: Somwhere after tried to open the connection to shiny';
}


//echo $result;

//http://0.0.0.0:8180/?token=d801d5008dac62890d7911829275c4966e89846adac18c125459ab24c705306d
//echo '<script type="text/javascript"> window.open("http://129.69.239.83:8180/"); </script>';
curl_close($ch);

# is something like this
# -X POST -d id=2 --data-binary @file2.csv https://example.com/upload -H 'Content-Type: text/csv' --data-binary needed?
# now this is the way :  curl -X POST -d id=2 --data-binary @test.csv http://localhost:8180 -H 'Content-Type: text/csv'
# sending Data to R Server


// $ch = curl_init();
// $endpoint = '129.69.239.43:7000/incomingEvaExam';

// $endpoint  = strval($endpoint . '?userID=' . $oUserID .'&examID=' .  $oSurveyId) ;
// print($endpoint);

// curl_setopt($ch, CURLOPT_URL, $endpoint );
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');


// curl_setopt($ch, CURLOPT_POSTFIELDS, $oCSV);

// $headers = array();
// $headers[] = 'Content-Type: text/csv ; charset=UTF-8';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error occured:' . curl_error($ch);
// }


// curl_close($ch);

//echo "<pre>$result</pre>";

?>

<!-- <iframe width= "500" height= 500 src= http://129.69.239.83:8180/ ></iframe> 