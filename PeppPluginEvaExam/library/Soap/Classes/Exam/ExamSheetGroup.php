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
 * User: sbe
 * Date: 25.01.2017
 * Time: 12:21
 */
class ExamSheetGroup extends _ASoap
{
	protected $m_GroupId;
	protected $m_Title;
	protected $m_FontSize;
	protected $m_IsTextElement;
	protected $m_Position;
	protected $m_ItemList;

	public function initFromArray($aArray)
	{
		$this->loadClass('ExamSheetGroupItem', 'Exam');

		$this->m_GroupId            = $aArray['GroupId'];
		$this->m_Position           = $aArray['Position'];
		$this->m_Title              = $aArray['Title'];
		$this->m_IsTextElement      = $aArray['IsTextElement'];
		$this->m_FontSize           = $aArray['FontSize'];
		$this->m_ItemList           = $this->initObjectArray($aArray['ItemList'], 'ExamSheetGroupItems', '\Soap\Exam\ExamSheetGroupItem');
	}

	public function getGroupId()
	{
		return $this->m_GroupId;
	}
	public function getPosition()
	{
		return $this->m_Position;
	}
	public function getTitle()
	{
		return $this->m_Title;
	}
	public function isTextElement()
	{
		return $this->m_IsTextElement;
	}
	public function getFontSize()
	{
		return $this->m_FontSize;
	}
	
	/**
	 * @return ExamSheetGroupItem[]
	 */
	public function getItemList()
	{
		return $this->m_ItemList;
	}
}