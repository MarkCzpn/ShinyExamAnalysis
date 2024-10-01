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
 * Session Helper class for EvaExam projects.
 * User: SBE
 * Date: 07.03.2019
 * Time: 10:05
 */
namespace Soap;

require_once 'library/Soap/SessionHelper.php';
require_once 'library/Soap/SoapFunctionsExam.php';

class SessionHelperExam extends SessionHelper
{
	public function __construct($sSessionId, $sToken)
	{
		parent::__construct($sSessionId, $sToken);
		
		self::$oSoapFunctions = new SoapFunctionsExam();
		self::$session_class = Exam\UserSessionInfo::class;
	}
}