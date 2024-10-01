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
 * Time: 10:42
 */
class SurveyStatus extends _ASoap
{
	protected $m_SurveyId;
	protected $m_SurveyStatus;
	protected $m_StatusMessage;
	
	public function initFromArray($aArray)
	{
		$this->m_SurveyId = $aArray['SurveyId'];
		$this->m_SurveyStatus = $aArray['SurveyStatus'];
		$this->m_StatusMessage = $aArray['StatusMessage'];
	}
	
	/**
	 * @return int
	 */
	public function getSurveyId()
	{
		return $this->m_SurveyId;
	}
	
	/**
	 * @return string
	 */
	public function getSurveyStatus()
	{
		return $this->m_SurveyStatus;
	}
	
	/**
	 * @return string[]
	 */
	public function getStatusMessage()
	{
		return $this->m_StatusMessage;
	}
	
}