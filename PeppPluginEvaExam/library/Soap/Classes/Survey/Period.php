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
 * Time: 14:38
 */
class Period extends _ASoap
{
	protected $m_nPeriodId;
	protected $m_sTitel;
	protected $m_sStartDate;
	protected $m_sEndDate;

	public function initFromArray($aArray)
	{
		$this->m_nPeriodId = $aArray['m_nPeriodId'];
		$this->m_sTitel = $aArray['m_sTitel'];
		$this->m_sStartDate = $aArray['m_sStartDate'];
		$this->m_sEndDate = $aArray['m_sEndDate'];
	}

	public function getPeriodId()
	{
		return $this->m_nPeriodId;
	}
	public function getTitel()
	{
		return $this->m_sTitel;
	}
	public function getStartDate()
	{
		return $this->m_sStartDate;
	}
	public function getEndDate()
	{
		return $this->m_sEndDate;
	}
}