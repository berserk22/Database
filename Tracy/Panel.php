<?php

/**
 * @author Sergey Tevs
 * @email sergey@tevs.org
 */

namespace Modules\Database\Tracy;

use Tracy\IBarPanel;

class Panel implements IBarPanel {

    /**
     * @var int
     */
    protected int $count;

    /**
     * @var mixed|string
     */
    protected mixed $data;

    /**
     * @var float
     */
    protected float $time = 0.0;

    /**
     * @param $data
     */
    public function __construct($data = null) {
        $this->data = $data;
        $this->count = count($this->data);
        $this->data = $this->parse();
    }

    /**
     * @return string
     */
    protected function getHeader(): string {
        return '<thead><tr><th style="width: 65px;"><b>Count</b></th><th style="width: 70px;"><b>Time</b></th><th>Query</th></tr></thead>';
    }

    /**
     * @return string
     */
    protected function getBaseRow(): string {
        return '<tr><td style="width: 65px;">%s</td><td style="width: 70px;">%s</td><td>%s</td></tr>';
    }

    /**
     * @return string
     */
    public function getTab(): string {
        return '<span title="DB Query Info"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 284.207 284.207" style="enable-background:new 0 0 284.207 284.207;" xml:space="preserve" width="512px" height="512px"><path d="M239.604,45.447c0-25.909-41.916-45.447-97.5-45.447s-97.5,19.538-97.5,45.447v47.882c0,6.217,2.419,12.064,6.854,17.365  c-3.84,0.328-6.854,3.543-6.854,7.468v47.882c0,6.217,2.419,12.065,6.855,17.366c-3.84,0.328-6.855,3.543-6.855,7.468v47.881  c0,25.91,41.916,45.448,97.5,45.448s97.5-19.538,97.5-45.448v-47.881c0-3.925-3.016-7.14-6.855-7.468  c4.437-5.301,6.855-11.149,6.855-17.366v-47.882c0-3.925-3.015-7.14-6.855-7.468c4.436-5.301,6.855-11.148,6.855-17.365V45.447z   M224.598,190.952c-0.121,14.354-35.358,30.373-82.494,30.373s-82.373-16.02-82.494-30.373  c16.977,12.544,46.938,20.539,82.494,20.539S207.621,203.496,224.598,190.952z M224.598,118.238  c-0.123,14.354-35.359,30.372-82.494,30.372s-82.371-16.019-82.494-30.372c16.977,12.543,46.938,20.538,82.494,20.538  S207.621,130.781,224.598,118.238z M142.104,15c47.218,0,82.5,16.075,82.5,30.447s-35.282,30.447-82.5,30.447  s-82.5-16.075-82.5-30.447S94.886,15,142.104,15z" fill="#005ccc"/></svg>&nbsp;'. $this->time.' ms / '.$this->count .'</span>';
    }

    /**
     * @return string
     */
    public function getPanel(): string {
        return '<h1>SkeletonApp / Eloquent ORM Querys Info</h1><div class="tracy-inner"><p><table width="100%">'. $this->data .'<tr class="yes"><th><b>'. $this->count .'</b></th><th><b>'. $this->time .'</b></th><th>Total</th></tr></table></p></div>';
    }

    /**
     * @return string
     */
    private function parse(): string {
        $return = $this->getHeader();
        $time = $cnt = 0;
        foreach($this->data as $var){
            $time += $var['time'];
            $row = $this->getBaseRow();
            $return .= sprintf(
                $row,
                ++$cnt,
                $var['time'],
                $var['query']
            );
        }
        $this->time = $time;
        return $return;
    }

}
