<?php

namespace Serenity\Modulr\Concerns;

use Serenity\Modulr\Support\ConfigStore;
use Serenity\Modulr\Support\Registry;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputOption;

trait GeneratesModules
{
  protected function module(): ?ConfigStore
  {
    if ($name = $this->option('module')) {
      $registry = $this->getLaravel()->make(Registry::class);

      if ($module = $registry->module($name)) {
        return $module;
      }

      throw new InvalidOptionException(sprintf('The "%s" module does not exist.', $name));
    }

    return null;
  }

  protected function configure()
  {
    parent::configure();

    $this->getDefinition()->addOption(
      new InputOption(
        '--module',
        null,
        InputOption::VALUE_REQUIRED,
        'Run inside an application module'
      )
    );
  }
}
