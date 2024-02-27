<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Foundation\Console\ComponentMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakeComponent extends ComponentMakeCommand
{
  use ConfiguresCommands;

  protected function viewPath($path = '')
  {
    if ($module = $this->module()) {
      return $module->path("resources/views/{$path}");
    }

    return parent::viewPath($path);
  }
}
