<?php
namespace TYPO3\Flow\Object\DependencyInjection;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A Proxy Class Builder which integrates Dependency Injection.
 *
 * @Flow\Proxy(false)
 * @api
 */
class DependencyProxy {

	/**
	 * @var \Closure
	 */
	protected $injector;

	/**
	 * @var string
	 */
	protected $className;

	/**
	 * Constructs this proxy
	 *
	 * @param \Closure $injector A closure which, if invoked, injects the real dependency into the target object and returns the result of a call to the original method
	 */
	public function __construct(\Closure $injector, $className) {
		$this->injector = $injector;
		$this->className = $className;
	}

	/**
	 * Proxy magic call method which triggers the injection of the real dependency
	 * and returns the result of a call to the original method in the dependency
	 *
	 * @param string $methodName Name of the method to be called
	 * @param array $arguments An array of arguments to be passed to the method
	 * @return mixed
	 */
	public function __call($methodName, array $arguments) {
		return $this->injector->__invoke($methodName, $arguments);
	}

	/**
	 * Activate the dependency and set it in the object.
	 *
	 * @return void
	 * @api
	 */
	public function _activateDependency() {
		$this->injector->__invoke();
	}

	/**
	 * Returns the class name of the proxied dependency
	 *
	 * @return string Fully qualified class name of the proxied object
	 * @api
	 */
	public function _getClassName() {
		return $this->className;
	}

}
?>
