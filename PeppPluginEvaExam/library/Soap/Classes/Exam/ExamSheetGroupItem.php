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
class ExamSheetGroupItem extends _ASoap
{
	protected $m_ItemId;
	protected $m_Type;
	protected $m_Text;
	protected $m_Difficulty;
	protected $m_Position;
	protected $m_OptionCount;
	protected $m_OptionList;
	protected $m_OptionValue;
	protected $m_Explanation;
	protected $m_Reference;
	protected $m_Shortname;
	protected $m_Solution;
	
	protected $m_OpenQuestion_LineCount;
	protected $m_OpenQuestion_AdditionalPages;
	protected $m_OpenQuestion_MaxCharacters;
	protected $m_OpenQuestion_MaxScore;

	public function initFromArray($aArray)
	{
		$this->loadClass('ExamSheetGroupItemOption', 'Exam');
		
		$this->m_ItemId = $aArray['ItemId'];
		$this->m_Type = $aArray['Type'];
		$this->m_Text = $aArray['Text'];
		$this->m_Difficulty = $aArray['Difficulty'];
		$this->m_Position = $aArray['Position'];
		$this->m_OptionCount = $aArray['OptionCount'];
		$this->m_OptionList = $this->initObjectArray($aArray['OptionList'], 'ExamSheetGroupItemOptions', '\Soap\Exam\ExamSheetGroupItemOption');
		$this->m_OptionValue = $aArray['OptionValue'];
		
		$this->m_Explanation = $aArray['Explanation'];
		$this->m_Reference = $aArray['Reference'];
		$this->m_Shortname = $aArray['Shortname'];
		$this->m_Solution = $aArray['Solution'];
		
		$this->m_OpenQuestion_LineCount = $aArray['OpenQuestion_LineCount'];
		$this->m_OpenQuestion_AdditionalPages = $aArray['OpenQuestion_AdditionalPages'];
		$this->m_OpenQuestion_MaxCharacters = $aArray['OpenQuestion_MaxCharacters'];
		$this->m_OpenQuestion_MaxScore = $aArray['OpenQuestion_MaxScore'];
	}
	
	public function getOpenQuestionLineCount()
	{
		return $this->m_OpenQuestion_LineCount;
	}
	public function getOpenQuestionAdditionalPages()
	{
		return $this->m_OpenQuestion_AdditionalPages;
	}
	public function getOpenQuestionMaxCharacters()
	{
		return $this->m_OpenQuestion_MaxCharacters;
	}
	public function getOpenQuestionMaxScore()
	{
		return $this->m_OpenQuestion_MaxScore;
	}

	public function getItemId()
	{
		return $this->m_ItemId;
	}
	public function getType()
	{
		return $this->m_Type;
	}
	public function getText()
	{
		return $this->m_Text;
	}
	public function getPosition()
	{
		return $this->m_Position;
	}
	public function getOptionCount()
	{
		return $this->m_OptionCount;
	}
	
	/**
	 * @return ExamSheetGroupItemOption[]
	 */
	public function getOptionList()
	{
		return $this->m_OptionList;
	}
	public function getOptionValue()
	{
		return $this->m_OptionValue;
	}
	public function getExplanation()
	{
		return $this->m_Explanation;
	}
	public function getReference()
	{
		return $this->m_Reference;
	}
	public function getShortname()
	{
		return $this->m_Shortname;
	}
	public function getSolution()
	{
		return $this->m_Solution;
	}
	
}