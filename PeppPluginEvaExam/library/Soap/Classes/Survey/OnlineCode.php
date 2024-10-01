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
 * Date: 25.10.2016
 * Time: 08:11
 */
class OnlineCode extends _ASoap
{
	protected $m_sOnlineCode;
	protected $m_nCodeType;
	protected $m_nSurveyId;
	protected $m_sRecipientMailAddress;
	protected $m_sDirectOnlineLink;

	public function initFromArray($aArray)
	{
		$this->m_sOnlineCode = $aArray['m_sOnlineCode'];
		$this->m_nCodeType = $aArray['m_nCodeType'];
		$this->m_nSurveyId = $aArray['m_nSurveyId'];
		$this->m_sRecipientMailAddress = $aArray['m_sRecipientMailAddress'];
		$this->m_sDirectOnlineLink = $aArray['m_sDirectOnlineLink'];
	}

	public function getOnlineCode()
	{
		return $this->m_sOnlineCode;
	}
	public function getCodeType()
	{
		return $this->m_nCodeType;
	}
	public function getSurveyId()
	{
		return $this->m_nSurveyId;
	}
	public function getRecipientMailAddress()
	{
		return $this->m_sRecipientMailAddress;
	}
	public function getDirectOnlineLink()
	{
		return $this->m_sDirectOnlineLink;
	}
	
	public function __toArray($aArray)
	{
		$aArray['m_sOnlineCode'] = $this->m_sOnlineCode;
		$aArray['m_nCodeType'] = $this->m_nCodeType;
		$aArray['m_nSurveyId'] = $this->m_nSurveyId;
		$aArray['m_sRecipientMailAddress'] = $this->m_sRecipientMailAddress;
		$aArray['m_sDirectOnlineLink'] = $this->m_sDirectOnlineLink;
	}
}