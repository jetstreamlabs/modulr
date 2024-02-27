<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Foundation\Console\ObserverMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakeObserver extends ObserverMakeCommand
{
  use ConfiguresCommands;
}
