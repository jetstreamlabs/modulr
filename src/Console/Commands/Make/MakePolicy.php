<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Foundation\Console\PolicyMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakePolicy extends PolicyMakeCommand
{
  use ConfiguresCommands;
}
