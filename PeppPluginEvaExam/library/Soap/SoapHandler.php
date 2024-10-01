<?php
/**
 * Copyright (C) 2019  Electric Paper Evaluationssysteme GmbH
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Contact:
 * Electric Paper
 * Evaluationssysteme GmbH
 * Konrad-Zuse-Allee 13
 * 21337 Lüneburg
 * Germany
 */
namespace Soap;

require_once 'library/Config/ConfigReader.php';
define('LOG_SOAP_ANSWERS', true);

/**
 * Created by PhpStorm.
 * User: tr
 * Date: 21.09.2016
 * Time: 08:10
 */
abstract class SoapHandler
{
	/**
	 * @var SoapClient
	 */
	protected $oSoapClient = null;
	protected $bLogSoap    = false;

	const SOAP_CONTEXT_SURVEY = 'SURVEY';
	const SOAP_CONTEXT_EXAM = 'EXAM';

	/**
	 * Soap constructor.
	 */
	public function __construct($bInternalWSDL = false, $sContext = self::SOAP_CONTEXT_SURVEY)
	{
		ini_set('soap.wsdl_cache', 0);
		ini_set('soap.wsdl_cache_enabled', 0);
		$this->bLogSoap = \ConfigReader::getConfigValue('soap.debug') == 1;
		
		$sUserName = \ConfigReader::getSoapUser();
		$sPassword = \ConfigReader::getSoapPassword();

		// Get the correct WSDL from the called context if several WSDLs are defined in Soap.ini
		$sExternalWSDL = mb_strtolower(\ConfigReader::getConfigValue('WSDL', \ConfigReader::PART_SOAP, \ConfigReader::INI_PROJECT));
		if (strpos($sExternalWSDL, ',') !== false)
		{
			$aMultipleExternalWSDLs = array_map('trim', explode(',', $sExternalWSDL));
			foreach ($aMultipleExternalWSDLs as $sOneExternalWSDL)
			{
				if ($sContext == self::SOAP_CONTEXT_EXAM && strpos(mb_strtolower($sOneExternalWSDL), mb_strtolower(self::SOAP_CONTEXT_EXAM)) !== false)
				{
					$sExternalWSDL = $sOneExternalWSDL;
				}
				elseif ($sContext == self::SOAP_CONTEXT_SURVEY && strpos(mb_strtolower($sOneExternalWSDL), mb_strtolower(self::SOAP_CONTEXT_EXAM)) === false)
				{
					$sExternalWSDL = $sOneExternalWSDL;
				}
			}
		}

		$sWSDL = $bInternalWSDL ? mb_strtolower(\ConfigReader::getConfigValue('soap.wsdl')) : $sExternalWSDL;
		$asClassMap = $this->getClassMap();
		
		$oSoapClient = $bInternalWSDL ? $this->getLocalSoapClient($sWSDL, $asClassMap) : $this->getExternalSoapClient($sWSDL, $asClassMap);
		
		$oSoapHeader = (object) array('Login' => $sUserName, 'Password' => $sPassword);
		$oSoapHeaders = new \SoapHeader($sWSDL, 'Header', $oSoapHeader);
		
		$oSoapClient->__setSoapHeaders($oSoapHeaders);
		$this->oSoapClient = $oSoapClient;
	}

	/**
	 * @return null|SoapFunctions|SoapFunctionsExam
	 */
	public static function getInstanceConsiderOperatingArea()
	{
		$sOperatingArea = \ConfigReader::getConfigValue('OperatingArea', \ConfigReader::PART_SOAP, \ConfigReader::INI_SOAP);
		if ($sOperatingArea == self::SOAP_CONTEXT_SURVEY)
		{
			require_once 'library/Soap/SoapFunctions.php';
			return new SoapFunctions();
		}
		else if ($sOperatingArea == self::SOAP_CONTEXT_EXAM)
		{
			require_once 'library/Soap/SoapFunctionsExam.php';
			return new SoapFunctionsExam();
		}
		else
		{
			error_log('Undefined Operating Area: '.$sOperatingArea);
			return null;
		}
	}
	
	public static function getSessionHelperConsiderOperatingArea($sSessionId, $sTokenId)
	{
		$sOperatingArea = \ConfigReader::getConfigValue('OperatingArea', \ConfigReader::PART_SOAP, \ConfigReader::INI_SOAP);
		if ($sOperatingArea == self::SOAP_CONTEXT_SURVEY)
		{
			require_once 'library/Soap/SessionHelper.php';
			return new SessionHelper($sSessionId, $sTokenId);
		}
		
		if ($sOperatingArea == self::SOAP_CONTEXT_EXAM)
		{
			require_once 'library/Soap/SessionHelperExam.php';
			return new SessionHelperExam($sSessionId, $sTokenId);
		}
		
		error_log('Undefined Operating Area: '.$sOperatingArea);
		
		return null;
	}

