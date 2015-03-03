<?php
/**
 * Class FormsExtension
 *
 * @author Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date 05.03.14
 */
namespace Flame\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Validators;

class FormsExtension extends CompilerExtension
{

	/** @var array  */
	public $defaults = array(
		'class' => 'Nette\Application\UI\Form',
		'translator' => null,
		'renderer' => null
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

	public function afterCompile(ClassType $class)
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig($this->defaults);

		$initialize = $class->methods['initialize'];
		$translator = $config['translator'];
		$renderer = $config['renderer'];
		if ($translator) {
			$initialize->addBody('$this->getService(?)->setTranslator($this->getService(?));', [$container->getByType('Flame\Forms\FormFactory'), $container->getByType($translator)]);
		}
		if ($renderer) {
			$initialize->addBody('$this->getService(?)->setRenderer($this->getService(?));', [$container->getByType('Flame\Forms\FormFactory'), $container->getByType($renderer)]);
		}
	}
}
