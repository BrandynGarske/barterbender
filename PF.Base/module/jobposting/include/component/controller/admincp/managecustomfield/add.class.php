<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright        [YOUNET_COPPYRIGHT]
 * @author          AnNT
 * @package          Module_jobposting
 */

class Jobposting_Component_Controller_Admincp_Managecustomfield_Add extends Phpfox_Component
{
    /**
     * Class process method which is used to execute this component.
     */
    public function process()
    {
        $bHideOptions = true;
        $iDefaultSelect = 4;
        $bIsEdit = false;
        $aForms = array('is_required' => '1');
        $iObjType = $this->request()->get('objtype');
		
        $sAction = $this->request()->get('action');
		
        if($sAction == 'add')
        {
            $iType = $this->request()->get('type');
        }
        elseif($sAction == 'edit')
        {
            $iId = $this->request()->get('id');
            $aField = Phpfox::getService('jobposting.custom')->getForCustomEdit($iId);
            if (isset($aField['field_id']))
            {                
                $bIsEdit = true;
                $aForms = $aField;
                
                if (isset($aField['option']) && $aField['var_type'] == 'select')
                {
                    $bHideOptions = false;                
                }
            }
        }
		elseif($sAction == 'delete')
		{
			$iId = $this->request()->get('id');
		}
        else
        {
            return Phpfox_Error::set('Invalid action.');
        }
		
        $phrase = _p('jobposting.are_you_sure_you_want_to_delete_this_custom_option');
		$phrase = str_replace("\r\n", "\\n", $phrase);
		
        $this->template()
        	->assign(array(
                'aLanguages' => Phpfox::getService('language')->getAll(),
                'urlModule' => Phpfox::getParam('core.path_file').'module/',
                'bHideOptions' => $bHideOptions,
                'iDefaultSelect' => $iDefaultSelect,
                'aForms' => $aForms,
                'bIsEdit' => $bIsEdit,
                'iCompanyId' => 0,
                'iObjType' => $iObjType,
                'iId' => isset($iId) ? $iId : '',
                'phrase' => $phrase,
            ))
			;
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {
        (($sPlugin = Phpfox_Plugin::get('jobposting.jobposting_component_controller_company_add_field_clean')) ? eval($sPlugin) : false);
    }

}
