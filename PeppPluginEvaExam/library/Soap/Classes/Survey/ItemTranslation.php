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
 * Time: 16:29
 */
class ItemTranslation extends _ASoap
{
	protected $m_nItemID;
	protected $m_sItemText;
	protected $m_sLeft;
	protected $m_sRight;
	protected $m_sAbstention;

	public function initFromArray($aArray)
	{
		$this->m_nItemID = $aArray['ItemId'];
		$this->m_sItemText = $aArray['ItemText'];
		$this->m_sLeft = $aArray['Left'];
		$this->m_sRight = $aArray['Right'];
		$this->m_sAbstention = $aArray['Abstention'];
	}

	public function getItemID()
	{
		return $this->m_nItemID;
	}
	public function getItemText()
	{
		return $this->m_sItemText;
	}
	public function getLeft()
	{
		return $this->m_sLeft;
	}
	public function getRight()
	{
		return $this->m_sRight;
	}
	public function GetAbstention()
	{
		return $this->m_sAbstention;
	}
}