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
 * Time: 12:04
 */

/**
 * Class ExamSheet
 * @package Soap\Exam
 */
class ExamSheet extends _ASoap
{
	protected $m_FormId;
	protected $m_OwnerId;
	protected $m_FormName;
	protected $m_FormTitle;
	protected $m_PaperFormat;
	protected $m_ScoreOpenQuestionsOnline;
	protected $m_UseSeparateAnswerSheet;
	protected $m_CreationDate;
	protected $m_PageCount;
	protected $m_QuestionNumberLabels;
	protected $m_FontFamily;
	protected $m_LineHeight;
	protected $m_FontSize;
	protected $m_AnswerBoxSize;
	protected $m_UpperLeftHeading;
	protected $m_UpperRightHeading;
	protected $m_LowerLeftHeading;
	protected $m_LowerRightHeading;
	protected $m_GroupList;
	protected $m_OnlineWizard;
	protected $m_IsExtensible;
	protected $m_Layout;
	protected $m_Range;
	protected $m_Version;
	protected $m_IsAnswerSheetTemplate;

	public function initFromArray($aArray)
	{
		$this->loadClass('ExamSheetGroup', 'Exam');

		$this->m_FormId = $aArray['FormId'];
		$this->m_OwnerId = $aArray['OwnerId'];
		$this->m_FormName = $aArray['FormName'];
		$this->m_FormTitle = $aArray['FormTitle'];
		$this->m_PaperFormat = $aArray['PaperFormat'];
		$this->m_ScoreOpenQuestionsOnline = $aArray['ScoreOpenQuestionsOnline'];
		$this->m_UseSeparateAnswerSheet = $aArray['UseSeparateAnswerSheet'];
		$this->m_CreationDate = $aArray['CreationDate'];
		$this->m_PageCount = $aArray['PageCount'];
		$this->m_FontFamily = $aArray['FontFamily'];
		$this->m_FontSize = $aArray['FontSize'];
		$this->m_LineHeight = $aArray['LineHeight'];
		$this->m_QuestionNumberLabels = $aArray['QuestionNumberLabels'];
		$this->m_AnswerBoxSize = $aArray['AnswerBoxSize'];
		$this->m_UpperLeftHeading = $aArray['UpperLeftHeading'];
		$this->m_UpperRightHeading = $aArray['UpperRightHeading'];
		$this->m_LowerLeftHeading = $aArray['LowerLeftHeading'];
		$this->m_LowerRightHeading = $aArray['LowerRightHeading'];
		$this->m_GroupList = $this->initObjectArray($aArray['GroupList'], 'ExamSheetGroups', '\Soap\Exam\ExamSheetGroup');
		$this->m_OnlineWizard = $aArray['OnlineWizard'];
		$this->m_IsExtensible = $aArray['IsExtensible'];
		$this->m_Layout = $aArray['Layout'];
		$this->m_Range = $aArray['Range'];
		$this->m_Version = $aArray['Version'];
		$this->m_IsAnswerSheetTemplate = $aArray['IsAnswerSheetTemplate'];
	}

	public function getFormId()
	{
		return $this->m_FormId;
	}
	public function getFormName()
	{
		return $this->m_FormName;
	}
	public function getFormTitle()
	{
		return $this->m_FormTitle;
	}
	public function getOwnerId()
	{
		return $this->m_OwnerId;
	}
	public function getPaperFormat()
	{
		return $this->m_PaperFormat;
	}
	public function getQuestionNumberLabels()
	{
		return $this->m_QuestionNumberLabels;
	}
	public function getAnswerBoxSize()
	{
		return $this->m_AnswerBoxSize;
	}
	
	public function getFontFamily()
	{
		return $this->m_FontFamily;
	}
	public function getFontSize()
	{
		return $this->m_FontSize;
	}
	public function getLineHeight()
	{
		return $this->m_LineHeight;
	}
	public function getCreationDate()
	{
		return $this->m_CreationDate;
	}
	
	public function getUpperLeftHeading()
	{
		return $this->m_UpperLeftHeading;
	}
	public function getUpperRightHeading()
	{
		return $this->m_UpperRightHeading;
	}
	public function getLowerLeftHeading()
	{
		return $this->m_LowerLeftHeading;
	}
	public function getLowerRightHeading()
	{
		return $this->m_LowerRightHeading;
	}
	
	public function getScoreOpenQuestionsOnline()
	{
		return $this->m_ScoreOpenQuestionsOnline;
	}
	
	public function getUseSeparateAnswerSheet()
	{
		return $this->m_UseSeparateAnswerSheet;
	}
	
	public function getPageCount()
	{
		return $this->m_PageCount;
	}
	
	public function getOnlineWizard()
	{
		return $this->m_OnlineWizard;
	}
	
	public function isExtensible()
	{
		return $this->m_IsExtensible;
	}
	
	public function getLayout()
	{
		return $this->m_Layout;
	}
	
	public function getRange()
	{
		return $this->m_Range;
	}
	
	public function getVersion()
	{
		return $this->m_Version;
	}
	
	public function isAnswerSheetTemplate()
	{
		return $this->m_IsAnswerSheetTemplate;
	}
	
	/**
	 * @return ExamSheetGroup[]
	 */
	public function getGroupList()
	{
		return $this->m_GroupList;
	}
	
}