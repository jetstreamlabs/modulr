<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Foundation\Console\JobMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakeJob extends JobMakeCommand
{
  use ConfiguresCommands;
}
