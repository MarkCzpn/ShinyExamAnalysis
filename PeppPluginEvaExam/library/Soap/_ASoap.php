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
namespace Soap;

require_once 'library/Soap/_ISoap.php';

/**
 * Created by PhpStorm.
 * User: tr
 * Date: 26.09.2016
 * Time: 14:39
 */
abstract class _ASoap implements _ISoap
{
	public function __construct($aArray)
	{
		$this->initFromArray($aArray);
	}

	public function __toArray()
	{
		$aArray = get_object_vars($this);
		$aArray = array_map('toArray', $aArray);
		return $aArray;
	}
	
	public function initObjectArray($aData, $sField, $sClassName)
	{
		$aReturn = array();
		if (is_array($aData) && count($aData))
		{
			if (isset($aData[$sField]) && is_array($aData[$sField]) && isset($aData[$sField][0]) && is_array($aData[$sField][0]))
			{
				foreach ($aData[$sField] as $aChildData)
				{
					array_push($aReturn, new $sClassName($aChildData));
				}
			}
			else
			{
				array_push($aReturn, new $sClassName($aData[$sField]));
			}
		}
		return $aReturn;
	}
	
	function loadClass($sClassName, $sScope = '')
	{
		if(strlen($sScope) > 0)
		{
			$sScope.="/";
		}
		require_once 'library/Soap/Classes/'.$sScope.$sClassName.'.php';
	}

	function __clone()
	{
		$aObjectVars = get_object_vars($this);
		
		foreach ($aObjectVars as $sAttributeName => $sAttributeValue)
		{
			if (is_object($this->$sAttributeName))
			{
				$this->$sAttributeName = clone $this->$sAttributeName;
			}
			else if (is_array($this->$sAttributeName))
			{
				// Note: This copies only one dimension arrays
				foreach ($this->$sAttributeName as &$aAttributeValue)
				{
					if (is_object($aAttributeValue))
					{
						$aAttributeValue = clone $aAttributeValue;
					}
					unset($aAttributeValue);
				}
			}
		}
	}
}

function toArray($sValue)
{
	if (is_object($sValue))
	{
		return $sValue->__toArray();
	}
	return $sValue;
}