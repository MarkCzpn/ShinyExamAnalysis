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
 * Time: 14:39
 */
class SurveyResult extends _ASoap
{
	protected $m_Survey;
	protected $m_ItemResults;
	protected $m_ItemGroupResults;

	public function initFromArray($aArray)
	{
		$this->loadClass('Survey', 'Survey');
		$this->loadClass('ItemResults', 'Survey');
		$this->loadClass('ItemGroupResults', 'Survey');

		$this->m_Survey = new Survey($aArray['Survey']);
		$this->m_ItemResults = $this->initObjectArray($aArray['ItemResults'], 'ItemResults', '\Soap\Survey\ItemResults');
		$this->m_ItemGroupResults = $this->initObjectArray($aArray['ItemGroupResults'], 'ItemGroupResults', '\Soap\Survey\ItemGroupResults');
	}

	/**
	 * @return Survey
	 */
	public function getSurvey()
	{
		return $this->m_Survey;
	}
	public function getItemResults()
	{
		return $this->m_ItemResults;
	}
	public function getItemGroupResults()
	{
		return $this->m_ItemGroupResults;
	}
}