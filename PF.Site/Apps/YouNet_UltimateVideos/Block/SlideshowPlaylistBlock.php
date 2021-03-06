<?php
/**
 * Created by PhpStorm.
 * User: namnv
 * Date: 8/11/16
 * Time: 9:22 AM
 */

namespace Apps\YouNet_UltimateVideos\Block;

use Phpfox;
use Phpfox_Component;


class SlideshowPlaylistBlock extends Phpfox_Component
{

    public function process()
    {
        if (!$this->getParam('bIsSearch')) {
            return false;
        }

        $iLimit = $this->getParam('limit', 5);
        if (!$iLimit) {
            return false;
        }

        $aItems = Phpfox::getService('ultimatevideo.playlist.browse')->getSlideshowPlaylists($iLimit);
        foreach ($aItems as $key => $aItem) {
            $aCategory = Phpfox::getService('ultimatevideo.category')->getCategoryById($aItem['category_id']);
            if($aCategory)
            {
                $aItems[$key]['category_name'] = $aCategory['title'];
            }
            else{
                $aItems[$key]['category_name'] = _p('no_category');
            }
        }
        Phpfox::getService('ultimatevideo.playlist.browse')->processRows($aItems);
        $this->template()->assign([
            'bShowTotalView'=> true,
            'bShowTotalLike'=> true,
            'bShowTotalComment'=> true,
            'aItems'=>$aItems,
            'corePath' => Phpfox::getParam('core.path_actual').'PF.Site/Apps/YouNet_UltimateVideos',
        ]);

        return 'block';
    }

    public function getSettings()
    {
        return [
            [
                'info' => _p('Featured Playlist Limit'),
                'description' => _p('Define the limit of how many featured playlist can be displayed when viewing the section. Set 0 will hide this block.'),
                'value' => 5,
                'type' => 'integer',
                'var_name' => 'limit',
            ],
            [
                'info' => _p('Featured Playlist Cache Time'),
                'description' => _p('Define how long we should keep the cache for the <b>Featured Playlist</b> by minutes. 0 means we do not cache data for this block.'),
                'value' => Phpfox::getParam('core.cache_time_default'),
                'options' => Phpfox::getParam('core.cache_time'),
                'type' => 'select',
                'var_name' => 'cache_time',
            ]
        ];
    }
    public function getValidation()
    {
        return [
            'limit' => [
                'def' => 'int',
                'min' => 0,
                'title' => '"Featured Playlist Limit" must be greater than or equal to 0'
            ]
        ];
    }
}