<?php
defined('PHPFOX') or exit('NO DICE!');
?>
<form method="get" action="{url link='admincp.ad.sponsor'}">
	<div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">{_p var='search_sponsorship'}</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{_p var='date_from'}</label>
                        {select_date start_year='2000' end_year='+100' prefix='from_' name='search'}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{_p var='date_to'}</label>
                        {select_date start_year='2000' end_year='+100' prefix='to_' name='search'}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ad_name">{_p var='ad_name'}</label>
                        <input type="text" class="form-control" name="search[ad_name]" id="ad_name" value="{value type='input' id='ad_name'}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="creator">{_p var='creator'}</label>
                        <input type="text" class="form-control" name="search[creator]" id="creator" value="{value type='input' id='creator'}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">{_p var='status'}</label>
                        <select name="search[status]" class="form-control" id="status">
                            <option value="0" {value type='select' id='status' default="0"}>{_p var='all_status'}</option>
                            <option value="upcoming" {value type='select' id='status' default='upcoming'}>{_p var='upcoming'}</option>
                            <option value="running" {value type='select' id='status' default='running'}>{_p var='running'}</option>
                            <option value="5" {value type='select' id='status' default='5'}>{_p var='completed'}</option>
                            <option value="ended" {value type='select' id='status' default='ended'}>{_p var='ended'}</option>
                            <option value="2" {value type='select' id='status' default='2'}>{_p var='pending'}</option>
                            <option value="1" {value type='select' id='status' default='1'}>{_p var='unpaid'}</option>
                            <option value="4" {value type='select' id='status' default='4'}>{_p var='denied'}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="active">{_p var='better_ads_active'}</label>
                        <select name="search[active]" class="form-control" id="active">
                            <option value="-1" {value type='select' id='active' default="-1"}>{_p var='any'}</option>
                            <option value="1" {value type='select' id='active' default='1'}>{_p var='better_ads_active'}</option>
                            <option value="0" {value type='select' id='active' default='0'}>{_p var='better_ads_inactive'}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" name="search[submit]" class="btn btn-primary"><i class="fa fa-search"></i> {_p var='search'}</button>
            <a href="{url link='admincp.ad.sponsor'}" class="btn btn-default">{_p var='reset'}</a>
        </div>
    </div>
</form>

{if $iPendingCount > 0 && empty($bViewingPending)}
<div class="alert alert-warning">
	{_p var='there_are_pending_sponsorships_that_require_your_attention_view_all_pending_sponsorships_a_href_link_here_a' number=$iPendingCount link=$sPendingLink}
