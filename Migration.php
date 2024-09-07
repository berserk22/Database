<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database;

use Core\Traits\App;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Builder;

abstract class Migration extends \Illuminate\Database\Migrations\Migration {

    use App;

    /**
     * @param string $connection
     * @return Builder|null
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function schema(string $connection = "default"): ?Builder {
        if ($this->getContainer()->has('database')) {
            /* @var $database Manager */
            $database = $this->getContainer()->get('database');
            return $database->schema($connection);
        }
        return null;
    }

    /**
     * @return void
     */
    public function create(): void {}

    /**
     * @return void
     */
    public function update(): void {}

    /**
     * @return void
     */
    public function delete(): void {}
}
