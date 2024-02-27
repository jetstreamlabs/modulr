<?php

use Serenity\Modulr\Console\Commands\CacheCommand;
use Serenity\Modulr\Console\Commands\ClearCommand;

uses(Serenity\Modulr\Tests\Concerns\WritesToAppFilesystem::class);

test('it writes to cache file', function () {
  $this->artisan(CacheCommand::class);

  $expected_path = $this->getBasePath().$this->normalizeDirectorySeparators('bootstrap/cache/modules.php');

  expect($expected_path)->toBeFile();

  $this->artisan(ClearCommand::class);

  $this->assertFileDoesNotExist($expected_path);
});
