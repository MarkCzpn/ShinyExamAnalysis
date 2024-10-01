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
 * User: tr
 * Date: 26.09.2016
 * Time: 14:37
 */
class Exam extends _ASoap
{
	protected $m_nExamId;
	protected $m_sCreateDate;
	protected $m_sProcessedDate;
	protected $m_nStatus;
	protected $m_sStatusName;
	protected $m_sName;
	protected $m_nExamCount;
	protected $m_nFormId;
	protected $m_nFolderId;
	protected $m_sShortName;
	protected $m_bOpen;
	protected $m_nPageLinkOffset;
	protected $m_bHasParticipants;
	protected $m_bIsOnline;
	protected $m_nTimeLimit;
	protected $m_bIsPreFilled;
	protected $m_aoParticipantList;
	protected $m_nExamType;

	public function initFromArray($aArray)
	{
		$this->m_nExamId 			= $aArray['ExamId'];
		$this->m_sCreateDate 		= $aArray['CreateDate'];
		$this->m_sProcessedDate 	= $aArray['ProcessedDate'];
		$this->m_nStatus 			= $aArray['Status'];
		$this->m_sStatusName 		= $aArray['StatusName'];
		$this->m_sName 				= $aArray['Name'];
		$this->m_nExamCount 		= $aArray['ExamCount'];
		$this->m_nFormId 			= $aArray['FormId'];
		$this->m_nFolderId 			= $aArray['FolderId'];
		$this->m_sShortName 		= $aArray['ShortName'];
		$this->m_bOpen 				= $aArray['Open'];
		$this->m_nPageLinkOffset 	= $aArray['PageLinkOffset'];
		$this->m_bHasParticipants 	= $aArray['HasParticipants'];
		$this->m_bIsOnline 			= $aArray['IsOnline'];
		$this->m_nTimeLimit 		= $aArray['TimeLimit'];
		$this->m_bIsPreFilled 		= $aArray['IsPreFilled'];
//		$this->m_aoParticipantList	= new Participant($aArray['ParticipantList']);
		$this->m_nExamType			= $aArray['ExamType'];
	}
	
	/**
	 * @return int
	 */
	public function getExamId()
	{
		return $this->m_nExamId;
	}
	
	/**
	 * @return string
	 */
	public function getCreateDate()
	{
		return $this->m_sCreateDate;
	}
	
	/**
	 * @return string
	 */
	public function getProcessedDate()
	{
		return $this->m_sProcessedDate;
	}
	
	/**
	 * @return int
	 */
	public function getStatus()
	{
		return $this->m_nStatus;
	}
	
	/**
	 * @return string
	 */
	public function getStatusName()
	{
		return $this->m_sStatusName;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->m_sName;
	}
	
	/**
	 * @return int
	 */
	public function getExamCount()
	{
		return $this->m_nExamCount;
	}
	
	/**
	 * @return int
	 */
	public function getFormId()
	{
		return $this->m_nFormId;
	}
	
	/**
	 * @return int
	 */
	public function getFolderId()
	{
		return $this->m_nFolderId;
	}
	
	/**
	 * @return string
	 */
	public function getShortName()
	{
		return $this->m_sShortName;
	}
	
	/**
	 * @return bool
	 */
	public function isOpen()
	{
		return $this->m_bOpen;
	}
	
	/**
	 * @return int
	 */
	public function getPageLinkOffset()
	{
		return $this->m_nPageLinkOffset;
	}
	
	/**
	 * @return bool
	 */
	public function hasParticipants()
	{
		return $this->m_bHasParticipants;
	}
	
	/**
	 * @return bool
	 */
	public function isOnline()
	{
		return $this->m_bIsOnline;
	}
	
	/**
	 * @return int
	 */
	public function getTimeLimit()
	{
		return $this->m_nTimeLimit;
	}
	
	/**
	 * @return bool
	 */
	public function isPreFilled()
	{
		return $this->m_bIsPreFilled;
	}
	
	/**
	 * @return Participant[]
	 */
	public function getParticipantList()
	{
		return $this->m_aoParticipantList;
	}
	
	/**
	 * @return int
	 */
	public function getExamType()
	{
		return $this->m_nExamType;
	}
}