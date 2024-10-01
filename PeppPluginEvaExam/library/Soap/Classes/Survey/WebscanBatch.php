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
 * Class FilterSet
 * User: sbe
 * Date: 01.09.2017
 * Time: 12:06
 * @package Soap\Survey
 */
class WebscanBatch extends _ASoap
{
	protected $m_nReaderBatchId;
	protected $m_nBatchId;
	protected $m_nStatus;
	protected $m_sText;
	protected $m_nProceedActionValue;
	protected $m_sProceedAction;
	protected $m_nCancelActionValue;
	protected $m_sCancelAction;
	
	public function initFromArray($aArray)
	{
		$this->m_nReaderBatchId            = $aArray['m_nReaderBatchId'];
		$this->m_nBatchId                  = $aArray['m_nBatchId'];
		$this->m_nStatus                   = $aArray['m_nStatus'];
		$this->m_sText                     = $aArray['m_sText'];
		$this->m_nProceedActionValue       = $aArray['m_nProceedActionValue'];
		$this->m_sProceedAction            = $aArray['m_sProceedAction'];
		$this->m_nCancelActionValue        = $aArray['m_nCancelActionValue'];
		$this->m_sCancelAction             = $aArray['m_sCancelAction'];
	}
	
	/**
	 * @return int
	 */
	public function getReaderBatchId()
	{
		return $this->m_nReaderBatchId;
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
	public function getStatus()
	{
		return $this->m_nStatus;
	}
	
	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->m_sText;
	}
	
	/**
	 * @return int
	 */
	public function getProceedActionValue()
	{
		return $this->m_nProceedActionValue;
	}
	
	/**
	 * @return string
	 */
	public function getProceedAction()
	{
		return $this->m_sProceedAction;
	}
	
	
	/**
	 * @return int
	 */
	public function getCancelActionValue()
	{
		return $this->m_nCancelActionValue;
	}
	
	/**
	 * @return string
	 */
	public function getCancelAction()
	{
		return $this->m_sCancelAction;
	}
}