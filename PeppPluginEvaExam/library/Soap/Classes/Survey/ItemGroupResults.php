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
 * Time: 15:14
 */
class ItemGroupResults extends _ASoap
{
	protected $m_ItemGroupId;
	protected $m_Mean;
	protected $m_StdDev;
	protected $m_Norm;

	public function initFromArray($aArray)
	{
		$this->m_ItemGroupId = $aArray['ItemGroupId'];
		$this->m_Mean = $aArray['Mean'];
		$this->m_StdDev = $aArray['StdDev'];
		$this->m_Norm = $aArray['Norm'];
	}

	public function getItemGroupId()
	{
		return $this->m_ItemGroupId;
	}
	public function getMean()
	{
		return $this->m_Mean;
	}
	public function getStdDev()
	{
		return $this->m_StdDev;
	}
	public function getNorm()
	{
		return $this->m_Norm;
	}
}