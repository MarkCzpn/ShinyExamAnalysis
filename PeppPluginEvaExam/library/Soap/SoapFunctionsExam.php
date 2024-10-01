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

use Soap\Exam as Classes;

require_once 'library/Soap/SoapHandler.php';
require_once 'library/Soap/_ASoap.php';

/**
 * Class that represent all current EvaExam SOAP API transactions
 *
 * Created by PhpStorm.
 * User: sbe
 * Date: 24.01.2017
 * Time: 09:11
 */
final class SoapFunctionsExam extends SoapHandler
{
	const ID_TYPE_INTERNAL 	= 'INTERNAL';
	const ID_TYPE_EXTERNAL 	= 'EXTERNAL';
	const ID_TYPE_PUBLIC	= 'PUBLIC';

	public function __construct()
	{
		parent::__construct(false, SoapHandler::SOAP_CONTEXT_EXAM);
	}

	protected function loadClass($sClassName, $sScope = 'Exam')
	{
		parent::loadClass($sClassName, $sScope);
	}
	
	public function addEMailsToQueue($aMails)
	{
		__FUNCTION__;
	}
	
	public function applyActionOnWebscanBatch($nBatchId, $nAction)
	{
		__FUNCTION__;
	}
	
	public function assignGradingKey($nExamId, $nGradingKeyId)
	{
		$this->loadClass('GradingKey');
		$aReturn =  $this->callTransaction(__FUNCTION__, ['ExamId' => $nExamId, 'GradingKeyId' => $nGradingKeyId]);
		return $aReturn;
	}
	
	public function closeExam($nExamId)
	{
		__FUNCTION__;
	}
	
	public function deleteCustomUserSetting($sSettingKey)
	{
		__FUNCTION__;
	}
	
	public function deleteExam($nExamId)
	{
		__FUNCTION__;
	}
	
	public function deleteExamFolder($nExamFolderId)
	{
		__FUNCTION__;
	}
	
	public function deleteExamSheet($nExamSheetId)
	{
		__FUNCTION__;
	}
	
	public function deleteForms($aFormList)
	{
		__FUNCTION__;
	}
	
	public function deleteGradingKey($nGradingKeyId)
	{
		__FUNCTION__;
	}
	
	public function deleteSubunit($nSubunitId, $nIdType)
	{
		__FUNCTION__;
	}
	
	public function deleteUnusedPswds($aOnlineCodes)
	{
		__FUNCTION__;
	}
	
	public function deleteUser($nUserId, $nIdType)
	{
		__FUNCTION__;
	}
	
	public function exportExamSheet($nExamSheetId)
	{
		__FUNCTION__;
	}
	
	public function generateExamPswds($nExamId, $nPswdCount)
	{
		__FUNCTION__;
	}
	
	public function getAccessibleSubunitsForSubunitAdmin($nUserId)
	{
		__FUNCTION__;
	}
	
