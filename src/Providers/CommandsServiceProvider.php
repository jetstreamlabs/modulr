<?php

namespace Serenity\Modulr\Providers;

use Illuminate\Console\Application as Artisan;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand as OriginalMakeMigrationCommand;
use Illuminate\Support\ServiceProvider;
use Serenity\Modulr\Console\Commands\Database\SeedCommand;
use Serenity\Modulr\Console\Commands\Make\MakeCast;
use Serenity\Modulr\Console\Commands\Make\MakeChannel;
use Serenity\Modulr\Console\Commands\Make\MakeCommand;
use Serenity\Modulr\Console\Commands\Make\MakeComponent;
use Serenity\Modulr\Console\Commands\Make\MakeController;
use Serenity\Modulr\Console\Commands\Make\MakeEvent;
use Serenity\Modulr\Console\Commands\Make\MakeException;
use Serenity\Modulr\Console\Commands\Make\MakeFactory;
use Serenity\Modulr\Console\Commands\Make\MakeJob;
use Serenity\Modulr\Console\Commands\Make\MakeListener;
use Serenity\Modulr\Console\Commands\Make\MakeMail;
use Serenity\Modulr\Console\Commands\Make\MakeMiddleware;
use Serenity\Modulr\Console\Commands\Make\MakeMigration;
use Serenity\Modulr\Console\Commands\Make\MakeModel;
use Serenity\Modulr\Console\Commands\Make\MakeNotification;
use Serenity\Modulr\Console\Commands\Make\MakeObserver;
use Serenity\Modulr\Console\Commands\Make\MakePolicy;
use Serenity\Modulr\Console\Commands\Make\MakeProvider;
use Serenity\Modulr\Console\Commands\Make\MakeRequest;
use Serenity\Modulr\Console\Commands\Make\MakeResource;
use Serenity\Modulr\Console\Commands\Make\MakeRule;
use Serenity\Modulr\Console\Commands\Make\MakeSeeder;
use Serenity\Modulr\Console\Commands\Make\MakeTest;

class CommandsServiceProvider extends ServiceProvider
{
  protected array $overrides = [
    'command.cast.make' => MakeCast::class,
    'command.controller.make' => MakeController::class,
    'command.console.make' => MakeCommand::class,
    'command.channel.make' => MakeChannel::class,
    'command.event.make' => MakeEvent::class,
    'command.exception.make' => MakeException::class,
    'command.factory.make' => MakeFactory::class,
    'command.job.make' => MakeJob::class,
    'command.listener.make' => MakeListener::class,
    'command.mail.make' => MakeMail::class,
    'command.middleware.make' => MakeMiddleware::class,
    'command.model.make' => MakeModel::class,
    'command.notification.make' => MakeNotification::class,
    'command.observer.make' => MakeObserver::class,
    'command.policy.make' => MakePolicy::class,
    'command.provider.make' => MakeProvider::class,
    'command.request.make' => MakeRequest::class,
    'command.resource.make' => MakeResource::class,
    'command.rule.make' => MakeRule::class,
    'command.seeder.make' => MakeSeeder::class,
    'command.test.make' => MakeTest::class,
    'command.component.make' => MakeComponent::class,
    'command.seed' => SeedCommand::class,
  ];

  public function register(): void
  {
    // Register our overrides via the "booted" event to ensure that we override
    // the default behavior regardless of which service provider happens to be
    // bootstrapped first.
    $this->app->booted(function () {
      Artisan::starting(function () {
        $this->registerMakeCommandOverrides();
        $this->registerMigrationCommandOverrides();
      });
    });
  }

  protected function registerMakeCommandOverrides()
  {
    foreach ($this->overrides as $alias => $class_name) {
      $this->app->singleton($alias, $class_name);
      $this->app->singleton(get_parent_class($class_name), $class_name);
    }
  }

  protected function registerMigrationCommandOverrides()
  {
    // Laravel 8
    $this->app->singleton('command.migrate.make', function ($app) {
      return new MakeMigration($app['migration.creator'], $app['composer']);
    });

    // Laravel 9
    $this->app->singleton(OriginalMakeMigrationCommand::class, function ($app) {
      return new MakeMigration($app['migration.creator'], $app['composer']);
    });
  }
}
