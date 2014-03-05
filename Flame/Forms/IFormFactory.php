<?php
/**
 * Class IFormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;

interface IFormFactory
{

	/**
	 * @param string $class
	 * @return $this
	 */
	public function setFormClass($class);

	/**
	 * @return string
	 */
	public function getFormClass();

	/**
	 * Create base Form
	 *
	 * @return \Nette\Application\UI\Form
	 */
	public function createForm();

	/**
	 * Set translate adapter
	 *
	 * @param ITranslator $translator
	 * @return $this
	 */
	public function setTranslator(ITranslator $translator = null);


	/**
	 * Set form renderer
	 *
	 * @param IFormRenderer $renderer
	 * @return $this
	 */
	public function setRenderer(IFormRenderer $renderer = null);

	/**
	 * Set form processor
	 *
	 * @param IFormProcessor $processor
	 * @return $this
	 */
	public function addProcessor(IFormProcessor $processor);

	/**
	 * Remove all or specific processors
	 *
	 * @param array $processors
	 * @return $this
	 */
	public function removeProcessors(array $processors = array());

	/**
	 * Get list of form processors
	 *
	 * @return array|IFormProcessor[]
	 */
	public function getProcessors();

}