<?php

namespace Serenity\Modulr\Support\PhpStorm;

use Illuminate\Support\Str;
use Serenity\Modulr\Support\ConfigStore;

class PhpFrameworkWriter extends ConfigWriter
{
  public function write(): bool
  {
    $config = simplexml_load_string(file_get_contents($this->config_path));
    if (empty($config->xpath('//component[@name="PhpIncludePathManager"]//include_path//path'))) {
      return true;
    }

    $namespace = config('modulr.modules_namespace', 'Modules');
    $vendor = config('modulr.modules_vendor') ?? Str::kebab($namespace);
    $module_paths = $this->module_registry->modules()
        ->map(function (ConfigStore $module) use (&$config, $vendor) {
          return '$PROJECT_DIR$/vendor/'.$vendor.'/'.$module->name;
        });

    $include_paths = $config->xpath('//component[@name="PhpIncludePathManager"]//include_path//path');

    foreach ($include_paths as $key => $existing) {
      if ($module_paths->contains((string) $existing['value'])) {
        unset($include_paths[$key][0]);
      }
    }

    return false !== file_put_contents($this->config_path, $this->formatXml($config));
  }
}