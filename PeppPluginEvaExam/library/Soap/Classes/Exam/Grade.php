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
namespace Soap\Exam;

use Soap\_ASoap as _ASoap;
/**
 * Created by PhpStorm.
 * User: sbe
 * Date: 25.01.2017
 * Time: 16:29
 */
class Grade extends _ASoap
{
	protected $Id;
	protected $GradingKeyId;
	protected $Name;
	protected $Percentage;
	protected $CreateDate;
	

	public function initFromArray($aArray)
	{
		$this->Id             = $aArray['Id'];
		$this->GradingKeyId = $aArray['GradingKeyId'];
		$this->Name         = $aArray['Name'];
		$this->Percentage   = $aArray['Percentage'];
		$this->CreateDate   = $aArray['CreateDate'];
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->Id;
	}
	
	/**
	 * @return int
	 */
	public function getGradingKeyId()
	{
		return $this->GradingKeyId;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->Name;
	}
	
	/**
	 * @return int
	 */
	public function getPercentage()
	{
		return $this->Percentage;
	}
	
	/**
	 * @return string
	 */
	public function getCreateDate()
	{
		return $this->CreateDate;
	}
	
	/**
	 * @param int $nId
	 */
	public function setId($nId)
	{
		$this->Id = $nId;
	}
	
	/**
	 * @param int $nId
	 */
	public function setGradingKeyId($nId)
	{
		$this->GradingKeyId = $nId;
	}
	
	/**
	 * @param int
	 */
	public function setPercentage($nPercentage)
	{
		$this->Percentage = $nPercentage;
	}
}