	/**
	 * @param $nUserId
	 *
	 * @return Classes\ExamFolder[]
	 */
	public function getAllExamFolders($nUserId)
	{
		$this->loadClass('ExamFolder');
		$aoFolders = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('nUserId' => (int) $nUserId)));
		if (isset($aReturn['ExamFolders']) && is_array($aReturn['ExamFolders']) && isset($aReturn['ExamFolders'][0]) && is_array($aReturn['ExamFolders'][0]))
		{
			foreach ($aReturn['ExamFolders'] as $asFolder)
			{
				array_push($aoFolders, new Classes\ExamFolder($asFolder));
			}
		}
		else
		{
			array_push($aoFolders, new Classes\ExamFolder($aReturn['ExamFolders']));
		}
		return $aoFolders;
	}
	
	/**
	 * @param $nFolderId
	 *
	 * @return Classes\Exam[]
	 */
	public function getAllExamsByFolderId($nFolderId)
	{
		$this->loadClass('Exam');
		$aoExams = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FolderId' => (int) $nFolderId)));
		if (isset($aReturn['Exams']) && is_array($aReturn['Exams']) && isset($aReturn['Exams'][0]) && is_array($aReturn['Exams'][0]))
		{
			foreach ($aReturn['Exams'] as $asExam)
			{
				$oExam = new Classes\Exam($asExam);
				if($oExam->getExamId() > null)
				{
					array_push($aoExams, $oExam);
				}
			}
		}
		else
		{
			$oExam = new Classes\Exam($aReturn['Exams']);
			if($oExam->getExamId() > null)
			{
				array_push($aoExams, $oExam);
			}
		}
		return $aoExams;
	}

		/**
	 * @param $nFolderId
	 *
	 * @return Classes\Exam[]
	 */
	public function getExamIdsByParams()
	{
		$this->loadClass('Exam');
		$aoExams = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('Name' => "ac132292")));
		var_dump($aReturn);
		return $aReturn;

		if (isset($aReturn['Exams']) && is_array($aReturn['Exams']) && isset($aReturn['Exams'][0]) && is_array($aReturn['Exams'][0]))
		{
			foreach ($aReturn['Exams'] as $asExam)
			{
				$oExam = new Classes\Exam($asExam);
				if($oExam->getExamId() > null)
				{
					array_push($aoExams, $oExam);
				}
			}
		}
		else
		{
			$oExam = new Classes\Exam($aReturn['Exams']);
			if($oExam->getExamId() > null)
			{
				array_push($aoExams, $oExam);
			}
		}
		return $aoExams;
	}
	
	public function getAllExamSheets($nUserId)
	{
		__FUNCTION__;
	}
	
	/**
	 * @param $nUserId
	 * @param $bIncludeCustomGradingKeys
	 *
	 * @return Classes\GradingKey[]
	 */
	public function getAllGradingKeys($nUserId, $bIncludeCustomGradingKeys)
	{
		$this->loadClass('GradingKey');
		$aoGradingKeys = array();
		$aParams = ['UserId' => (int) $nUserId, 'IncludeCustomGradingKeys' => (bool) $bIncludeCustomGradingKeys];
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
		if (isset($aReturn['GradingKeys']) && is_array($aReturn['GradingKeys']) && isset($aReturn['GradingKeys'][0]) && is_array($aReturn['GradingKeys'][0]))
		{
			foreach ($aReturn['GradingKeys'] as $asGradingKey)
			{
				$oGradingKey = new Classes\GradingKey($asGradingKey);
				if($oGradingKey->getId() > null)
				{
					array_push($aoGradingKeys, $oGradingKey);
				}
			}
		}
		else
		{
			$oGradingKey = new Classes\GradingKey($aReturn['GradingKeys']);
			if($oGradingKey->getId() > null)
			{
				array_push($aoGradingKeys, $oGradingKey);
			}
		}
		return $aoGradingKeys;
	}
	
	public function getAllTextTemplateIDs()
	{
		__FUNCTION__;
	}
	
	public function getAnswerKeyByExamId($nExamId)
	{
		__FUNCTION__;
	}
	
	public function getAnswerKeyByFormId($nFormId)
	{
		__FUNCTION__;
	}

	/**
	 * Call SOAP Transaction GetConfigurationInfo
	 * @param int $nUserID
	 * @return Classes\KeyValuePair[]
	 */
	public function getConfigurationInfo($nUserID)
	{
		$this->loadClass('KeyValuePair');
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserId' => (int)$nUserID)));
		$aoKeyValuePairs = $this->initObjectArray($aReturn, 'Struct', '\Soap\Exam\KeyValuePair');
		return $aoKeyValuePairs;
	}
	
	public function getCSVRawData($nExamId)
	{
		__FUNCTION__;
	}
	
	public function getCustomUserSetting($sSettingKey)
	{
		__FUNCTION__;
	}
	
	public function getCustomUserSettingsList()
	{
		__FUNCTION__;
	}
	
	public function getEMailsByIdList($aMailIdList, $nStatus)
	{
		__FUNCTION__;
	}
	
	public function getEMailSummaryByCreationDate($sCreationDate)
	{
		__FUNCTION__;
	}
	
	public function getExam($nExamId, $bWithParticipants)
	{
		$this->loadClass('Exam');
		$oExam = new Classes\Exam($this->asArray($this->callTransaction(__FUNCTION__, array(
			'ExamId' => $nExamId,
			'WithParticipants' => $bWithParticipants))));
		if($oExam->getExamId() != null)
		{
			return $oExam;
		}
		return null;
	}
	
	public function getExamFolder($nExamFolderId)
	{
		__FUNCTION__;
	}
	
	public function getExamOriginalScansPDF($nExamId, $nSheetId, $nBatchId)
	{
		__FUNCTION__;
	}
	
	public function getExamPdf($nExamId, $nCopies, $nSerialNumber, $sParticipantIdentifier)
	{
		__FUNCTION__;
	}
	
	public function getExamPswds($nExamId)
	{
		__FUNCTION__;
	}

	/**
	 * Call SOAP Transaction GetExamResults
	 * @param $nExamId
	 * @param $sExportType = "pdf" or "csv"
	 * @return String - Link to pdf or csv
	 */
	public function getExamResults($nExamId, $sExportType = 'pdf')
	{
		return $this->callTransaction(__FUNCTION__, array('ExamId' => (int)$nExamId, 'ExportType' => $sExportType));
	}
	
	/**
	 * @param $nExamSheetId
	 *
	 * @return Classes\ExamSheet
	 */
	public function getExamSheet($nExamSheetId)
	{
		$this->loadClass('ExamSheet');
		$oExamSheet = new Classes\ExamSheet($this->asArray($this->callTransaction(__FUNCTION__, array(
			'ExamSheetId' => $nExamSheetId))));
		return $oExamSheet;
	}
	
	public function getExamTypes()
	{
		__FUNCTION__;
	}
	
	/**
	 * @param $nGradingKeyId
	 *
	 * @return Classes\GradingKey
	 */
	public function getGradingKey($nGradingKeyId)
	{
		$this->loadClass('GradingKey');
		$oGradingKey = new Classes\GradingKey($this->asArray($this->callTransaction(__FUNCTION__, array(
			'GradingKeyId' => $nGradingKeyId))));
		if($oGradingKey->getId() != null)
		{
			return $oGradingKey;
		}
		return null;
	}
	
	public function getOnlineExamLinkByParticipant($nExamId, $sParticipantIdentifier, $bAutoIncreasePSWDCount)
	{
		__FUNCTION__;
	}
	
	public function getPDFPswd($nExamId)
	{
		__FUNCTION__;
	}
	
	public function getPDFReport($nExamId, $nUserId, $nCustomPDFId, $nLanguageId)
	{
		__FUNCTION__;
	}
	
	public function getPreviewOfExamSheet($nExamSheetId)
	{
		__FUNCTION__;
	}
	
	public function getPswdsByExam($nExamId, $nPswdCount, $nCodeTypes)
	{
		__FUNCTION__;
	}
	
	public function getPswdsByParticipant($sParticipantIdentifier)
	{
		__FUNCTION__;
	}
	
	public function getSessionForUser($nUserId, $nIdType)
	{
		__FUNCTION__;
	}
	
	public function getSimpleForm($nFormId, $nIDType, $bIncludeCustomReports, $bIncludeUsageRestrictions)
	{
		__FUNCTION__;
	}
	
	public function getSubunit($nSubunitId, $nIdType, $bIncludeExaminers)
	{
		__FUNCTION__;
	}
	
	public function getSubunits()
	{
		__FUNCTION__;
	}
	
	public function getTextTemplateById($nTextTemplateId, $nFormId)
	{
		__FUNCTION__;
	}
	
	public function getUser($nUserId, $nTypeId)
	{
		__FUNCTION__;
	}
	
	public function getUserByIdConsiderExternalID($nUserId, $nIdType)
	{
		__FUNCTION__;
	}
	
	public function getUserByLogin($sLogin, $sPassword)
	{
		__FUNCTION__;
	}
	
	public function getUsersBySubunit($nSubunitId)
	{
		__FUNCTION__;
	}
	
	/**
	 * @param $sSessionId
	 * @param $bResumeSession
	 *
	 * @return null|Classes\UserSessionInfo
	 */
	public function getUserSessionInfo($sSessionId, $bResumeSession)
	{
		$this->loadClass('UserSessionInfo');
		$oUserSessionInfo = new Classes\UserSessionInfo($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SessionId' => $sSessionId,
			'ResumeSession' => (int) $bResumeSession))));
		if($oUserSessionInfo instanceof Classes\UserSessionInfo
		&& $oUserSessionInfo->getUserID() === null)
		{
			return null;
		}
		return $oUserSessionInfo;
	}
	
	public function getVerifierInfoByBatch($nBatchId, $nBatchIdType, $nExamId)
	{
		__FUNCTION__;
	}
	
	public function getVerifierInfoByParticipant($nExamId, $sParticipantIdentifier)
	{
		__FUNCTION__;
	}
	
	public function getVerifierInfoBySerialNumber($nExamId, $nSerialNumber, $nSerialNumberCounter)
	{
		__FUNCTION__;
	}
	
	public function getVerifierInfoBySurvey($nExamId)
	{
		__FUNCTION__;
	}
	
	public function getVFD($nFormId, $bIncludeSecondaryData)
	{
		__FUNCTION__;
	}
	
	public function getWebscanBatchList($nUserId, $sLanguage)
	{
		__FUNCTION__;
	}
	
	public function insertExam($oExam)
	{
		__FUNCTION__;
	}
	
	public function insertExamFolder($nFolderId, $nUserId, $sCreateDate, $sFolderName, $nDirTypeId)
	{
		__FUNCTION__;
	}
	
	public function insertExamSheet($oExamSheet)
	{
		__FUNCTION__;
	}
	
	public function insertGradingKey($oGradingKey)
	{
		$this->loadClass('GradingKey');
		$aoReturn = $this->callTransaction(__FUNCTION__, ['GradingKey' => $oGradingKey]);
		if($aoReturn instanceof  \stdClass)
		{
			return new Classes\GradingKey($this->asArray($aoReturn));
		}
		else
		{
			return null;
		}
	}
	
	public function insertSubunit($oUnit)
	{
		__FUNCTION__;
	}
	
	public function insertUser($oUser)
	{
		__FUNCTION__;
	}
	
	public function isPswdUnused($sPSWD)
	{
		__FUNCTION__;
	}
	
	public function openExam($nExamId)
	{
		__FUNCTION__;
	}
	
	public function requestTicket()
	{
		__FUNCTION__;
	}
	
	public function resetExam($nExamId)
	{
		__FUNCTION__;
	}
	
	public function saveCustomUserSetting($sSettingKey, $sSettingValue)
	{
		__FUNCTION__;
	}
	
	public function setScoring($nFormId, $aScores)
	{
		__FUNCTION__;
	}
	
	public function updateExam($oExam, $bDeleteExistingParticipants, $bCloseExam)
	{
		__FUNCTION__;
	}
	
	public function updateExamFolder($oExamFolder)
	{
		__FUNCTION__;
	}
	
	/**
	 * @param Classes\GradingKey $oGradingKey
	 *
	 * @return null|Classes\GradingKey
	 */
	public function updateGradingKey($oGradingKey)
	{
		$this->loadClass('GradingKey');
		$aoReturn = $this->callTransaction(__FUNCTION__, ['GradingKey' => $oGradingKey]);
		if($aoReturn instanceof  \stdClass)
		{
			return new Classes\GradingKey($this->asArray($aoReturn));
		}
		
		return null;
	}
	
	public function updateUser($oUser)
	{
		__FUNCTION__;
	}
	
	/**
	 * Returns the amount of SOAP request since a timestamp.
	 *
	 * @param string $sTimeFrom
	 * @param ?int   $nUserID
	 * @param string $sTimeTo
	 * @return array
	 */
	public function getSoapUsage($sTimeFrom, $nUserID = null, $sTimeTo = '')
	{
		$aData = ['TimeFrom' => $sTimeFrom, 'UserId' => $nUserID, 'TimeTo' => $sTimeTo];
		
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array($aData)));
		$aSoapUsage = [];
		if (isset($aReturn['Strings']) && \is_array($aReturn['Strings']) && \count($aReturn['Strings']) > 0)
		{
			foreach ($aReturn['Strings'] as $asSoapUsage)
			{
				$aSoapUsage[] = $asSoapUsage;
			}
		}
		elseif (isset($aReturn['Strings']))
		{
			$aSoapUsage[] = $aReturn['Strings'];
		}
		return $aSoapUsage;
	}
}