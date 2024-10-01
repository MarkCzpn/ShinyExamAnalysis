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
 * User: sbe
 * Date: 06.01.2017
 * Time: 10:21
 */
class ItemAnswer extends _ASoap
{
	protected $m_ItemId;
	protected $m_ItemCode;
	protected $m_ItemValue;
	protected $m_ResultId;
	
	public function initFromArray($aArray)
	{
		$this->m_ItemId = $aArray['ItemId'];
		$this->m_ItemCode = $aArray['ItemCode'];
		$this->m_ItemValue = $aArray['ItemValue'];
		$this->m_ResultId = $aArray['ResultId'];
	}
	
	public function getItemId()
	{
		return $this->m_ItemId;
	}
	public function getItemCode()
	{
		return $this->m_ItemCode;
	}
	public function getItemValue()
	{
		return $this->m_ItemValue;
	}
	public function getResultId()
	{
		return $this->m_ResultId;
	}
	
	public function __toArray()
	{
		$aArray = [];
		$aArray['ItemId'] = $this->m_ItemId;
		$aArray['ItemCode'] = $this->m_ItemCode;
		$aArray['ItemValue'] = $this->m_ItemValue;
		$aArray['ResultId'] = $this->m_ResultId;
		return $aArray;
	}
}