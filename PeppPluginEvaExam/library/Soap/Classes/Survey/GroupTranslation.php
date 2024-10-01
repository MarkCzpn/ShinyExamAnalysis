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
 * Date: 21.10.2016
 * Time: 16:31
 */
class GroupTranslation extends _ASoap
{
	protected $m_nID;
	protected $m_sTitle;
	protected $m_sDescription;

	public function initFromArray($aArray)
	{
		$this->m_nID = $aArray['GroupId'];
		$this->m_sTitle = $aArray['GroupTitle'];
		$this->m_sDescription = $aArray['GroupDescription'];
	}

	public function getID()
	{
		return $this->m_nID;
	}
	public function getTitle()
	{
		return $this->m_sTitle;
	}
	public function getDescription()
	{
		return $this->m_sDescription;
	}
}