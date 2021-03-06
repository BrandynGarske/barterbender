<?php

/**
 * [PHPFOX_HEADER]
 */
defined('PHPFOX') or exit('NO DICE!');

class Ecommerce_Component_Controller_Admincp_Category_Add extends Phpfox_Component
{
    /**
     * Class process method wnich is used to execute this component.
     */
    public function process()
    {
        $bIsEdit = false;
        $aLanguages = Phpfox::getService('language')->getAll();
        if ($iEditId = $this->request()->getInt('id')) {
            if ($aCategory = Phpfox::getService('ecommerce.category')->getForEdit($iEditId)) {
                $bIsEdit = true;

                $this->template()->setHeader('<script type="text/javascript"> $Behavior.ynjpEditEcommerceCategory = function(){ $(function(){$(\'#js_mp_category_item_' . $aCategory['parent_id'] . '\').attr(\'selected\', true);}); };</script>')->assign('aForms',
                    $aCategory);
            }
        }

        if ($aVals = $this->request()->getArray('val')) {
            if ($aVals = $this->_validate($aVals)) {
                if ($bIsEdit) {
                    if (Phpfox::getService('ecommerce.category.process')->update((array)$aVals)) {
                        $this->url()->send('admincp.ecommerce.category.add', array('id' => $aVals['edit_id']),
                            _p('category_successfully_updated'));
                    }
                } else {
                    if (Phpfox::getService('ecommerce.category.process')->add((array)$aVals)) {
                        $this->url()->send('admincp.ecommerce.category.add', null, _p('category_successfully_added'));
                    }
                }
            }
        }

        $this->template()->setTitle(($bIsEdit ? _p('edit_a_category') : _p('create_a_new_category')))->setBreadCrumb(_p("Apps"),
                $this->url()->makeUrl('admincp.apps'))->setBreadCrumb(_p('module_ecommerce'),
                $this->url()->makeUrl('admincp.app') . '?id=__module_ecommerce')->setBreadcrumb(($bIsEdit ? _p('edit_a_category') : _p('create_a_new_category')),
                $this->url()->makeUrl('admincp.ecommerce.category.add'))->assign(array(
                    'sOptions' => Phpfox::getService('ecommerce.category')->display('option')->get(),
                    'bIsEdit' => $bIsEdit,
                    'aLanguages' => $aLanguages
                ));
    }

    /**
     * validate input value
     * @param $aVals
     *
     * @return bool
     */
    private function _validate($aVals)
    {
        return Phpfox::getService('language')->validateInput($aVals, 'name', false);
    }

    /**
     * Garbage collector. Is executed after this class has completed
     * its job and the template has also been displayed.
     */
    public function clean()
    {

    }

}
