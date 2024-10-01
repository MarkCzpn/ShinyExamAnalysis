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

/**
 * Class to generate Objects for direct use in SoapFunctions.php
 *
 * Created by PhpStorm.
 * User: tr
 * Date: 25.10.2016
 * Time: 16:43
 */
abstract class ObjectCreator
{
	public static function createCourse($aArray)
	{
		require_once 'library/Soap/Classes/Survey/Course.php';
		return new \Soap\Survey\Course($aArray);
	}

	public static function createInvitationTask($nSurveyID, $sStartTime, $sEmailText, $sEmailSubject, $bSendInstructorNotification, $nStatus = '', $nTaskID = '')
	{
	    require_once 'library/Soap/Classes/Survey/InvitationTask.php';
	    return (object) array(
	        'StartTime' => $sStartTime,
	        'SurveyID' => $nSurveyID,
	        'TaskID' => $nTaskID,
	        'Status' => $nStatus,
	        'EmailText' => $sEmailText,
	        'EmailSubject' => $sEmailSubject,
	        'SendInstructorNotification' => $bSendInstructorNotification);
	}
	
	
	public static function createRemindTask($m_nSurveyID, $m_sStartTime, $m_nTaskID = '', $m_nStatus = '', $m_sSenderName= '', $m_sSenderEmail= '', $m_sEmailText= '', $m_sEmailSubject, $m_nRepeatAfterDays)
	{
	    require_once 'library/Soap/Classes/Survey/RemindTask.php';
	    
	    return (object) array(
	        'SurveyID' => $m_nSurveyID,
	        'StartTime' => $m_sStartTime,
	        'TaskID' => $m_nTaskID,
	        'Status' => $m_nStatus,
	        'SenderName' => $m_sSenderName,
	        'SenderEmail' => $m_sSenderEmail,
	        'EmailText' => $m_sEmailText,
	        'EmailSubject' => $m_sEmailSubject,
	        'RepeatAfterDays'=> $m_nRepeatAfterDays);
	}
	
	public static function createResponseRateTask($m_nSurveyID, $m_sStartTime, $m_nTaskID, $m_nStatus, $m_nResponseRateValue, $m_nCalcMethod, $m_bMailToInstructor, $m_bMailToDean)
	{
	    require_once 'library/Soap/Classes/Survey/ResponseRateTask.php';
	    return (object) array(
	        'SurveyID' => $m_nSurveyID,
	        'StartTime' => $m_sStartTime,
	        'TaskID' => $m_nTaskID,
	        'Status' => $m_nStatus,
	        'ResponseRateValue' => $m_nResponseRateValue,
	        'CalcMethod' => $m_nCalcMethod,
	        'MailToInstructor' => $m_bMailToInstructor,
	        'MailToDean' => $m_bMailToDean);
	}
	
	public static function createCloseTask($nSurveyID, $sStartTime, $bSendReport, $nStatus = '', $nTaskID = '')
	{
		require_once 'library/Soap/Classes/Survey/CloseTask.php';
		return (object) array(
			'StartTime' => $sStartTime,
			'SurveyID' => $nSurveyID,
			'TaskID' => $nTaskID,
			'Status' => $nStatus,
			'SendReport' => (int) $bSendReport);
	}

	/**
	 * Build the "User" Object for SoapFunction "InsertUser"
	 *
	 * @param integer $nID
	 * @param integer $nType
	 * @param String $sLoginName
	 * @param String $sExternalID
	 * @param String $sTitle
	 * @param String $sFirstName
	 * @param String $sLastName
	 * @param String $sProjectName
	 * @param String $sAddress
	 * @param String $sEmail
	 * @param integer $nSubunitID
	 * @param integer $nAddressID
	 * @param String $sPassword
	 * @param String $sPhoneNumber
	 * @param bool $bActiveUser
	 *
	 * @return object
	 */
	public static function createUser($nID, $nType, $sLoginName, $sExternalID, $sTitle, $sFirstName, $sLastName, $sProjectName, $sAddress, $sEmail, $nSubunitID, $nAddressID, $sPassword, $sPhoneNumber, $bActiveUser)
	{
		// Build and return object
		return new Survey\User(array(
				'm_nId' => $nID,
				'm_nType' => $nType,
				'm_sLoginName' => $sLoginName,
				'm_sExternalId' => $sExternalID,
				'm_sTitle' => $sTitle,
				'm_sFirstName' => $sFirstName,
				'm_sSurName' => $sLastName,
				'm_sUnitName' => $sProjectName,
				'm_sAddress' => $sAddress,
				'm_sEmail' => $sEmail,
				'm_nFbid' => $nSubunitID,
				'm_nAddressId' => $nAddressID,
				'm_sPassword' => $sPassword,
				'm_sPhoneNumber' => $sPhoneNumber,
				'm_bActiveUser' => $bActiveUser,
				'm_aCourses' => array()
				)
		);
	}

