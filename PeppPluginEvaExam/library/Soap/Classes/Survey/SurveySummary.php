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
 * Class FilterSet
 * User: sbe
 * Date: 01.09.2017
 * Time: 12:06
 * @package Soap\Survey
 */
class SurveySummary extends _ASoap
{
	protected $m_nSurveyId;
	protected $m_sSurveyName;
	protected $m_sSurveyCourseCode;
	protected $m_sSubunitName;
	protected $m_sSurveyInstructorName;
	protected $m_sSurveyType;
	protected $m_bSurveyIsAnonymous;
	protected $m_nSurveyStatus;
	protected $m_nSurveyOpenState;
	protected $m_sSurveyPeriod;
	protected $m_sSurveyCreationDate;
	protected $m_sSurveyScheduledStartDate;
	protected $m_sSurveyScheduledEndDate;
	protected $m_sDirectOnlineLink;
	protected $m_bParticipated;
	
	public function initFromArray($aArray)
	{
		$this->m_nSurveyId = $aArray['SurveyId'];
		$this->m_sSurveyName = $aArray['SurveyName'];
		$this->m_sSurveyCourseCode = $aArray['SurveyCourseCode'];
		$this->m_sSubunitName = $aArray['SubunitName'];
		$this->m_sSurveyInstructorName = $aArray['SurveyInstructorName'];
		$this->m_sSurveyType = $aArray['SurveyType'];
		$this->m_bSurveyIsAnonymous = $aArray['SurveyIsAnonymous'];
		$this->m_nSurveyStatus = $aArray['SurveyStatus'];
		$this->m_nSurveyOpenState = $aArray['SurveyOpenState'];
		$this->m_sSurveyPeriod = $aArray['SurveyPeriod'];
		$this->m_sSurveyCreationDate = $aArray['SurveyCreationDate'];
		$this->m_sSurveyScheduledStartDate = $aArray['SurveyScheduledStartDate'];
		$this->m_sSurveyScheduledEndDate = $aArray['SurveyScheduledEndDate'];
		$this->m_sDirectOnlineLink = $aArray['DirectOnlineLink'];
		$this->m_bParticipated = $aArray['Participated'];
	}
	
	/**
	 * @return int
	 */
	public function getSurveyId()
	{
		return $this->m_nSurveyId;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyName()
	{
		return $this->m_sSurveyName;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyCourseCode()
	{
		return $this->m_sSurveyCourseCode;
	}
	
	/**
	 * @return string
	 */
	public function getSubunitName()
	{
		return $this->m_sSubunitName;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyInstructorName()
	{
		return $this->m_sSurveyInstructorName;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyType()
	{
		return $this->m_sSurveyType;
	}
	
	
	/**
	 * @return boolean
	 */
	public function getSurveyIsAnonymous()
	{
		return $this->m_bSurveyIsAnonymous;
	}
	
	/**
	 * @return int
	 */
	public function getSurveyStatus()
	{
		return $this->m_nSurveyStatus;
	}
	
	/**
	 * @return int
	 */
	public function getSurveyOpenState()
	{
		return $this->m_nSurveyOpenState;
	}
	
	
	/**
	 * @return string
	 */
	public function getSurveyPeriod()
	{
		return $this->m_sSurveyPeriod;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyCreationDate()
	{
		return $this->m_sSurveyCreationDate;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyScheduledStartDate()
	{
		return $this->m_sSurveyScheduledStartDate;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyScheduledEndDate()
	{
		return $this->m_sSurveyScheduledEndDate;
	}
	
	/**
	 * @return mixed
	 */
	public function getDirectOnlineLink()
	{
		return $this->m_sDirectOnlineLink;
	}
	
	/**
	 * @return boolean
	 */
	public function getParticipated()
	{
		return $this->m_bParticipated;
	}
}