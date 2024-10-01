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

/**
 * Session Helper class for EvaSys projects.
 * User: SBE
 * Date: 07.03.2019
 * Time: 10:05
 */
namespace Soap;

require_once 'library/Soap/SoapFunctions.php';

class SessionHelper
{
	protected static $session_class;
	protected static $oSoapFunctions;
	protected $sSessionId;
	protected $sToken;
	protected $oUserSessionInfo;
	
	public function __construct($sSessionId, $sToken)
	{
		$this->sSessionId = $sSessionId;
		$this->sToken = $sToken;
		$this->oUserSessionInfo = null;
		
		self::$oSoapFunctions = new SoapFunctions();
		self::$session_class = Survey\UserSessionInfo::class;
	}
	
	
	/**
	 * Check if the session is valid and allowed to use this plug-in
	 * @return bool
	 */
	public function checkSession()
	{
		if($this->oUserSessionInfo === null)
		{
			$this->oUserSessionInfo = false;
			
			$oUserSessionInfo = self::$oSoapFunctions->getUserSessionInfo($this->sSessionId, true);
			if(isset($oUserSessionInfo)
			&& get_class($oUserSessionInfo) === self::$session_class
			&& $this->sToken === $oUserSessionInfo->getToken())
			{
				$this->oUserSessionInfo = $oUserSessionInfo;
				return true;
			}
			
			return false;
		}
		
		return $this->oUserSessionInfo !== false;
	}
	
	/**
	 * Check if the session is valid and for an admin
	 * @return bool
	 */
	public function isSessionForAdmin()
	{
		return $this->checkSession() && $this->oUserSessionInfo->isAdmin();
	}
	
	/**
	 * Check if the session is valid and for an subunit admin
	 * @return bool
	 */
	public function isSessionForSubunitAdmin()
	{
		return $this->checkSession() && $this->oUserSessionInfo->isSubunitAdmin();
	}
	
	/**
	 * Check if the session is valid and for special user type
	 * @param int[] $aTypes
	 * @return bool
	 */
	public function isSessionForUserTypes($aTypes)
	{
		return $this->checkSession() && in_array($this->oUserSessionInfo->getUserType(), $aTypes);
	}
	
	/**
	 * Check if the session is valid and for this user id
	 * @param int $nUserId
	 * @return bool
	 */
	public function isSessionForUserId($nUserId)
	{
		return $this->checkSession() && $this->oUserSessionInfo->getUserID() == $nUserId;
	}
	
	public function getUserSessionInfo()
	{
		return $this->oUserSessionInfo;
	}
}