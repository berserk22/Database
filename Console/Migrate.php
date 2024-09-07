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

class Migrate extends Command {

    /**
     * @return void
     */
    public function configure(): void {
        $this->setName('db:migration');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int {
        return 1;
    }

}
