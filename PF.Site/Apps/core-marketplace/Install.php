<?php
namespace Apps\Core_Marketplace;

use Core\App;
use Phpfox_Url;

/**
 * Class Install
 * @author  phpFox
 * @package Apps\Core_Marketplace
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];

    public $store_id = 2008;

    protected function setId()
    {
        $this->id = 'Core_Marketplace';
    }

    protected function setAlias()
    {
        $this->alias = 'marketplace';
    }

    protected function setName()
    {
        $this->name = _p('Marketplace');
    }

    protected function setVersion()
    {
        $this->version = '4.7.0';
    }

    protected function setSupportVersion()
    {
        $this->start_support_version = '4.7.8';
    }

    protected function setSettings()
    {
        $iIndex = 1;
        $this->settings = [
            'marketplace_paging_mode' => [
                'var_name' => 'marketplace_paging_mode',
                'info' => 'Pagination Style',
                'description' => 'Select Pagination Style at Search Page.',
                'type' => 'select',
                'value' => 'loadmore',
                'options' => [
                    'loadmore' => 'Scrolling down to Load More items',
                    'next_prev' => 'Use Next and Prev buttons',
                    'pagination' => 'Use Pagination with page number'
                ],
                'ordering' => $iIndex++,
            ],
            'marketplace_meta_description' => [
                'var_name' => 'marketplace_meta_description',
                'info' => 'Marketplace Meta Description',
                'description' => 'Meta description added to pages related to the Marketplace app. <a role="button" onclick="$Core.editMeta(\'seo_marketplace_meta_description\', true)">Click here</a> to edit meta description.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_marketplace_meta_description"></span>',
                'type' => '',
                'value' => '{_p var=\'seo_marketplace_meta_description\'}',
                'group_id' => 'seo',
                'ordering' => $iIndex++,
            ],
            'marketplace_meta_keywords' => [
                'var_name' => 'marketplace_setting_meta_keywords',
                'info' => 'Marketplace Meta Keywords',
                'description' => 'Meta keywords that will be displayed on sections related to the Marketplace app. <a role="button" onclick="$Core.editMeta(\'seo_marketplace_meta_keywords\', true)">Click here</a> to edit meta keywords.<span style="float:right;">(SEO) <input style="width:150px;" readonly value="seo_marketplace_meta_keywords"></span>',
                'type' => '',
                'value' => '{_p var=\'seo_marketplace_meta_keywords\'}',
                'group_id' => 'seo',
                'ordering' => $iIndex++
            ],
            'days_to_expire_listing' => [
                'var_name' => 'days_to_expire_listing',
                'info' => 'Days to Expire',
                'description' => 'If you want marketplace listings to expire you can enter the number of days here. If you enter 0 days listings will not expire.',
                'type' => 'integer',
                'value' => '0',
                'ordering' => $iIndex++
            ],
            'days_to_notify_expire' => [
                'var_name' => 'days_to_notify_expire',
                'info' => 'Days to Notify Expiring Listing',
                'description' => 'When you allow listings to expire you can also set a notification to be sent automatically to the owner of the listing, you can define here how many days in advanced to notify them. If you set this to 0 no email will be sent to the owner.',
                'type' => 'integer',
                'value' => '0',
                'ordering' => $iIndex++
            ],
            'marketplace_allow_create_feed_when_add_new_item' => [
                'var_name' => 'marketplace_allow_posting_on_main_feed',
                'info' => 'Allow posting on Main Feed',
                'description' => 'Allow posting on Main feed when adding a new listing.',
                'type' => 'boolean',
                'value' => '1',
                'ordering' => $iIndex++
            ],
            'marketplace_paging_mode_map_view' => [
                'var_name' => 'marketplace_paging_mode_map_view',
                'info' => 'Pagination Style for Map view',
                'description' => 'Select Pagination Style at Map view page',
                'type' => 'select',
                'value' => 'next_prev',
                'options' => [
                    'next_prev' => 'Use Next and Pre buttons',
                    'pagination' => 'Use Pagination with page number'
                ],
                'ordering' => $iIndex++
            ],
            'display_marketplace_created_in_page' => [
                'var_name' => 'display_marketplace_created_in_page',
                'info' => 'Display marketplace listings which created in Page to Marketplace app',
                'description' => 'Enable to display all public marketplace listings created in Page to Marketplace app. Disable to hide them.',
                'type' => 'boolean',
                'value' => '0',
                'ordering' => $iIndex++,
            ],
            'display_marketplace_created_in_group' => [
                'var_name' => 'display_marketplace_created_in_group',
                'info' => 'Display marketplace listings which created in Group to Marketplace app',
                'description' => 'Enable to display all public marketplace listings created in Group to Marketplace app. Disable to hide them.',
                'type' => 'boolean',
                'value' => '0',
                'ordering' => $iIndex++,
            ],
        ];
        unset($iIndex);
    }

    protected function setUserGroupSettings()
    {
        $iIndex = 1;
        $this->user_group_settings = [
            'can_post_comment_on_listing' => [
                'var_name' => 'can_post_comment_on_listing',
                'info' => 'Can members of this user group post a comment on marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '0',
                    '4' => '1',
                    '5' => '1'
                ],
                'ordering' => $iIndex++
            ],
            'can_access_marketplace' => [
                'var_name' => 'can_access_marketplace',
                'info' => 'Can members of this user group browse and view listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_create_listing' => [
                'var_name' => 'can_create_listing',
                'info' => 'Can members of this user group create a listing?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_edit_own_listing' => [
                'var_name' => 'can_edit_own_listing',
                'info' => 'Can members of this user group edit own marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '0',
                    '4' => '1',
                    '5' => '1'
                ],
                'ordering' => $iIndex++
            ],
            'can_edit_other_listing' => [
                'var_name' => 'can_edit_other_listing',
                'info' => 'Can members of this user group edit all marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_delete_own_listing' => [
                'var_name' => 'can_delete_own_listing',
                'info' => 'Can members of this user group delete own marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '0',
                    '4' => '1',
                    '5' => '1'
                ],
                'ordering' => $iIndex++
            ],
            'can_delete_other_listings' => [
                'var_name' => 'can_delete_other_listings',
                'info' => 'Can members of this user group delete all marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'max_upload_size_listing' => [
                'var_name' => 'max_upload_size_listing',
                'info' => 'Max file size for photos upload in kilobytes (kb), (1024 kb = 1 mb). For unlimited add "0" without quotes.',
                'description' => '',
                'type' => 'integer',
                'value' => [
                    '1' => '8192',
                    '2' => '8192',
                    '3' => '8192',
                    '4' => '8192',
                    '5' => '8192'
                ],
                'ordering' => $iIndex++
            ],
            'can_feature_listings' => [
                'var_name' => 'can_feature_listings',
                'info' => 'Can members of this user group feature a listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'listing_approve' => [
                'var_name' => 'listing_approve',
                'info' => 'Listings must be approved first before they are displayed publicly?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '0',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_approve_listings' => [
                'var_name' => 'can_approve_listings',
                'info' => 'Can members of this user group approve marketplace listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_sponsor_marketplace' => [
                'var_name' => 'can_sponsor_marketplace',
                'info' => 'Can members of this user group mark a marketplace listing as Sponsor without paying fee?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_purchase_sponsor' => [
                'var_name' => 'can_purchase_sponsor',
                'info' => 'Can members of this user group purchase a sponsored ad space for their items?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'marketplace_sponsor_price' => [
                'var_name' => 'marketplace_sponsor_price',
                'info' => 'How much is the sponsor space worth for marketplace listings? This works in a CPM basis.',
                'description' => '',
                'type' => 'currency',
                'ordering' => $iIndex++
            ],
            'auto_publish_sponsored_item' => [
                'var_name' => 'auto_publish_sponsored_item',
                'info' => 'Auto publish sponsored item?',
                'description' => 'After the user has purchased a sponsored space, should the item be published right away? 
If set to No, the admin will have to approve each new purchased sponsored item space before it is shown in the site.',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_sell_items_on_marketplace' => [
                'var_name' => 'can_sell_items_on_marketplace',
                'info' => 'Can members of this user group sell items on the marketplace?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '0',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'point_payment_on_marketplace' => [
                'var_name' => 'point_payment_on_marketplace',
                'info' => 'Can members of this user group enable/disable Activity Point payment on the marketplace? default is Disabled.',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '0',
                    '4' => '1',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'flood_control_marketplace' => [
                'var_name' => 'flood_control_marketplace',
                'info' => 'How many minutes should a user wait before they can create another marketplace listing? Note: Setting it to "0" (without quotes) is default and users will not have to wait.',
                'description' => '',
                'type' => 'integer',
                'value' => [
                    '1' => '0',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'points_marketplace' => [
                'var_name' => 'points_marketplace',
                'info' => 'How many activity points should the user get when adding a new listing?',
                'type' => 'integer',
                'value' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1'
                ],
                'ordering' => $iIndex++
            ],
            'total_photo_upload_limit' => [
                'var_name' => 'total_photo_upload_limit',
                'info' => 'Control how many photos a user can upload to a marketplace listing.',
                'description' => '',
                'type' => 'integer',
                'value' => [
                    '1' => '6',
                    '2' => '6',
                    '3' => '6',
                    '4' => '6',
                    '5' => '6'
                ],
                'ordering' => $iIndex++
            ],
            'can_view_expired' => [
                'var_name' => 'can_view_expired',
                'info' => 'Can members of this user group view the section "Expired" in the marketplace?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_reopen_own_expired_listing' => [
                'var_name' => 'can_reopen_own_expired_listing',
                'info' => 'Can members of this user group reopen own expired listing?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
            'can_reopen_expired_listings' => [
                'var_name' => 'can_reopen_expired_listings',
                'info' => 'Can members of this user group reopen all expired listings?',
                'description' => '',
                'type' => 'boolean',
                'value' => [
                    '1' => '1',
                    '2' => '0',
                    '3' => '0',
                    '4' => '0',
                    '5' => '0'
                ],
                'ordering' => $iIndex++
            ],
        ];
        unset($iIndex);
    }

    protected function setComponent()
    {
        $this->component = [
            'block' => [
                'menu' => '',
                'profile' => '',
                'info' => '',
                'my' => '',
                'category' => '',
                'sponsored' => '',
                'featured' => '',
                'invite' => '',
                'related' => ''
            ],
            'controller' => [
                'index' => 'marketplace.index',
                'view' => 'marketplace.view',
                'invoice' => 'marketplace.invoice',
                'profile' => 'marketplace.profile',
            ]
        ];
    }

    protected function setComponentBlock()
    {
        $this->component_block = [
            'Map View' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.index',
                'component' => 'gmap-block',
                'module_id' => 'core',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Sponsored' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.index',
                'component' => 'sponsored',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Users Invites' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.index',
                'component' => 'invite',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '2',
            ],
            'Featured Listings' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.index',
                'component' => 'featured',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '3',
            ],
            'Category' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.index',
                'component' => 'category',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '2',
            ],
            'Sponsored ' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.invoice',
                'component' => 'sponsored',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Users Invites ' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.invoice',
                'component' => 'invite',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '2',
            ],
            'Featured Listings ' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.invoice',
                'component' => 'featured',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '3',
            ],
            'Category ' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.invoice',
                'component' => 'category',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '2',
            ],
            'More From Seller' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.view',
                'component' => 'my',
                'location' => '3',
                'is_active' => '1',
                'ordering' => '1',
            ],
            'Categories' => [
                'type_id' => '0',
                'm_connection' => 'marketplace.view',
                'component' => 'category',
                'location' => '1',
                'is_active' => '1',
                'ordering' => '1',
            ]
        ];
    }

    protected function setPhrase()
    {
        $this->phrase = $this->_app_phrases;
    }

    protected function setOthers()
    {
        $this->admincp_route = '/marketplace/admincp';
        $this->admincp_menu = [
            _p('Manage Categories') => '#'
        ];
        $this->admincp_action_menu = [
            '/admincp/marketplace/add' => _p('New Category')
        ];
        $this->map = [];
        $this->menu = [
            'phrase_var_name' => 'menu_marketplace',
            'url' => 'marketplace',
            'icon' => 'usd'
        ];
        $this->database = [
            'Marketplace',
            'Marketplace_Text',
            'Marketplace_Image',
            'Marketplace_Category',
            'Marketplace_Category_Data',
            'Marketplace_Invite',
            'Marketplace_Invoice',
        ];
        $this->_apps_dir = 'core-marketplace';
        $this->_admin_cp_menu_ajax = false;
        $this->_publisher = 'phpFox';
        $this->_publisher_url = 'http://store.phpfox.com/';
        $this->_writable_dirs = [
            'PF.Base/file/pic/marketplace/'
        ];
    }
}