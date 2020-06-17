<?php
namespace Apps\Core_Forums\Block;

use Phpfox;
use Phpfox_Component;

defined('PHPFOX') or exit('NO DICE!');

class RecentThreadBlock extends Phpfox_Component
{
    public function process()
    {
        if ($this->request()->segment(2) == 'search') {
            return false;
        }
        $iForumId = $this->getParam('iActiveForumId');
        if ($iForumId &&
            !Phpfox::getService('forum')->hasAccess($this->getParam('iActiveForumId'), 'can_view_thread_content')
        ) {
            return false;
        }
        $iLimit = $this->getParam('limit', 4);
        if (!(int)$iLimit) {
            return false;
        }
        $type = 'threads';
        $title = _p('recent_discussions');

        $ids = [];
        $forums = Phpfox::getService('forum')->getForums();
        foreach ($forums as $forum) {
            $ids[] = $forum['forum_id'];
            $childs = Phpfox::getService('forum')->id($forum['forum_id'])->getChildren();
            if ($childs) {
                foreach ($childs as $id) {
                    $ids[] = $id;
                }
            }
        }

        if (empty($ids)) {
            $ids = array(0);
        }
        $aForumLists = array_map(function ($id) {
            return intval($id);
        }, $ids);
        $aForumLists = Phpfox::getService('forum.thread')->getCanViewForumIdList($aForumLists);
        $sForumLists = implode(',', $aForumLists) . (($iForumId) ? ',' . $iForumId : '');
        $cond[] = 'ft.forum_id IN(' . $sForumLists . ') AND ft.group_id = 0 AND ft.view_id = 0';
        list(, $threads) = Phpfox::getService('forum.thread')->getRecentDiscussions($cond, 'ft.time_update DESC', 0, $iLimit, true);

        if (empty($threads)) {
            return false;
        }
        $this->template()->assign([
            'sHeader' => $title,
            'threads' => $threads,
            'type' => $type
        ]);

        return 'block';
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return [
            [
                'info' => _p('Recent Discussions Limit'),
                'description' => _p('Define the limit of how many discussions can be displayed when viewing the forum section. Set 0 will hide this block.'),
                'value' => 4,
                'type' => 'integer',
                'var_name' => 'limit',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getValidation()
    {
        return [
            'limit' => [
                'def' => 'int',
                'min' => 0,
                'title' => _p('"Recent Discussions Limit" must be greater than or equal to 0')
            ],
        ];
    }
}