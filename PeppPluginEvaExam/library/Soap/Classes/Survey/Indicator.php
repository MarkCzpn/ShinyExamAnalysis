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
 * Time: 15:56
 */
class Indicator extends _ASoap
{
	protected $m_nPosition;
	protected $m_asNames;
	protected $m_anItems;
	protected $m_fMean;
	protected $m_fStdDev;

	public function initFromArray($aArray)
	{
		$this->loadClass('IndicatorName', 'Survey');
		
		$this->m_nPosition = $aArray['Position'];
		$this->m_asNames = array();
		if (is_array($aArray['Names']) && count($aArray['Names']) && is_array($aArray['Names']['IndicatorName']) && count($aArray['Names']['IndicatorName']))
		{
			foreach ($aArray['Names']['IndicatorName'] as $asIndicatorName)
			{
				array_push($this->m_asNames, new IndicatorName($asIndicatorName));
			}
		}
		$this->m_anItems = array();
		if (is_array($aArray['Items']) && count($aArray['Items']) && is_array($aArray['Items']['ID']) && count($aArray['Items']['ID']))
		{
			foreach ($aArray['Items']['ID'] as $anID)
			{
				array_push($this->m_anItems, $anID);
			}
		}
		$this->m_fMean = $aArray['Mean'];
		$this->m_fStdDev = $aArray['StdDev'];
	}

	public function getPosition()
	{
		return $this->m_nPosition;
	}
	public function getNames()
	{
		return $this->m_asNames;
	}
	public function getItems()
	{
		return $this->m_anItems;
	}
	public function getMean()
	{
		return $this->m_fMean;
	}
	public function getStdDev()
	{
		return $this->m_fStdDev;
	}

}