	/**
	 * Build the "Params" Object for SoapFunction "GetUserIdsByParams"
	 *
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
	 *
	 * @return object
	 */
	public static function createUsersParams($anUserIds = array(),
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
		// Build and return object
		return (object) array(
			'UserIds' => self::createStringList($anUserIds),
			'Types' => self::createStringList($anTypes),
			'LoginName' => $sLoginName,
			'ExternalID' => $sExternalID,
			'Title' => $sTitle,
			'FirstName' => $sFirstName,
			'SurName' => $sSurName,
			'UnitName' => $sUnitName,
			'Email' => $sMail,
			'Subunits' => self::createStringList($anSubunits),
			'ActiveUsers' => self::createStringList($anActiveUsers),
			'OrderBy' => $sOrderBy,
		    'OrderByDirection' => $sOrderDirection,
			'Limit' => $nLimit,
			'ExtendedResponseAsJSON' => $bExtendedResponseAsJSON
		);
	}

	/**
	 * Build the "Params" Object for SoapFunction "GetSurveyIDsByParams"
	 *
	 * @param string $sName
	 * @param array(int)|int $anSubunitIDs
	 * @param array(int)|int $anInstructorIDs
	 * @param array(int)|int $anPeriodIDs
	 * @param array(int)|int $anFormIDs
	 * @param array(int)|int $anCourseTypes
	 * @param array(int)|int $anCourseIDs
	 * @param array(string)|string $asPos
	 * @param array(int)|int $anStatusIDs
	 * @param array(char)|char $acSurveyTypes
	 * @param bool $bExtendedResponseAsJSON
	 * @param string $sOrderBy
	 * @param string $sOrderDirection
	 * @param int $nLimit
	 *
	 * @return object
	 */
	public static function createSurveyParams($sName = '[*]', $anSubunitIDs = array(), $anInstructorIDs = array(), $anPeriodIDs = array(), $anFormIDs = array(), $anCourseTypes = array(), $anCourseIDs = array(), $asPos = array(), $anStatusIDs = array(), $acSurveyTypes = array(), $bExtendedResponseAsJSON = false, $sOrderBy ='', $sOrderDirection = 'ASC', $nLimit = 0)
	{
		// Build and return object
		return (object) array(
			'Name' => $sName,
			'Subunits' => self::createStringList($anSubunitIDs),
			'Instructors' => self::createStringList($anInstructorIDs),
			'Periods' => self::createStringList($anPeriodIDs),
			'Forms' => self::createStringList($anFormIDs),
			'CourseTypes' => self::createStringList($anCourseTypes),
			'Courses' => self::createStringList($anCourseIDs),
			'ProgramOfStudies' => self::createStringList($asPos),
			'Statuses' => self::createStringList($anStatusIDs),
			'Types' => self::createStringList($acSurveyTypes),
			'OrderBy' => $sOrderBy,
			'OrderByDirection' => $sOrderDirection,
			'Limit' => $nLimit,
			'ExtendedResponseAsJSON' => $bExtendedResponseAsJSON
		);
	}

