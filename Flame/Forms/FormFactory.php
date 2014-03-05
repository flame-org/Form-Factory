<?php
/**
 * Class FormFactory
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 23.08.13
 */
namespace Flame\Forms;

use Nette\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Nette\InvalidArgumentException;
use Nette\Localization\ITranslator;
use Nette\Object;

class FormFactory extends Object implements IFormFactory
{

	/** @var  string */
	private $class = 'Nette\Application\UI\Form';

	/** @var \Nette\Localization\ITranslator */
	private $translator;

	/** @var \Nette\Forms\IFormRenderer */
	private $renderer;

	/** @var  array|IFormProcessor[] */
	private $processors = array();

	/**
	 * @param string $class
	 * @return $this
	 */
	public function setFormClass($class)
	{
		$this->class = (string) $class;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFormClass()
	{
		return $this->class;
	}

	/**
	 * Set translate adapter
	 *
	 * @param ITranslator $translator
	 * @return $this
	 */
	public function setTranslator(ITranslator $translator = null)
	{
		$this->translator = $translator;
		return $this;
	}

	/**
	 * Sets form renderer
	 *
	 * @param IFormRenderer $renderer
	 * @return $this
	 */
	public function setRenderer(IFormRenderer $renderer = null)
	{
		$this->renderer = $renderer;
		return $this;
	}

	/**
	 * Set form processor
	 *
	 * @param IFormProcessor $processor
	 * @return $this
	 */
	public function addProcessor(IFormProcessor $processor)
	{
		$this->processors[spl_object_hash($processor)] = $processor;
		return $this;
	}

	/**
	 * @return \Nette\Application\UI\Form
	 * @throws \Nette\InvalidArgumentException
	 */
	public function createForm()
	{
		if (!class_exists($this->class)) {
			throw new InvalidArgumentException('Given class "' . $this->class . '" not found.');
		}

		/** @var \Nette\Application\UI\Form $form */
		$form = new $this->class;

		if (!$form instanceof Form) {
			throw new InvalidArgumentException('Class "' . $this->class . '" is not instance of Nette\Application\UI\Form.');
		}

		$form->setTranslator($this->translator)
			->setRenderer($this->renderer);

		foreach ($this->processors as $processor) {
			$processor->attach($form);
		}

		return $form;
	}

	/**
	 * Get list of form processors
	 *
	 * @return array|IFormProcessor[]
	 */
	public function getProcessors()
	{
		return $this->processors;
	}

	/**
	 * Remove all or specific processors
	 *
	 * @param array $processors
	 * @return $this
	 */
	public function removeProcessors(array $processors = array())
	{
		if (count($processors)) {
			foreach ($processors as $processor) {
				if (isset($this->processors[$processor])) {
					unset($this->processors[$processor]);
				}
			}
		}else {
			$this->processors = array();
		}

		return $this;
	}
}