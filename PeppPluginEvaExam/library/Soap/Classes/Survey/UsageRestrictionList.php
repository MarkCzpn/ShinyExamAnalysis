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
class UsageRestrictionList extends _ASoap
{
	protected $m_aSubunits;
	protected $m_aCourseTypes;
	protected $m_aPeriods;

	public function initFromArray($aArray)
	{
		$this->m_aSubunits = array();
		if (is_array($aArray['Subunits']))
		{
			if(count($aArray['Subunits']) && is_array($aArray['Subunits']['ID']) && count($aArray['Subunits']['ID']))
			{
				foreach ($aArray['Subunits']['ID'] as $nID)
				{
					array_push($this->m_aSubunits, $nID);
				}
			}
			elseif(isset($aArray['Subunits']['ID']))
			{
				array_push($this->m_aSubunits, $aArray['Subunits']['ID']);
			}
		}
		
		$this->m_aCourseTypes = array();
		if (is_array($aArray['CourseTypes']))
		{
			if(count($aArray['CourseTypes']) && is_array($aArray['CourseTypes']['ID']) && count($aArray['CourseTypes']['ID']))
			{
				foreach ($aArray['CourseTypes']['ID'] as $nID)
				{
					array_push($this->m_aCourseTypes, $nID);
				}
			}
			elseif(isset($aArray['CourseTypes']['ID']))
			{
				array_push($this->m_aCourseTypes, $aArray['CourseTypes']['ID']);
			}
		}
		$this->m_aPeriods = array();
		if (is_array($aArray['Periods']))
		{
			if(count($aArray['Periods']) && is_array($aArray['Periods']['ID']) && count($aArray['Periods']['ID']))
			{
				foreach ($aArray['Periods']['ID'] as $nID)
				{
					array_push($this->m_aPeriods, $nID);
				}
			}
			elseif(isset($aArray['Periods']['ID']))
			{
				array_push($this->m_aPeriods, $aArray['Periods']['ID']);
			}
		}
	}

	public function getSubunits()
	{
		return $this->m_aSubunits;
	}
	public function getCourseTypes()
	{
		return $this->m_aCourseTypes;
	}
	public function getPeriods()
	{
		return $this->m_aPeriods;
	}
}