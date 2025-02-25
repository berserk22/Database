<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database;

use Core\Traits\App;

class Model extends \Illuminate\Database\Eloquent\Model {

    use App;

    /**
    * @return void
    */
    public function disableForeignKeyChecks():void {
        $this->getConnection()->statement('SET FOREIGN_KEY_CHECKS=0');
    }

    /**
    * @return void
    */
    public function enableForeignKeyChecks():void {
        $this->getConnection()->statement('SET FOREIGN_KEY_CHECKS=1');
    }

}
