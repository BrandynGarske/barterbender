<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright      YouNet Company
 * @author         LyTK
 * @package        Module_ProfilePopup
 * @version        3.01
 */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>
<script type="text/javascript">
{literal}
        $Behavior.ynppInitUser = function()
        {
                $('#update').click(function(event)
                {
                        event.preventDefault();
                        if($('#public_message'))
                        {
                                $('#public_message').remove();
                        }
                        if($('#core_js_messages'))
                        {
                                $('#core_js_messages').html('');
                        }
                        $('#update').ajaxCall('profilepopup.updateGlobalSettings', '&item_type=user' + '&' + $('#globalSettings').serialize());
                }); 
                
                $('.checkbox').change(function(){
                        var sIdName = '#js_row' + $(this).get(0).id.replace('js_id_row', '');
                        if ($(sIdName).hasClass('is_checked'))
                        {
                                $(sIdName).removeClass('is_checked');
                        }
                        $('.sJsCheckBoxButton').removeClass('disabled');
                        $('.sJsCheckBoxButton').attr('disabled', false); 
                });
                $("#js_check_box_all_basic").change(function(){
                        $('.checkRow .basic').removeClass('is_checked');
                        $('.sJsCheckBoxButton').removeClass('disabled');
                        $('.sJsCheckBoxButton').attr('disabled', false); 
                });
                $("#js_check_box_all_resume").change(function(){
                        $('.checkRow .resume').removeClass('is_checked');
                        $('.sJsCheckBoxButton').removeClass('disabled');
                        $('.sJsCheckBoxButton').attr('disabled', false); 
                });
                
				$("#js_check_box_all_basic").click(function()
				{
					var bStatus = this.checked;
					if (bStatus)
					{
						$('.checkRow .ynpp_basic').addClass('is_checked');
						$('.sJsCheckBoxButton').removeClass('disabled');
						$('.sJsCheckBoxButton').attr('disabled', false);
					}
					else
					{
						$('.checkRow .ynpp_basic').removeClass('is_checked');
						$('.sJsCheckBoxButton').addClass('disabled');
						$('.sJsCheckBoxButton').attr('disabled', true);
					}
					$(".checkRow .ynpp_basic").each(function()
					{
						this.checked = bStatus;
					});
				});                
				$("#js_check_box_all_resume").click(function()
				{
					var bStatus = this.checked;
					if (bStatus)
					{
						$('.checkRow .ynpp_resume').addClass('is_checked');
						$('.sJsCheckBoxButton').removeClass('disabled');
						$('.sJsCheckBoxButton').attr('disabled', false);
					}
					else
					{
						$('.checkRow .ynpp_resume').removeClass('is_checked');
						$('.sJsCheckBoxButton').addClass('disabled');
						$('.sJsCheckBoxButton').attr('disabled', true);
					}
					$(".checkRow .ynpp_resume").each(function()
					{
						this.checked = bStatus;
					});
				});                
        };
{/literal}
</script>
<style type="text/css">
        {literal}
        {/literal}
</style>

{if count($aAllItems)}
    <div class="panel panel-default">
        <form id="globalSettings" method="post" action="{url link='admincp.profilepopup.user'}">
    		<div class="panel-heading">
                <div class="panel-title">
                    <div class="p_4"><span style="font-weight: bold; text-decoration: underline; font-size: 15px;">{phrase var='profilepopup.notice'}</span>: {phrase var='profilepopup.global_settings_info'}</div>
                </div>
			</div>
            <div class="panel-heading">
                <div class="panel-title">
				    {phrase var='profilepopup.basic_information'}:
                </div>
			</div>
            <div class="panel-body">
                <div class="table-responsive flex-sortable">
                    <table id="js_drag_drop" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{phrase var='profilepopup.field_label'}</th>
                            <th style="width:10px;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all_basic" class="main_checkbox" /></th>
                            <th>{phrase var='profilepopup.global_settings_ordering'}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$aAllItems key=iKey item=aItem}
                        <tr id="js_row{$aItem.item_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
                            <td width="470px">{$aItem.lang_name}</td>
                            <td><input type="checkbox" name="display[]" class="checkbox ynpp_basic" {$aItem.checked} value="{$aItem.item_id}" id="js_id_row{$aItem.item_id}" /></td>
                            <td>
                                {if $aItem.name != 'cover_photo'}
                                <input type="text" name="ordering[]" value="{$aItem.ordering}" id="ordering[]" size="5" maxlength="5" style="text-align: center;" />
                                <input type="hidden" name="id[]" value="{$aItem.item_id}" />
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
            
			<!-- Resume -->
            <div class="panel-heading">
                <div class="panel-title">
                    {phrase var='profilepopup.resume_fields'}:
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive flex-sortable">
                    <table id="js_drag_drop" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{phrase var='profilepopup.field_label'}</th>
                            <th style="width:10px;"><input type="checkbox" name="val[id_resume]" value="" id="js_check_box_all_resume" class="main_checkbox" /></th>
                            <th>{phrase var='profilepopup.global_settings_ordering'}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$aResumeItems key=iKey item=aItem}
                        <tr id="js_row{$aItem.item_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
                            <td width="470px">{$aItem.lang_name}</td>
                            <td><input type="checkbox" name="display_resume[]" class="checkbox ynpp_resume" {$aItem.checked} value="{$aItem.item_id}" id="js_id_row{$aItem.item_id}" /></td>
                            <td>
                                <input type="text" name="ordering_resume[]" value="{$aItem.ordering}" id="ordering[]" size="5" maxlength="5" style="text-align: center;" />
                                <input type="hidden" name="id_resume[]" value="{$aItem.item_id}" />
                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>

<!-- 			End -->
            <div class="panel-footer">
                <input type="button" id="update" name="update" value="{phrase var='profilepopup.global_settings_update'}" class="btn btn-primary sJsCheckBoxButton" />
            </div>
        </form>
    </div>
{else}
        <div class="p_4">
                {phrase var='profilepopup.no_user_global_settings'}
        </div>
{/if}
