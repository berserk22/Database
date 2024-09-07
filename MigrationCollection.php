<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database;

use Illuminate\Support\Collection;

class MigrationCollection extends Collection {

    /**
     * @param $item
     * @return MigrationCollection|$this
     */
    public function add($item): MigrationCollection|static {
        parent::add($item);
        return $this;
    }
}
