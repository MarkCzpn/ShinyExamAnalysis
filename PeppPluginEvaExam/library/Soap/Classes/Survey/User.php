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
 * Time: 17:01
 */
class User extends _ASoap
{
	protected $m_nId;
	protected $m_nType;
	protected $m_sLoginName;
	protected $m_sExternalId;
	protected $m_sTitle;
	protected $m_sFirstName;
	protected $m_sSurName;
	protected $m_sUnitName;
	protected $m_sAddress;
	protected $m_sEmail;
	protected $m_nFbid;
	protected $m_nAddressId;
	protected $m_sPassword;
	protected $m_sPhoneNumber;
	protected $m_bUseLDAP;
	protected $m_bActiveUser;
// 	protected $m_aCourses;

	public function initFromArray($aArray)
	{
		$this->loadClass('Course', 'Survey');

		$this->m_nId = $aArray['m_nId'];
		$this->m_nType = $aArray['m_nType'];
		$this->m_sLoginName = $aArray['m_sLoginName'];
		$this->m_sExternalId = $aArray['m_sExternalId'];
		$this->m_sTitle = $aArray['m_sTitle'];
		$this->m_sFirstName = $aArray['m_sFirstName'];
		$this->m_sSurName = $aArray['m_sSurName'];
		$this->m_sUnitName = $aArray['m_sUnitName'];
		$this->m_sAddress = $aArray['m_sAddress'];
		$this->m_sEmail = $aArray['m_sEmail'];
		$this->m_nFbid = $aArray['m_nFbid'];
		$this->m_nAddressId = $aArray['m_nAddressId'];
		$this->m_sPassword = $aArray['m_sPassword'];
		$this->m_sPhoneNumber = $aArray['m_sPhoneNumber'];
		$this->m_bUseLDAP = $aArray['m_bUseLDAP'];
		$this->m_bActiveUser = $aArray['m_bActiveUser'];
		$this->m_aCourses = $this->initObjectArray($aArray['m_aCourses'], 'Courses', '\Soap\Survey\Course');
	}

	public function getId()
	{
		return $this->m_nId;
	}
	public function getType()
	{
		return $this->m_nType;
	}
	public function getLoginName()
	{
		return $this->m_sLoginName;
	}
	public function getExternalId()
	{
		return $this->m_sExternalId;
	}
	public function getTitle()
	{
		return $this->m_sTitle;
	}
	public function getFirstName()
	{
		return $this->m_sFirstName;
	}
	public function getSurName()
	{
		return $this->m_sSurName;
	}
	public function getUnitName()
	{
		return $this->m_sUnitName;
	}
	public function getAddress()
	{
		return $this->m_sAddress;
	}
	public function getEmail()
	{
		return $this->m_sEmail;
	}
	public function getFbid()
	{
		return $this->m_nFbid;
	}
	public function getAddressId()
	{
		return $this->m_nAddressId;
	}
	public function getPassword()
	{
		return $this->m_sPassword;
	}
	public function getPhoneNumber()
	{
		return $this->m_sPhoneNumber;
	}
	public function getUseLDAP()
	{
		return $this->m_bUseLDAP;
	}
	public function getActiveUser()
	{
		return $this->m_bActiveUser;
	}
	public function getCourses()
	{
		return $this->m_aCourses;
	}
}