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
 * Date: 21.10.2016
 * Time: 16:16
 */
class SimpleForm extends _ASoap
{
	protected $m_nID;
	protected $m_sName;
	protected $m_sOwnerID;
	protected $m_sFormEngine;
	protected $m_sCustomReportList;
	protected $m_sUsageRestrictionList;

	public function initFromArray($aArray)
	{
		$this->loadClass('CustomReports', 'Survey');
		$this->loadClass('UsageRestrictionList', 'Survey');
		
		$this->m_nID = $aArray['ID'];
		$this->m_sName = $aArray['Name'];
		$this->m_sOwnerID = $aArray['OwnerID'];
		$this->m_sFormEngine = $aArray['FormEngine'];
		$this->m_sCustomReportList = $this->initObjectArray($aArray['CustomReportList'], 'CustomReports', '\Soap\Survey\CustomReports');
		$this->m_sUsageRestrictionList = new UsageRestrictionList($aArray['UsageRestrictionList']);
	}

	public function getID()
	{
		return $this->m_nID;
	}
	public function getName()
	{
		return $this->m_sName;
	}
	public function getOwnerID()
	{
		return $this->m_sOwnerID;
	}
	public function getFormEngine()
	{
		return $this->m_sFormEngine;
	}
	public function getCustomReportList()
	{
		return $this->m_sCustomReportList;
	}
	public function getUsageRestrictionList()
	{
		return $this->m_sUsageRestrictionList;
	}
}