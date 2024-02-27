<?php

namespace Serenity\Modulr\Tests;

use Illuminate\Encryption\Encrypter;
use Orchestra\Testbench\TestCase as Orchestra;
use Serenity\Modulr\Console\Commands\Make\MakeModule;
use Serenity\Modulr\Providers\CommandsServiceProvider;
use Serenity\Modulr\Providers\ModulrServiceProvider;
use Serenity\Modulr\Support\ConfigStore;
use Serenity\Modulr\Support\DatabaseFactoryHelper;
use Serenity\Modulr\Support\Facades\Modulr;

abstract class TestCase extends Orchestra
{
  protected function setUp(): void
  {
    parent::setUp();

    Modulr::reload();

    $config = $this->app['config'];

    // Add encryption key for HTTP tests
    $config->set('app.key', 'base64:'.base64_encode(Encrypter::generateKey('AES-128-CBC')));

    // Add stubs to view
    // $this->app['view']->addLocation(__DIR__.'/Feature/stubs');
  }

  protected function tearDown(): void
  {
    $this->app->make(DatabaseFactoryHelper::class)->resetResolvers();

    parent::tearDown();
  }

  protected function makeModule(string $name = 'test-module'): ConfigStore
  {
    $this->artisan(MakeModule::class, [
      'name' => $name,
      '--accept-namespace' => true,
    ]);

    return Modulr::module($name);
  }

  protected function requiresLaravelVersion(string $minimum_version)
  {
    if (version_compare($this->app->version(), $minimum_version, '<')) {
      $this->markTestSkipped("Only applies to Laravel {$minimum_version} and above.");
    }

    return $this;
  }

  protected function getPackageProviders($app)
  {
    return [
      ModulrServiceProvider::class,
      CommandsServiceProvider::class,
    ];
  }

  protected function getPackageAliases($app)
  {
    return [
      'Modulr' => Modulr::class,
    ];
  }
}
