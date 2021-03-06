<?php

namespace Apps\Core_Pages\Service;

use Phpfox;
use Phpfox_Pages_Browse;

defined('PHPFOX') or exit('NO DICE!');

class Browse extends Phpfox_Pages_Browse
{
    /**
     * @return Facade
     */
    public function getFacade()
    {
        return Phpfox::getService('pages.facade');
    }

    public function processRows(&$aRows)
    {
        foreach ($aRows as $iKey => $aPage) {
            if (!isset($aPage['vanity_url']) || empty($aPage['vanity_url'])) {
                $aRows[$iKey]['url'] = Phpfox::permalink('pages', $aPage['page_id']);
            } else {
                $aRows[$iKey]['url'] = url($aPage['vanity_url']);
            }

            // check manage/delete for each page
            Phpfox::getService('pages')->getActionsPermission($aRows[$iKey],'pending');

            if (!empty($aPage['category_id'])) {
                $aRows[$iKey]['category_link'] = Phpfox::permalink('pages.sub-category', $aPage['category_id'], $aPage['category_name']);
            }
            else {
                $aRows[$iKey]['type_link'] = Phpfox::permalink('pages.category', $aPage['type_id'], $aPage['type_name']);
            }

            list($iCnt, $aMembers) = Phpfox::getService('pages')->getMembers($aPage['page_id']);
            $aRows[$iKey]['members'] = $aMembers;
            $aRows[$iKey]['total_members'] = $iCnt;
            $aRows[$iKey]['remain_members'] = $iCnt - 3;
            $aRows[$iKey]['text_parsed'] = Phpfox::getService('pages')->getInfo($aPage['page_id'], true);
        }
    }
}
