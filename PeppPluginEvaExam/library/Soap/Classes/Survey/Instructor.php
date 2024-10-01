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
 * Time: 16:45
 */
class Instructor extends _ASoap
{
	protected $m_nInstructorUid;
	protected $m_sInstructorLogin;
	protected $m_sFirstName;
	protected $m_sLastName;
	protected $m_sTitle;
	protected $m_cGender;
	protected $m_sEmail;
	protected $m_sPhone;
	protected $m_nLanguage;
	protected $m_nIsActiveUser;
	protected $m_sProjectName;

	public function initFromArray($aArray)
	{
		$this->m_nInstructorUid = $aArray['InstructorUid'];
		$this->m_sInstructorLogin = $aArray['InstructorLogin'];
		$this->m_sFirstName = $aArray['FirstName'];
		$this->m_sLastName = $aArray['LastName'];
		$this->m_sTitle = $aArray['Title'];
		$this->m_cGender = $aArray['Gender'];
		$this->m_sEmail = $aArray['Email'];
		$this->m_sPhone = $aArray['Phone'];
		$this->m_nLanguage = $aArray['Language'];
		$this->m_nIsActiveUser = $aArray['IsActiveUser'];
		$this->m_sProjectName = $aArray['ProjectName'];
	}

	public function getInstructorUid()
	{
		return $this->m_nInstructorUid;
	}
	public function getInstructorLogin()
	{
		return $this->m_sInstructorLogin;
	}
	public function getFirstName()
	{
		return $this->m_sFirstName;
	}
	public function getLastName()
	{
		return $this->m_sLastName;
	}
	public function getTitle()
	{
		return $this->m_sTitle;
	}
	public function getGender()
	{
		return $this->m_cGender;
	}
	public function getEmail()
	{
		return $this->m_sEmail;
	}
	public function getPhone()
	{
		return $this->m_sPhone;
	}
	public function getLanguage()
	{
		return $this->m_nLanguage;
	}
	public function getIsActiveUser()
	{
		return $this->m_nIsActiveUser;
	}
	public function getProjectName()
	{
		return $this->m_sProjectName;
	}

}