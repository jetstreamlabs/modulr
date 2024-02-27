<?php

use Serenity\Modulr\Support\ConfigStore;
use Serenity\Modulr\Support\Registry;

uses(Serenity\Modulr\Tests\Concerns\WritesToAppFilesystem::class);

test('it resolves modules', function () {
  $this->makeModule('test-module');
  $this->makeModule('test-module-two');

  $registry = $this->app->make(Registry::class);

  expect($registry->module('test-module'))->toBeInstanceOf(ConfigStore::class);
  expect($registry->module('test-module-two'))->toBeInstanceOf(ConfigStore::class);
  expect($registry->module('non-existant-module'))->toBeNull();

  expect($registry->modules())->toHaveCount(2);

  $module = $registry->moduleForPath($this->getModulePath('test-module', 'foo/bar'));
  expect($module)->toBeInstanceOf(ConfigStore::class);
  expect($module->name)->toEqual('test-module');

  $module = $registry->moduleForPath($this->getModulePath('test-module-two', 'foo/bar'));
  expect($module)->toBeInstanceOf(ConfigStore::class);
  expect($module->name)->toEqual('test-module-two');

  $module = $registry->moduleForClass('Modules\\TestModule\\Foo');
  expect($module)->toBeInstanceOf(ConfigStore::class);
  expect($module->name)->toEqual('test-module');

  $module = $registry->moduleForClass('Modules\\TestModuleTwo\\Foo');
  expect($module)->toBeInstanceOf(ConfigStore::class);
  expect($module->name)->toEqual('test-module-two');
});
