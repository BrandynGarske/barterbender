<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[YOUNET_COPPYRIGHT]
 * @author  		VuDP, AnNT
 * @package  		Module_jobposting
 */

class Jobposting_Service_Catjob_Catjob extends Core_Service_Systems_Category_Category
{
	private $_sOutput = '';

	private $_iCnt = 0;

	private $_sDisplay = 'select';

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = Phpfox::getT('jobposting_job_category');
        $this->_sTableData = Phpfox::getT('jobposting_job_category_data');
	}

	public function getForBrowse($iCategoryId = null)
	{
		$sCacheId = $this->cache()->set('jobposting_job_category_browse' . ($iCategoryId === null ? '' : '_' . $iCategoryId));
	 	if (!($aCategories = $this->cache()->get($sCacheId)))
		{
			$aCategories = $this->database()->select('mc.category_id, mc.name')
				->from($this->_sTable, 'mc')
				->where('mc.parent_id = ' . ($iCategoryId === null ? '0' : (int) $iCategoryId) . ' AND mc.is_active = 1')
				->order('mc.ordering ASC')
				->execute('getRows');

			foreach ($aCategories as $iKey => $aCategory)
			{
				$aCategories[$iKey]['url'] = Phpfox::permalink('jobposting.catjob', $aCategory['category_id'], $aCategory['name']);

				//if ($sCategory === null)
				{
					$aCategories[$iKey]['sub'] = $this->database()->select('mc.category_id, mc.name')
						->from($this->_sTable, 'mc')
						->where('mc.parent_id = ' . $aCategory['category_id'] . ' AND mc.is_active = 1')
						->order('mc.ordering ASC')
						->execute('getRows');

					foreach ($aCategories[$iKey]['sub'] as $iSubKey => $aSubCategory)
					{
						$aCategories[$iKey]['sub'][$iSubKey]['url'] = Phpfox::permalink('jobposting.catjob', $aSubCategory['category_id'], $aSubCategory['name']);
					}
				}
			}

			$this->cache()->save($sCacheId, $aCategories);
		}

		return $aCategories;
	}

	public function display($sDisplay)
	{
		$this->_sDisplay = $sDisplay;

		return $this;
	}

	public function get($type=1)
	{
		$sCacheId = $this->cache()->set('jobposting_job_category_display_' . $this->_sDisplay . '_' . Phpfox::getLib('locale')->getLangId());

		if ($this->_sDisplay == 'admincp')
		{

			//if (!($sOutput = $this->cache()->get($sCacheId)))
			{
				$sOutput = $this->_get(0, 1,$type);

				$this->cache()->save($sCacheId, $sOutput);
			}

			return $sOutput;
		}
		else
		{

			//if (!($this->_sOutput = $this->cache()->get($sCacheId)))
			{
				$this->_get(0, 1,$type);

				$this->cache()->save($sCacheId, $this->_sOutput);
			}

			return $this->_sOutput;
		}
	}

	public function getParentBreadcrumb($sCategory)
	{
		$sCacheId = $this->cache()->set('jobposting_job_parent_breadcrumb_' . md5($sCategory));
		if (!($aBreadcrumb = $this->cache()->get($sCacheId)))
		{
			$sCategories = $this->getParentCategories($sCategory);

			$aCategories = $this->database()->select('*')
				->from($this->_sTable)
				->where('category_id IN(' . $sCategories . ')')
				->execute('getRows');

			$aBreadcrumb = $this->getCategoriesById(null, $aCategories);

			$this->cache()->save($sCacheId, $aBreadcrumb);
		}

		return $aBreadcrumb;
	}

	public function getCategoriesById($iId = null, &$aCategories = null)
	{
		$oUrl = Phpfox::getLib('url');

		if ($aCategories === null)
		{
			$aCategories = $this->database()->select('pc.parent_id, pc.category_id, pc.name')
				->from(Phpfox::getT('jobposting_job_category_data'), 'pcd')
				->join($this->_sTable, 'pc', 'pc.category_id = pcd.category_id')
				->where('pcd.job_id = ' . (int) $iId)
				->order('pc.parent_id ASC, pc.ordering ASC')
				->execute('getSlaveRows');
		}

		if (!count($aCategories))
		{
			return null;
		}

		$aBreadcrumb = array();
		if (count($aCategories) > 1)
		{
			foreach ($aCategories as $aCategory)
			{
				$aBreadcrumb[] = array((Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])), Phpfox::permalink('jobposting.catjob', $aCategory['category_id'], $aCategory['name']));
			}
		}
		else
		{
			$aBreadcrumb[] = array((Phpfox::isPhrase($aCategories[0]['name']) ? _p($aCategories[0]['name']) : Phpfox_Locale::instance()->convert($aCategories[0]['name'])), Phpfox::permalink('jobposting.catjob', $aCategories[0]['category_id'], $aCategories[0]['name']));
		}

		return $aBreadcrumb;
	}

	public function getCategoryIds($iId)
	{
		$aCategories = $this->database()->select('category_id')
			->from(Phpfox::getT('jobposting_job_category_data'))
			->where('job_id = ' . (int) $iId)
			->execute('getSlaveRows');

		$aCache = array();
		foreach ($aCategories as $aCategory)
		{
			$aCache[] = $aCategory['category_id'];
		}

		return implode(',', $aCache);
	}

	public function getAllCategories($sCategory)
	{
		$sCacheId = $this->cache()->set('jobposting_job_category_childern_' . $sCategory);

		if (!($sCategories = $this->cache()->get($sCacheId)))
		{
			$iCategory = $this->database()->select('category_id')
				->from($this->_sTable)
				->where('category_id = \'' . (int) $sCategory . '\'')
				->execute('getField');

			$sCategories = $this->_getChildIds($sCategory, false);
			$sCategories = rtrim($iCategory . ',' . ltrim($sCategories, $iCategory . ','), ',');

			$this->cache()->save($sCacheId, $sCategories);
		}

		return $sCategories;
	}

	public function getChildIds($iId)
	{
		return rtrim($this->_getChildIds($iId), ',');
	}

	public function getParentCategories($sCategory)
	{
		$sCacheId = $this->cache()->set('jobposting_job_category_parent_' . $sCategory);

		if (!($sCategories = $this->cache()->get($sCacheId)))
		{
			$iCategory = $this->database()->select('category_id')
				->from($this->_sTable)
				->where('category_id = \'' . (int) $sCategory . '\'')
				->execute('getField');

			$sCategories = $this->_getParentIds($iCategory);

			$sCategories = rtrim($sCategories, ',');

			$this->cache()->save($sCacheId, $sCategories);
		}

		return $sCategories;
	}

	/**
	 * If a call is made to an unknown method attempt to connect
	 * it to a specific plug-in with the same name thus allowing
	 * plug-in developers the ability to extend classes.
	 *
	 * @param string $sMethod is the name of the method
	 * @param array $aArguments is the array of arguments of being passed
	 */
	public function __call($sMethod, $aArguments)
	{
		/**
		 * Check if such a plug-in exists and if it does call it.
		 */
		if ($sPlugin = Phpfox_Plugin::get('jobposting.service_category_category__call'))
		{
			return eval($sPlugin);
		}

		/**
		 * No method or plug-in found we must throw a error.
		 */
		Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}

	private function _getChildIds($iParentId, $bUseId = true)
	{
		$bUseId = true;

		$aCategories = $this->database()->select('pc.name, pc.category_id')
			->from($this->_sTable, 'pc')
			->where(($bUseId ? 'pc.parent_id = ' . (int) $iParentId . '' : 'pc.name_url = \'' . $this->database()->escape($iParentId) . '\''))
			->execute('getRows');

		$sCategories = '';
		foreach ($aCategories as $aCategory)
		{
			$sCategories .= $aCategory['category_id'] . ',' . $this->_getChildIds($aCategory['category_id']) . '';
		}

		return $sCategories;
	}

	private function _getParentIds($iId)
	{
		$aCategories = $this->database()->select('pc.category_id, pc.parent_id')
			->from($this->_sTable, 'pc')
			->where('pc.category_id = ' . (int) $iId)
			->execute('getRows');

		$sCategories = '';
		foreach ($aCategories as $aCategory)
		{
			$sCategories .= $aCategory['category_id'] . ',' . $this->_getParentIds($aCategory['parent_id']) . '';
		}

		return $sCategories;
	}

	private function _get($iParentId, $iActive = null,$type = 1)
	{

		$aCategories = $this->database()->select('*')
			->from($this->_sTable)
			->where('parent_id = ' . (int) $iParentId . ' AND is_active = ' . (int) $iActive . '')
			->order('ordering ASC')
			->execute('getRows');

		if (count($aCategories))
		{
			$aCache = array();

			if ($iParentId != 0)
			{
				$this->_iCnt++;
			}

			if ($this->_sDisplay == 'option')
			{

			}
			elseif ($this->_sDisplay == 'admincp')
			{
				$sOutput = '<ul>';
			}
			else
			{
				if($type!=3)
					$this->_sOutput .= '<div class="js_mp_parent_holder" id="js_mp_holder_' . $iParentId . '" ' . ($iParentId > 0 ? ' style="display:none; padding:5px 0px 0px 0px;"' : '') . '>';
				else {
					$this->_sOutput .= '<div class="popup_js_mp_parent_holder" id="popup_js_mp_holder_' . $iParentId . '" ' . ($iParentId > 0 ? ' style="display:none; padding:5px 0px 0px 0px;"' : '') . '>';
				}
				if($type==1 || $type==3){
					if($type==1)
						$this->_sOutput .= '<select name="val[category][' . $iParentId . ']" class="form-control js_mp_category_list" id="js_mp_id_' . $iParentId . '">' . "\n";
					else {
						$this->_sOutput .= '<select name="val[category][' . $iParentId . ']" class="form-control popup_js_mp_category_list" id="popup_js_mp_id_' . $iParentId . '">' . "\n";
					}

				}

				else
					$this->_sOutput .= '<select name="search[category][' . "search_".$iParentId . ']" class="form-control js_mp_category_list" id="js_mp_id_' . $iParentId . '">' . "\n";

				$this->_sOutput .= '<option value="">' . ($iParentId === 0 ? _p('select') : _p('select_a_sub_cat')) . ':</option>' . "\n";
			}

			foreach ($aCategories as $iKey => $aCategory)
			{
				$aCache[] = $aCategory['category_id'];

				if ($this->_sDisplay == 'option')
				{
					if(!PHpfox::isAdmin() || ($aCategory['parent_id']==0 && PHpfox::isAdmin()))
					{
						if($type!=3)
						{
							$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="js_mp_category_item_' . $aCategory['category_id'] . '">' . ($this->_iCnt > 0 ? str_repeat('&nbsp;', ($this->_iCnt * 2)) . ' ' : '') . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
						}
						else
						{

							$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="popup_js_mp_category_item_' . $aCategory['category_id'] . '">' . ($this->_iCnt > 0 ? str_repeat('&nbsp;', ($this->_iCnt * 2)) . ' ' : '') . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
						}
						$this->_sOutput .= $this->_get($aCategory['category_id'], $iActive);
					}
				}
				elseif ($this->_sDisplay == 'admincp')
				{
					$sOutput .= '<li><img src="' . Phpfox::getLib('template')->getStyle('image', 'misc/draggable.png') . '" alt="" /> <input type="hidden" name="order[' . $aCategory['category_id'] . ']" value="' . $aCategory['ordering'] . '" class="js_mp_order" /><a href="#?id=' . $aCategory['category_id'] . '" class="js_drop_down">' . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</a>' . $this->_get($aCategory['category_id'], $iActive) . '</li>' . "\n";
				}
				else
				{
					if($type!=3)
					{
						$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="js_mp_category_item_' . $aCategory['category_id'] . '">' . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
					}
					else {
						$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="popup_js_mp_category_item_' . $aCategory['category_id'] . '">' . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
					}
				}
			}

			if ($this->_sDisplay == 'option')
			{

			}
			elseif ($this->_sDisplay == 'admincp')
			{
				$sOutput .= '</ul>';

				return $sOutput;
			}
			else
			{
				$this->_sOutput .= '</select>' . "\n";
				$this->_sOutput .= '</div>';

				foreach ($aCache as $iCateoryId)
				{
					$this->_get($iCateoryId, $iActive,$type);
				}
			}

			$this->_iCnt = 0;
		}
	}

	private function _getParentsUrl($iParentId, $bPassName = false)
	{
		// Cache the round we are going to increment
		static $iCnt = 0;

		// Add to the cached round
		$iCnt++;

		// Check if this is the first round
		if ($iCnt === 1)
		{
			// Cache the cache ID
			static $sCacheId = null;

			// Check if we have this data already cached
			$sCacheId = $this->cache()->set('jobposting_job_category_url' . ($bPassName ? '_name' : '') . '_' . $iParentId);
			if ($sParents = $this->cache()->get($sCacheId))
			{
				return $sParents;
			}
		}

		// Get the menus based on the category ID
		$aParents = $this->database()->select('category_id, name, name_url, parent_id')
			->from($this->_sTable)
			->where('category_id = ' . (int) $iParentId)
			->execute('getRows');

		// Loop thur all the sub menus
		$sParents = '';
		foreach ($aParents as $aParent)
		{
			$sParents .= $aParent['name_url'] . ($bPassName ? '|' . $aParent['name'] . '|' . $aParent['category_id'] : '') . '/' . $this->_getParentsUrl($aParent['parent_id'], $bPassName);
		}

		// Save the cached based on the static cache ID
		if (isset($sCacheId))
		{
			$this->cache()->save($sCacheId, $sParents);
		}

		// Return the loop
		return $sParents;
	}

    /**
     * Get for add/edit company
     * @param int $iLimit = 3
     * @param array $aCats = array()
     */
    public function getForAdd($iLimit = 3, $aCats = array())
    {
        for($i=0; $i<$iLimit; $i++)
        {
            $this->_getForAdd($i, 0, 1, $aCats);
        }

        return $this->_sOutput;
    }

   	private function _getForAdd($iNo, $iParentId, $iActive = null, $aCats = array())
	{
		$aCategories = $this->database()->select('*')
			->from($this->_sTable)
			->where('parent_id = ' . (int) $iParentId . ' AND is_active = ' . (int) $iActive . '')
			->order('ordering ASC')
			->execute('getRows');

		if (count($aCategories))
		{
			$aCache = array();

			if ($iParentId != 0)
			{
				$this->_iCnt++;
			}

            $sStyle = ($iParentId == 0) ? 'padding:5px 0 0 0;' : '';
            if($iParentId > 0 && (!is_array($aCats[$iNo]) || (is_array($aCats[$iNo]) && !in_array($iParentId, $aCats[$iNo]))))
            {
                $sStyle .= 'display:none;';
            }

			$this->_sOutput .= '<div class="js_mp_jobpost_parent_holder" id="js_mp_jobpost_holder_' . $iNo . '_' . $iParentId . '" style="' . $sStyle . '">';
			$this->_sOutput .= '<select name="val[category][' . $iNo . '][' . $iParentId . ']" class="js_mp_jobpost_category_list form-control" id="js_mp_id_' . $iNo . '_' . $iParentId . '">' . "\n";
			$this->_sOutput .= '<option value="">' . ($iParentId === 0 ? _p('select') : _p('select_a_sub_cat')) . ':</option>' . "\n";

			foreach ($aCategories as $iKey => $aCategory)
			{
				$aCache[] = $aCategory['category_id'];

                $sSelect = (!empty($aCats[$iNo][$iParentId]) && $aCats[$iNo][$iParentId] == $aCategory['category_id']) ? ' selected="selected"' : '';
				//if($type!=3)
					$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="js_mp_jobpost_category_item_' . $iNo . '_' . $aCategory['category_id'] . '"' . $sSelect . '>' . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
				//else
				//	$this->_sOutput .= '<option value="' . $aCategory['category_id'] . '" id="popup_js_mp_category_item_' . $iNo . '_' . $aCategory['category_id'] . '"' . $sSelect . '>' . (Phpfox::isPhrase($aCategory['name']) ? _p($aCategory['name']) : Phpfox_Locale::instance()->convert($aCategory['name'])) . '</option>' . "\n";
			}

			$this->_sOutput .= '</select>' . "\n";
			$this->_sOutput .= '</div>';

			foreach ($aCache as $iCateoryId)
			{
				$this->_getForAdd($iNo, $iCateoryId, $iActive, $aCats);
			}

			$this->_iCnt = 0;
		}
	}

	/**
	 * Get Industry data
	 */
	public function getCategoryData($iId, $iLimit = 3)
	{
		$aTemp = array();

		$aCats = $this->database()->select('no, category_id')->from($this->_sTableData)->where('job_id = '.$iId)->execute('getSlaveRows');
		foreach($aCats as $k=>$aCat)
		{
			$no = $aCat['no'];
			$category_id = $aCat['category_id'];
			$parent_id = $this->_getParentId($category_id);
			$aTemp[$no][$parent_id] = $category_id;
		}

		for($no=0; $no<$iLimit; $no++)
		{
			if(empty($aTemp[$no]))
			{
				$aTemp[$no] = array();
			}
		}

		return $aTemp;
	}

	private function _getParentId($iId)
	{
		return $this->database()->select('parent_id')->from($this->_sTable)->where('category_id = '.$iId)->execute('getSlaveField');
	}

	public function getTotalActive()
	{
		return $this->database()->select('COUNT(category_id)')->from($this->_sTable)->where('is_active = 1')->execute('getSlaveField');
	}

	public function getPhraseCategory($job_id){
		$str = "";
		$aCategory = $this->getCategoryData($job_id);

		foreach($aCategory as $key=>$Category){
			if(isset($Category[0]) && $Category[0]>0)
			{

				$aData1 = $this->getForEdit($Category[0]);

				if(isset($aData1['category_id']))
				{

					$str.= (Phpfox::isPhrase($aData1['name']) ? _p($aData1['name']) : Phpfox_Locale::instance()->convert($aData1['name']));

					if(isset($Category[$Category[0]]) && $Category[$Category[0]]>0){
						$aData2 = $this->getForEdit($Category[$Category[0]]);

						if(isset($aData2['category_id'])){
							$str .= " &#8250; " . (Phpfox::isPhrase($aData2['name']) ? _p($aData2['name']) : Phpfox_Locale::instance()->convert($aData2['name']));
						}
					}
					$str.=" | ";
				}

			}
		}
		$str = trim($str," ");
		return trim($str,"|");
	}

    public function getForAdmin($iParentId = 0, $bGetSub = 1)
    {
        $aRows = $this->database()->select('*')
            ->from($this->_sTable)
            ->where('parent_id = ' . (int) $iParentId)
            ->order('ordering ASC')
            ->execute('getSlaveRows');

        foreach ($aRows as $iKey => $aRow){
            if ($bGetSub) {
                $aRows[$iKey]['categories'] = $this->getForAdmin($aRow['category_id']);
            }
        }

        return $aRows;
    }
}
