<?php

if ($iId == 6) {
    array_splice($aBlocks[$iId], 1, 0, [['type_id' => 0, 'component' => 'core.template-breadcrumbmenu', 'params' => []]]);
} elseif ($iId == 1 && Phpfox::getLib('module')->getFullControllerName() == 'search.index') {
    array_unshift($aBlocks[$iId], array('type_id' => 0, 'component' => 'core.template-menusub', 'params' => array()));
}