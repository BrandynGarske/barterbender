<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * 
 * 
 * @copyright        [YOUNET_COPPYRIGHT]
 * @author           TriLM
 * @package          Module_coupon
 */

class Coupon_Service_Custom_Custom extends Phpfox_service
{
    private $_aHasOption = array('select', 'radio', 'multiselect', 'checkbox');
    
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('coupon_custom_field');
        $this->_sTableOption = Phpfox::getT('coupon_custom_option');
        $this->_sTableValue = Phpfox::getT('coupon_custom_value');
    }
    

    
    /**
     * @param int $iCompanyId
     * @return array
     */
    public function getCustomField()
    {

        $aFields = $this->database()->select('*')
            ->from($this->_sTable)
            ->order('ordering ASC')
            ->execute('getSlaveRows');
        
        if(is_array($aFields) && count($aFields))
        {
            foreach($aFields as $k=>$aField)
            {
                if(in_array($aField['var_type'], $this->_aHasOption))
                {
                    $aOptions = $this->database()->select('*')->from($this->_sTableOption)->where('field_id = '.$aField['field_id'])->order('option_id ASC')->execute('getSlaveRows');
                    if(is_array($aOptions) && count($aOptions))
                    {
                        foreach($aOptions as $k2=>$aOption)
                        {
                            $aFields[$k]['option'][$aOption['option_id']] = $aOption['phrase_var_name'];
                        }
                    }
                }
            }
        }
        
        return $aFields;
    }
    
    public function getByCouponId($iCouponId)
    {
        $aFields = $this->database()->select('cf.*, cv.value,cv.coupon_id')
            ->from($this->_sTable, 'cf')
            ->leftJoin($this->_sTableValue, 'cv', 'cv.field_id = cf.field_id AND cv.coupon_id = '.$iCouponId)
            ->group('cf.field_id')
            ->order('cf.ordering ASC')
            ->execute('getSlaveRows');


        if(is_array($aFields) && count($aFields))
        {
            foreach($aFields as $k=>$aField)
            {
                if(in_array($aField['var_type'], $this->_aHasOption))
                {
                    //get all option of specific field.
                    $aOptions = $this->database()->select('*')->from($this->_sTableOption)->where('field_id = '.$aField['field_id'])->order('option_id ASC')->execute('getSlaveRows');
                    if(is_array($aOptions) && count($aOptions))
                    {
                        foreach($aOptions as $k2=>$aOption)
                        {
                            $aFields[$k]['option'][$aOption['option_id']] = $aOption['phrase_var_name'];
                        }
                    }

                    //get default option of specifice field belong to specific coupon.
                    $aOptions = $this->database()->select('co.*')
                        ->from($this->_sTableOption, 'co')
                        ->leftJoin($this->_sTableValue, 'cv', 'cv.option_id = co.option_id')
                        ->where('co.field_id = '.$aField['field_id'].' AND cv.coupon_id = '.$iCouponId)
                        ->order('co.option_id ASC')
                        ->execute('getSlaveRows');
                    
                    if(is_array($aOptions) && count($aOptions))
                    {
                        foreach($aOptions as $k2=>$aOption)
                        {
                            $aFields[$k]['value'][$aOption['option_id']] = $aOption['phrase_var_name'];
                        }
                    }
                }
            }
        }

        
        return $aFields;
    }
            
    public function getForCustomEdit($iId)
    {
        $aField = $this->database()->select('*')->from($this->_sTable)->where('field_id = '.(int)$iId)->execute('getRow');
        
        list($sModule, $sVarName) = explode('.', $aField['phrase_var_name']);
        
        // Get the name of the field in every language
        $aPhrases = $this->database()->select('language_id, text')
            ->from(Phpfox::getT('language_phrase'))
            ->where('var_name = \'' . $this->database()->escape($sVarName) . '\'')
            ->execute('getSlaveRows');
        
        foreach ($aPhrases as $aPhrase)
        {
            $aField['name'][$aField['phrase_var_name']][$aPhrase['language_id']] = $aPhrase['text'];
        }
        
        if ($aField['var_type'] == 'select' || $aField['var_type'] == 'multiselect' || $aField['var_type'] == 'radio' || $aField['var_type'] == 'checkbox')
        {
            $aOptions = $this->database()->select('option_id, field_id, phrase_var_name')
                ->from($this->_sTableOption)
                ->where('field_id = ' . $aField['field_id'])
                ->order('option_id ASC')
                ->execute('getSlaveRows');
            
            foreach ($aOptions as $iKey => $aOption)
            {
                list($sModule, $sVarName) = explode('.', $aOption['phrase_var_name']);

                $aPhrases = $this->database()->select('language_id, text, var_name')
                    ->from(Phpfox::getT('language_phrase'))
                    ->where('var_name = \'' . $this->database()->escape($sVarName) . '\'')
                    ->execute('getSlaveRows');
                
                foreach ($aPhrases as $aPhrase)
                {
                    if (!isset($aField['option'][$aOption['option_id']][$aOption['phrase_var_name']][$aPhrase['language_id']]))
                    {
                        $aField['option'][$aOption['option_id']][$aOption['phrase_var_name']][$aPhrase['language_id']] = array();
                    }
                    $aField['option'][$aOption['option_id']][$aOption['phrase_var_name']][$aPhrase['language_id']]['text'] = $aPhrase['text'];
                }
            }
        }
        return $aField;
    }

	public function updateOrder($aVals)
	{
		foreach ($aVals as $iId => $iOrder)
		{
			$this->database()->update($this->_sTable, array('ordering' => $iOrder), 'field_id = ' . (int) $iId);
		}
		
		$this->cache()->remove('coupon', 'substr');
		
		return true;
	}

}