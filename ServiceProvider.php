<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database;

use Core\Module\Provider;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Modules\Database\Console\Create;
use Modules\Database\Console\Delete;
use Modules\Database\Console\Update;
use Monolog\Handler\Handler;
use PDO;

class ServiceProvider extends Provider {

    /**
     * @return string[]
     */
    public function console(): array {
        return [
            Create::class,
            Update::class,
            Delete::class
        ];
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function init(): void {
        $container = $this->getContainer();
        $config = $container->get('config')->getSetting()['database'];

        $default = $config['main'];
        $default['driver'] = $config['driver'];
        $default['charset'] = $config['charset'];
        $default['collation'] = $config['collation'];
        //$default['strict'] = $config['strict'];
        $default['options'] = [
            PDO::ATTR_PERSISTENT => true, // Aktiviert persistente Verbindungen
        ];

        $container->set($this->getName()."::Migration::Collection", new MigrationCollection([]));
        $capsule = new Manager();

        $tmpContainer = new Container();

        $capsule->addConnection($default);
        $capsule->setContainer($tmpContainer);
        $capsule->setEventDispatcher(new Dispatcher($tmpContainer));
        $capsule->setAsGlobal();
        $capsule->connection()->enableQueryLog();
        $capsule->bootEloquent();

        $capsule->getConnection()->getQueryLog();

        $capsule->getContainer()->singleton(
            ExceptionHandler::class,
            Handler::class,
        );

        $container->set('database', $capsule);
    }

}
