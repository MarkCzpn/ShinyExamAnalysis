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
 * Time: 16:56
 */
class TextTemplate extends _ASoap
{
	protected $m_Id;
	protected $m_SystemLanguage;
	protected $m_SystemLanguageAbbreviation;
	protected $m_Type;
	protected $m_FormSpecificText;
	protected $m_Subject;
	protected $m_Text;

	public function initFromArray($aArray)
	{
		$this->m_Id = $aArray['Id'];
		$this->m_SystemLanguage = $aArray['SystemLanguage'];
		$this->m_SystemLanguageAbbreviation = $aArray['SystemLanguageAbbreviation'];
		$this->m_Type = $aArray['Type'];
		$this->m_FormSpecificText = $aArray['FormSpecificText'];
		$this->m_Subject = $aArray['Subject'];
		$this->m_Text = $aArray['Text'];
	}

	public function getID()
	{
		return $this->m_Id;
	}
	public function getSystemLanguage()
	{
		return $this->m_SystemLanguage;
	}
	public function getSystemLanguageAbbreviation()
	{
		return $this->m_SystemLanguageAbbreviation;
	}
	public function getType()
	{
		return $this->m_Type;
	}
	public function getFormSpecificText()
	{
		return $this->m_FormSpecificText;
	}
	public function getSubject()
	{
		return $this->m_Subject;
	}
	public function getText()
	{
		return $this->m_Text;
	}
}