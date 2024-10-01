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
namespace Soap\Survey;

use Soap\_ASoap as _ASoap;
/**
 * Created by PhpStorm.
 * User: tr
 * Date: 26.09.2016
 * Time: 14:37
 */
class Course extends _ASoap
{
	protected $m_nCourseId;
	protected $m_sProgramOfStudy;
	protected $m_sCourseTitle;
	protected $m_sRoom;
	protected $m_nCourseType;
	protected $m_sPubCourseId;
	protected $m_sExternalId;
	protected $m_nCountStud;
	protected $m_sCustomFieldsJSON;
	protected $m_nUserId;
	protected $m_nFbid;
	protected $m_nPeriodId;
	protected $m_aoParticipants;
	protected $m_aoSecondaryInstructors;
	protected $m_oSurveyHolder;

	public function initFromArray($aArray)
	{
		$this->loadClass('Person', 'Survey');
		$this->loadClass('Survey', 'Survey');
		$this->loadClass('User', 'Survey');

		$this->m_nCourseId = $aArray['m_nCourseId'];
		$this->m_sProgramOfStudy = $aArray['m_sProgramOfStudy'];
		$this->m_sCourseTitle = $aArray['m_sCourseTitle'];
		$this->m_sRoom = $aArray['m_sRoom'];
		$this->m_nCourseType = $aArray['m_nCourseType'];
		$this->m_sPubCourseId = $aArray['m_sPubCourseId'];
		$this->m_sExternalId = $aArray['m_sExternalId'];
		$this->m_nCountStud = $aArray['m_nCountStud'];
		$this->m_sCustomFieldsJSON = $aArray['m_sCustomFieldsJSON'];
		$this->m_nUserId = $aArray['m_nUserId'];
		$this->m_nFbid = $aArray['m_nFbid'];
		$this->m_nPeriodId = $aArray['m_nPeriodId'];
		$this->m_aoParticipants = $this->initObjectArray($aArray['m_aoParticipants'], 'Persons', '\Soap\Survey\Person');
		$this->m_aoSecondaryInstructors = $this->initObjectArray($aArray['m_aoSecondaryInstructors'], 'Users', '\Soap\Survey\User');
		$this->m_oSurveyHolder = $this->initObjectArray($aArray['m_oSurveyHolder'], 'm_aSurveys', '\Soap\Survey\Survey');
	}

	public function getCourseId()
	{
		return $this->m_nCourseId;
	}

	public function getProgramOfStudy()
	{
		return $this->m_sProgramOfStudy;
	}

	public function getCourseTitle()
	{
		return $this->m_sCourseTitle;
	}

	public function getRoom()
	{
		return $this->m_sRoom;
	}

	public function getCourseType()
	{
		return $this->m_nCourseType;
	}

	public function getPubCourseId()
	{
		return $this->m_sPubCourseId;
	}

	public function getExternalId()
	{
		return $this->m_sExternalId;
	}

	public function getCountStud()
	{
		return $this->m_nCountStud;
	}

	public function getCustomFieldsJSON()
	{
		return $this->m_sCustomFieldsJSON;
	}

	public function getUserId()
	{
		return $this->m_nUserId;
	}

	public function getFbid()
	{
		return $this->m_nFbid;
	}

	public function getPeriodId()
	{
		return $this->m_nPeriodId;
	}

	public function getParticipants()
	{
		return $this->m_aoParticipants;
	}

	public function getSecondaryInstructors()
	{
		return $this->m_aoSecondaryInstructors;
	}

	public function getSurveys()
	{
		return $this->m_oSurveyHolder;
	}
}