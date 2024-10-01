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
 * Class FilterSet
 * User: sbe
 * Date: 01.09.2017
 * Time: 11:50
 * @package Soap\Survey
 */
class FilterSet extends _ASoap
{
	protected $m_nTriggerItemId;
	protected $m_nAction;
	protected $m_anTargetItems;
	protected $m_anTriggerValues;
	protected $m_bIsInitialFilterSet;
	protected $m_nOperator;
	
	public function initFromArray($aArray)
	{
		$this->m_nTriggerItemId = $aArray['TriggerItemId'];
		$this->m_nAction = $aArray['Action'];
		
		$this->m_anTargetItems = [];
		if (is_array($aArray['TargetItems']) && is_array($aArray['TargetItems']['ID'])
		&& count($aArray['TargetItems']['ID']))
		{
			foreach ($aArray['TargetItems']['ID'] as $nValue)
			{
				array_push($this->m_anTargetItems, $nValue);
			}
		}
		
		$this->m_anTriggerValues = [];
		if (is_array($aArray['TriggerValues']) && count($aArray['TriggerValues']))
		{
			foreach ($aArray['TriggerValues'] as $nValue)
			{
				array_push($this->m_anTriggerValues, $nValue);
			}
		}
		
		$this->m_bIsInitialFilterSet = $aArray['IsInitialFilterSet'];
		$this->m_nOperator = $aArray['Operator'];
	}
	
	/**
	 * @return int
	 */
	public function getTriggerItemId()
	{
		return $this->m_nTriggerItemId;
	}
	
	/**
	 * @return int
	 */
	public function getAction()
	{
		return $this->m_nAction;
	}
	
	/**
	 * @return int[]
	 */
	public function getTargetItems()
	{
		return $this->m_anTargetItems;
	}
	
	/**
	 * @return int[]
	 */
	public function getTriggerValues()
	{
		return $this->m_anTriggerValues;
	}
	
	/**
	 * @return boolean
	 */
	public function getIsInitialFilterSet()
	{
		return $this->m_bIsInitialFilterSet;
	}
	
	/**
	 * @return int
	 */
	public function getOperator()
	{
		return $this->m_nOperator;
	}
}