	/**
	 * Start an external connection to the SOAP API via URL.
	 * -> "<b>soap.serverURL</b>" has to be set in the config.ini
	 *
	 * @param String $sWsdlURL - Server URL of the WSDL
	 * @param array $asClassMap - class map of the SOAP API
	 * 
	 * @return \SoapClient
	 */
	private function getExternalSoapClient($sWsdlURL, $asClassMap = array())
	{
		return new \SoapClient($sWsdlURL, array(
				'trace' => 1, 
				'feature' => SOAP_SINGLE_ELEMENT_ARRAYS,
				'classmap ' => $asClassMap
		));
	}
	
	/**
	 * Start an internal connection to the SOAP API via local wsdl path
	 * 
	 * @param String $sWSDL - User password of the SOAP API user
	 * @param array $asClassMap - class map of the SOAP API
	 * 
	 * @return \SoapClient
	 */
	private function getLocalSoapClient($sWSDL, $asClassMap = array())
	{
		$sLocalServices = \ConfigReader::getSoapServicesPath();
		$sServicesLocation = $sLocalServices . substr($sWSDL, 0, -4). 'php';
		
		return new \SoapClient(null, array(
				'trace' => 1,
				'feature' => SOAP_SINGLE_ELEMENT_ARRAYS,
				'location' => $sServicesLocation,
				'uri' => $sLocalServices,
				'classmap ' => $asClassMap
		));
	}

