<?php

namespace Apps\YNC_Comment\Block;

defined('PHPFOX') or exit('NO DICE!');

use Phpfox;
use Phpfox_Component;

class MoreReplies extends Phpfox_Component
{
    public function process()
    {
        $iCommentId = $this->getParam('iCommentId');
        $iItemId = $this->getParam('iItemId');
        $sCommentTypeId = $this->getParam('sCommentTypeId');
        $iShownTotal = $this->getParam('iShownTotal');
        $iTotalReplies = $this->getParam('iTotalReplies');
        $iTimeStamp = $this->getParam('iTimeStamp');
        $iMaxTime = $this->getParam('iMaxTime');
        $iLimit = 10;
        $aComment = Phpfox::getService('ynccomment')->getComment($iCommentId);
        if ($aComment['child_total'] > $iTotalReplies) {
            $iShownTotal = $iShownTotal + ($aComment['child_total'] - $iTotalReplies);
        } elseif ($aComment['child_total'] < $iTotalReplies) {
            $iShownTotal = $iShownTotal - ($iTotalReplies - $aComment['child_total']);
        }
        if (!$iCommentId) {
            return false;
        }
        $aReplies = Phpfox::getService('ynccomment')->loadMoreChild($iCommentId, $sCommentTypeId, $iItemId, $iTimeStamp,
            $iMaxTime, $iLimit);
        if (!$aReplies) {
            return false;
        }
        $iShownTotal = $iShownTotal + count($aReplies);
        $aUser = $this->getParam('aUser');
        if (!empty($aUser)) {
            $this->template()->assign([
                'aUser' => $aUser,
            ]);
        }
        $this->template()->assign([
            'aComment' => $aComment,
            'aReplies' => $aReplies,
            'iShownTotal' => $iShownTotal,
            'iMaxTime' => $iMaxTime,
            'iLoadMoreTotal' => !setting('ynccomment_show_replies_on_comment') ? $iShownTotal : $iShownTotal - Phpfox::getParam('comment.thread_comment_total_display')
        ]);
        return 'block';
    }
}