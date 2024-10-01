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

require_once 'VerifierQuestionAnswer.php';
/**
 * Created by PhpStorm.
 * User: sbe
 * Date: 12.09.2017
 * Time: 16:42
 */
class VerifierQuestion extends _ASoap
{
	protected $m_nQuestionId;
	protected $m_nSheetId;
	protected $m_nQuestionType;
	protected $m_nQuestionPosition;
	protected $m_sDataType;
	protected $m_anQuestionCoord;
	protected $m_oVerifierQuestionAnswers;
	
	public function initFromArray($aArray)
	{
		$this->m_nQuestionId = $aArray["QuestionId"];
		$this->m_nSheetId = $aArray["SheetId"];
		$this->m_nQuestionType = $aArray["QuestionType"];
		$this->m_nQuestionPosition = $aArray["QuestionPosition"];
		$this->m_sDataType = $aArray["DataType"];
		$this->m_anQuestionCoord = $aArray["QuestionCoord"];
		$this->m_oVerifierQuestionAnswers = $this->initObjectArray($aArray['VerifierQuestionAnswers'], 'VerifierQuestionAnswer', '\Soap\Survey\VerifierQuestionAnswer');
	}
	
	/**
	 * @return int
	 */
	public function getQuestionId()
	{
		return $this->m_nQuestionId;
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
	public function getQuestionType()
	{
		return $this->m_nQuestionType;
	}
	
	/**
	 * @return int
	 */
	public function getQuestionPosition()
	{
		return $this->m_nQuestionPosition;
	}
	
	/**
	 * @return string
	 */
	public function getDataType()
	{
		return $this->m_sDataType;
	}
	
	/**
	 * @return int[]
	 */
	public function getQuestionCoord()
	{
		return $this->m_anQuestionCoord;
	}
	
	/**
	 * @return mixed
	 */
	public function getVerifierQuestionAnswers()
	{
		return $this->m_oVerifierQuestionAnswers;
	}
	
	
}