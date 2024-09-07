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

        $container->set($this->getName()."::Migration::Collection", new MigrationCollection([]));
        $capsule = new Manager();

        $capsule->addConnection($default);

        $capsule->setEventDispatcher(new Dispatcher(new Container()));
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
