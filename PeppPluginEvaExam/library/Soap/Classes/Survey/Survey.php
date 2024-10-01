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
 * Date: 26.09.2016
 * Time: 14:37
 */
class Survey extends _ASoap
{
	protected $m_nSurveyId;
	protected $m_nState;
	protected $m_sTitle;
	protected $m_cType;
	protected $m_nFrmid;
	protected $m_nStuid;
	protected $m_nVerid;
	protected $m_nOpenState;
	protected $m_nFormCount;
	protected $m_nPswdCount;
	protected $m_sLastDataCollectionDate;
	protected $m_nPageLinkOffset;
	protected $m_sMaskTan;
	protected $m_nMaskState;
	protected $m_oPeriod;

	public function initFromArray($aArray)
	{
		$this->loadClass('Period', 'Survey');

		$this->m_nSurveyId = $aArray['m_nSurveyId'];
		$this->m_nState = $aArray['m_nState'];
		$this->m_sTitle = $aArray['m_sTitle'];
		$this->m_cType = $aArray['m_cType'];
		$this->m_nFrmid = $aArray['m_nFrmid'];
		$this->m_nStuid = $aArray['m_nStuid'];
		$this->m_nVerid = $aArray['m_nVerid'];
		$this->m_nOpenState = $aArray['m_nOpenState'];
		$this->m_nFormCount = $aArray['m_nFormCount'];
		$this->m_nPswdCount = $aArray['m_nPswdCount'];
		$this->m_sLastDataCollectionDate = $aArray['m_sLastDataCollectionDate'];
		$this->m_nPageLinkOffset = $aArray['m_nPageLinkOffset'];
		$this->m_sMaskTan = $aArray['m_sMaskTan'];
		$this->m_nMaskState = $aArray['m_nMaskState'];
		$this->m_oPeriod = new Period($aArray['m_oPeriod']);
	}

	public function getSurveyId()
	{
		return $this->m_nSurveyId;
	}

	public function getState()
	{
		return $this->m_nState;
	}

	public function getTitle()
	{
		return $this->m_sTitle;
	}

	public function getType()
	{
		return $this->m_cType;
	}

	public function getFrmid()
	{
		return $this->m_nFrmid;
	}

	public function getStuid()
	{
		return $this->m_nStuid;
	}

	public function getVerid()
	{
		return $this->m_nVerid;
	}

	public function getOpenState()
	{
		return $this->m_nOpenState;
	}

	public function getFormCount()
	{
		return $this->m_nFormCount;
	}

	public function getPswdCount()
	{
		return $this->m_nPswdCount;
	}

	public function getLastDataCollectionDate()
	{
		return $this->m_sLastDataCollectionDate;
	}

	public function getPageLinkOffset()
	{
		return $this->m_nPageLinkOffset;
	}

	public function getMaskTan()
	{
		return $this->m_sMaskTan;
	}

	public function getMaskState()
	{
		return $this->m_nMaskState;
	}

	public function getPeriod()
	{
		return $this->m_oPeriod;
	}
}