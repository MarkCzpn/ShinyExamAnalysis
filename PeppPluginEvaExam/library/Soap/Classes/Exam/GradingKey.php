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
class GradingKey extends _ASoap
{
	protected $Id;
	protected $StandardExamId;
	protected $CustomExamId;
	protected $UserId;
	protected $Name;
	protected $Comment;
	protected $PassedGradeId;
	protected $CreateDate;
	protected $Grades;
	

	public function initFromArray($aArray)
	{
		$this->loadClass('Grade', 'Exam');
		
		$this->Id               = $aArray['Id'];
		$this->StandardExamId = $aArray['StandardExamId'];
		$this->CustomExamId   = $aArray['CustomExamId'];
		$this->UserId         = $aArray['UserId'];
		$this->Name           = $aArray['Name'];
		$this->Comment        = $aArray['Comment'];
		$this->PassedGradeId  = $aArray['PassedGradeId'];
		$this->CreateDate     = $aArray['CreateDate'];
		$this->Grades         = $this->initObjectArray($aArray['Grades'], 'Grades', '\Soap\Exam\Grade');
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
	public function getStandardExamId()
	{
		return $this->StandardExamId;
	}
	
	/**
	 * @return int
	 */
	public function getCustomExamId()
	{
		return $this->CustomExamId;
	}
	
	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->UserId;
	}
	
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->Name;
	}
	
	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->Comment;
	}
	
	/**
	 * @return int
	 */
	public function getPassedGradeId()
	{
		return $this->PassedGradeId;
	}
	
	/**
	 * @return string
	 */
	public function getCreateDate()
	{
		return $this->CreateDate;
	}
	
	/**
	 * @return Grade[]
	 */
	public function getGrades()
	{
		return $this->Grades;
	}
	
	/**
	 * @param int $nId
	 */
	public function setId($nId)
	{
		$this->Id = $nId;
	}
	
	/**
	 * @param int $nExamId
	 */
	public function setStandardExamId($nExamId)
	{
		$this->StandardExamId = $nExamId;
	}
	
	/**
	 * @param int $nExamId
	 */
	public function setCustomExamId($nExamId)
	{
		$this->CustomExamId = $nExamId;
	}
	
	/**
	 * @param int $PassedGradeId
	 */
	public function setPassedGradeId($PassedGradeId)
	{
		$this->PassedGradeId = $PassedGradeId;
	}
	
	/**
	 * @param Grade[] $aGrades
	 */
	public function setGrades($aGrades)
	{
		$this->Grades = $aGrades;
	}
	
	/**
	 * @return Grade
	 */
	public function getPassingGrade()
	{
		foreach($this->getGrades() as $oGrade)
		{
			if($oGrade->getId() == $this->getPassedGradeId())
			{
				return $oGrade;
			}
		}
	}
	
	/**
	 * @param String $sName
	 */
	public function setName($sName)
	{
		$this->Name = $sName;
	}
}