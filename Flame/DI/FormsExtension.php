<?php
/**
 * Class FormsExtension
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 05.03.14
 */
namespace Flame\DI;

use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;

class FormsExtension extends CompilerExtension
{

	/** @var array  */
	public $defaults = array(
		'class' => 'Nette\Application\UI\Form'
	);

	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		Validators::assertField($config, 'class', 'string');

		$container->addDefinition($this->prefix('formFactory'))
			->setClass('Flame\Forms\FormFactory')
			->addSetup('setFormClass', array($config['class']));

	}
} 