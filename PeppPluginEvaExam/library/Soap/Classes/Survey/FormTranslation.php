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
 * Time: 16:35
 */
class FormTranslation extends _ASoap
{
	protected $m_nFormTranslationId;
	protected $m_nFormId;
	protected $m_sName;
	protected $m_sAbbreviation;
	protected $m_sPDFFilename;
	protected $m_sLogoFile;
	protected $m_nSystemLanguage;
	protected $m_sSystemLanguageAbbreviation;
	protected $m_nLanguageSet;
	protected $m_bIsEnabled;
	protected $m_aoGroupTranslations;
	protected $m_aoItemTranslations;

	public function initFromArray($aArray)
	{
		$this->loadClass('GroupTranslation', 'Survey');
		$this->loadClass('ItemTranslation', 'Survey');
		
		$this->m_nFormTranslationId = $aArray['FormTranslationId'];
		$this->m_nFormId = $aArray['FormId'];
		$this->m_sName = $aArray['Name'];
		$this->m_sAbbreviation = $aArray['Abbreviation'];
		$this->m_sPDFFilename = $aArray['PDFFilename'];
		$this->m_sLogoFile = $aArray['LogoFile'];
		$this->m_nSystemLanguage = $aArray['SystemLanguage'];
		$this->m_sSystemLanguageAbbreviation = $aArray['SystemLanguageAbbreviation'];
		$this->m_nLanguageSet = $aArray['LanguageSet'];
		$this->m_bIsEnabled = $aArray['IsEnabled'];
		$this->m_aoGroupTranslations = $this->initObjectArray($aArray['GroupTranslations'], 'GroupTranslation', '\Soap\Survey\GroupTranslation');
		$this->m_aoItemTranslations = $this->initObjectArray($aArray['ItemTranslations'], 'ItemTranslation', '\Soap\Survey\ItemTranslation');
	}

	public function getFormTranslationId()
	{
		return $this->m_nFormTranslationId;
	}
	public function getFormId()
	{
		return $this->m_nFormId;
	}
	public function getName()
	{
		return $this->m_sName;
	}
	public function getAbbreviation()
	{
		return $this->m_sAbbreviation;
	}
	public function getPDFFilename()
	{
		return $this->m_sPDFFilename;
	}
	public function getLogoFile()
	{
		return $this->m_sLogoFile;
	}
	public function getSystemLanguage()
	{
		return $this->m_nSystemLanguage;
	}
	public function getSystemLanguageAbbreviation()
	{
		return $this->m_sSystemLanguageAbbreviation;
	}
	public function getLanguageSet()
	{
		return $this->m_nLanguageSet;
	}
	public function getIsEnabled()
	{
		return $this->m_bIsEnabled;
	}
	public function getGroupTranslations()
	{
		return $this->m_aoGroupTranslations;
	}
	public function getItemTranslations()
	{
		return $this->m_aoItemTranslations;
	}

}