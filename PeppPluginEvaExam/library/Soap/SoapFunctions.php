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

require_once 'library/Soap/SoapHandler.php';
require_once 'library/Soap/_ASoap.php';
require_once 'library/Soap/ObjectCreator.php';

use Soap\Survey as Classes;
/**
 * Class that (should) represent all current SOAP API transactions
 *
 * Created by PhpStorm.
 * User: tr
 * Date: 21.09.2016
 * Time: 09:11
 */
final class SoapFunctions extends SoapHandler
{
	const ID_TYPE_INTERNAL = 'INTERNAL';
	const ID_TYPE_EXTERNAL = 'EXTERNAL';
	const ID_TYPE_PUBLIC = 'PUBLIC';
	
	const PDF_REPORT_DEFINITION_MODE_CREATE_INCLUSIVE = 'INCLUSIVE';
	const PDF_REPORT_DEFINITION_MODE_CREATE_EXCLUSIVE = 'EXCLUSIVE';

	public function __construct()
	{
		parent::__construct(false, SoapHandler::SOAP_CONTEXT_SURVEY);
	}

	public function loadClass($sClassName, $sScope = 'Survey')
	{
		parent::loadClass($sClassName, $sScope);
	}
	
	/**
	 * Activates the IOQ mode for one survey.
	 * @param int		$nSurveyID		ID of the survey
	 * @param boolean	$bSendEmail		If true, a mail is send to the instructor to activate the IOQ questions
	 * @param int		$nMode			Mode of activation:
	 *                      			1: Activate
	 *                      			2: Remind
	 *
	 * @return array
	 */
	public function activateOptionalQuestionsForSurvey($nSurveyID, $bSendEmail, $nMode)
	{
		return $this->asArray($this->callTransaction(__FUNCTION__, ['SurveyId' 	=> $nSurveyID,
																	'SendEmail' => $bSendEmail,
																	'Mode' 		=> $nMode]));
	}
	
	/**
	 * activate OptionalQuestions (=Meldemaske) for a survey and add some special questiongroups and questions
	 *
	 * @param integer $nSurveyID
	 * @param ItemGroupList $ItemGroupList
	 * @return boolean
	 */
	public function activateOptionalQuestionsForSurveyAddQuestions($nSurveyID, $oItemGroupList)
	{		
	    $this->loadClass('ItemGroupList');
		return $this->asArray($this->callTransaction(__FUNCTION__, ['SurveyId' 	=> $nSurveyID,
		                                                            'ItemGroupList' => $oItemGroupList])); 
	}
	
	/**
	 * Activates the IOQ mode for several surveys.
	 * @param int[]		$anSurveyIDs	ID of the surveys
	 * @param boolean	$bSendEmail		If true, a mail is send to the instructor to activate the IOQ questions
	 * @param int		$nMode			Mode of activation:
	 *                      			1: Activate
	 *                      			2: Remind
	 *
	 * @return array
	 */
	public function activateOptionalQuestionsForSurveys($anSurveyIDs, $bSendEmail, $nMode)
	{
		return $this->asArray($this->callTransaction(__FUNCTION__, ['SurveyIDList' 	=> $anSurveyIDs,
																	'SendEmail' => $bSendEmail,
																	'Mode' 		=> $nMode]));
	}

	public function addEMailsToQueue($aoMails)
	{
		return $this->asArray($this->callTransaction(__FUNCTION__, array('Mails' => $aoMails)));
	}
	
	/**
	 * Use "GetWebscanBatchList" to get a list of all webscan batches, where actions can be applied.
	 * Use the values of ProceedActionValue and CancelActionValue for proper actions.
	 * @param int $nBatchID		ReaderBatchId in the WebscanBatch object
	 * @param int $nAction		1 = continue
	 *                      	2 = cancel batch
	 *                      	3 = release batch
	 *                      	4 = not enough volume (SurveyGrid)
	 * @return boolean
	 */
	public function applyActionOnWebscanBatch($nBatchID, $nAction)
	{
		return $this->callTransaction(__FUNCTION__, array('BatchId' => $nBatchID, 'Action' => $nAction));
	}
	
	/**
	 * Sets the overall volume for a subunit. This function does not add but overwrites the volume.
	 * Note: -1 will reset the volume to unlimited.
	 * @param int 	$nSubunitID		Id of the subunit which should receive a volume amount
	 * @param int	$nVolume		Amount of volume which can be used by this subunit. -1 = unlimited
	 *
	 * @return boolean
	 */
	public function assignVolumeToSubunit($nSubunitID, $nVolume)
	{
		return $this->callTransaction(__FUNCTION__, array('SubunitId' => $nSubunitID, 'Volume' => $nVolume));
	}

