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

namespace Language;

/**
 * Class CLanguage
 * Created by PhpStorm.
 * User: tr
 * Date: 20.01.2017
 * Time: 08:17
 */
class CLanguage
{
	/**
	 * @var array(string => string) - All translated strings
	 */
	protected $m_aTranslation;
	/**
	 * @var string - The name of the language
	 */
	protected $m_sLanguage;
	/**
	 * @var string - The absolute folder path of the language.
	 */
	protected $m_sLanguagePath;
	
	/**
	 * CLanguage constructor.
	 * @param string $sLanguage
	 * @param string $sLanguagePath
	 */
	public function __construct($sLanguage, $sLanguagePath = '')
	{
		$this->m_aTranslation = array();
		$this->m_sLanguage = $sLanguage;
		$this->m_sLanguagePath = !empty($sLanguagePath) ? $sLanguagePath : realpath(__DIR__ . '../../../lang/');
	}
	
	/**
	 * Try to load a language file
	 */
	public function loadTranslations(): void
	{
		$sTranslationFile = $this->m_sLanguagePath . '\\' . $this->m_sLanguage . '.lang.php';
		
		if (file_exists($sTranslationFile))
		{
			\Translation::setTranslations(include $sTranslationFile);
		}
		else
		{
			error_log(__METHOD__ . '(): LanguageFile does not exits: ' . $sTranslationFile);
		}
	}
	
	/**
	 * Add the translated $sValue with the $sKey to the known translation list
	 * @param string $sKey
	 * @param string $sValue
	 */
	public function setValue($sKey, $sValue): void
	{
		if ($this->m_aTranslation === null)
		{
			$this->m_aTranslation = array();
		}
		$this->m_aTranslation[$sKey] = $sValue;
	}
	
	/**
	 * Translate the string with key $sKey. If the key does not exists, the key will be returned
	 * @param string $sKey
	 * @return string
	 */
	public function translate($sKey): string
	{
		return $this->m_aTranslation[$sKey] ?? $sKey;
	}
	
	/**
	 * Get the name of the current language
	 * @return string
	 */
	public function getLanguage(): string
	{
		return $this->m_sLanguage;
	}
}