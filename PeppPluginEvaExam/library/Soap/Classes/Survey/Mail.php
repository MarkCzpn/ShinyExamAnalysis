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
 * Class Mail
 * User: sbe
 * Date: 12.09.2017
 * Time: 08:35
 * @package Soap\Survey
 */
class Mail extends _ASoap
{
	protected $m_sFromMail;
	protected $m_sFromName;
	protected $m_asToList;
	protected $m_sSubject;
	protected $m_sBody;
	protected $m_nDeliveryType;
	protected $m_asCcList;
	protected $m_asBccList;
	protected $m_sScheduledDate;
	protected $m_nStatus;
	protected $m_nSurveyID;
	protected $m_sCreationDate;
	protected $m_nID;
	protected $m_asErrors;
	
	public function initFromArray($aArray)
	{
		$this->m_sFromMail = $aArray['FromMail'];
		$this->m_sFromName = $aArray['FromName'];
		$this->m_asToList = [];
		if (is_array($aArray['ToList']))
		{
			if(is_array($aArray['ToList']['MailAddress']) && count($aArray['ToList']['MailAddress']))
			{
				foreach ($aArray['ToList']['MailAddress'] as $nValue)
				{
					array_push($this->m_asToList, $nValue);
				}
			}
			elseif(isset($aArray['ToList']['MailAddress']))
			{
				array_push($this->m_asToList, $aArray['ToList']['MailAddress']);
			}
		}
		$this->m_sSubject = $aArray['Subject'];
		$this->m_sBody = $aArray['Body'];
		$this->m_nDeliveryType = $aArray['DeliveryType'];
		$this->m_asCcList = [];
		if (is_array($aArray['CcList']))
		{
			if(is_array($aArray['CcList']['MailAddress']) && count($aArray['CcList']['MailAddress']))
			{
				foreach ($aArray['CcList']['MailAddress'] as $nValue)
				{
					array_push($this->m_asCcList, $nValue);
				}
			}
			elseif(isset($aArray['CcList']['MailAddress']))
			{
				array_push($this->m_asCcList, $aArray['CcList']['MailAddress']);
			}
		}
		$this->m_asBccList = [];
		if (is_array($aArray['BccList']))
		{
			if(is_array($aArray['BccList']['MailAddress']) && count($aArray['BccList']['MailAddress']))
			{
				foreach ($aArray['BccList']['MailAddress'] as $nValue)
				{
					array_push($this->m_asBccList, $nValue);
				}
			}
			elseif(isset($aArray['BccList']['MailAddress']))
			{
				array_push($this->m_asBccList, $aArray['BccList']['MailAddress']);
			}
		}
		$this->m_sScheduledDate = $aArray['ScheduledDate'];
		$this->m_nStatus        = $aArray['Status'];
		$this->m_nSurveyID      = $aArray['SurveyID'];
		$this->m_sCreationDate  = $aArray['CreationDate'];
		$this->m_nID            = $aArray['ID'];
		$this->m_asErrors       = [];
		if (is_array($aArray['Errors']) && is_array($aArray['Errors']['Strings'])
			&& count($aArray['Errors']['Strings']))
		{
			foreach ($aArray['Errors']['Strings'] as $nValue)
			{
				array_push($this->m_asErrors, $nValue);
			}
		}
	}
	
	/**
	 * @return string
	 */
	public function getFromMail()
	{
		return $this->m_sFromMail;
	}
	
	/**
	 * @return string
	 */
	public function getFromName()
	{
		return $this->m_sFromName;
	}
	
	/**
	 * @return string[]
	 */
	public function getToList()
	{
		return $this->m_asToList;
	}
	
	/**
	 * @return string
	 */
	public function getSubject()
	{
		return $this->m_sSubject;
	}
	
	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->m_sBody;
	}
	
	/**
	 * @return int
	 */
	public function getDeliveryType()
	{
		return $this->m_nDeliveryType;
	}
	
	/**
	 * @return string[]
	 */
	public function getCcList()
	{
		return $this->m_asCcList;
	}
	
	/**
	 * @return string[]
	 */
	public function getBccList()
	{
		return $this->m_asBccList;
	}
	
	/**
	 * @return string
	 */
	public function getScheduledDate()
	{
		return $this->m_sScheduledDate;
	}
	
	/**
	 * @return int
	 */
	public function getStatus()
	{
		return $this->m_nStatus;
	}
	
	/**
	 * @return int
	 */
	public function getSurveyID()
	{
		return $this->m_nSurveyID;
	}
	
	/**
	 * @return string
	 */
	public function getCreationDate()
	{
		return $this->m_sCreationDate;
	}
	
	/**
	 * @return int
	 */
	public function getID()
	{
		return $this->m_nID;
	}
	
	/**
	 * @return string[]
	 */
	public function getErrors()
	{
		return $this->m_asErrors;
	}
	
	public function __toArray()
	{
		$aArray = [];
		$aArray['FromMail'] = $this->m_sFromMail;
		$aArray['FromName'] = $this->m_sFromName;
		$aArray['ToList'] = [];
		foreach($this->m_asToList as $sMailAddress)
		{
			$aArray['ToList']['MailAddress'][] = $sMailAddress;
		}
		$aArray['Subject'] = $this->m_sSubject;
		$aArray['Body'] = $this->m_sBody;
		$aArray['DeliveryType'] = $this->m_nDeliveryType;
		$aArray['CcList'] = [];
		foreach($this->m_asCcList as $sMailAddress)
		{
			$aArray['CcList']['MailAddress'][] = $sMailAddress;
		}
		$aArray['BccList'] = [];
		foreach($this->m_asBccList as $sMailAddress)
		{
			$aArray['BccList']['MailAddress'][] = $sMailAddress;
		}
		$aArray['ScheduledDate'] = $this->m_sScheduledDate;
		$aArray['Status'] = $this->m_nStatus;
		$aArray['SurveyID'] = $this->m_nSurveyID;
		$aArray['CreationDate'] = $this->m_sCreationDate;
		$aArray['ID'] = $this->m_nID;
		$aArray['Errors'] = [];
		foreach($this->m_asErrors as $sMailAddress)
		{
			$aArray['Errors']['Strings'][] = $sMailAddress;
		}
		return $aArray;
	}
}