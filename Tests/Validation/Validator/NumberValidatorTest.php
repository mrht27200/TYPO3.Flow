<?php
declare(ENCODING = 'utf-8');
namespace F3\FLOW3\Validation\Validator;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package FLOW3
 * @subpackage Tests
 * @version $Id$
 */

/**
 * Testcase for the number validator
 *
 * @package FLOW3
 * @subpackage Tests
 * @version $Id$
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class NumberValidatorTest extends \F3\Testing\BaseTestCase {

	/**
	 * @test
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function numberValidatorReturnsTrueForASimpleInteger() {
		$numberValidator = new \F3\FLOW3\Validation\Validator\NumberValidator();
		$validationErrors = new \F3\FLOW3\Validation\Errors();

		$this->assertTrue($numberValidator->isValid(1029437, $validationErrors));
	}

	/**
	 * @test
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function numberValidatorReturnsFalseForAString() {
		$error = new \F3\FLOW3\Validation\Error('', 1221563685);
		$mockObjectFactory = $this->getMock('F3\FLOW3\Object\FactoryInterface');
		$mockObjectFactory->expects($this->any())->method('create')->will($this->returnValue($error));

		$numberValidator = new \F3\FLOW3\Validation\Validator\NumberValidator();
		$numberValidator->injectObjectFactory($mockObjectFactory);
		$validationErrors = new \F3\FLOW3\Validation\Errors();

		$this->assertFalse($numberValidator->isValid('not a number', $validationErrors));
	}

	/**
	 * @test
	 * @author Andreas Förthner <andreas.foerthner@netlogix.de>
	 */
	public function numberValidatorCreatesTheCorrectErrorObjectForAnInvalidSubject() {
		$error = new \F3\FLOW3\Validation\Error('', 1221563685);
		$mockObjectFactory = $this->getMock('F3\FLOW3\Object\FactoryInterface');
		$mockObjectFactory->expects($this->any())->method('create')->will($this->returnValue($error));

		$numberValidator = new \F3\FLOW3\Validation\Validator\NumberValidator();
		$numberValidator->injectObjectFactory($mockObjectFactory);
		$validationErrors = new \F3\FLOW3\Validation\Errors();

		$numberValidator->isValid('this is not a number', $validationErrors);

		$this->assertType('F3\FLOW3\Validation\Error', $validationErrors[0]);
		$this->assertEquals(1221563685, $validationErrors[0]->getCode());
	}
}

?>