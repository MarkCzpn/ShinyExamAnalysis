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
class ItemGroup extends _ASoap
{
	protected $m_ItemGroupId;
	protected $m_Position;
	protected $m_Title;
	protected $m_Description;
	protected $m_IndicatorDimension;
	protected $m_IsText;
	protected $m_FontSize;
	protected $m_ItemList;

	public function initFromArray($aArray)
	{
		$this->loadClass('Item', 'Survey');

		$this->m_ItemGroupId = $aArray['ItemGroupId'];
		$this->m_Position = $aArray['Position'];
		$this->m_Title = $aArray['Title'];
		$this->m_Description = $aArray['Description'];
		$this->m_IndicatorDimension = $aArray['IndicatorDimension'];
		$this->m_IsText = $aArray['IsText'];
		$this->m_FontSize = $aArray['FontSize'];
		$this->m_ItemList = $this->initObjectArray($aArray['ItemList'], 'Items', '\Soap\Survey\Item');
	}

	public function getItemGroupId()
	{
		return $this->m_ItemGroupId;
	}
	public function getPosition()
	{
		return $this->m_Position;
	}
	public function getTitle()
	{
		return $this->m_Title;
	}
	public function getDescription()
	{
		return $this->m_Description;
	}
	public function getIndicatorDimension()
	{
		return $this->m_IndicatorDimension;
	}
	public function getIsText()
	{
		return $this->m_IsText;
	}
	public function getFontSize()
	{
		return $this->m_FontSize;
	}
	public function getItemList()
	{
		return $this->m_ItemList;
	}
	
	public function __toArray()
	{
		$aArray['ItemGroupId'] = $this->m_ItemGroupId;
		$aArray['Position'] = $this->m_Position;
		$aArray['Title'] = $this->m_Title;
		$aArray['Description'] = $this->m_Description;
		$aArray['IndicatorDimension'] = $this->m_IndicatorDimension;
		$aArray['IsText'] = $this->m_IsText;
		$aArray['FontSize'] = $this->m_FontSize;
		$aArray['ItemList'] = [];
		foreach($this->m_ItemList as $oItem)
		{
			$aArray['ItemList'][] = $oItem->__toArray();
		}
		
		return $aArray;
	}
}