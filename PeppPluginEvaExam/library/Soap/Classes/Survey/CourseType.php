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
 * Date: 19.10.2016
 * Time: 15:09
 */
class CourseType extends _ASoap
{
	protected $m_nCourseTypeId;
	protected $m_sName;
	protected $m_nModuleFrmId;

	public function initFromArray($aArray)
	{
		$this->m_nCourseTypeId = $aArray['m_nCourseTypeId'];
		$this->m_sName = $aArray['m_sName'];
		$this->m_nModuleFrmId = $aArray['m_nModuleFrmId'];
	}

	public function getCourseTypeId()
	{
		return $this->m_nCourseTypeId;
	}
	public function getName()
	{
		return $this->m_sName;
	}
	public function getModuleFrmId()
	{
		return $this->m_nModuleFrmId;
	}
}