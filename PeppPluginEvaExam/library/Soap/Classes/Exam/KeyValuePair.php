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
 * Date: 08.02.2017
 * Time: 09:19
 */
class KeyValuePair extends _ASoap
{
	protected $m_sKey;
	protected $m_sValue;

	public function initFromArray($aArray)
	{
		$this->m_sKey = $aArray['Key'];
		$this->m_sValue = $aArray['Value'];
	}

	public function getKey()
	{
		return $this->m_sKey;
	}
	public function getValue()
	{
		return $this->m_sValue;
	}
}