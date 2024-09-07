<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database\Console;

use Core\Console\Command;
use DI\DependencyException;
use DI\NotFoundException;
use Modules\Database\Migration;
use Modules\Database\MigrationCollection;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Create extends Command {

    /**
     * @return void
     */
    public function configure(): void {
        $this->setName('db:create')->setDescription("Create Table on Database");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        $method = "create";
        if ($this->getContainer()->has('Modules\Database\ServiceProvider::Migration::Collection')){
            try {
                /** @var $databaseMigrationCollection MigrationCollection */
                $databaseMigrationCollection = $this->getContainer()->get('Modules\Database\ServiceProvider::Migration::Collection');
                $databaseMigrationCollection->each(function(Migration $migration) use ($method){
                    $callback = function() use ($migration, $method) {
                        if (method_exists($migration, $method)){
                            $migration->{$method}();
                        }
                    };
                    $connection = $migration->schema()->getConnection();
                    $connection->getSchemaGrammar()->supportsSchemaTransactions() ? $connection->transaction($callback) : $callback();
                });
            } catch (DependencyException|NotFoundException $e) {
                $this->error($e->getMessage());
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        return 1;
    }

}
