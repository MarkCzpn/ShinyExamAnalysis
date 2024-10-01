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
 * Date: 27.09.2016
 * Time: 08:23
 */
class Person extends _ASoap
{
	protected $m_nId;
	protected $m_sTitle;
	protected $m_sFirstname;
	protected $m_sLastname;
	protected $m_sIdentifier;
	protected $m_sEmail;
	protected $m_nGender;
	protected $m_sAddress;
	protected $m_sCustomFieldsJSON;

	public function initFromArray($aArray)
	{
		$this->m_nId = $aArray['m_nId'];
		$this->m_sTitle = $aArray['m_sTitle'];
		$this->m_sFirstname = $aArray['m_sFirstname'];
		$this->m_sLastname = $aArray['m_sLastname'];
		$this->m_sIdentifier = $aArray['m_sIdentifier'];
		$this->m_sEmail = $aArray['m_sEmail'];
		$this->m_nGender = $aArray['m_nGender'];
		$this->m_sAddress = $aArray['m_sAddress'];
		$this->m_sCustomFieldsJSON = $aArray['m_sCustomFieldsJSON'];
	}

	public function getId()
	{
		return $this->m_nId;
	}
	public function getTitle()
	{
		return $this->m_sTitle;
	}
	public function getFirstname()
	{
		return $this->m_sFirstname;
	}
	public function getLastname()
	{
		return $this->m_sLastname;
	}
	public function getIdentifier()
	{
		return $this->m_sIdentifier;
	}
	public function getEmail()
	{
		return $this->m_sEmail;
	}
	public function getGender()
	{
		return $this->m_nGender;
	}
	public function getAddress()
	{
		return $this->m_sAddress;
	}
	public function getCustomFieldsJSON()
	{
		return $this->m_sCustomFieldsJSON;
	}
}