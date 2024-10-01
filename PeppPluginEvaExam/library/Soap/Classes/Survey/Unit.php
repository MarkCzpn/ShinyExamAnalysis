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
 * Date: 19.10.2016
 * Time: 14:28
 */
class Unit extends _ASoap
{
	protected $m_nId;
	protected $m_sName;
	protected $m_nPublicUnitNumber;
	protected $m_nImageAccess;
	protected $m_aUsers;

	public function initFromArray($aArray)
	{
		$this->loadClass('User', 'Survey');
		
		$this->m_nId = $aArray['m_nId'];
		$this->m_sName = $aArray['m_sName'];
		$this->m_nPublicUnitNumber = $aArray['m_nPublicUnitNumber'];
		$this->m_nImageAccess = $aArray['m_nImageAccess'];
		$this->m_aUsers = $this->initObjectArray($aArray['m_aUsers'], 'Users', '\Soap\Survey\User');
	}

	public function getId()
	{
		return $this->m_nId;
	}
	public function getName()
	{
		return $this->m_sName;
	}
	public function getPublicUnitNumber()
	{
		return $this->m_nPublicUnitNumber;
	}
	public function getImageAccess()
	{
		return $this->m_nImageAccess;
	}
	public function getUsers()
	{
		return $this->m_aUsers;
	}
}