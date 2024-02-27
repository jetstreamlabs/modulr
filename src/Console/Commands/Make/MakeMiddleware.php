<?php

namespace Serenity\Modulr\Console\Commands\Make;

use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Serenity\Modulr\Concerns\ConfiguresCommands;

class MakeMiddleware extends MiddlewareMakeCommand
{
  use ConfiguresCommands;
}
