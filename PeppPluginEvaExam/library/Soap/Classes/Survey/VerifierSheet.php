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

require_once 'VerifierQuestion.php';
/**
 * Created by PhpStorm.
 * User: sbe
 * Date: 12.09.2017
 * Time: 16:42
 */
class VerifierSheet extends _ASoap
{
	protected $m_nSheetId;
	protected $m_nBatchId;
	protected $m_nSheetNumberInBatch;
	protected $m_nSurveyId;
	protected $m_nFormId;
	protected $m_nPageId;
	protected $m_nSerialNumber;
	protected $m_nSerialNumberCounter;
	protected $m_sParticipantEmail;
	protected $m_sParticipantIdentifier;
	protected $m_bCoversheet;
	protected $m_nNonFormType;
	protected $m_sSheetImage;
	protected $m_aoVerifierQuestions;
	
	public function initFromArray($aArray)
	{
		$this->m_nSheetId = $aArray["SheetId"];
		$this->m_nBatchId = $aArray["BatchId"];
		$this->m_nSheetNumberInBatch = $aArray["SheetNumberInBatch"];
		$this->m_nSurveyId = $aArray["SurveyId"];
		$this->m_nFormId = $aArray["FormId"];
		$this->m_nPageId = $aArray["PageId"];
		$this->m_nSerialNumber = $aArray["SerialNumber"];
		$this->m_nSerialNumberCounter = $aArray["SerialNumberCounter"];
		$this->m_sParticipantEmail = $aArray["ParticipantEmail"];
		$this->m_sParticipantIdentifier = $aArray["ParticipantIdentifier"];
		$this->m_bCoversheet = $aArray["Coversheet"];
		$this->m_nNonFormType = $aArray["NonFormType"];
		$this->m_sSheetImage = $aArray["SheetImage"];
		$this->m_aoVerifierQuestions = $this->initObjectArray($aArray['VerifierQuestions'], 'VerifierQuestion', '\Soap\Survey\VerifierQuestion');
	}
	
	/**
	 * @return int
	 */
	public function getSheetId()
	{
		return $this->m_nSheetId;
	}
	
	/**
	 * @return int
	 */
	public function getBatchId()
	{
		return $this->m_nBatchId;
	}
	
	/**
	 * @return int
	 */
	public function getSheetNumberInBatch()
	{
		return $this->m_nSheetNumberInBatch;
	}
	
	/**
	 * @return int
	 */
	public function getSurveyId()
	{
		return $this->m_nSurveyId;
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
	public function getPageId()
	{
		return $this->m_nPageId;
	}
	
	/**
	 * @return int
	 */
	public function getSerialNumber()
	{
		return $this->m_nSerialNumber;
	}
	
	/**
	 * @return int
	 */
	public function getSerialNumberCounter()
	{
		return $this->m_nSerialNumberCounter;
	}
	
	/**
	 * @return string
	 */
	public function getParticipantEmail()
	{
		return $this->m_sParticipantEmail;
	}
	
	/**
	 * @return string
	 */
	public function getParticipantIdentifier()
	{
		return $this->m_sParticipantIdentifier;
	}
	
	/**
	 * @return boolean
	 */
	public function getCoversheet()
	{
		return $this->m_bCoversheet;
	}
	
	/**
	 * @return int
	 */
	public function getNonFormType()
	{
		return $this->m_nNonFormType;
	}
	
	/**
	 * @return string
	 */
	public function getSheetImage()
	{
		return $this->m_sSheetImage;
	}
	
	/**
	 * @return VerifierQuestion[]
	 */
	public function getVerifierQuestions()
	{
		return $this->m_aoVerifierQuestions;
	}
}