	/**
	 * Build the "Params" Object for SoapFunction "GetFormsInfoByParams"
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
	 * @return object
	 */
	public static function createFormParams($aSelectFields = [],
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
		// Build and return object
		return (object) array(
			'SelectFields' => self::createFormSelectFieldList($aSelectFields),
			'SearchQuery' => $sSearchQuery,
			'Users' => self::createStringList($aUsers),
			'IncludeFormsOfOtherSubunitAdministrators' => $bIncludeFormsOfOtherSubunitAdministrators,
			'IncludeDeactivatedForms' => $bIncludeDeactivatedForms,
			'ExcludeActiveForms' => $bExcludeActiveForms,
			'IncludeChildForms' => $bIncludeChildForms,
			'FolderId' => $nFolderId,
			'OrderBy' => $sOrderBy,
			'OrderByDirection' => $sOrderDirection,
			'Limit' => $nLimit,
			'FormSearchType' => $sFormSearchType
		);
	}

	/**
	 * Build the "FormIDList" Object for SoapFunction
	 *
	 * @param array(int)|int $anFormIDs
	 *
	 * @return object
	 */
	public static function createFormIDList($anFormIDs = array())
	{
		return self::createIDList($anFormIDs);
	}

	/**
	 * Build the "IDList" Object
	 *
	 * @param int[]|int $anIDs
	 * @param string $sName
	 *
	 * @return object IDList
	 */
	private static function createIDList($anIDs = array(), $sName = 'ID')
	{
		// Ensure everything is an array
		if (!is_array($anIDs)) $anIDs = array($anIDs);

		// Convert all values to "Integer"
		$anIDs = array_map('intval', $anIDs);

		// Build and return object
		return (object) array($sName => $anIDs);
	}

	/**
	 * Build the "StringList" Object
	 *
	 * @param string[]|string $asStrings
	 * @param string $sName
	 *
	 * @return object StringList
	 */
	private static function createStringList($asStrings = array(), $sName = 'Strings')
	{
		// Ensure everything is an array
		if (!is_array($asStrings)) $asStrings = array($asStrings);

		// Convert all values to "String"
		$asStrings = array_map('strval', $asStrings);

		// Build and return object
		return (object) array($sName => $asStrings);
	}

	/**
	 * Build the "FormSelectFieldList" Object
	 *
	 * @param string[]|string $asFormSelectFields
	 * @param string $sName
	 *
	 * @return object FormSelectFieldList
	 */
	private static function createFormSelectFieldList($asFormSelectFields = array(), $sName = 'FormSelectField')
	{
		// Ensure everything is an array
		if (!is_array($asFormSelectFields)) $asFormSelectFields = array($asFormSelectFields);

		// Convert all values to "String"
		$asFormSelectFields = array_map('strval', $asFormSelectFields);

		// Build and return object
		return (object) array($sName => $asFormSelectFields);
	}

	/**
	 * Build the "Mail" Object
	 *
	 * @param String $sFromMail
	 * @param String $sFromName
	 * @param String[] $asToList
	 * @param String $sSubject
	 * @param integer $sBody
	 * @param null|$nDeliveryType
	 * @param null|String[] $asCCList
	 * @param null|String[] $asBCCList
	 * @param null|String $sScheduledDate
	 * @param null|integer $nStatus
	 * @param null|integer $nSurveyID
	 * @param null|String $sCreationDate
	 * @param null|integer $nID
	 * @param null|String[] $asErrors
	 *
	 * @return object Mail
	 */

	public static function createMail($sFromMail, $sFromName, $asToList, $sSubject, $sBody,
	                                  $nDeliveryType = null, $asCCList = null, $asBCCList = null, $sScheduledDate = null,
	                                  $nStatus = null, $nSurveyID = null, $sCreationDate = null, $nID = null, $asErrors = null)
	{
		// Build and return object

		$aMail = array(
			'FromMail' => $sFromMail,
			'FromName' => $sFromName,
			'ToList' => self::createStringList($asToList, 'MailAddress'),
			'Subject' => $sSubject,
			'Body' => $sBody,
			'DeliveryType' => $nDeliveryType,
			'CcList' => !is_null($asCCList) ? self::createStringList($asCCList, 'MailAddress') : null,
			'BccList' => !is_null($asBCCList) ? self::createStringList($asBCCList, 'MailAddress') : null,
			'ScheduledDate' => $sScheduledDate,
			'Status' => $nStatus,
			'SurveyID' => $nSurveyID,
			'CreationDate' => $sCreationDate,
			'ID' => $nID,
			'Errors' => !is_null($asErrors) ? self::createStringList($asErrors) : null
		);

		return (object) $aMail;
	}
}