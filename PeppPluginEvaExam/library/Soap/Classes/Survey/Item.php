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
 * Time: 15:12
 */
class Item extends _ASoap
{
	protected $m_ItemId;
	protected $m_Position;
	protected $m_Title;
	protected $m_ItemCode;
	protected $m_AnswerCount;
	protected $m_Type;
	protected $m_Options;
	protected $m_GraphType;
	protected $m_Abstention;
	protected $m_Orientation;
	protected $m_RowCount;
	protected $m_IsMirrored;
	protected $m_UseIcr;
	protected $m_IcrType;
	protected $m_OptionValue;
	protected $m_AnswerPosition;
	protected $m_ShowDropdown;
	protected $m_MaximalAnswers;
	protected $m_Alignment;
	protected $m_Degree;
	protected $m_IsRequired;
	protected $m_ExportValues;

	public function initFromArray($aArray)
	{
		$this->m_ItemId = $aArray['ItemId'];
		$this->m_Position = $aArray['Position'];
		$this->m_Title = $aArray['Title'];
		$this->m_ItemCode = $aArray['ItemCode'];
		$this->m_AnswerCount = $aArray['AnswerCount'];
		$this->m_Type = $aArray['Type'];
		$this->m_Options = array();
		if (is_array($aArray['Options']) && count($aArray['Options']) && 
			is_array($aArray['Options']['Strings']) && count($aArray['Options']['Strings']))
		{
			foreach ($aArray['Options']['Strings'] as $option)
			{
				array_push($this->m_Options, $option);
			}
		}
		$this->m_GraphType = $aArray['GraphType'];
		$this->m_Abstention = $aArray['Abstention'];
		$this->m_Orientation = $aArray['Orientation'];
		$this->m_RowCount = $aArray['RowCount'];
		$this->m_IsMirrored = $aArray['IsMirrored'];
		$this->m_UseIcr = $aArray['UseIcr'];
		$this->m_IcrType = $aArray['IcrType'];
		$this->m_OptionValue = $aArray['OptionValue'];
		$this->m_AnswerPosition = $aArray['AnswerPosition'];
		$this->m_ShowDropdown = $aArray['ShowDropdown'];
		$this->m_MaximalAnswers = $aArray['MaximalAnswers'];
		$this->m_Alignment = $aArray['Alignment'];
		$this->m_Degree = $aArray['Degree'];
		$this->m_IsRequired = $aArray['IsRequired'];
		$this->m_ExportValues = array();
		if (is_array($aArray['ExportValues']) && count($aArray['ExportValues']))
		{
			foreach ($aArray['ExportValues'] as $value)
			{
				array_push($this->m_ExportValues, $value);
			}
		}
	}

	public function getItemId()
	{
		return $this->m_ItemId;
	}
	public function getPosition()
	{
		return $this->m_Position;
	}
	public function getTitle()
	{
		return $this->m_Title;
	}
	public function getItemCode()
	{
		return $this->m_ItemCode;
	}
	public function getAnswerCount()
	{
		return $this->m_AnswerCount;
	}
	public function getType()
	{
		return $this->m_Type;
	}
	public function getOptions()
	{
		return $this->m_Options;
	}
	public function getGraphType()
	{
		return $this->m_GraphType;
	}
	public function getAbstention()
	{
		return $this->m_Abstention;
	}
	public function getOrientation()
	{
		return $this->m_Orientation;
	}
	public function getRowCount()
	{
		return $this->m_RowCount;
	}
	public function getIsMirrored()
	{
		return $this->m_IsMirrored;
	}
	public function getUseIcr()
	{
		return $this->m_UseIcr;
	}
	public function getIcrType()
	{
		return $this->m_IcrType;
	}
	public function getOptionValue()
	{
		return $this->m_OptionValue;
	}
	public function getAnswerPosition()
	{
		return $this->m_AnswerPosition;
	}
	public function getShowDropdown()
	{
		return $this->m_ShowDropdown;
	}
	public function getMaximalAnswers()
	{
		return $this->m_MaximalAnswers;
	}
	public function getAlignment()
	{
		return $this->m_Alignment;
	}
	public function getDegree()
	{
		return $this->m_Degree;
	}
	public function getIsRequired()
	{
		return $this->m_IsRequired;
	}
	public function getExportValues()
	{
		return $this->m_ExportValues;
	}
	
	public function __toArray()
	{
		$aArray['ItemId'] = $this->m_ItemId;
		$aArray['Position'] = $this->m_Position;
		$aArray['Title'] = $this->m_Title;
		$aArray['ItemCode'] = $this->m_ItemCode;
		$aArray['AnswerCount'] = $this->m_AnswerCount;
		$aArray['Type'] = $this->m_Type;
		$aArray['Options'] = [];
		foreach($this->m_Options as $sOption)
		{
			$aArray['Options']['Strings'][] = $sOption;
		}
		$aArray['GraphType'] = $this->m_GraphType;
		$aArray['Abstention'] = $this->m_Abstention;
		$aArray['Orientation'] = $this->m_Orientation;
		$aArray['RowCount'] = $this->m_RowCount;
		$aArray['IsMirrored'] = $this->m_IsMirrored;
		$aArray['UseIcr'] = $this->m_UseIcr;
		$aArray['IcrType'] = $this->m_IcrType;
		$aArray['OptionValue'] = $this->m_OptionValue;
		$aArray['AnswerPosition'] = $this->m_AnswerPosition;
		$aArray['ShowDropdown'] = $this->m_ShowDropdown;
		$aArray['MaximalAnswers'] = $this->m_MaximalAnswers;
		$aArray['Alignment'] = $this->m_Alignment;
		$aArray['Degree'] = $this->m_Degree;
		$aArray['IsRequired'] = $this->m_IsRequired;
		$aArray['ExportValues'] = $this->m_ExportValues;
		
		return $aArray;
	}
}