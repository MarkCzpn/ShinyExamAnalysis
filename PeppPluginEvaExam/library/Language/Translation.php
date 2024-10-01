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

/**
 * Class Language
 * Created by PhpStorm.
 * User: tr
 * Date: 20.01.2017
 * Time: 08:20
 */
class Translation
{
	/**
	 * Add the string $sValue to the current language with key $sKey
	 * @param string $sKey
	 * @param string $sValue
	 */
	public static function setTranslation($sKey, $sValue): void
	{
		Language\LanguageFactory::getCurrentLanguage()->setValue($sKey, $sValue);
	}
	
	/**
	 * Get the real language string of the key $sKey. Optionally in a defined language
	 * @param        $sKey - The Key of translated string
	 * @param string $sLanguage - Name of language. If not isset the current language is used
	 * @return string
	 */
	public static function translate($sKey, $sLanguage = null): string
	{
		$oLanguage = Language\LanguageFactory::getLanguage($sLanguage);
		return $oLanguage !== null ? $oLanguage->translate($sKey) : $sKey;
	}
	
	/**
	 * Add a list of string $sValue to the current language with key $sKey
	 * @param $asKeyValues array(string => string) - Key => Translation
	 */
	public static function setTranslations($asKeyValues): void
	{
		if (is_array($asKeyValues) && count($asKeyValues))
		{
			foreach ($asKeyValues as $sKey => $sValue)
			{
				self::setTranslation($sKey, $sValue);
			}
		}
	}
}