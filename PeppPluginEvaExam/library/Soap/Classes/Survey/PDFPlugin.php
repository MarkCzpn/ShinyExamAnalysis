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
 * Time: 16:13
 */
class PDFPlugin extends _ASoap
{
	protected $m_nPluginId;
	protected $m_sTitle;
	protected $m_sClassName;
	protected $m_bIsDefault;
	protected $m_bIsCustomPlugin;
	protected $m_nReportType;
	protected $m_nOwner;
	protected $m_sPath;

	public function initFromArray($aArray)
	{
		$this->m_nPluginId = $aArray['PluginId'];
		$this->m_sTitle = $aArray['Title'];
		$this->m_sClassName = $aArray['ClassName'];
		$this->m_bIsDefault = $aArray['IsDefault'];
		$this->m_bIsCustomPlugin = $aArray['IsCustomPlugin'];
		$this->m_nReportType = $aArray['ReportType'];
		$this->m_nOwner = $aArray['Owner'];
		$this->m_sPath = $aArray['Path'];
	}

	public function getPluginId()
	{
		return $this->m_nPluginId;
	}
	public function getTitle()
	{
		return $this->m_sTitle;
	}
	public function getClassName()
	{
		return $this->m_sClassName;
	}
	public function getIsDefault()
	{
		return $this->m_bIsDefault;
	}
	public function getIsCustomPlugin()
	{
		return $this->m_bIsCustomPlugin;
	}
	public function getReportType()
	{
		return $this->m_nReportType;
	}
	public function getOwner()
	{
		return $this->m_nOwner;
	}
	public function getPath()
	{
		return $this->m_sPath;
	}

}