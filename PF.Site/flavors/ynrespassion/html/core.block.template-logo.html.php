<?php
/**
 * [PHPFOX_HEADER]
 *
 * @copyright        [PHPFOX_COPYRIGHT]
 * @author           Raymond_Benc
 * @package          Phpfox
 * @version          $Id: template-logo.html.php 7042 2014-01-14 12:42:41Z Fern $
 */

defined('PHPFOX') or exit('NO DICE!');

?>
<div class="site-logo">
    <a href="{url link=''}" class="site-logo-link">
        <span class="site-logo-icon"><i style="background-image:url({if isset($logo)}{$logo}{else}{param var='core.path_actual'}PF.Site/Apps/ync-respassion/assets/images/ynrespassion_logo.png{/if})"></i></span>
        {if (isset($site_name))}
        <span class="site-logo-name" style="display:none;">{$site_name}</span>
        {/if}
    </a>
</div>
