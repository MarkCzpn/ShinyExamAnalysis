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
 * Date: 13.09.2017
 * Time: 09:08
 */
class VerifierQuestionAnswer extends _ASoap
{
	protected $m_nAnswerOptionValue;
	protected $m_fAnswerOptionFillingGrade;
	protected $m_nAnswerPosition;
	protected $m_nX;
	protected $m_nY;
	
	public function initFromArray($aArray)
	{
		$this->m_nAnswerOptionValue        = $aArray["AnswerOptionValue"];
		$this->m_fAnswerOptionFillingGrade = $aArray["AnswerOptionFillingGrade"];
		$this->m_nAnswerPosition           = $aArray["AnswerPosition"];
		$this->m_nX                        = $aArray["x"];
		$this->m_nY                        = $aArray["y"];
	}
	
	/**
	 * @return int
	 */
	public function getAnswerOptionValue()
	{
		return $this->m_nAnswerOptionValue;
	}
	
	/**
	 * @return float
	 */
	public function getAnswerOptionFillingGrade()
	{
		return $this->m_fAnswerOptionFillingGrade;
	}
	
	/**
	 * @return int
	 */
	public function getAnswerPosition()
	{
		return $this->m_nAnswerPosition;
	}
	
	/**
	 * @return int
	 */
	public function getX()
	{
		return $this->m_nX;
	}
	
	/**
	 * @return int
	 */
	public function getY()
	{
		return $this->m_nY;
	}

	
}