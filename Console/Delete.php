<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database\Console;

use Core\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Delete extends Command {

    public function configure(): void {
        $this->setName('db:delete');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $method = "delete";

        $this->success("Method: ".$method);

        return 1;
    }

}
