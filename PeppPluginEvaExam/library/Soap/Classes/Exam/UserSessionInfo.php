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
namespace Soap\Exam;

use Soap\_ASoap as _ASoap;
/**
 * Created by PhpStorm.
 * User: tr
 * Date: 24.10.2016
 * Time: 08:40
 */
class UserSessionInfo extends _ASoap
{
	protected $m_nUserId;
	protected $m_nUserType;
	protected $m_nSubunitId;
	protected $m_bIsAdmin;
	protected $m_bIsSubunitAdmin;
	protected $m_sPenultimateLogin;
	protected $m_sSessionStart;
	protected $m_sSessionLastChange;
	protected $m_nSessionRemainingSeconds;
	protected $m_sToken;

	public function initFromArray($aArray)
	{
		$this->m_nUserId = $aArray['UserId'];
		$this->m_nUserType = $aArray['UserType'];
		$this->m_nSubunitId = $aArray['SubunitId'];
		$this->m_bIsAdmin = $aArray['IsAdmin'];
		$this->m_bIsSubunitAdmin = $aArray['IsSubunitAdmin'];
		$this->m_sPenultimateLogin = $aArray['PenultimateLogin'];
		$this->m_sSessionStart = $aArray['SessionStart'];
		$this->m_sSessionLastChange = $aArray['SessionLastChange'];
		$this->m_nSessionRemainingSeconds = $aArray['SessionRemainingSeconds'];
		$this->m_sToken = $aArray['Token'];
	}

	public function getUserID()
	{
		return $this->m_nUserId;
	}
	public function getUserType()
	{
		return $this->m_nUserType;
	}
	public function getSubunitId()
	{
		return $this->m_nSubunitId;
	}
	public function isAdmin()
	{
		return $this->m_bIsAdmin;
	}
	public function isSubunitAdmin()
	{
		return $this->m_bIsSubunitAdmin;
	}
	public function getPenultimateLogin()
	{
		return $this->m_sPenultimateLogin;
	}
	public function getSessionStart()
	{
		return $this->m_sSessionStart;
	}
	public function getSessionLastChange()
	{
		return $this->m_sSessionLastChange;
	}
	public function getSessionRemainingSeconds()
	{
		return $this->m_nSessionRemainingSeconds;
	}
	public function getToken()
	{
		return $this->m_sToken;
	}
}