<?php
/**
 * Created by PhpStorm.
 * User: thanhnc
 * Date: 10/20/16
 * Time: 4:55 PM
 */
?>
<?php
if (Phpfox_Request::instance()->get('req1') == 'directory' || (!empty($this->_aCallback['module']) && $this->_aCallback['module'] == 'directory')) {
    unset($aRow['parent_user_id']);
}
?>