	/**
	 * Call a SOAP transaction by name with params
	 * @param string $sTransactionName - Name of the transaction : not case-sensitive
	 * @param array $asParams - Params for call of the transaction
	 * @return bool|mixed - false on failure or mixed return value of the transaction
	 */
	public function callTransaction($sTransactionName, $asParams, $bDie = false)
	{
		try
		{
			return call_user_func_array(array($this->oSoapClient, $sTransactionName), $asParams);
		}
		catch (\SoapFault $oException)
		{
			//In some cases, it's okay if null is returned instead of SoapFault
			if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_202') !== false
			|| strpos($oException->getCode() . $oException->getMessage(), 'ERR_312') !== false
			|| strpos($oException->getCode() . $oException->getMessage(), 'ERR_550') !== false
			|| strpos($oException->getCode() . $oException->getMessage(), 'ERR_600_201') !== false)
			{
				return null;
			}

			$sMessage = __METHOD__ ."($sTransactionName) Exception at ".$oException->getFile().":".$oException->getLine()."\n".
					' - Code: ' . $oException->getCode() ."\n".
					' - Message: ' . $oException->getMessage() ."\n".
					' - Params: ' .	print_r($asParams, true) ."\n".
					' - Trace ' .$oException->getTraceAsString() ."\n".
					"\r\n";
			$this->logMessage($sMessage, 'soap.error.log');
			if ($this->bLogSoap)
			{
				echo '<pre>'.$sMessage.'</pre>';
			}
			if ($bDie)
			{
				if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_101') !== false)
				{
					die('SOAP Error: Internal SQL-Error');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_102') !== false)
				{
					die('SOAP Error: Unauthorized Client-IP');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_103') !== false)
				{
					die('SOAP Error: Incorrect credentials supplied (login and/or password are wrong)');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_104') !== false)
				{
					die('SOAP Error: No SOAP Header transmitted');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_105') !== false)
				{
					die('SOAP Error: Transmitted ticket is not valid. Please request a new ticket by calling "RequestTicket"-method');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_106') !== false)
				{
					die('SOAP Error: The SOAP client has no rights to perform this SOAP call');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_107') !== false)
				{
					die('SOAP Error: No ticket in transmitted SOAP header found');
				}
				else if (strpos($oException->getCode() . $oException->getMessage(), 'ERR_108') !== false)
				{
					die('SOAP Error: Incomplete input parameters');
				}
				else
				{
					die('SOAP ERROR: Error during SOAP Request.' . $oException->getMessage());
				}
			}
		}
		return false;
	}

	/**
	 * Log a message in a file
	 * @param string $sMessage - Message to log
	 * @param string $sFilename - Name of the log file
	 */
	protected function logMessage($sMessage, $sFilename = 'soap.log')
	{
		$hFile = fopen($sFilename, "a+");
		fwrite($hFile, @date("Y-m-d H:i:s", time()) . " - " . $sMessage . "\r\n");
		fclose($hFile);
	}

	/**
	 * Convert stdClass Object to Array
	 * @param array aData
	 * @return array
	 */
	public function asArray($aData)
	{
		if (empty($aData))
		{
			$aData = false;
		}
		if ($aData !== false)
		{
			$aData = json_decode(json_encode($aData), true);
			if ($this->bLogSoap)
			{
				$aFunction = debug_backtrace();
				$this->logMessage($aFunction[1]['function'] . '(): ' . print_r($aFunction, true), 'soap.debug.log');
			}
		}
		return $aData;
	}
	
	/**
	 * Returns the SOAP API class map
	 * @return array();
	 */
	protected function getClassMap()
	{
		return array(
			'OnlineSurveyKey' => 'COnlineSurveyKeyModel',
			'OnlineSurveyKeyList' => 'CListOnlineSurveyKeyModel',
			'User' => 'SoapCUser',
			'Unit' => 'SoapCUnit',
			'Course' => 'SoapCCourse',
			'Survey' => 'SoapCSurvey',
			'ObjectList' => 'CObjectList',
			'OnlineCode' => 'COnlineCode',
			'Person' => 'CPerson',
			'Session' => 'CCourseSession',
			'CourseCreator' => 'CSoapCourse',
			'UploadStatus' => 'CUploadStatus',
			'Instructor' => 'CInstructor',
			'SurveyHolder' => 'CAbstractSurveyHolder',
			'SurveyRawData' => 'CSurveyRawData',
			'ItemAnswer' => 'CItemAnswer',
			'SimpleForm' => 'CForm',
			'VFForm' => 'CSoapForm',
			'ItemGroup' => 'CSoapItemGroup',
			'Item' => 'CSoapItem',
			'Period' => 'CPeriod',
			'ItemAnswerListList' => 'ItemAnswerListList',
			'ItemAnswerList' => 'ItemAnswerList',
			'SurveyStatusList' => 'CSurveyStatusList',
			'SurveyStatus' => 'CSurveyStatus',
			'InvitationTask' => 'CSoapInvitationTask',
			'RemindTask' => 'CSoapRemindTask',
			'ResponseRateTask' => 'CSoapResponseRateTask',
			'CloseTask' => 'CSoapCloseTask',
			'TaskList' => 'TaskList',
			'Module' => 'CModule',
			'ModuleSession' => 'CModuleSession',
			'ModuleCourse' => 'CModuleCourse',
			'ModuleSurveyCreator' => 'ModuleSurveyCreator',
			'CustomModuleForm' => 'CCustomModuleForm',
			'ModuleItemGroup' => 'CSoapModuleItemGroup',
			'CourseType' => 'CCourseType',
			'VolumeLicense' => 'CSoapVolumeLicense',
			'VolumeLicenseList' => 'CSoapVolumeLicenseList',
			'SoapWebscanBatch' => 'CSoapWebscanBatch',
			'KeyValueList' => 'KeyValueList',
			'KeyValuePair' => 'CSoapKeyValuePair',
			'FilterSet' => 'CSoapFilterSet',
			'FilterSetList' => 'CFilterSetList',
			'Mail' => 'CSoapMail',
			'MailList' => 'CMailList',
			'MailSummary' => 'CSoapMailSummary',
			'VerifierSurvey' => 'CSoapVerifierSurvey',
			'VerifierBatch' => 'CSoapVerifierBatch',
			'VerifierSheet' => 'CSoapVerifierSheet',
			'VerifierQuestion' => 'CSoapVerifierQuestion',
			'VerifierQuestionAnswer' => 'CSoapVerifierQuestionAnswer',
			'VerifierBatchList' => 'VerifierBatchList',
			'VerifierSheetList' => 'VerifierSheetList',
			'VerifierQuestionList' => 'VerifierQuestionList',
			'VerifierQuestionAnswerList' => 'VerifierQuestionAnswerList',
			'Coord' => 'Position',
			'SurveySummary' => 'CSoapSurveySummary',
			'SurveySummaryList' => 'SurveySummaryList',
			'PDFReportDefinition' => 'CSoapPDFReportDefinition',
			'PDFReportDefinitionList' => 'PDFReportDefinitionList',
			'TextTemplate' => 'CSoapTextTemplate',
			'TextTemplateList' => 'TextTemplateList',
			'PswdSummay' => 'CSoapPwsdSummary',
			'Indicator' => 'CSoapIndicator',
			'IndicatorList' => 'IndicatorList',
			'IndicatorName' => 'CSoapIndicatorName',
			'IndicatorNameList' => 'IndicatorNameList',
			'Notice' => 'CSoapNotice',
			'NoticeList' => 'NoticeList'
		);
	}

	protected function initObjectArray($aData, $sField, $sClassName)
	{
		$aReturn = array();
		if (is_array($aData) && count($aData))
		{
			if (isset($aData[$sField]) && is_array($aData[$sField]) && isset($aData[$sField][0]) && is_array($aData[$sField][0]))
			{
				foreach ($aData[$sField] as $aChildData)
				{
					array_push($aReturn, new $sClassName($aChildData));
				}
			}
			else
			{
				array_push($aReturn, new $sClassName($aData[$sField]));
			}
		}
		return $aReturn;
	}

	protected function loadClass($sClassName, $sScope = '')
	{
		if(strlen($sScope) > 0)
		{
			$sScope.="/";
		}
		require_once 'library/Soap/Classes/'.$sScope.$sClassName.'.php';
	}
}