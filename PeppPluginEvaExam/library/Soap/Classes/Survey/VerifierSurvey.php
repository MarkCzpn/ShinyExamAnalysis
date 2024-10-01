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

require_once 'VerifierBatch.php';
/**
 * Created by PhpStorm.
 * User: sbe
 * Date: 13.09.2017
 * Time: 10:29
 * @package Soap\Survey
 */
class VerifierSurvey extends _ASoap
{
	protected $m_nSurveyId;
	protected $m_aoVerifierBatchs;
	
	public function initFromArray($aArray)
	{
		$this->m_nSurveyId = $aArray['SurveyId'];
		$this->m_aoVerifierBatchs = $this->initObjectArray($aArray['VerifierBatchs'], 'VerifierBatch', '\Soap\Survey\VerifierBatch');
	}
	
	/**
	 * @return int
	 */
	public function getSurveyId()
	{
		return $this->m_nSurveyId;
	}
	
	/**
	 * @return VerifierBatch[]
	 */
	public function getVerifierBatchs()
	{
		return $this->m_aoVerifierBatchs;
	}
	
}