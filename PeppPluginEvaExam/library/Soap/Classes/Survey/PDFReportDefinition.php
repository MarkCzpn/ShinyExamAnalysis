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
 * Date: 24.10.2016
 * Time: 16:28
 */
class PDFReportDefinition extends _ASoap
{
	protected $m_nReportDefinitionId;
	protected $m_sName;
	protected $m_sDescription;
	protected $m_nBaseFormId;
	protected $m_aQuestions;
	protected $m_aRecipients;
	protected $m_nBaseReportId;
	protected $m_nSubgroupQuestion;
	protected $m_bSubgroupShowOverallReport;
	protected $m_bSubgroupShowDivider;
	protected $m_bSubgroupIncludeOpenQuestions;

	public function initFromArray($aArray)
	{
		$this->m_nReportDefinitionId = $aArray['ReportDefinitionId'];
		$this->m_sName = $aArray['Name'];
		$this->m_sDescription = $aArray['Description'];
		$this->m_nBaseFormId = $aArray['BaseFormId'];
		$this->m_aQuestions = [];
		if (is_array($aArray['Questions']) && count($aArray['Questions']) &&
			is_array($aArray['Questions']['ID']) && count($aArray['Questions']['ID']))
		{
			foreach ($aArray['Questions']['ID'] as $option)
			{
				array_push($this->m_aQuestions, $option);
			}
		}
		
		$this->m_aRecipients = [];
		if (is_array($aArray['Recipients']) && count($aArray['Recipients']) &&
			is_array($aArray['Recipients']['ID']) && count($aArray['Recipients']['ID']))
		{
			foreach ($aArray['Recipients']['ID'] as $option)
			{
				array_push($this->m_aRecipients, $option);
			}
		}
		
		$this->m_nBaseReportId = $aArray['BaseReportId'];
		$this->m_nSubgroupQuestion = $aArray['SubgroupQuestion'];
		$this->m_bSubgroupShowOverallReport = $aArray['SubgroupShowOverallReport'];
		$this->m_bSubgroupShowDivider = $aArray['SubgroupShowDivider'];
		$this->m_bSubgroupIncludeOpenQuestions = $aArray['SubgroupIncludeOpenQuestions'];
	}

	public function getReportDefinitionId()
	{
		return $this->m_nReportDefinitionId;
	}
	public function getName()
	{
		return $this->m_sName;
	}
	public function getDescription()
	{
		return $this->m_sDescription;
	}
	public function getBaseFormId()
	{
		return $this->m_nBaseFormId;
	}
	public function getQuestions()
	{
		return $this->m_aQuestions;
	}
	public function getRecipients()
	{
		return $this->m_aRecipients;
	}
	public function getBaseReportId()
	{
		return $this->m_nBaseReportId;
	}
	public function getSubgroupQuestion()
	{
		return $this->m_nSubgroupQuestion;
	}
	public function getSubgroupShowOverallReport()
	{
		return $this->m_bSubgroupShowOverallReport;
	}
	public function getSubgroupShowDivider()
	{
		return $this->m_bSubgroupShowDivider;
	}
	public function getSubgroupIncludeOpenQuestions()
	{
		return $this->m_bSubgroupIncludeOpenQuestions;
	}
	
	/**
	 * @param int $nReportDefinitionId
	 */
	public function setReportDefinitionId($nReportDefinitionId)
	{
		$this->m_nReportDefinitionId = $nReportDefinitionId;
	}
	
	/**
	 * @param string $sName
	 */
	public function setName($sName)
	{
		$this->m_sName = $sName;
	}
	
	/**
	 * @param string $sDescription
	 */
	public function setDescription($sDescription)
	{
		$this->m_sDescription = $sDescription;
	}
	
	/**
	 * @param int $nBaseFormId
	 */
	public function setBaseFormId($nBaseFormId)
	{
		$this->m_nBaseFormId = $nBaseFormId;
	}
	
	/**
	 * @param int[] $aQuestions
	 */
	public function setQuestions($aQuestions)
	{
		$this->m_aQuestions = $aQuestions;
	}
	
	/**
	 * @param int[] $aRecipients
	 */
	public function setRecipients($aRecipients)
	{
		$this->m_aRecipients = $aRecipients;
	}
	
	/**
	 * @param int $nBaseReportId
	 */
	public function setBaseReportId($nBaseReportId)
	{
		$this->m_nBaseReportId = $nBaseReportId;
	}
	
	/**
	 * @param int $nSubgroupQuestion
	 */
	public function setSubgroupQuestion($nSubgroupQuestion)
	{
		$this->m_nSubgroupQuestion = $nSubgroupQuestion;
	}
	
	/**
	 * @param boolean $bSubgroupShowOverallReport
	 */
	public function setSubgroupShowOverallReport($bSubgroupShowOverallReport)
	{
		$this->m_bSubgroupShowOverallReport = $bSubgroupShowOverallReport;
	}
	
	/**
	 * @param boolean $bSubgroupShowDivider
	 */
	public function setSubgroupShowDivider($bSubgroupShowDivider)
	{
		$this->m_bSubgroupShowDivider = $bSubgroupShowDivider;
	}
	
	/**
	 * @param boolean $bSubgroupIncludeOpenQuestions
	 */
	public function setSubgroupIncludeOpenQuestions($bSubgroupIncludeOpenQuestions)
	{
		$this->m_bSubgroupIncludeOpenQuestions = $bSubgroupIncludeOpenQuestions;
	}
	
	
	
	public function __toArray()
	{
		$aArray['ReportDefinitionId'] = $this->m_nReportDefinitionId;
		$aArray['Name'] = $this->m_sName;
		$aArray['Description'] = $this->m_sDescription;
		$aArray['BaseFormId'] = $this->m_nBaseFormId;
		foreach($this->m_aQuestions as $nQuestionId)
		{
			$aArray['Questions']['ID'][] = $nQuestionId;
		}
		foreach($this->m_aRecipients as $nRecipientId)
		{
			$aArray['Recipients']['ID'][] = $nRecipientId;
		}
		
		$aArray['BaseReportId'] = $this->m_nBaseReportId;
		$aArray['SubgroupQuestion'] = $this->m_nSubgroupQuestion;
		$aArray['SubgroupShowOverallReport'] = $this->m_bSubgroupShowOverallReport;
		$aArray['SubgroupShowDivider'] = $this->m_bSubgroupShowDivider;
		$aArray['SubgroupIncludeOpenQuestions'] = $this->m_bSubgroupIncludeOpenQuestions;
		
		return $aArray;
	}
}