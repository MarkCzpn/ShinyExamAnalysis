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
 * Time: 12:21
 */
class ExamSheetGroupItemOption extends _ASoap
{
	protected $m_Text;
	protected $m_Score;

	public function initFromArray($aArray)
	{
		$this->m_Text = $aArray['Text'];
		$this->m_Score = $aArray['Score'];
	}
	
	public function getText()
	{
		return $this->m_Text;
	}
	public function getScore()
	{
		return $this->m_Score;
	}
	
	public function getScoreForCrossing()
	{
		return explode("/", $this->m_Score)[0];
	}
	
	public function getScoreForNotCrossing()
	{
		$scores = explode("/", $this->m_Score);
		if(count($scores) > 1)
		{
			return $scores[1];
		}
		return 0;
	}
}