<?php
namespace Apps\YNC_Reaction\Controller\Admin;

defined('PHPFOX') or exit('NO DICE!');

use Phpfox;
use Phpfox_Component;
use Phpfox_Plugin;

class ManageReactionsController extends Phpfox_Component
{

    public function process()
    {
        if ($iId = $this->request()->getInt('delete')) {
            if (Phpfox::getService('yncreaction.process')->deleteReaction($iId)) {
                $this->url()->send('admincp.app', ['id' => 'YNC_Reaction'], _p('reaction_deleted_successfully'));
            }
        }
        $this->template()
            ->setTitle(_p('manage_reactions'), true)
            ->setBreadCrumb(_p('manage_reactions'))
            ->assign([
                'aReactions' => Phpfox::getService('yncreaction')->getForAdmin(),
                'iTotalReaction' => Phpfox::getService('yncreaction')->countReactions()
            ]);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('yncreaction.component_controller_admincp_manage_reactions_clean')) ? eval($sPlugin) : false);
    }
}

