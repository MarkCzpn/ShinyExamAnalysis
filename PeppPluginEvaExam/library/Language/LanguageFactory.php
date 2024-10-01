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

require_once 'library/Language/CLanguage.php';
require_once 'library/Language/Translation.php';

/**
 * Class LanguageFactory
 * Created by PhpStorm.
 * User: tr
 * Date: 20.01.2017
 * Time: 08:18
 */
class LanguageFactory
{
	/**
	 * @var array(string => CLanguage) All loaded languages
	 */
	protected static $aoLanguages = array();
	/**
	 * @var null|CLanguage - The current loaded language
	 */
	protected static $oCurrentLanguage;
	
	/**
	 * Set the current language by Object
	 * @param CLanguage $oLanguage
	 */
	public static function setCurrentLanguage(CLanguage $oLanguage): void
	{
		self::$oCurrentLanguage = $oLanguage;
	}
	
	/**
	 * Set the current language by name
	 * @param string $sLanguage
	 */
	public static function setCurrentLanguageByName($sLanguage): void
	{
		self::setCurrentLanguage(self::getLanguage($sLanguage));
	}
	
	/**
	 * Get the current language
	 * @return CLanguage
	 */
	public static function getCurrentLanguage(): ?CLanguage
	{
		return self::$oCurrentLanguage;
	}
	
	/**
	 * Creates a language by name and load its translations
	 * @param        $sLanguage
	 * @param string $sLanguagePath - Path of language file. Default: plug-in root/lang
	 */
	public static function createLanguage($sLanguage, $sLanguagePath = ''): void
	{
		$sLanguage = strtolower($sLanguage);
		if (!array_key_exists($sLanguage, self::$aoLanguages))
		{
			self::$aoLanguages[$sLanguage] = new CLanguage($sLanguage, $sLanguagePath);
			self::setCurrentLanguage(self::$aoLanguages[$sLanguage]);
			self::$oCurrentLanguage->loadTranslations();
		}
		else
		{
			error_log(__METHOD__ . '(): Language "' . $sLanguage . '" already exists.');
		}
	}
	
	/**
	 * Get the language by name. If no name isset the default language is returned
	 * @param string $sLanguage
	 * @return null|CLanguage
	 */
	public static function getLanguage($sLanguage = null): ?CLanguage
	{
		$oLanguage = null;
		if ($sLanguage === null)
		{
			if (!self::$oCurrentLanguage instanceof CLanguage)
			{
				error_log(__METHOD__ . '(): The default language is not set jet.');
			}
			else
			{
				$sLanguage = self::$oCurrentLanguage->getLanguage();
			}
		}
		if (array_key_exists($sLanguage, self::$aoLanguages))
		{
			$oLanguage = self::$aoLanguages[$sLanguage];
		}
		else
		{
			error_log(__METHOD__ . '(): The Language "' . $sLanguage . '" does not exists.');
		}
		return $oLanguage;
	}
}