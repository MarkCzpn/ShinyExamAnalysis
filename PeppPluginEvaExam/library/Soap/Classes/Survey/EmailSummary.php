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
 * Class EmailSummary
 * User: sbe
 * Date: 12.09.2017
 * Time: 13:54
 * @package Soap\Survey
 */
class EmailSummary extends _ASoap
{
	protected $m_anPendingMails;
	protected $m_nPendingSchedulerMailsCount;
	protected $m_anDeliveredMails;
	protected $m_anUndeliveredMails;
	
	public function initFromArray($aArray)
	{
		$this->m_anPendingMails = [];
		if (is_array($aArray['PendingMails']))
		{
			if(is_array($aArray['PendingMails']['ID']) && count($aArray['PendingMails']['ID']))
			{
				foreach ($aArray['PendingMails']['ID'] as $nValue)
				{
					array_push($this->m_anPendingMails, $nValue);
				}
			}
			elseif(isset($aArray['PendingMails']['ID']))
			{
				array_push($this->m_anPendingMails, $aArray['PendingMails']['ID']);
			}
		}
		
		$this->m_nPendingSchedulerMailsCount = $aArray['PendingSchedulerMailsCount'];
		
		$this->m_anDeliveredMails = [];
		if (is_array($aArray['DeliveredMails']))
		{
			if(is_array($aArray['DeliveredMails']['ID']) && count($aArray['DeliveredMails']['ID']))
			{
				foreach ($aArray['DeliveredMails']['ID'] as $nValue)
				{
					array_push($this->m_anDeliveredMails, $nValue);
				}
			}
			elseif(isset($aArray['DeliveredMails']['ID']))
			{
				array_push($this->m_anDeliveredMails, $aArray['DeliveredMails']['ID']);
			}
		}
		$this->m_anUndeliveredMails = [];
		if (is_array($aArray['UndeliveredMails']))
		{
			if(is_array($aArray['UndeliveredMails']['ID']) && count($aArray['UndeliveredMails']['ID']))
			{
				foreach ($aArray['UndeliveredMails']['ID'] as $nValue)
				{
					array_push($this->m_anUndeliveredMails, $nValue);
				}
			}
			elseif(isset($aArray['UndeliveredMails']['ID']))
			{
				array_push($this->m_anUndeliveredMails, $aArray['UndeliveredMailsMails']['ID']);
			}
		}
	}
	
	/**
	 * @return int[]
	 */
	public function getPendingMails()
	{
		return $this->m_anPendingMails;
	}
	
	/**
	 * @return mixed
	 */
	public function getPendingSchedulerMailsCount()
	{
		return $this->m_nPendingSchedulerMailsCount;
	}
	
	/**
	 * @return int[]
	 */
	public function getDeliveredMails()
	{
		return $this->m_anDeliveredMails;
	}
	
	/**
	 * @return int[]
	 */
	public function getUndeliveredMails()
	{
		return $this->m_anUndeliveredMails;
	}
	
	
}