	/**
	 * Call SOAP Transaction CloseSurvey
	 * @param integer $nSurveyID
	 * @return bool
	 */
	public function closeSurvey($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('nSurveyId' => $nSurveyID)) === 'true';
	}
	
	/**
	 * Creates a PDF report definition for a form.
	 *
	 * @param Classes\PDFReportDefinition $oPDFReportDefinition Object with basic parameters
	 * @param string					  $sCreationMode Modes: INCLUSIVE and EXCLUSIVE<br>
	 *                                    INCLUSIVE: Report contains only the questions given in the questions list<br>
	 *                                    EXCLUSIVE: Report contains all BUT the questions given in the questions list<br>
	 * 									  This function uses EXCLUSIVE as default
	 *
	 * @return int|null	returns either the ID of the report which was created or null, if any error occured
	 */
	public function createPdfReportDefinition($oPDFReportDefinition, $sCreationMode = self::PDF_REPORT_DEFINITION_MODE_CREATE_EXCLUSIVE)
	{
		$aReturn = $this->callTransaction(__FUNCTION__, array('PDFReportDefinition' => $oPDFReportDefinition->__toArray(), 'PDFReportDefinitionCreationMode' => $sCreationMode));
		if($aReturn > 0)
		{
			return $aReturn;
		}
		return null;
	}

	/**
	 * Call SOAP Transaction DeleteCourse
	 * @param int $nCourseID
	 * @param string $sIdType
	 * @return bool
	 */
	public function deleteCourse($nCourseID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		return $this->callTransaction(__FUNCTION__, array('CourseId' => (int)$nCourseID, 'IdType' => $sIdType)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteCourseType
	 * @param int $nCourseTypeID
	 * @return bool
	 */
	public function deleteCourseType($nCourseTypeID)
	{
		return $this->callTransaction(__FUNCTION__, array('CourseTypeId' => (int)$nCourseTypeID)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteFiltersByFormId
	 * @param int $nFormID
	 * @param int $nSurveyID
	 * @return bool
	 */
	public function deleteFiltersByFormId($nFormID, $nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'SurveyId' => (int)$nSurveyID)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteForm
	 * @param int $nFormID
	 * @return bool
	 */
	public function deleteForm($nFormID)
	{
		return $this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteForm
	 * @param array(int) $anFormIDs
	 * @return Classes\KeyValuePair[]
	 */
	public function deleteForms($anFormIDs)
	{
		$this->loadClass('KeyValuePair');
		$aoKeyValuePairs = array();
		$oFormIDList = ObjectCreator::createFormIDList($anFormIDs);
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array($oFormIDList)));
		if (isset($aReturn['KeyValuePair']) &&
			is_array($aReturn['KeyValuePair']) &&
			isset($aReturn['KeyValuePair'][0]) &&
			is_array($aReturn['KeyValuePair'][0])
		)
		{
			foreach ($aReturn['KeyValuePair'] as $asKeyValuePair)
			{
				$aoKeyValuePairs[] = new Classes\KeyValuePair($asKeyValuePair);
			}
		}
		else
		{
			$aoKeyValuePairs[] = new Classes\KeyValuePair($aReturn['KeyValuePair']);
		}
		return $aoKeyValuePairs;
	}

	/**
	 * Call SOAP Transaction DeleteSubunit
	 * @param int $nSubunitID
	 * @param string $sIdType
	 * @return bool
	 */
	public function deleteSubunit($nSubunitID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		return $this->callTransaction(__FUNCTION__, array('SubunitId' => (int)$nSubunitID, 'IdType' => $sIdType)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteSurvey
	 * @param int $nSurveyID
	 * @return bool
	 */
	public function deleteSurvey($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteTask
	 * @param int $nTaskID
	 * @return bool
	 */
	public function deleteTask($nTaskID)
	{
		return $this->callTransaction(__FUNCTION__, array('TaskId' => (int)$nTaskID)) === 'true';
	}
	
	/**
	 * Removes unused PSWDs. Unused PSWDs are those, which are not used yet. Send passwords will be deleted
	 * by this function as well.
	 * @param Classes\OnlineCode[] $aoOnlineCodes
	 *
	 * @return boolean
	 */
	public function deleteUnusedPswds($aoOnlineCodes)
	{
		$this->loadClass('OnlineCode');
		return $this->callTransaction(__FUNCTION__, array('OnlineCodes' => $aoOnlineCodes)) === 'true';
	}

	/**
	 * Call SOAP Transaction DeleteUser
	 * @param int $nUserID
	 * @param string $sIdType
	 * @return bool
	 */
	public function deleteUser($nUserID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		return $this->callTransaction(__FUNCTION__, array('UserId' => (int)$nUserID, 'IdType' => $sIdType)) === 'true';
	}
	
	public function deleteVolumeLicense($nUserID, $nLicenseID, $sLicenseKey)
	{
        return $this->callTransaction(__FUNCTION__, array('UserId' => (int)$nUserID, 'LicenseId' => $nLicenseID, 'LicenseKey' => $sLicenseKey)) === 'true';
	}

	/**
	 * Call SOAP Transaction GetAccessibleSubunitsForSubunitAdmin
	 * @param int $nUserID
	 * @return Classes\Unit[]
	 */
	public function getAccessibleSubunitsForSubunitAdmin($nUserID)
	{
		$this->loadClass('Unit');
		$aoUnits = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('nUserId' => (int)$nUserID)));
		if (isset($aReturn['Units']) && is_array($aReturn['Units']) && isset($aReturn['Units'][0]) && is_array($aReturn['Units'][0]))
		{
			foreach ($aReturn['Units'] as $asUnit)
			{
				$aoUnits[] = new Classes\Unit($asUnit);
			}
		}
		else
		{
			$aoUnits[] = new Classes\Unit($aReturn['Units']);
		}
		return $aoUnits;
	}

	public function getAllForms($bIncludeCustomReports, $bIncludeUsageRestrictions, Classes\UsageRestrictionList $oUsageRestrictionList = null)
	{
		$this->loadClass('SimpleForm');
		$aoForms = array();

		$aParams = [
			'IncludeCustomReports' => $bIncludeCustomReports,
			'IncludeUsageRestrictions' => $bIncludeUsageRestrictions,
			'UsageRestrictionList' => $oUsageRestrictionList];
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
		if (isset($aReturn['SimpleForms']) && is_array($aReturn['SimpleForms']) && isset($aReturn['SimpleForms'][0]) && is_array($aReturn['SimpleForms'][0]))
		{
			foreach ($aReturn['SimpleForms'] as $asForm)
			{
				$aoForms[] = new Classes\SimpleForm($asForm);
			}
		}
		else
		{
			$aoForms[] = new Classes\SimpleForm($aReturn['SimpleForms']);
		}
		return $aoForms;
	}

	/**
	 * Call SOAP Transaction GetAllPeriods
	 * @return Classes\Period[]
	 */
	public function getAllPeriods()
	{
		$this->loadClass('Period');
		$aoPeriods = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array()));
		if (isset($aReturn['Periods']) && is_array($aReturn['Periods']) && isset($aReturn['Periods'][0]) && is_array($aReturn['Periods'][0]))
		{
			foreach ($aReturn['Periods'] as $asPeriod)
			{
				$aoPeriods[] = new Classes\Period($asPeriod);
			}
		}
		else
		{
			$aoPeriods[] = new Classes\Period($aReturn['Periods']);
		}
		return $aoPeriods;
	}

	/**
	 * Call SOAP Transaction GetAllSurveysByFolderId
	 * @param int $nFolderID
	 * @return Classes\Survey[]
	 */
	public function getAllSurveysByFolderId($nFolderID)
	{
		$this->loadClass('Survey');
		$aoSurveys = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FolderId' => (int)$nFolderID)));
		if (isset($aReturn['Surveys']) && is_array($aReturn['Surveys']) && isset($aReturn['Surveys'][0]) && is_array($aReturn['Surveys'][0]))
		{
			foreach ($aReturn['Surveys'] as $asSurvey)
			{
				$aoSurveys[] = new Classes\Survey($asSurvey);
			}
		}
		else
		{
			$aoSurveys[] = new Classes\Survey($aReturn['Surveys']);
		}
		return $aoSurveys;
	}

	/**
	 * Call SOAP Transaction GetAllTextTemplateIDs
	 * @return array(string)
	 */
	public function getAllTextTemplateIDs()
	{
		$aResult = $this->asArray($this->callTransaction(__FUNCTION__, array()));
		return $aResult['Strings'];
	}

	/**
	 * Call SOAP Transaction GetConfigurationInfo
	 * @param int $nUserID
	 * @return Classes\KeyValuePair[]
	 */
	public function getConfigurationInfo($nUserID)
	{
		$this->loadClass('KeyValuePair');
		$aoKeyValuePairs = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserId' => (int)$nUserID)));
		if (isset($aReturn['KeyValuePair']) &&
			is_array($aReturn['KeyValuePair']) &&
			isset($aReturn['KeyValuePair'][0]) &&
			is_array($aReturn['KeyValuePair'][0])
		)
		{
			foreach ($aReturn['KeyValuePair'] as $asKeyValuePair)
			{
				$aoKeyValuePairs[] = new Classes\KeyValuePair($asKeyValuePair);
			}
		}
		elseif($aReturn['KeyValuePair'] != null)
		{
			$aoKeyValuePairs[] = new Classes\KeyValuePair($aReturn['KeyValuePair']);
		}
		return $aoKeyValuePairs;
	}

	/**
	 * Call SOAP Transaction GetCourse
	 * @param int $nCourseID
	 * @param string $sIdType
	 * @param bool $bIncludeSurveys
	 * @param bool $bIncludeParticipants
	 * @return Classes\Course
	 */
	public function getCourse($nCourseID, $sIdType = self::ID_TYPE_INTERNAL, $bIncludeSurveys = false, $bIncludeParticipants = false)
	{
		$this->loadClass('Course');
		return new Classes\Course($this->asArray($this->callTransaction('GetCourse', array(
			'CourseId' => $nCourseID,
			'IdType' => $sIdType,
			'IncludeSurveys' => (int)$bIncludeSurveys,
			'IncludeParticipants' => (int)$bIncludeParticipants))));
	}

	/**
	 * Call SOAP Transaction GetCourse
	 * @param int $nUserID
	 * @return Classes\Course[]
	 */
	public function getCoursesByUserId($nUserID)
	{
		$this->loadClass('Course');
		$aoCourses = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('nUserId' => (int)$nUserID)));
		if (isset($aReturn['Courses']) && is_array($aReturn['Courses']) && isset($aReturn['Courses'][0]) && is_array($aReturn['Courses'][0]))
		{
			foreach ($aReturn['Courses'] as $asCourse)
			{
				$aoCourses[] = new Classes\Course($asCourse);
			}
		}
		else
		{
			$aoCourses[] = new Classes\Course($aReturn['Courses']);
		}
		return $aoCourses;
	}

	/**
	 * Call SOAP Transaction GetCourseTypes
	 * @param bool $bOnlyModuleCourseTypes
	 * @return Classes\CourseType[]
	 */
	public function getCourseTypes($bOnlyModuleCourseTypes = false)
	{
		$this->loadClass('CourseType');

		$aoCourseTypes = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('OnlyModuleCourseTypes' => (int)$bOnlyModuleCourseTypes)));
		if (isset($aReturn['CourseTypes']) && is_array($aReturn['CourseTypes']) && isset($aReturn['CourseTypes'][0]) && is_array($aReturn['CourseTypes'][0]))
		{
			foreach ($aReturn['CourseTypes'] as $asCourseType)
			{
				$aoCourseTypes[] = new Classes\CourseType($asCourseType);
			}
		}
		else
		{
			$aoCourseTypes[] = new Classes\CourseType($aReturn['CourseTypes']);
		}
		return $aoCourseTypes;
	}

	/**
	 * Call SOAP Transaction GetCSVRawData
	 * @param int $nSurveyID
	 * @return string URL
	 */
	public function getCSVRawData($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID));
	}

	/**
	 * Call SOAP Transaction GetCSVRawData
	 * @param int $nFormID
	 * @param string $sIdType
	 * @return Classes\CustomReports[]
	 */
	public function getCustomReportsByForm($nFormID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		$this->loadClass('CustomReports');
		$aoCustomReports = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'IdType' => $sIdType)));
		if (isset($aReturn['CustomReports']) &&
			is_array($aReturn['CustomReports']) &&
			isset($aReturn['CustomReports'][0]) &&
			is_array($aReturn['CustomReports'][0])
		)
		{
			foreach ($aReturn['CustomReports'] as $asCustomReport)
			{
				$aoCustomReports[] = new Classes\CustomReports($asCustomReport);
			}
		}
		else
		{
			$aoCustomReports[] = new Classes\CustomReports($aReturn['CustomReports']);
		}
		return $aoCustomReports;
	}

	/**
	 * Call SOAP Transaction GetCustomUserSetting
	 * @param $sKey
	 * @return string
	 */
	public function getCustomUserSetting($sKey)
	{
		return $this->callTransaction(__FUNCTION__, array('SettingKey' => $sKey));
	}
	
	/**
	 * Returns a list of Mail Objects to the given ids
	 * @param int[] 	$anMailIDs
	 * @param string 	$sStatus
	 *
	 * @return Classes\Mail[]|null
	 */
	public function getEMailsByIDList($anMailIDs, $sStatus)
	{
		$this->loadClass('Mail');
		$aoMails = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('MailIDs' => $anMailIDs, 'Status' => $sStatus)));
		if($aReturn == false)
		{
			return null;
		}
		elseif (isset($aReturn['Mail']) &&
			is_array($aReturn['Mail']) &&
			isset($aReturn['Mail'][0]) &&
			is_array($aReturn['Mail'][0])
		)
		{
			foreach ($aReturn['Mail'] as $aMail)
			{
				$aoMails[] = new Classes\Mail($aMail);
			}
		}
		else
		{
			$aoMails[] = new Classes\Mail($aReturn['Mail']);
		}
		return $aoMails;
	}
	
	/**
	 * Return a summary of mails for a given date
	 * @param string $sCreationDate
	 *
	 * @return null|Survey\EmailSummary
	 */
	public function getEMailSummaryByCreationDate($sCreationDate)
	{
		$this->loadClass('EmailSummary');
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('CreationDate' => $sCreationDate)));
		if($aReturn == false)
		{
			return null;
		}
		return new Classes\EmailSummary($aReturn['Summary']);
	}
	
	/**
	 * Get a list of all surveys where the email address is invited to.
	 * @param string	$sParticipantMailAddress
	 * @param string 	$sSurveyTypes
	 * @param int 		$nSurveyOpenState
	 *
	 * @return null|Classes\SurveySummary[]
	 */
	public function getEvaluationSummaryByParticipant($sParticipantMailAddress, $sSurveyTypes, $nSurveyOpenState)
	{
		$this->loadClass('SurveySummary');
		$aoSurveySummary = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('ParticipantMailAddress' => $sParticipantMailAddress, 'SurveyTypes' => $sSurveyTypes, 'SurveyOpenState' => $nSurveyOpenState)));
		if($aReturn == false)
		{
			return null;
		}
		elseif (isset($aReturn['SurveySummary']) &&
				is_array($aReturn['SurveySummary']) &&
				isset($aReturn['SurveySummary'][0]) &&
				is_array($aReturn['SurveySummary'][0])
		)
		{
			foreach ($aReturn['SurveySummary'] as $aSurveySummary)
			{
				$aoSurveySummary[] = new Classes\SurveySummary($aSurveySummary);
			}
		}
		else
		{
			$aoSurveySummary[] = new Classes\SurveySummary($aReturn['SurveySummary']);
		}
		return $aoSurveySummary;
	}
	
	/**
	 * Return the FilterSets for a form / survey
	 * @param int $nFormID
	 * @param int $nSurveyID
	 *
	 * @return null|Classes\FilterSet[]
	 */
	public function getFiltersByFormId($nFormID, $nSurveyID)
	{
		$this->loadClass('FilterSet');
		$aoFilterSets = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'SurveyId' => $nSurveyID)));
		if($aReturn == false)
		{
			return null;
		}
		elseif (isset($aReturn['FilterSet']) &&
				is_array($aReturn['FilterSet']) &&
				isset($aReturn['FilterSet'][0]) &&
				is_array($aReturn['FilterSet'][0]))
		{
			foreach ($aReturn['FilterSet'] as $aFilterSet)
			{
				$aoFilterSets[] = new Classes\FilterSet($aFilterSet);
			}
		}
		else
		{
			$aoFilterSets[] = new Classes\FilterSet($aReturn['FilterSet']);
		}
		return $aoFilterSets;
	}

	/**
	 * Call SOAP Transaction GetFoldersByUserId
	 * @param int $nUserID
	 * @return Classes\Folder[]
	 */
	public function getFoldersByUserId($nUserID)
	{
		$this->loadClass('Folder');
		$aoFolders = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserId' => (int)$nUserID)));
		if (isset($aReturn['Folders']) && is_array($aReturn['Folders']) && isset($aReturn['Folders'][0]) && is_array($aReturn['Folders'][0]))
		{
			foreach ($aReturn['Folders'] as $asFolder)
			{
				$aoFolders[] = new Classes\Folder($asFolder);
			}
		}
		else
		{
			$aoFolders[] = new Classes\Folder($aReturn['Folders']);
		}
		return $aoFolders;
	}

	/**
	 * Call SOAP Transaction GetForm
	 * @param $nFormID
	 * @param string $sIdType
	 * @param bool $bIncludeOnlyQuestions
	 * @param bool $bSkipPoleLabelsInheritance
	 * @return Classes\Form
	 */
	public function getForm($nFormID, $sIdType = self::ID_TYPE_INTERNAL, $bIncludeOnlyQuestions = false, $bSkipPoleLabelsInheritance = false)
	{
		$this->loadClass('Form');
		return new Classes\Form($this->asArray($this->callTransaction('GetForm', array(
			'FormId' => $nFormID,
			'IdType' => $sIdType,
			'IncludeOnlyQuestions' => (int)$bIncludeOnlyQuestions,
			'SkipPoleLabelsInheritance' => (int)$bSkipPoleLabelsInheritance))));
	}

	/**
	 * Call SOAP Transaction GetFormByCourseIdAndPeriodId
	 * @param int $nCourseID
	 * @param int $nPeriodID
	 * @return Classes\SimpleForm[]
	 */
	public function getFormByCourseIdAndPeriodId($nCourseID, $nPeriodID)
	{
		$this->loadClass('SimpleForm');
		$aoSimpleForms = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('nCourseId' => (int)$nCourseID, 'nPeriodId' => (int)$nPeriodID)));
		if (isset($aReturn['SimpleForms']) && is_array($aReturn['SimpleForms']) && isset($aReturn['SimpleForms'][0]) && is_array($aReturn['SimpleForms'][0]))
		{
			foreach ($aReturn['SimpleForms'] as $asSimpleForm)
			{
				$aoSimpleForms[] = new Classes\SimpleForm($asSimpleForm);
			}
		}
		else
		{
			$aoSimpleForms[] = new Classes\SimpleForm($aReturn['SimpleForms']);
		}
		return $aoSimpleForms;
	}

	/**
	 * Call SOAP Transaction GetFormTranslations
	 * @param int $nFormID
	 * @return Classes\FormTranslation[]
	 */
	public function getFormTranslations($nFormID)
	{
		$this->loadClass('FormTranslation');
		$aoFormTranslations = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID)));
		if (isset($aReturn['FormTranslation']) &&
			is_array($aReturn['FormTranslation']) &&
			isset($aReturn['FormTranslation'][0]) &&
			is_array($aReturn['FormTranslation'][0])
		)
		{
			foreach ($aReturn['FormTranslation'] as $asFormTranslation)
			{
				$aoFormTranslations[] = new Classes\FormTranslation($asFormTranslation);
			}
		}
		else
		{
			$aoFormTranslations[] = new Classes\FormTranslation($aReturn['FormTranslation']);
		}
		return $aoFormTranslations;
	}

	/**
	 * Call SOAP Transaction GetIndicatorsByFormId
	 * @param int $nFormID
	 * @param int $nSurveyID
	 * @return Classes\Indicator[]
	 */
	public function getIndicatorsByFormId($nFormID, $nSurveyID)
	{
		$this->loadClass('Indicator');
		$aoIndicators = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'SurveyId' => (int)$nSurveyID)));
		if (isset($aReturn['Indicator']) && is_array($aReturn['Indicator']) && isset($aReturn['Indicator'][0]) && is_array($aReturn['Indicator'][0]))
		{
			foreach ($aReturn['Indicator'] as $asIndicator)
			{
				$aoIndicators[] = new Classes\Indicator($asIndicator);
			}
		}
		else
		{
			$aoIndicators[] = new Classes\Indicator($aReturn['Indicator']);
		}
		return $aoIndicators;
	}

	/**
	 * Call SOAP Transaction GetOnlineSurveyLinkByEmail
	 * @param int $nSurveyID
	 * @param string $sEmailAddress
	 * @param int $bAddRecipientToSurvey
	 * @param int $bAutoIncreasePSWDCount
	 * @return string URL
	 */
	public function getOnlineSurveyLinkByEmail($nSurveyID, $sEmailAddress, $bAddRecipientToSurvey = false, $bAutoIncreasePSWDCount = false)
	{
		return $this->callTransaction(__FUNCTION__, array(
			'SurveyId' => (int)$nSurveyID,
			'EmailAddress' => $sEmailAddress,
			'AddRecipientToSurvey' => (int)$bAddRecipientToSurvey,
			'AutoIncreasePSWDCount' => (int)$bAutoIncreasePSWDCount,));
	}

	/**
	 * Call SOAP Transaction GetPDFCoversheet
	 * @param int $nSurveyID
	 * @return string URL
	 */
	public function getPDFCoversheet($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID));
	}

	/**
	 * Call SOAP Transaction GetPDFPluginsByFormId
	 * @param int $nFormID
	 * @param int $nUserID
	 * @return Classes\PDFPlugin[]
	 */
	public function getPDFPluginsByFormId($nFormID, $nUserID)
	{
		$this->loadClass('PDFPlugin');
		$aoPDFPlugins = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'UserId' => (int)$nUserID)));
		if (isset($aReturn['PDFPlugins']) && is_array($aReturn['PDFPlugins']) && isset($aReturn['PDFPlugins'][0]) && is_array($aReturn['PDFPlugins'][0]))
		{
			foreach ($aReturn['PDFPlugins'] as $asPDFPlugin)
			{
				$aoPDFPlugins[] = new Classes\PDFPlugin($asPDFPlugin);
			}
		}
		else
		{
			$aoPDFPlugins[] = new Classes\PDFPlugin($aReturn['PDFPlugins']);
		}
		return $aoPDFPlugins;
	}

	/**
	 * Call SOAP Transaction GetPDFPswd
	 * @param int $nSurveyID
	 * @return string URL
	 */
	public function getPDFPswd($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID));
	}

	/**
	 * Call SOAP Transaction GetPDFQuestionnaire
	 * @param int $nFormID
	 * @param int $nSurveyID
	 * @param bool $bSerialPrint
	 * @param int $nAdditionalcopies
	 * @param int $nSerialNumberFrom
	 * @param int $nSerialNumberTo
	 * @return string URL
	 */
	public function getPDFQuestionnaire($nFormID, $nSurveyID, $bSerialPrint = false, $nAdditionalcopies = 0, $nSerialNumberFrom = 0, $nSerialNumberTo = 0)
	{
		return $this->callTransaction(__FUNCTION__, array(
			'FormId' => (int)$nFormID,
			'SurveyId' => (int)$nSurveyID,
			'SerialPrint' => (int)$bSerialPrint,
			'Additionalcopies' => (int)$nAdditionalcopies,
			'SerialNumberFrom' => (int)$nSerialNumberFrom,
			'SerialNumberTo' => (int)$nSerialNumberTo));
	}

	/**
	 * Call SOAP Transaction GetPDFReport
	 * @param int $nSurveyID
	 * @param int $nUserID
	 * @param int $nCustomPDFID
	 * @param int $nLanguageID
	 * @return string URL
	 */
	public function getPDFReport($nSurveyID, $nUserID, $nCustomPDFID, $nLanguageID)
	{
		return $this->callTransaction(__FUNCTION__, array(
			'nSurveyId' => (int)$nSurveyID,
			'nUserId' => (int)$nUserID,
			'nCustomPDFId' => (int)$nCustomPDFID,
			'nLanguageID' => (int)$nLanguageID,));
	}

	/**
	 * Call SOAP Transaction GetPdfReportDefinition
	 * @param int $nPDFReportDefinitionID
	 * @return Classes\PDFReportDefinition
	 */
	public function getPdfReportDefinition($nPDFReportDefinitionID)
	{
		$this->loadClass('PDFReportDefinition');
		return new Classes\PDFReportDefinition($this->asArray($this->callTransaction(__FUNCTION__, array('PDFReportDefinitionId' => (int)$nPDFReportDefinitionID))));
	}

	/**
	 * Call SOAP Transaction GetPdfReportDefinitionsByFormId
	 * @param int $nFormID
	 * @return Classes\PDFReportDefinition[]
	 */
	public function getPdfReportDefinitionsByFormId($nFormID)
	{
		$this->loadClass('PDFReportDefinition');
		$aoPDFReportDefinitions = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID)));
		if (isset($aReturn['PDFReportDefinition']) &&
			is_array($aReturn['PDFReportDefinition']) &&
			isset($aReturn['PDFReportDefinition'][0]) &&
			is_array($aReturn['PDFReportDefinition'][0])
		)
		{
			foreach ($aReturn['PDFReportDefinition'] as $asPDFReportDefinition)
			{
				$aoPDFReportDefinitions[] = new Classes\PDFReportDefinition($asPDFReportDefinition);
			}
		}
		else
		{
			$aoPDFReportDefinitions[] = new Classes\PDFReportDefinition($aReturn['PDFReportDefinition']);
		}
		return $aoPDFReportDefinitions;
	}
	
	/**
	 * @param string $sUserMailAddress
	 * @param string $sStartDate
	 * @param string $sEndDate
	 * @param int    $nSubunitID
	 * @param string $sIdType
	 *
	 * @return bool|int
	 */
	public function getPercentOfCompletedSurveysByParticipant($sUserMailAddress, $sStartDate, $sEndDate, $nSubunitID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		$nReturn = $this->callTransaction(__FUNCTION__, array('UserMailAddress' => $sUserMailAddress,
														'StartDate' 		=> $sStartDate,
														'EndDate'			=> $sEndDate,
														'SubunitId' 		=> (int)$nSubunitID,
														'IdType' 			=> $sIdType));
		return $nReturn;
	}

	/**
	 * Call SOAP Transaction GetPeriod
	 * @param integer $nPeriodID
	 * @param string $sIdType
	 * @return Classes\Period
	 */
	public function getPeriod($nPeriodID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		$this->loadClass('Period');
		return new Classes\Period($this->asArray($this->callTransaction(__FUNCTION__, array('sPeriodId' => $nPeriodID, 'sPeriodIdType' => $sIdType))));
	}

	/**
	 * Call SOAP Transaction GetPswdsByParticipant
	 * @param string $sUserMailAddress
	 * @param string $sCourseCode
	 * @return Classes\OnlineSurveyKey[]
	 */
	public function getPswdsByParticipant($sUserMailAddress, $sCourseCode = '')
	{
		$this->loadClass('OnlineSurveyKey');
		$aoOnlineSurveyKeys = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserMailAddress' => $sUserMailAddress, 'CourseCode' => $sCourseCode)));
		if (isset($aReturn['OnlineSurveyKeys']) &&
			is_array($aReturn['OnlineSurveyKeys']) &&
			isset($aReturn['OnlineSurveyKeys'][0]) &&
			is_array($aReturn['OnlineSurveyKeys'][0])
		)
		{
			foreach ($aReturn['OnlineSurveyKeys'] as $asOnlineSurveyKey)
			{
				$aoOnlineSurveyKeys[] = new Classes\OnlineSurveyKey($asOnlineSurveyKey);
			}
		}
		else
		{
			$aoOnlineSurveyKeys[] = new Classes\OnlineSurveyKey($aReturn['OnlineSurveyKeys']);
		}
		return $aoOnlineSurveyKeys;
	}

	/**
	 * Call SOAP Transaction GetPswdsByRecipient
	 * @param string $sUserMailAddress
	 * @return Classes\OnlineCode[]
	 */
	public function getPswdsByRecipient($sUserMailAddress)
	{
		$this->loadClass('OnlineCode');
		$aoOnlineCodes = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserMailAddress' => $sUserMailAddress)));
		if (isset($aReturn['OnlineCodes']) && is_array($aReturn['OnlineCodes']) && isset($aReturn['OnlineCodes'][0]) && is_array($aReturn['OnlineCodes'][0]))
		{
			foreach ($aReturn['OnlineCodes'] as $asOnlineCode)
			{
				$aoOnlineCodes[] = new Classes\OnlineCode($asOnlineCode);
			}
		}
		else
		{
			$aoOnlineCodes[] = new Classes\OnlineCode($aReturn['OnlineCodes']);
		}
		return $aoOnlineCodes;
	}

	/**
	 * Call SOAP Transaction GetPswdsBySurvey
	 * @param int $nSurveyID
	 * @param int $nPswdCount
	 * @param int $nCodeTypes
	 * @param bool $bForceNewPasswordGeneration
	 * @param bool $bSetPswdsToSent
	 * @return Classes\OnlineCode[]
	 */
	public function getPswdsBySurvey($nSurveyID, $nPswdCount = 0, $nCodeTypes = 0, $bForceNewPasswordGeneration = false, $bSetPswdsToSent = false)
	{
		$this->loadClass('OnlineCode');
		$aoOnlineCodes = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array(
			'nSurveyId' => (int)$nSurveyID,
			'nPswdCount' => (int)$nPswdCount,
			'nCodeTypes' => (int)$nCodeTypes,
			'bForceNewPasswordGeneration' => (int)$bForceNewPasswordGeneration,
			'bSetPswdsToSent' => (int)$bSetPswdsToSent,)));
		if (isset($aReturn['OnlineCodes']) && is_array($aReturn['OnlineCodes']) && isset($aReturn['OnlineCodes'][0]) && is_array($aReturn['OnlineCodes'][0]))
		{
			foreach ($aReturn['OnlineCodes'] as $asOnlineCode)
			{
				$aoOnlineCodes[] = new Classes\OnlineCode($asOnlineCode);
			}
		}
		else
		{
			$aoOnlineCodes[] = new Classes\OnlineCode($aReturn['OnlineCodes']);
		}
		return $aoOnlineCodes;
	}

	/**
	 * Call SOAP Transaction GetPswdSummary
	 * @param string $sPSWD
	 * @return Classes\PswdSummary
	 */
	public function getPswdSummary($sPSWD)
	{
		$this->loadClass('PswdSummary');
		return new Classes\PswdSummary($this->asArray($this->callTransaction(__FUNCTION__, array('Pswd' => $sPSWD))));
	}

	/**
	 * Call SOAP Transaction GetSessionForUser
	 * @param int $nUserID
	 * @param string $sIdType
	 * @return Classes\SessionModel
	 */
	public function getSessionForUser($nUserID, $sIdType = self::ID_TYPE_INTERNAL)
	{
		$this->loadClass('SessionModel');
		return new Classes\SessionModel($this->asArray($this->callTransaction(__FUNCTION__, array('Pswd' => (int)$nUserID, 'IdType' => $sIdType))));
	}

	/**
	 * Call SOAP Transaction GetSimpleForm
	 * @param int $nFormID
	 * @param string $sIdType
	 * @param bool $bIncludeCustomReports
	 * @param bool $bIncludeUsageRestrictions
	 * @return Classes\SimpleForm
	 */
	public function getSimpleForm($nFormID, $sIdType = self::ID_TYPE_INTERNAL, $bIncludeCustomReports = true, $bIncludeUsageRestrictions = true)
	{
		$this->loadClass('SimpleForm');
		return new Classes\SimpleForm($this->asArray($this->callTransaction(__FUNCTION__, array(
			'FormId' => (int)$nFormID,
			'IdType' => $sIdType,
			'IncludeCustomReports' => $bIncludeCustomReports,
			'IncludeUsageRestrictions' => $bIncludeUsageRestrictions,))));
	}

	/**
	 * Call SOAP Transaction GetSPSSRawData
	 * @param int $nSurveyID
	 * @return string URL
	 */
	public function getSPSSRawData($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID));
	}

	/**
	 * Call SOAP Transaction GetSubunit
	 *
	 * @param int $nSubunitID
	 * @param string $sIdType
	 * @param bool $bIncludeInstructors
	 *
	 * @return Classes\Unit
	 */
	public function getSubunit($nSubunitID, $sIdType = self::ID_TYPE_INTERNAL, $bIncludeInstructors = false)
	{
		$this->loadClass('Unit');
		return new Classes\Unit($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SubunitId' => $nSubunitID,
			'IdType' => $sIdType,
			'IncludeInstructors' => (int)$bIncludeInstructors))));
	}

	/**
	 * Call SOAP Transaction GetSubunits
	 * @return Classes\Unit[]
	 */
	public function getSubunits()
	{
		$this->loadClass('Unit');
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array()));
		return $this->initObjectArray($aReturn, 'Units', '\Soap\Survey\Unit');
	}

	/**
	 * Call SOAP Transaction GetSurveyByID
	 * @param int $nSurveyID - Internal survey ID
	 * @return Classes\Survey
	 */
	public function getSurveyByID($nSurveyID)
	{
		$this->loadClass('Survey');
		return new Classes\Survey($this->asArray($this->callTransaction('GetSurveyByID', array($nSurveyID))));
	}

	/**
	 * Call SOAP Transaction GetSurveyIDsByParams
	 * @param string $sName
	 * @param int[]|int $anSubunitIDs
	 * @param int[]|int $anInstructorIDs
	 * @param int[]int $anPeriodIDs
	 * @param int[]|int $anFormIDs
	 * @param int[]|int $anCourseTypes
	 * @param int[]|int $anCourseIDs
	 * @param string[]|string $asPos
	 * @param int[]|int $anStatusIDs
	 * @param string[]|string $acSurveyTypes
	 * @param bool $bExtendedResponseAsJSON
	 * @param string $sOrderBy
	 * @param string $sOrderDirection
	 * @param int $nLimit
	 * @return int[]
	 */
	public function getSurveyIDsByParams($sName = '[*]',
	                                     $anSubunitIDs = array(),
	                                     $anInstructorIDs = array(),
	                                     $anPeriodIDs = array(),
	                                     $anFormIDs = array(),
	                                     $anCourseTypes = array(),
	                                     $anCourseIDs = array(),
	                                     $asPos = array(),
	                                     $anStatusIDs = array(),
	                                     $acSurveyTypes = array(),
	                                     $bExtendedResponseAsJSON = false,
	                                     $sOrderBy = '',
	                                     $sOrderDirection = 'ASC',
	                                     $nLimit = 0)
	{
		$oSurveyParams =
			ObjectCreator::createSurveyParams($sName, $anSubunitIDs, $anInstructorIDs, $anPeriodIDs, $anFormIDs, $anCourseTypes, $anCourseIDs, $asPos,
			                                  $anStatusIDs, $acSurveyTypes, $bExtendedResponseAsJSON, $sOrderBy, $sOrderDirection, $nLimit);
		$anSurveyIDs = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array($oSurveyParams)));
		if (isset($aReturn['Strings']) && is_array($aReturn['Strings']) && count($aReturn['Strings']) > 0)
		{
			foreach ($aReturn['Strings'] as $nSurveyID)
			{
				$anSurveyIDs[] = $nSurveyID;
			}
		}
		elseif (isset($aReturn['Strings']))
		{
			$anSurveyIDs[] = $aReturn['Strings'];
		}
		return $anSurveyIDs;
	}
	
	/**
	 * Returns the link to a sheet scan
	 * @param int $nSurveyID
	 * @param int $nSheetID
	 * @param int $nBatchID
	 *
	 * @return array
	 */
	public function getSurveyOriginalScansPDF($nSurveyID, $nSheetID, $nBatchID)
	{
		$aParams = [
			'SurveyId' => $nSurveyID,
			'SheetId' => $nSheetID,
			'BatchId' => $nBatchID
		];
		
		//return PDFLink
		return $this->callTransaction(__FUNCTION__, $aParams);
	}
	
	/**
	 * @param int  	$nSurveyID
	 * @param bool 	$bIncludeOpenEndedQuestions
	 * @param int[]	$anResultIDs
	 *
	 * @return array
	 */
	public function getSurveyRawData($nSurveyID, $bIncludeOpenEndedQuestions = false, $anResultIDs)
	{
		$aParams = [
			'SurveyId' => $nSurveyID,
			'IncludeOpenEndedQuestions' => $bIncludeOpenEndedQuestions,
			'ResultIDs' => $anResultIDs
		];
		
		$this->loadClass('Survey');
		$this->loadClass('ItemAnswer');
		$oReturn = $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
		return $this->formatSurveyRawData($oReturn);
	}
	
	/**
	 * Formats the result from getSurveyRawData and getSurveyRawDataByTime
	 * @param array $aDataArray
	 *
	 * @return array
	 */
	private function formatSurveyRawData($aDataArray)
	{
		$oSurvey = null;
		if(isset($aDataArray['Survey']) && is_array($aDataArray['Survey']))
		{
			$oSurvey = new Classes\Survey($aDataArray['Survey']);
		};
		$aSheetResults = [];
		if(isset($aDataArray['SheetResults']) && is_array($aDataArray['SheetResults'])
			&& isset($aDataArray['SheetResults']['ItemAnswerLists']) && is_array($aDataArray['SheetResults']['ItemAnswerLists']))
		{
			foreach($aDataArray['SheetResults']['ItemAnswerLists'] as $aItemAnswerList)
			{
				$aoItemAnswerList = [];
				if(isset($aItemAnswerList['ItemAnswers']))
				{
					foreach($aItemAnswerList['ItemAnswers'] as $aItemAnswer)
					{
						$aoItemAnswerList[] = new Classes\ItemAnswer($aItemAnswer);
					}
				}
				else
				{
					foreach($aItemAnswerList as $aItemAnswer)
					{
						$aoItemAnswerList[] = new Classes\ItemAnswer($aItemAnswer);
					}
				}
				$aSheetResults[] = $aoItemAnswerList;
			}
		};
		return ['Survey' => $oSurvey, 'SheetResults' => $aSheetResults];
	}
	
	/**
	 * Get all raw data by a given time period
	 * @param string	$sStartTime
	 * @param string 	$sEndTime
	 * @param boolean	$bIncludeOpenEndedQuestions
	 *
	 * @return array|null
	 */
	public function getSurveyRawDataByTime($sStartTime, $sEndTime, $bIncludeOpenEndedQuestions)
	{
		$aParams = [
			'StartTime' => $sStartTime,
			'EndTime' => $sEndTime,
			'IncludeOpenEndedQuestions' => $bIncludeOpenEndedQuestions
		];
		
		$this->loadClass('Survey');
		$this->loadClass('ItemAnswer');
		$oReturn = $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
		if(count($oReturn) == 0)
		{
			return null;
		}
		$aSurveyRawDataArray = [];
		if(isset($oReturn['SurveyRawDataArray']) && is_array($oReturn['SurveyRawDataArray']))
		{
			if(isset($oReturn['SurveyRawDataArray']['Survey']))
			{
				$aSurveyRawDataArray[] = $this->formatSurveyRawData($oReturn['SurveyRawDataArray']);
			}
			elseif(is_array($oReturn['SurveyRawDataArray']))
			{
				foreach($oReturn['SurveyRawDataArray'] as $aSurveyRawData)
				{
					$aSurveyRawDataArray[] = $this->formatSurveyRawData($aSurveyRawData);
				}
			}
		}
		return $aSurveyRawDataArray;
	}
	
	/**
	 * @param array  		$aSurveyIds
	 * @param bool   		$bIsOnline
	 * @param bool   		$bGroupBySurveyId
	 * @param string 		$sDataAggregationUnit
	 * @param null|string   $sStartTime
	 * @param null|string   $sEndTime
	 *
	 * @return array
	 */
	public function getSurveyResponseDistribution($aSurveyIds = [], $bIsOnline = true, $bGroupBySurveyId = false, $sDataAggregationUnit = 'minute', $sStartTime = null, $sEndTime = null)
	{
		$aParams = [
			'SurveyIDs' => $aSurveyIds,
			'OnlineResponses' => $bIsOnline,
			'GroupBySurveyId' => $bGroupBySurveyId,
			'DataAggregationUnit' => $sDataAggregationUnit,
			'StartTime' => $sStartTime,
			'EndTime' => $sEndTime
		];
		
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
		$aReturnArray = [];
		if(isset($aReturn['Strings']))
		{
			if(is_array($aReturn['Strings']))
			{
				foreach($aReturn['Strings'] as $sRow)
				{
					$aReturnArray[] = json_decode($sRow);
				}
			}
			else
			{
				$aReturnArray[] = json_decode($aReturn['Strings']);
			}
		}
		return $aReturnArray;
	}

	/**
	 * Call SOAP transaction getFormsInfoByParams
	 * @param array  $aSelectFields
	 * @param string $sSearchQuery
	 * @param array  $aUsers
	 * @param bool   $bIncludeFormsOfOtherSubunitAdministrators
	 * @param bool   $bIncludeDeactivatedForms
	 * @param bool   $bExcludeActiveForms
	 * @param bool   $bIncludeChildForms
	 * @param null   $nFolderId
	 * @param string $sOrderBy
	 * @param string $sOrderDirection
	 * @param int    $nLimit
	 * @param string $sFormSearchType a value from enum: 'form', 'group', 'question' or 'all'
	 *
	 * @return array
	 */
	public function getFormsInfoByParams($aSelectFields = [],
										 $sSearchQuery = '[*]',
										 $aUsers = [],
										 $bIncludeFormsOfOtherSubunitAdministrators = false,
										 $bIncludeDeactivatedForms = false,
										 $bExcludeActiveForms = false,
										 $bIncludeChildForms = false,
										 $nFolderId = null,
										 $sOrderBy = '',
										 $sOrderDirection = 'ASC',
										 $nLimit = 0,
										 $sFormSearchType = 'form')
	{
		$oFormParams = ObjectCreator::createFormParams($aSelectFields, $sSearchQuery, $aUsers, $bIncludeFormsOfOtherSubunitAdministrators,
				$bIncludeDeactivatedForms, $bExcludeActiveForms, $bIncludeChildForms,
				$nFolderId,	$sOrderBy, $sOrderDirection, $nLimit, $sFormSearchType);
		$anFormsInfo = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array($oFormParams)));
		if (isset($aReturn['Strings']) && is_array($aReturn['Strings']) && count($aReturn['Strings']) > 0)
		{
			foreach ($aReturn['Strings'] as $aSurveyInfo)
			{
				$anFormsInfo[] = json_decode($aSurveyInfo);
			}
		}
		else
		{
			if (strlen($aReturn['Strings']) > 0)
			{
				$anFormsInfo[] = json_decode($aReturn['Strings']);
			}
		}
		return $anFormsInfo;
	}

	/**
	 * Call SOAP Transaction GetSurveyResults
	 * @param int $nSurveyID - Internal survey ID
	 * @return Classes\SurveyResult
	 */
	public function getSurveyResults($nSurveyID)
	{
		$this->loadClass('SurveyResult');
		return new Classes\SurveyResult($this->asArray($this->callTransaction('GetSurveyResults', array($nSurveyID))));
	}

	/**
	 * Call SOAP Transaction GetSurveysByCourse
	 * @param int $nCourseID
	 * @param int $nFormID
	 * @param int $nPeriodID
	 * @return Classes\Survey[]
	 */
	public function getSurveysByCourse($nCourseID, $nFormID, $nPeriodID)
	{
		$this->loadClass('Survey');
		$aoSurveys = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array(
			'nCourseId' => (int)$nCourseID,
			'nFormId' => (int)$nFormID,
			'nPeriodId' => (int)$nPeriodID,)));
		if (isset($aReturn['Surveys']) && is_array($aReturn['Surveys']) && isset($aReturn['Surveys'][0]) && is_array($aReturn['Surveys'][0]))
		{
			foreach ($aReturn['Surveys'] as $asSurvey)
			{
				$aoSurveys[] = new Classes\Survey($asSurvey);
			}
		}
		else
		{
			$aoSurveys[] = new Classes\Survey($aReturn['Surveys']);
		}
		return $aoSurveys;
	}

	/**
	 * Call SOAP Transaction GetSurveyTypes
	 * @return Classes\SurveyType[]
	 */
	public function getSurveyTypes()
	{
		$this->loadClass('SurveyType');
		$aoSurveyTypes = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array()));
		if (isset($aReturn['SurveyTypes']) && is_array($aReturn['SurveyTypes']) && count($aReturn['SurveyTypes']) > 0)
		{
			foreach ($aReturn['SurveyTypes'] as $asSurveyType)
			{
				$aoSurveyTypes[] = new Classes\SurveyType($asSurveyType);
			}
		}
		return $aoSurveyTypes;
	}

	/**
	 * Call SOAP Transaction GetTextTemplateById
	 * @param string $sTextTemplateId
	 * @param int $nFormID
	 * @return Classes\TextTemplate[]
	 */
	public function getTextTemplateById($sTextTemplateId, $nFormID)
	{
		$this->loadClass('TextTemplate');
		$aoTextTemplates = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('TextTemplateId' => $sTextTemplateId, 'FormId' => (int)$nFormID)));
		if (isset($aReturn['TextTemplate']) &&
			is_array($aReturn['TextTemplate']) &&
			isset($aReturn['TextTemplate'][0]) &&
			is_array($aReturn['TextTemplate'][0])
		)
		{
			foreach ($aReturn['TextTemplate'] as $asTextTemplate)
			{
				$aoTextTemplates[] = new Classes\TextTemplate($asTextTemplate);
			}
		}
		else
		{
			$aoTextTemplates[] = new Classes\TextTemplate($aReturn['TextTemplate']);
		}
		return $aoTextTemplates;
	}

	/**
	 * Call SOAP Transaction GetUser
	 * @param int $nUserID
	 * @param string $sIdType
	 * @param bool $bIncludeCourses
	 * @param bool $bIncludeSurveys
	 * @param bool $bIncludeParticipants
	 * @param bool $bIncludeSecondaryCourses
	 * @return Classes\User
	 */
	public function getUser($nUserID,
	                        $sIdType = self::ID_TYPE_INTERNAL,
	                        $bIncludeCourses = false,
	                        $bIncludeSurveys = false,
	                        $bIncludeParticipants = false,
	                        $bIncludeSecondaryCourses = false)
	{
		$this->loadClass('User');
		return new Classes\User($this->asArray($this->callTransaction(__FUNCTION__, array(
			'UserId' => $nUserID,
			'IdType' => $sIdType,
			'IncludeCourses' => (int)$bIncludeCourses,
			'IncludeSurveys' => (int)$bIncludeSurveys,
			'IncludeParticipants' => (int)$bIncludeParticipants,
			'IncludeSecondaryCourses' => (int)$bIncludeSecondaryCourses))));
	}

	/**
	 * Call SOAP Transaction GetUserByIdConsiderExternalID
	 * @param int $nUserID
	 * @param string $sIdType
	 * @param bool $bIncludeCourses
	 * @param bool $bIncludeSurveys
	 * @param bool $bIncludeParticipants
	 * @param bool $bIncludeSecondaryCourses
	 * @return Classes\User[]
	 */
	public function getUserByIdConsiderExternalID($nUserID,
	                                              $sIdType = self::ID_TYPE_INTERNAL,
	                                              $bIncludeCourses = false,
	                                              $bIncludeSurveys = false,
	                                              $bIncludeParticipants = false,
	                                              $bIncludeSecondaryCourses = false)
	{
		$this->loadClass('User');
		$aoUsers = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array(
			'UserId' => $nUserID,
			'IdType' => $sIdType,
			'IncludeCourses' => (int)$bIncludeCourses,
			'IncludeSurveys' => (int)$bIncludeSurveys,
			'IncludeParticipants' => (int)$bIncludeParticipants,
			'IncludeSecondaryCourses' => (int)$bIncludeSecondaryCourses)));
		if (isset($aReturn['Users']) && is_array($aReturn['Users']) && isset($aReturn['Users'][0]) && is_array($aReturn['Users'][0]))
		{
			foreach ($aReturn['Users'] as $asUser)
			{
				$aoUsers[] = new Classes\User($asUser);
			}
		}
		else
		{
			$aoUsers[] = new Classes\User($aReturn['Users']);
		}
		return $aoUsers;
	}

	/**
	 * Call SOAP Transaction GetUserByLogin
	 * @param string $sLogin
	 * @param string $sPassword
	 * @return Classes\User
	 */
	public function getUserByLogin($sLogin, $sPassword)
	{
		$this->loadClass('User');
		return new Classes\User($this->asArray($this->callTransaction(__FUNCTION__, array(
			'Login' => $sLogin,
			'Password' => $sPassword))));
	}

	/**
	 * Call SOAP Transaction GetUsersBySubunit
	 * @param int $nSubunitID
	 * @param bool $bIncludeCourses
	 * @param bool $bIncludeSurveys
	 * @param bool $bIncludeParticipants
	 * @param bool $bIncludeSecondaryCourses
	 * @return Classes\User[]
	 */
	public function getUsersBySubunit($nSubunitID,
	                                  $bIncludeCourses = false,
	                                  $bIncludeSurveys = false,
	                                  $bIncludeParticipants = false,
	                                  $bIncludeSecondaryCourses = false)
	{
		$this->loadClass('User');
		$aoUsers = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array(
			'nSubunitId' => (int)$nSubunitID,
			'IncludeCourses' => (int)$bIncludeCourses,
			'IncludeSurveys' => (int)$bIncludeSurveys,
			'IncludeParticipants' => (int)$bIncludeParticipants,
			'IncludeSecondaryCourses' => (int)$bIncludeSecondaryCourses)));
		if (isset($aReturn['Users']) && is_array($aReturn['Users']) && isset($aReturn['Users'][0]) && is_array($aReturn['Users'][0]))
		{
			foreach ($aReturn['Users'] as $asUser)
			{
				$aoUsers[] = new Classes\User($asUser);
			}
		}
		else
		{
			$aoUsers[] = new Classes\User($aReturn['Users']);
		}
		return $aoUsers;
	}

	/**
	 * Call SOAP Transaction GetUserSessionInfo
	 * @param string $sSessionId
	 * @param bool $bResumeSession
	 * @return Classes\UserSessionInfo
	 */
	public function GetUserSessionInfo($sSessionId, $bResumeSession)
	{
		$this->loadClass('UserSessionInfo');
		$oReturn = new Classes\UserSessionInfo($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SessionId' => $sSessionId,
			'ResumeSession' => (int)$bResumeSession))));
		if ($oReturn instanceof Classes\UserSessionInfo && $oReturn->getUserID() === null)
		{
			return null;
		}
		return $oReturn;
	}
	
	public function getUserVolumeLicenses($nUserID)
	{
		$this->loadClass('UserVolumeLicense');
		$oReturn = new Classes\UserVolumeLicense($this->asArray(
		               $this->callTransaction(__FUNCTION__, array('UserId' => $nUserID))));
		
		if ($oReturn instanceof Classes\UserVolumeLicense && $oReturn->getUserID() === null)
		{
			return null;
		}
		return $oReturn;
	}
	
	/**
	 * Get the verifier batch info
	 * @param int    $nBatchID
	 * @param int    $nSurveyID
	 * @param string $sBatchIdType	ID_TYPE_INTERNAL or ID_TYPE_EXTERNAL
	 *
	 * @return null|Survey\VerifierBatch
	 */
	public function getVerifierInfoByBatch($nBatchID, $nSurveyID, $sBatchIdType = self::ID_TYPE_INTERNAL)
	{
		$this->loadClass('VerifierBatch');
		$oReturn = new Classes\VerifierBatch($this->asArray($this->callTransaction(__FUNCTION__, array(
			'BatchId' => $nBatchID, 'BatchIdType' => $sBatchIdType, 'SurveyId' => $nSurveyID))));
		if ($oReturn instanceof Classes\VerifierBatch && $oReturn->getBatchId() === null)
		{
			return null;
		}
		return $oReturn;
	}

	public function getVerifierInfoByParticipant($nSurveyID, $sParticipantIdentifier)
	{
	    $this->loadClass('VerifierSurvey');
		$oReturn = new Classes\VerifierSurvey($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SurveyId' => $nSurveyID, 'ParticipantIdentifier' => $sParticipantIdentifier))));
		if ($oReturn instanceof Classes\VerifierSurvey && $oReturn->getSurveyId() === null)
		{
			return null;
		}
		return $oReturn;
	}

	public function getVerifierInfoBySerialNumber($nSurveyID, $nSerialNumber, $nSerialNumberCounter)
	{
		$this->loadClass('VerifierSurvey');
		$oReturn = new Classes\VerifierSurvey($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SurveyId' => $nSurveyID, 'SerialNumber' => $nSerialNumber, 'SerialNumberCounter' => $nSerialNumberCounter))));
		if ($oReturn instanceof Classes\VerifierSurvey && $oReturn->getSurveyId() === null)
		{
			return null;
		}
		return $oReturn;
	}
	
	/**
	 * Get the verifier batches for one survey
	 * @param $nSurveyID
	 *
	 * @return null|Survey\VerifierSurvey
	 */
	public function getVerifierInfoBySurvey($nSurveyID)
	{
		$this->loadClass('VerifierSurvey');
		$oReturn = new Classes\VerifierSurvey($this->asArray($this->callTransaction(__FUNCTION__, array(
			'SurveyId' => $nSurveyID))));
		if ($oReturn instanceof Classes\VerifierSurvey && $oReturn->getSurveyId() === null)
		{
			return null;
		}
		return $oReturn;
	}

	/**
	 * Call SOAP Transaction GetVFD
	 * @param integer $nFormID
	 * @param bool $bIncludeSecondaryData
	 * @return array
	 */
	public function getVFD($nFormID, $bIncludeSecondaryData = true)
	{
		return $this->callTransaction(__FUNCTION__, array('FormId' => $nFormID, 'IncludeSecondaryData' => (int)$bIncludeSecondaryData));
	}
	
	/**
	 * Get a list of all webscan batches, which are currently in progress.
	 * Returns null if none are available.
	 * @param int 		$nUserID		Owner of the batches
	 * @param string	$sLanguage		Language of the owner for the string. e.g.: de, en, ...
	 *
	 * @return Classes\WebscanBatch[]|null
	 */
	public function getWebscanBatchList($nUserID, $sLanguage)
	{
		$this->loadClass('WebscanBatch');
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array('UserId' => $nUserID, 'Language' => $sLanguage)));
		
		$aOutput = [];
		if(isset($aReturn['WebscanBatch']) && count($aReturn['WebscanBatch']) > 0)
		{
			foreach($aReturn['WebscanBatch'] as $aWebscanBatch)
			{
				$aOutput[] = new Classes\WebscanBatch($aWebscanBatch);
			}
			return $aOutput;
		}
		
		return null;
	}

	public function insertCentralSurvey($nUserID, $nCourseID, $nFormID, $nPeriodID, $sSurveyType, $sNotice = "")
	{
		$aParams = [
			'nUserId' => (int)$nUserID,
			'nCourseId' => (int)$nCourseID,
			'nFormId' => (int)$nFormID,
			'nPeriodId' => (int)$nPeriodID,
			'sSurveyType' => $sSurveyType,
			'sNotice' => $sNotice];
		$this->loadClass('Survey');
		return new Classes\Survey($this->asArray($this->callTransaction('InsertCentralSurvey', $this->asArray($aParams))));
	}

	public function insertCloseTask($oCloseTask) 
	{
		$this->loadClass('Survey');
		return $this->callTransaction(__FUNCTION__, array('CloseTask' => $oCloseTask));
	}

	public function insertCourse($oCourse)
	{
		$this->loadClass('Survey');
		return $this->callTransaction(__FUNCTION__, array('oCourse' => $oCourse->__toArray())); 
	}

	/**
	 * @param Classes\Course[] $aoCourseCreators
	 */
	public function insertCourses($aoCourseCreators)
	{
		__FUNCTION__;
	}

	public function insertCourseType($sName, $nModuleFormID, $bAddConnectionToForms)
	{
		$this->loadClass('CourseType');
		return new Classes\CourseType($this->callTransaction(__FUNCTION__, array('Name' => $sName, '' => $nModuleFormID, 
		                                                  'ModuleFormId' => $nModuleFormID,
		                                                  'AddConnectionToForms' => $bAddConnectionToForms))) ;
	}

	public function insertForm(Classes\Form $oForm)
	{
		__FUNCTION__;
	}

	public function insertInvitationTask($oInvitationTask) 
	{
		$this->loadClass('InvitationTask');
		return $this->callTransaction(__FUNCTION__, array('InvitationTask' => $oInvitationTask));
	}

	/**
	 * @param Classes\Module[] $oaModules
	 */
	public function insertModules($oaModules)
	{
		__FUNCTION__;
	}

	/**
	 * @param Classes\Person[] $aoPersons
	 * @param $nCourseID
	 * @param string $sIdType
	 * @param bool $bDeleteExisting
	 * @return bool|mixed
	 */
	public function insertParticipants($aoPersons, $nCourseID, $sIdType = self::ID_TYPE_INTERNAL, $bDeleteExisting = false)
	{
		$this->loadClass('Person');
		return $this->callTransaction(__FUNCTION__,
		                              array('PersonList' => $aoPersons, 'CourseId' => $nCourseID, 'IdType' => $sIdType, 'DeleteExisting' => $bDeleteExisting));
	}

	public function insertRemindTask($oRemindTask)
	{
		$this->loadClass('RemindTask');
		return $this->callTransaction(__FUNCTION__, array('RemindTask' => $oRemindTask));
	}

	public function insertResponseRateTask(Classes\ResponseRateTask $oResponseRateTask)
	{
		__FUNCTION__;
	}

	public function insertSubunit($oUnit)
	{
		$this->loadClass('Unit');
		return $this->callTransaction(__FUNCTION__, array('Unit' => $oUnit));
	}

	public function insertSurveyNotice($nSurveyID, $sNotice, $nUserID, $sIdType = self::ID_TYPE_INTERNAL)
	{	    
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => $nSurveyID,'Notice' => $sNotice,'UserId' => $nUserID,'IdType' => $sIdType));
	}

	/**
	 * Insert survey raw data
	 * @param int $nSurveyID
	 * @param string $sDateFrom
	 * @param string $sDateTo
	 * @param bool $bUseExportValues
	 * @param array $aSheetResults
	 *
	 * @return Classes\SurveyStatus
	 */
	public function insertSurveyRawData($nSurveyID, $sDateFrom, $sDateTo, $bUseExportValues, $aSheetResults)
	{
		$oStdSheetResults = new \stdClass();
		foreach ($aSheetResults as $aItemAnswerList)
		{
			$oStdItemAnswerList = new \stdClass();
			foreach ($aItemAnswerList as $oItemAnswer)
			{
				$oStdItemAnswerList->ItemAnswers[] = $oItemAnswer->__toArray();
			}
			$oStdSheetResults->ItemAnswerLists[] = $oStdItemAnswerList;
		}
		$aParams = [
			'SurveyId' => (int)$nSurveyID,
			'StartTime' => $sDateFrom,
			'EndTime' => $sDateTo,
			'UseExportValues' => $bUseExportValues,
			'SheetResults' => $oStdSheetResults];
		$this->loadClass('SurveyStatus');
		return new Classes\SurveyStatus($this->asArray($this->callTransaction(__FUNCTION__, $aParams)));
	}

	public function insertUser($oUser)
	{
		return $this->callTransaction(__FUNCTION__, array('User' => $oUser));
	}

	/**
	 * Call SOAP Transaction IsPswdUnused
	 * @param string $sPSWD
	 * @return bool
	 */
	public function isPswdUnused($sPSWD)
	{
		return $this->callTransaction(__FUNCTION__, array('sPSWD' => $sPSWD)) === 'true';
	}

	public function listTasks($anSubunitIDs, $anFormIDs, $anSurveyIDs, $anUserIDs, $anTaskTypeIDs)
	{
		$aParams = [
			'SubunitIDList' => $anSubunitIDs,
			'FormIDList' => $anFormIDs,
			'SurveyIDList' => $anSurveyIDs,
			'UserIDList' => $anUserIDs,
			'TaskTypeIDList' => $anTaskTypeIDs];
		return $this->asArray($this->callTransaction(__FUNCTION__, $aParams));
	}

	/**
	 * Call SOAP Transaction OpenSurvey
	 * @param integer $nSurveyID
	 * @return bool
	 */
	public function openSurvey($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('nSurveyId' => (int)$nSurveyID)) === 'true';
	}

	public function prefillDataIntoOnlineSurvey($nSurveyID, $aasKeyValuePairs, $asPSWDs)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID, 'FieldValueList' => $aasKeyValuePairs, 'PSWDList' => $asPSWDs));
	}

	public function replaceAnswersToOpenQuestions($anSurveyIDs, $asItemCodes, $sReplaceComment)
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyIDList' => $anSurveyIDs, 
		                                                  'ItemCodeList' => $asItemCodes, 
		                                                  'sReplaceComment' => $sReplaceComment));
		
	}

	/**
	 * Call SOAP Transaction RequestTicket
	 * @param string $sLogin
	 * @param string $sPassword
	 * @return string
	 */
	public function requestTicket($sLogin, $sPassword)
	{
		return $this->callTransaction(__FUNCTION__, array('Login' => $sLogin, 'Password' => $sPassword));
	}

	/**
	 * Call SOAP Transaction ResetSurvey
	 * @param int $nSurveyID
	 * @return bool
	 */
	public function resetSurvey($nSurveyID)
	{
		return $this->callTransaction(__FUNCTION__, array('nSurveyId' => (int)$nSurveyID)) === 'true';
	}

	/**
	 * Call SOAP Transaction SendInvitationToParticipants
	 * @param $nSurveyID
	 * @param bool $bIsRemind
	 * @param string $sProgressIdPrefix
	 * @return string
	 */
	public function sendInvitationToParticipants($nSurveyID, $bIsRemind = false, $sProgressIdPrefix = '')
	{
		return $this->callTransaction(__FUNCTION__, array('SurveyId' => (int)$nSurveyID, 'IsReminder' => intval($bIsRemind), 'ProgressIdPrefix' => $sProgressIdPrefix));
	}

	/**
	 * @param int $nFormID
	 * @param int $nSurveyID
	 * @param Classes\FilterSet[] $aoFilterSets
	 */
	public function setFiltersForForm($nFormID, $nSurveyID, $aoFilterSets)
	{
		__FUNCTION__;
	}

	public function setFormActivationStatus($nFormID, $nActivationStatus)
	{
		return $this->callTransaction(__FUNCTION__, array('FormId' => (int)$nFormID, 'ActivationStatus' => $nActivationStatus));
	}

	public function setupCentralSurvey(Classes\User $oUser, Classes\Course $oCourse, Classes\Unit $oSubunit, $nFormID, $nPeriodID, $sSurveyType, $sNotice = "")
	{
		__FUNCTION__;
	}

	public function updateCloseTask($oCloseTask)
	{
		$this->loadClass('CloseTask');
		return $this->callTransaction(__FUNCTION__, array('CloseTask' => $oCloseTask));
	}

	public function updateCourse($oCourse, $bDeleteExistingParticipants = true)
	{
	    $this->loadClass('Course');
	    return $this->callTransaction(__FUNCTION__, array('Course' => $oCourse));
	}

	public function updateCourseType($nCourseTypeID, $sName, $nModuleFormID, $bAddConnectionToForms)
	{
		return $this->callTransaction(__FUNCTION__, array('CourseTypeId' => (int)$nCourseTypeID, 
		                                                  'Name' => $sName, 
		                                                  'ModuleFormId' => $nModuleFormID, 
                                                   		  'AddConnectionToForms' => $bAddConnectionToForms));
	}

	public function updateInvitationTask($oInvitationTask)
	{
		$this->loadClass('InvitationTask');
		return $this->callTransaction(__FUNCTION__, array('InvitationTask' => $oInvitationTask));
	}

	public function updateRemindTask(Classes\RemindTask $oRemindTask)
	{
		__FUNCTION__;
	}

	public function updateResponseRateTask(Classes\ResponseRateTask $oResponseRateTask)
	{
		__FUNCTION__;
	}

	public function updateSurvey(Classes\Survey $oSurvey)
	{
		return $this->callTransaction('UpdateSurvey', $this->asArray($oSurvey));
	}

	public function updateUser(Classes\User $oUser)
	{
		__FUNCTION__;
	}

	public function uploadVolumeLicense($nUserID, $sLicenseKey)
	{
		__FUNCTION__;
	}

	/**
	 * Call SOAP Transaction GetSurveyIDsByParams
	 * @param array $anUserIds
	 * @param array $anTypes
	 * @param string $sLoginName
	 * @param string $sExternalID
	 * @param string $sTitle
	 * @param string $sFirstName
	 * @param string $sSurName
	 * @param string $sUnitName
	 * @param string $sMail
	 * @param array $anSubunits
	 * @param array $anActiveUsers
	 * @param bool $bExtendedResponseAsJSON
	 * @param string $sOrderBy
	 * @param string $sOrderDirection
	 * @param int $nLimit
	 * @return array
	 */
	public function getUserIdsByParams($anUserIds = array(),
	                                   $anTypes = array(),
	                                   $sLoginName = '',
	                                   $sExternalID = '',
	                                   $sTitle = '',
	                                   $sFirstName = '',
	                                   $sSurName = '',
	                                   $sUnitName = '',
	                                   $sMail = '',
	                                   $anSubunits = array(),
	                                   $anActiveUsers = array(),
	                                   $bExtendedResponseAsJSON = false,
	                                   $sOrderBy = '',
	                                   $sOrderDirection = 'ASC',
	                                   $nLimit = 0)
	{
		$oUserParams = ObjectCreator::createUsersParams($anUserIds, $anTypes, $sLoginName, $sExternalID, $sTitle, $sFirstName, $sSurName, $sUnitName,
		                                                   $sMail, $anSubunits, $anActiveUsers, $bExtendedResponseAsJSON, $sOrderBy, $sOrderDirection, $nLimit);
		$anUserIDs = array();
		$aReturn = $this->asArray($this->callTransaction(__FUNCTION__, array($oUserParams)));
		if (isset($aReturn['Strings']) && is_array($aReturn['Strings']) && count($aReturn['Strings']) > 0)
		{
			foreach ($aReturn['Strings'] as $nUserID)
			{
				$anUserIDs[] = $nUserID;
			}
		}
		elseif (isset($aReturn['Strings']))
		{
			$anUserIDs[] = $aReturn['Strings'];
		}
		return $anUserIDs;
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