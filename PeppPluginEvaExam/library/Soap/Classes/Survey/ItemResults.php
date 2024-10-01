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
class ItemResults extends _ASoap
{
	protected $m_ItemId;
	protected $m_ItemCode;
	protected $m_ResponseCount;
	protected $m_AbstentionCount;
	protected $m_FrequencyDistribution;
	protected $m_Mean;
	protected $m_StdDev;
	protected $m_Median;
	protected $m_Norm;

	public function initFromArray($aArray)
	{
		$this->m_ItemId = $aArray['ItemId'];
		$this->m_ItemCode = $aArray['ItemCode'];
		$this->m_ResponseCount = $aArray['ResponseCount'];
		$this->m_AbstentionCount = $aArray['AbstentionCount'];
		$this->m_FrequencyDistribution = array();
		if (is_array($aArray['FrequencyDistribution']) && count($aArray['FrequencyDistribution']) &&
			is_array($aArray['FrequencyDistribution']['Frequencies']) && count($aArray['FrequencyDistribution']['Frequencies']))
		{
			foreach ($aArray['FrequencyDistribution']['Frequencies'] as $aFrequencies)
			{
				array_push($this->m_FrequencyDistribution, $aFrequencies);
			}
		}
		$this->m_Mean = $aArray['Mean'];
		$this->m_StdDev = $aArray['StdDev'];
		$this->m_Median = $aArray['Median'];
		$this->m_Norm = $aArray['Norm'];
	}

	public function getItemId()
	{
		return $this->m_ItemId;
	}
	public function getItemCode()
	{
		return $this->m_ItemCode;
	}
	public function getResponseCount()
	{
		return $this->m_ResponseCount;
	}
	public function getAbstentionCount()
	{
		return $this->m_AbstentionCount;
	}
	public function getFrequencyDistribution()
	{
		return $this->m_FrequencyDistribution;
	}
	public function getMean()
	{
		return $this->m_Mean;
	}
	public function getStdDev()
	{
		return $this->m_StdDev;
	}
	public function getMedian()
	{
		return $this->m_Median;
	}
	public function getNorm()
	{
		return $this->m_Norm;
	}
}