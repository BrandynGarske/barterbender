<?php

/**
 * [PHPFOX_HEADER]
 */
defined('PHPFOX') or exit('NO DICE!');

class Directory_Component_Block_detailactivities extends Phpfox_Component {

	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process() {

		$aYnDirectoryDetail  = $this->getParam('aYnDirectoryDetail');
		$this->template()->assign(array(
				'aYnDirectoryDetail' => $aYnDirectoryDetail, 
			)
		);
	}

}

?>