</div>
{/if}
{if count($aAds)}
<form method="post" action="{url link='admincp.ad.sponsor'}" id="manage_ads_form">
    <div class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-admin">
                <tr>
                    <th class="w20">
                        <div class="custom-checkbox-wrapper">
                            <label>
                                <input type="checkbox" name="val[id][]" value="" id="js_check_box_all" class="main_checkbox" />
                                <span class="custom-checkbox"></span>
                            </label>
                        </div>
                    </th>
                    <th style="width:35px;">{_p var='better_ads_id'}</th>
                    <th {table_sort asc="s.start_date asc" desc="s.start_date desc" current=$sCurrentSort query="sort"}>{_p var='start_date'}</th>
                    <th>{_p var='ad_name'}</th>
                    <th>{_p var='better_ads_status'}</th>
                    <th>{_p var='creator'}</th>
                    <th>{_p var='type'}</th>
                    <th {table_sort class="t_center" asc="s.total_view asc" desc="s.total_view desc" current=$sCurrentSort query="sort"}>{_p var='better_ads_views'}</th>
                    <th {table_sort class="t_center" asc="s.total_click asc" desc="s.total_click desc" current=$sCurrentSort query="sort"}>{_p var='better_ads_clicks'}</th>
                    <th style="width:50px;">{_p var='better_ads_active'}</th>
                    <th class="w100 t_center">{_p var='settings'}</th>
                </tr>
                {foreach from=$aAds key=iKey item=aAd}
                <tr class="{if is_int($iKey/2)} tr{else}{/if}{if $aAd.is_custom && $aAd.is_custom == '2'} is_checked{/if}">
                    <td class="t_center">
                        <div class="custom-checkbox-wrapper">
                            <label>
                                <input type="checkbox" name="val[id][]" class="checkbox" value="{$aAd.sponsor_id}" id="js_id_row{$aAd.sponsor_id}" />
                                <span class="custom-checkbox"></span>
                            </label>
                        </div>
                    </td>
                    <td class="t_center">{$aAd.sponsor_id}</td>
                    <td>{$aAd.start}</td>
                    <td style="max-width:300px"><a href="{url link='ad.sponsor' view=$aAd.sponsor_id}">{$aAd.campaign_name|clean|convert}</a></td>
                    <td style="white-space: nowrap">{$aAd.status}</td>
                    <td><a href="{url link=''$aAd.user_name'}">{$aAd|user}</a></td>
                    <td>{$aAd.type}</td>
                    <td class="t_center">{$aAd.count_view|intval}</td>
                    <td class="t_center">{$aAd.count_click|intval}</td>
                    <td class="t_center">
                        {if $aAd.is_custom == '2' || $aAd.is_custom == '1'}
                            {_p var='n_a'}
                        {else}
                        <div class="js_item_is_active"{if !$aAd.is_active} style="display:none;"{/if}>
                            <a href="#?call=ad.updateSponsorActivity&amp;id={$aAd.sponsor_id}&amp;active=0" class="js_item_active_link" title="{_p var='deactivate'}"></a>
                        </div>
                        <div class="js_item_is_not_active"{if $aAd.is_active} style="display:none;"{/if}>
                            <a href="#?call=ad.updateSponsorActivity&amp;id={$aAd.sponsor_id}&amp;active=1" class="js_item_active_link" title="{_p var='activate'}"></a>
                        </div>
                    {/if}
                    </td>
                    <td class="t_center">
                        <a role="button" class="js_drop_down_link" title="{_p var='better_ads_manage'}"></a>
                        <div class="link_menu">
                            <ul class="dropdown-menu dropdown-menu-right">
                                {if $aAd.is_custom == '2' || $aAd.is_custom == '4'}
                                <li><a href="{url link='admincp.ad.sponsor' approve=$aAd.sponsor_id}">{_p var='better_ads_approve'}</a></li>
                                {/if}
                                {if $aAd.is_custom == '2'}
                                <li><a href="{url link='admincp.ad.sponsor' deny=$aAd.sponsor_id}" class="sJsConfirm" data-message="{_p var='are_you_sure_you_want_to_deny_this_sponsorship'}">{_p var='better_ads_deny'}</a></li>
                                {/if}
                                <li><a href="{url link='admincp.ad.sponsor' delete=$aAd.sponsor_id}" class="sJsConfirm" data-message="{_p var='are_you_sure_you_want_to_delete_this_sponsorship_permanently'}">{_p var='better_ads_delete'}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </table>
        </div>
    </div>
    <div class="table_hover_action hide">
        <a role="button" class="btn btn-primary sJsCheckBoxButton disabled" disabled="disabled" onclick="$Core.Ads.confirmSubmitForm(this, '#manage_ads_form')" data-action="approve">{_p var='approve_selected'}</a>
        <a role="button" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled" onclick="$Core.Ads.confirmSubmitForm(this, '#manage_ads_form')" data-action="deny">{_p var='deny_selected'}</a>
        <a role="button" class="btn btn-danger sJsCheckBoxButton disabled" disabled="disabled" onclick="$Core.Ads.confirmSubmitForm(this, '#manage_ads_form')" data-action="delete">{_p var='delete_selected'}</a>
    </div>
</form>
{else}
<div class="alert alert-info">
    {_p var='no_sponsorship_found'}
</div>
{/if}
{pager}