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
 * Time: 14:38
 */
class Form extends _ASoap
{
	protected $m_FormId;
	protected $m_FormName;
	protected $m_FormTitle;
	protected $m_OwnerId;
	protected $m_PaperFormat;
	protected $m_ShowNumeration;
	protected $m_AnswerBoxSize;
	protected $m_MaxPages;
	protected $m_MaxQuestions;
	protected $m_FontFamily;
	protected $m_FontSize;
	protected $m_RowHeight;
	protected $m_CreateDate;
	protected $m_IsActivated;
	protected $m_ResultAccess;
	protected $m_HeadLineUpperLeft;
	protected $m_HeadLineLowerLeft;
	protected $m_HeadLineUpperRight;
	protected $m_HeadLineLowerRight;
	protected $m_HeadLineMark;
	protected $m_HeadLineCorrection;
	protected $m_ItemGroupList;
	protected $m_HeaderLineCount;
	protected $m_AdditionalHeaderLineList;
	protected $m_OnlineLayout;
	protected $m_FormFolderName;
	protected $m_LastChangeDate;

	public function initFromArray($aArray)
	{
		$this->loadClass('ItemGroup', 'Survey');

		$this->m_FormId = $aArray['FormId'];
		$this->m_FormName = $aArray['FormName'];
		$this->m_FormTitle = $aArray['FormTitle'];
		$this->m_OwnerId = $aArray['OwnerId'];
		$this->m_PaperFormat = $aArray['PaperFormat'];
		$this->m_ShowNumeration = $aArray['ShowNumeration'];
		$this->m_AnswerBoxSize = $aArray['AnswerBoxSize'];
		$this->m_MaxPages = $aArray['MaxPages'];
		$this->m_MaxQuestions = $aArray['MaxQuestions'];
		$this->m_FontFamily = $aArray['FontFamily'];
		$this->m_FontSize = $aArray['FontSize'];
		$this->m_RowHeight = $aArray['RowHeight'];
		$this->m_CreateDate = $aArray['CreateDate'];
		$this->m_IsActivated = $aArray['IsActivated'];
		$this->m_ResultAccess = $aArray['ResultAccess'];
		$this->m_HeadLineUpperLeft = $aArray['HeadLineUpperLeft'];
		$this->m_HeadLineLowerLeft = $aArray['HeadLineLowerLeft'];
		$this->m_HeadLineUpperRight = $aArray['HeadLineUpperRight'];
		$this->m_HeadLineLowerRight = $aArray['HeadLineLowerRight'];
		$this->m_HeadLineMark = $aArray['HeadLineMark'];
		$this->m_HeadLineCorrection = $aArray['HeadLineCorrection'];
		$this->m_ItemGroupList = $this->initObjectArray($aArray['ItemGroupList'], 'ItemGroups', '\Soap\Survey\ItemGroup');
		$this->m_HeaderLineCount = $aArray['HeaderLineCount'];
		$this->m_AdditionalHeaderLineList = $aArray['AdditionalHeaderLineList'];
		$this->m_OnlineLayout = $aArray['OnlineLayout'];
		$this->m_FormFolderName = $aArray['FormFolderName'];
		$this->m_LastChangeDate = $aArray['LastChangeDate'];
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
	public function getShowNumeration()
	{
		return $this->m_ShowNumeration;
	}
	public function getAnswerBoxSize()
	{
		return $this->m_AnswerBoxSize;
	}
	public function getMaxPages()
	{
		return $this->m_MaxPages;
	}
	public function getMaxQuestions()
	{
		return $this->m_MaxQuestions;
	}
	public function getFontFamily()
	{
		return $this->m_FontFamily;
	}
	public function getFontSize()
	{
		return $this->m_FontSize;
	}
	public function getRowHeight()
	{
		return $this->m_RowHeight;
	}
	public function getCreateDate()
	{
		return $this->m_CreateDate;
	}
	public function getIsActivated()
	{
		return $this->m_IsActivated;
	}
	public function getResultAccess()
	{
		return $this->m_ResultAccess;
	}
	public function getHeadLineUpperLeft()
	{
		return $this->m_HeadLineUpperLeft;
	}
	public function getHeadLineLowerLeft()
	{
		return $this->m_HeadLineLowerLeft;
	}
	public function getHeadLineUpperRight()
	{
		return $this->m_HeadLineUpperRight;
	}
	public function getHeadLineLowerRight()
	{
		return $this->m_HeadLineLowerRight;
	}
	public function getHeadLineMark()
	{
		return $this->m_HeadLineMark;
	}
	public function getHeadLineCorrection()
	{
		return $this->m_HeadLineCorrection;
	}
	public function getItemGroupList()
	{
		return $this->m_ItemGroupList;
	}
	public function getHeaderLineCount()
	{
		return $this->m_HeaderLineCount;
	}
	public function getAdditionalHeaderLineList()
	{
		return $this->m_AdditionalHeaderLineList;
	}
	public function getOnlineLayout()
	{
		return $this->m_OnlineLayout;
	}
	public function getFormFolderName()
	{
		return $this->m_FormFolderName;
	}
	public function getLastChangeDate()
	{
		return $this->m_LastChangeDate;
	}
}