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
 * Date: 24.10.2016
 * Time: 09:11
 */
class InvitationTask extends _ASoap
{
	protected $m_nSurveyID;
	protected $m_sStartTime;
	protected $m_nTaskID;
	protected $m_nStatus;
	protected $m_sSenderName;
	protected $m_sSenderEmail;
	protected $m_sEmailText;
	protected $m_sEmailSubject;
	protected $m_bSendInstructorNotification;

	public function initFromArray($aArray)
	{
		$this->m_nSurveyID = $aArray['nSurveyID'];
		$this->m_sStartTime = $aArray['StartTime'];
		$this->m_nTaskID = $aArray['TaskID'];
		$this->m_nStatus = $aArray['Status'];
		$this->m_sSenderName = $aArray['SenderName'];
		$this->m_sSenderEmail = $aArray['SenderEmail'];
		$this->m_sEmailText = $aArray['EmailText'];
		$this->m_sEmailSubject = $aArray['EmailSubject'];
		$this->m_bSendInstructorNotification = $aArray['SendInstructorNotification'];
	}

	public function getSurveyID()
	{
		return $this->m_nSurveyID;
	}
	public function getStartTime()
	{
		return $this->m_sStartTime;
	}
	public function getTaskID()
	{
		return $this->m_nTaskID;
	}
	public function getStatus()
	{
		return $this->m_nStatus;
	}
	public function getSenderName()
	{
		return $this->m_sSenderName;
	}
	public function getSenderEmail()
	{
		return $this->m_sSenderEmail;
	}
	public function getEmailText()
	{
		return $this->m_sEmailText;
	}
	public function getEmailSubject()
	{
		return $this->m_sEmailSubject;
	}
	public function getSendInstructorNotification()
	{
		return $this->m_bSendInstructorNotification;
	}

}