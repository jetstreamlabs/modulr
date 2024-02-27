<?php

namespace Serenity\Modulr\Support;

use Serenity\Modulr\Support\Facades\Modulr;
use SplFileInfo;

class DiscoverEvents extends \Illuminate\Foundation\Events\DiscoverEvents
{
  protected static function classFromFile(SplFileInfo $file, $basePath)
  {
    if ($module = Modulr::moduleForPath($file->getRealPath())) {
      return $module->pathToFullyQualifiedClassName($file->getPathname());
    }

    return parent::classFromFile($file, $basePath);
  }
}
