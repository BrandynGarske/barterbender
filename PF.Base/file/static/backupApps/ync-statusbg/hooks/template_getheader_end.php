<?php

if (Phpfox::isModule('ynfeed')) {
    $aEmojis = Phpfox::getService('ynfeed.emoticon')->getAll();
    $aRegex = '';
    foreach ($aEmojis as $aEmoji) {
        $sRegex[] = $aEmoji['code'];
    }
    $sData .= '<script>var yncstatusbg_emoji_regex = ' . json_encode($sRegex) . ';</script>';
}
