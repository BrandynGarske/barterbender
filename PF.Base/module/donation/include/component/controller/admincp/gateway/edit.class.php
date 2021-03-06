<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package 		Phpfox_Component
 * @version 		$Id: add.class.php 979 2009-09-14 14:05:38Z Raymond_Benc $
 */
class Donation_Component_Controller_Admincp_Gateway_Edit extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$this->_setMenuName('admincp.donation');
		
		if (!($aGateway = Phpfox::getService('donation.gateway')->getForEdit($this->request()->get('id'))))
		{
			return Phpfox_Error::display(_p('api.unable_to_find_the_payment_gateway'));
		}
		
		if (($aVals = $this->request()->getArray('val')))
		{
			if (Phpfox::getService('donation.gateway.process')->update($aGateway['gateway_id'], $aVals))
			{
				$this->url()->send('admincp.donation.gateway.edit', array('id' => $aGateway['gateway_id']), _p('donation.gateway_successfully_updated'));
			}
		}
		
		$this->template()->setTitle(_p('donation.payment_gateways'))
            ->setBreadcrumb(_p('Apps'), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('donation'), $this->url()->makeUrl('admincp.app',['id' => '__module_donation']))
			->setBreadcrumb(_p('donation.payment_gateways'), $this->url()->makeUrl('admincp.donation'))
			->setBreadcrumb(_p('donation.editing') . ': ' . $aGateway['title'], null, true)
			->assign(array(
					'aForms' => $aGateway
				)
			);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('api.component_controller_admincp_gateway_add_clean')) ? eval($sPlugin) : false);
	}
}

?>