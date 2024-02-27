<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Foundation\Console\ProviderMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakeProvider extends ProviderMakeCommand
{
  use ConfiguresCommands;
}
