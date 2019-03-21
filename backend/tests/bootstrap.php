<?php

use App\Kernel;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\MigrationsBundle\Command\MigrationsMigrateDoctrineCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// Load cached env vars if the .env.local.php file exists
// Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
// Load cached env vars if the .env.local.php file exists
// Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
if (is_array($env = @include dirname(__DIR__).'/.env.local.php')) {
    $_SERVER += $env;
    $_ENV += $env;
} elseif (!class_exists(Dotenv::class)) {
    throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
} else {
    // load all the .env files
    (new Dotenv())->loadEnv(dirname(__DIR__).'/.env');
}

$_SERVER['APP_ENV'] = 'test';
$_SERVER['APP_DEBUG'] = 1;
$_SERVER['HTTP_HOST'] = 'test.local';

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();

$application = new Application($kernel);

// add the database:drop command to the application and run it
$command = new DropDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput([
    'command' => 'doctrine:database:drop',
    '--force' => true,
]);
$command->run($input, new ConsoleOutput());

// add the database:create command to the application and run it
$command = new CreateDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput([
    'command' => 'doctrine:database:create',
]);
$command->run($input, new ConsoleOutput());

// Run the database migrations, with --quiet because they are quite
// chatty on the console.
$command = new MigrationsMigrateDoctrineCommand();
$application->add($command);
$input = new ArrayInput([
    'command'          => 'doctrine:migrations:migrate',
    '--quiet'          => true,
    '--no-interaction' => true,
]);
$input->setInteractive(false);
$command->run($input, new ConsoleOutput(ConsoleOutput::VERBOSITY_QUIET));





