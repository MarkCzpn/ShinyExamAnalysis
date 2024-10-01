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
 * Class ConfigReader
 * Created by PhpStorm.
 * User: tr
 * Date: 21.09.2016
 * Time: 08:10
 */
abstract class ConfigReader
{
	public const INI_SOAP = 0x1;
	public const INI_CONFIG = 0x2;
	public const INI_PROJECT = 0x3;
	public const XML_CONFIG = 0x4;
	public const PART_CONFIG = 'settings';
	public const PART_PROJECT = 'Project';
	public const PART_SOAP = 'Soap';
	public const PART_SOAP_RIGHTS = 'SoapRights';
	public const PART_REPORT_PLUGIN = 'ReportPlugin';
	
	/**
	 * @param int $nFileType
	 * @return string
	 */
	private static function getFilePath($nFileType): string
	{
		$sFilePath = '';
		$sRealPath = realpath(__DIR__ . '../../../');
		switch ($nFileType)
		{
			case self::INI_SOAP:
				$sFilePath = $sRealPath . '\\Soap.ini';
				break;
			case self::INI_CONFIG:
				$sFilePath = $sRealPath . '\\config.ini';
				break;
			case self::INI_PROJECT:
				$sFilePath = $sRealPath . '\\Project.ini';
				break;
			case self::XML_CONFIG:
				$sFilePath = $sRealPath . '\\config.xml';
				break;
		}
		return $sFilePath;
	}
	
	/**
	 * @param string $sKey
	 * @param int    $nFile
	 * @return string
	 */
	public static function getConfigValueXML($sKey, $nFile = self::XML_CONFIG): string
	{
		$aOptionsXML = self::getConfigFileValuesXML($nFile);
		if (is_array($aOptionsXML) && array_key_exists($sKey, $aOptionsXML))
		{
			return $aOptionsXML[$sKey];
		}
		return '';
	}
	
	/**
	 * @param int $nFile
	 * @return array
	 */
	public static function getConfigFileValuesXML($nFile = self::XML_CONFIG): array
	{
		// Get Config from XML
		$sFilePath = self::getFilePath($nFile);
		$sContent = file_get_contents($sFilePath);
		if (strpos($sContent, '<?xml') === 0)
		{
			$sContent = mb_substr($sContent, mb_strpos($sContent, '>') + 1);
		}
		$oXML = simplexml_load_string($sContent, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		$aOptionsXML = array();
		if ($oXML !== false)
		{
			foreach ($oXML->children() as $oOption) /* @var $oOption SimpleXMLElement */
			{
				if ($oOption->getName() !== 'option')
				{
					continue;
				}
				if ($oOption->{'name'} instanceof SimpleXMLElement && $oOption->{'value'} instanceof SimpleXMLElement)
				{
					$sName = (string)$oOption->{'name'}; // get Name
					$sValue = htmlspecialchars_decode((string)$oOption->{'value'}); // get Value
					
					$aOptionsXML[$sName] = $sValue;
				}
			}
		}
		return $aOptionsXML;
	}
	
	/**
	 * Get a setting content of a section from INI file
	 * @param string $sConfigName - Name of INI setting
	 * @param string $sSectionName - Name of INI section
	 * @param int    $nFileType - Name of INI file
	 * @return string - content of setting
	 */
	public static function getConfigValue($sConfigName, $sSectionName = self::PART_CONFIG, $nFileType = self::INI_CONFIG): string
	{
		$sValue = '';
		$aSectionValues = self::getConfigSectionValues($sSectionName, $nFileType);
		if (isset($aSectionValues[$sConfigName]))
		{
			$sValue = $aSectionValues[$sConfigName];
		}
		return $sValue;
	}
	
	/**
	 * Get all settings of a section from INI file
	 * @param string $sSectionName - Name of INI section
	 * @param int    $nFileType - Name of INI file
	 * @return array - content of section
	 */
	public static function getConfigSectionValues($sSectionName = self::PART_CONFIG, $nFileType = self::INI_CONFIG): array
	{
		$aSectionValues = array();
		$aFileContent = self::getConfigFileValues($nFileType);
		if (isset($aFileContent[$sSectionName]))
		{
			$aSectionValues = $aFileContent[$sSectionName];
		}
		return $aSectionValues;
	}
	
	/**
	 * Requires a hashPassword in config.
	 * Checks if the URL is manipulated by checking, if the hash is identical to the
	 * one that the core generated
	 * @param string $sHMAC HMAC from core (usually in $_GET['hmac'])
	 * @return bool returns true if not manipulated, otherwise false.
	 */
	public static function validateURLHash($sHMAC): bool
	{
		$sHashPassword = self::getConfigValue('hashPassword', self::PART_PROJECT, self::INI_PROJECT);
		$sParamsPart = mb_substr($_SERVER['REQUEST_URI'], mb_stripos($_SERVER['REQUEST_URI'], '?') + 1);
		$sParamsPart = mb_substr($sParamsPart, 0, mb_strpos($sParamsPart, '&hmac='));
		$sHASH = hash_hmac('sha256', $sParamsPart, $sHashPassword);
		
		return $sHASH === $sHMAC;
	}
	
	/**
	 * Get all sections with its settings from INI file
	 * @param int $nFileType - Name of INI file
	 * @return array - content of file
	 */
	public static function getConfigFileValues($nFileType = self::INI_CONFIG): array
	{
		$sFile = self::getFilePath($nFileType);
		$aResult = array();
		if (file_exists($sFile))
		{
			$aResult = parse_ini_file($sFile, true);
		}
		return $aResult;
	}
	
	/**
	 * Get the name of the SOAP user
	 * @return string - SOAP user name
	 */
	public static function getSoapUser(): string
	{
		return self::getConfigValue('User', self::PART_SOAP, self::INI_SOAP);
	}
	
	/**
	 * Get the password of the SOAP user
	 * @return string - SOAP Password
	 */
	public static function getSoapPassword(): string
	{
		return self::getConfigValue('Password', self::PART_SOAP, self::INI_SOAP);
	}
	
	/**
	 * Get the SOAP services path
	 * @return string - Services path
	 */
	public static function getSoapServicesPath(): string
	{
		return self::getConfigValue('Services', self::PART_SOAP, self::INI_SOAP);
	}
	
	/**
	 * Get the version of the plug-in
	 * @return float - Version
	 */
	public static function getVersion(): float
	{
		return self::getConfigValue('version', self::PART_PROJECT, self::INI_PROJECT);
	}
}