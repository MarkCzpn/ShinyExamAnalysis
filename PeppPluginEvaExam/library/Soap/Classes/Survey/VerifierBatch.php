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

require_once 'VerifierSheet.php';
/**
 * Created by PhpStorm.
 * User: sbe
 * Date: 12.09.2017
 * Time: 16:36
 * @package Soap\Survey
 */
class VerifierBatch extends _ASoap
{
	protected $m_nBatchId;
	protected $m_nPageCount;
	protected $m_nNonFormsCount;
	protected $m_nUnlocatedAnswers;
	protected $m_sScanstation;
	protected $m_aoVerifierSheets;
	
	public function initFromArray($aArray)
	{
		$this->m_nBatchId = $aArray['BatchId'];
		$this->m_nPageCount = $aArray['PageCount'];
		$this->m_nNonFormsCount = $aArray['NonFormsCount'];
		$this->m_nUnlocatedAnswers = $aArray['UnlocatedAnswers'];
		$this->m_sScanstation = $aArray['Scanstation'];
		$this->m_aoVerifierSheets = $this->initObjectArray($aArray['VerifierSheets'], 'VerifierSheet', '\Soap\Survey\VerifierSheet');
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
	public function getPageCount()
	{
		return $this->m_nPageCount;
	}
	
	/**
	 * @return int
	 */
	public function getNonFormsCount()
	{
		return $this->m_nNonFormsCount;
	}
	
	/**
	 * @return int
	 */
	public function getUnlocatedAnswers()
	{
		return $this->m_nUnlocatedAnswers;
	}
	
	/**
	 * @return string
	 */
	public function getScanstation()
	{
		return $this->m_sScanstation;
	}
	
	/**
	 * @return VerifierSheet[]
	 */
	public function getVerifierSheets()
	{
		return $this->m_aoVerifierSheets;
	}
	
}