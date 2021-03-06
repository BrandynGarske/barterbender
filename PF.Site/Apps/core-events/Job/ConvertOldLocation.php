<?php

namespace Apps\Core_Events\Job;

use Core\Queue\JobAbstract;
use Phpfox;
use Phpfox_Queue;

class ConvertOldLocation extends JobAbstract
{
    public function perform()
    {
        $aResult = Phpfox::getService('event.process')->convertOldLocation($this->getParams());
        $this->delete();
        if ($aResult && !empty($aResult['total_remain'])) {
            Phpfox_Queue::instance()->addJob('event_convert_old_location', $aResult, null, 3600);
        }
    }
}