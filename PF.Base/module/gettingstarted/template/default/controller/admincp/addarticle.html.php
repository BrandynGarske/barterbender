<?php
/**
 *
 *
 * @copyright        [YouNet_COPYRIGHT]
 * @author           YouNet Company
 * @package          Module_GettingStarted
 * @version          2.01
 */
defined('PHPFOX') or exit('NO DICE!');
?>
{literal}
<style type="text/css">
    .error_message
    {
        margin: 5px 8px 0px 0px;
    }
    .global_attachment
    {
        position:relative;
        border-top:0px #dfdfdf solid;
    }

    .global_attachment_manage
    {
        line-height:26px;
        height:26px;
        padding:4px 0px 4px 0px;
        position:absolute;
        right:0px;
        display:none;
    }

    .global_attachment_manage a,
    .global_attachment_manage a:hover
    {
        display:block;
        line-height:26px;
        height:26px;
        text-decoration:none;
        padding:0px 5px 0px 5px;
    }

    .global_attachment_manage a.is_not_active,
    .global_attachment_manage a.is_not_active:hover
    {
        color:#808080;
    }

    .global_attachment_manage a:hover,
    .global_attachment_manage a.is_not_active:hover
    {
        background:#333;
        color:#fff;
    }

    .global_attachment ul.global_attachment_list
    {
        margin:0px;
        padding:0px;
        list-style-type:none;
    }

    .global_attachment ul.global_attachment_list li
    {
        float:left;
        line-height:26px;
        padding:4px 0px 4px 0px;
    }

    .global_attachment .global_attachment_title
    {
        color:#9F9F9F;
        margin-right:5px;
    }

    .global_attachment ul.global_attachment_list li a,
    .global_attachment ul.global_attachment_list li a:hover
    {
        display:block;
        line-height:26px;
        text-decoration:none;
        padding:0px 5px 0px 5px;
        border:1px #fff solid;
    }

    .global_attachment ul.global_attachment_list li a:hover
    {
        background:#D0D0D0;
    }

    .global_attachment ul.global_attachment_list li a.active
    {
        background:#5F5F5F;
        border:1px #000 solid;
        color:#fff;
    }

    .global_attachment_holder
    {
        margin-top:10px;
        border-bottom:1px #ccc solid;
        padding:0px 0px 10px 0px;
        display:none;
    }

    .global_attachment_holder_section
    {
        display:none;
    }

    div.global_attachment_sub_menu
    {
        margin:0px;
        padding:0px 0px 10px 0px;
    }

    div.global_attachment_sub_menu ul
    {
        margin:0px;
        padding:0px;
        list-style-type:none;
    }

    div.global_attachment_sub_menu ul li
    {
        float:left;
        margin-right:4px;
        line-height:22px;
        height:22px;
    }

    div.global_attachment_sub_menu ul li a,
    div.global_attachment_sub_menu ul li a:hover
    {
        background:#fff;
        color:#333;
        display:block;
        padding:0px 5px 0px 5px;
        line-height:22px;
        height:22px;
        border:1px #ccc solid;
        text-decoration:none;
        -moz-border-radius:6px;
        -webkit-border-radius:6px;
        border-radius:6px;
    }

    div.global_attachment_sub_menu ul li a.active
    {
        background:#5F5F5F;
        color:#fff;
    }

    .global_attachment_holder_title
    {
        border-bottom:1px #ccc solid;
        margin-bottom:10px;
        padding-bottom:5px;
        font-size:12px;
        font-weight:bold;
        position:relative;
    }

    a.global_attachment_holder_cancel,
    a.global_attachment_holder_cancel:hover
    {
        position:absolute;
        right:0px;
    }

    .attachment_image
    {
        float:left;
        width:140px;
        text-align:center;
    }

    .attachment_body
    {
        margin-left:140px;
    }

    .attachment_link_button
    {
        border-top:1px #DFDFDF solid;
        padding:8px 0px 0px 0px;
        margin:8px 0px 0px 0px;
        margin-left:140px;
    }

    a.attachment_body_title,
    a.attachment_body_title:hover
    {
        text-decoration:none;
        color:#333;
        font-weight:bold;
        font-size:12px;
    }

    div.attachment_body_link
    {
        color:#808080;
    }

    div.attachment_pager
    {
        margin:10px 0px 5px 0px;
    }

    div.attachment_pager ul
    {
        margin:0px;
        padding:0px;
        list-style-type:none;
    }

    div.attachment_pager ul li
    {
        display:block;
        float:left;
        line-height:20px;
    }

    div.attachment_pager ul li.counter
    {
        margin-left:5px;
    }

    div.attachment_pager ul li.counter span.small
    {
        color:#808080;
        padding-left:4px;
        font-size:9px;
    }

    div.attachment_pager ul li a,
    div.attachment_pager ul li a:hover
    {
        text-decoration:none;
        display:block;
        border:1px #7F7F7F solid;
        line-height:20px;
        overflow:hidden;
        text-indent:-1000px;
        width:28px;
    }

    div.attachment_pager ul li.no_link a
    {
        border:1px #ccc solid;
    }

    div.attachment_pager ul li a.first
    {
        border-right:0px;
    }

    div.attachment_pager ul li a.previous
    {
        background:url('../image/layout/attachment_pager.png') no-repeat;
    }

    div.attachment_pager ul li a.next
    {
        background:url('../image/layout/attachment_pager_next.png') no-repeat;
    }

    div.attachment_body label
    {
        vertical-align:middle;
    }

    div.attachment_body_description
    {
        margin-top:5px;
    }

    div.attachment_body_description a,
    div.attachment_body_description a:hover
    {
        text-decoration:none;
        color:#333;
    }

    a.attachment_body_title:hover,
    div.attachment_body_description a:hover:hover
    {
        background:#FFFF88;
    }

    div.attachment_pager ul li.no_link a.previous
    {
        cursor:default;
        background:url('../image/layout/attachment_pager.png') no-repeat 0px -20px;
    }

    div.attachment_pager ul li.no_link a.next
    {
        cursor:default;
        background:url('../image/layout/attachment_pager_next.png') no-repeat 0px -20px;
    }

    div.attachment_pager ul li a:active
    {
        background:#627AAD;
    }

    .js_upload_form_image_holder
    {
        display:none; border-bottom:1px #DFDFDF solid; padding:4px 0px 4px 0px; margin-bottom:6px; position:relative;
    }

    .js_upload_form_image_holder_image
    {
        position:absolute; right:4px;
    }

    .attachment_holder
    {
        border-bottom:1px #DFDFDF solid;
    }

    .attachment_header_holder
    {
        position:relative;
        height:30px;
        background:url('../image/layout/action_drop_down.png') no-repeat 10px 20px;
        margin-top:10px;
    }

    .attachment_header
    {
        background:#333;
        color:#DFDFDF;
        padding:5px 10px 5px 10px;
        position:absolute;
        left:0px;
        -moz-border-radius:8px;
        -webkit-border-radius:8px;
        border-radius:8px;
    }

    .attachment_row
    {
        padding:6px 0px 6px 0px;
    }

    .attachment_row_title
    {
        padding:0px 0px 6px 0px;
        color:#BFBFBF;
    }

    a.attachment_row_link,
    a.attachment_row_link:hover,
    span.attachment_row_link
    {
        font-weight:bold;
        font-size:11px;
        color:#333;
    }

    .attachment_inline_holder
    {
        border-top:1px #dfdfdf solid;
        border-bottom:1px #dfdfdf solid;
        margin:4px 0px 4px 0px;
        padding:10px 0px 10px 0px;
    }

    .play_link
    {
        position:relative;
    }

    .play_link_img
    {
        position:absolute;
        bottom:4px;
        left:2px;
        width:30px;
        height:22px;
        background:url('../image/layout/play.png') no-repeat;
        overflow:hidden;
        text-indent:-100px;
    }

    #global_attachment_list_inline
    {
        display:none; position:absolute; width: 500px; z-index:40000; background:#fff; border:1px #333 solid;
        -moz-box-shadow:6px 6px 6px #CFCFCF;
        -webkit-box-shadow:6px 6px 6px #CFCFCF;
        box-shadow:6px 6px 6px #CFCFCF;
    }

    #global_attachment_list_inline_holder
    {
        padding:8px;
    }

    #global_attachment_list_inline_close
    {
        background:#fff; padding:6px; border-top:1px #dfdfdf solid; text-align:right;
        background:#DFDFDF;
    }
    .emoticon_preview,
    .emoticon_preview:hover
    {
        border: 1px solid #F1F1F1;
        cursor: pointer;
        float: left;
        margin: 2px;
        padding: 5px 0;
        text-align: center;
        width: 14%;
    }

    .emoticon_preview:hover
    {
        background:#F9F9F9;
    }
</style>
{/literal}

{*{if count($scheduled_category)>0}*}
<form id="my_form" method="post" enctype="multipart/form-data" action="">
    <div class="panel panel-default">
        <div id ="test_inner" name="test_inner"></div>
        <div class="panel-heading">
            {if $isEdit}{phrase var='gettingstarted.edit_knowledge_base_article'}{else}{phrase var='gettingstarted.add_knowledge_base_article'}{/if}
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label>
                    {required}{phrase var='gettingstarted.language'}
                </label>
                <select id="language_id" class="form-control" name="val[language_id]" onchange="$.ajaxCall('gettingstarted.getCatSelectByLanguage', 'language_id='+this.value+'&name=val[article_category_id]'{if $isEdit}+'&selected={$art_for_edit.article_category_id}'{/if}, 'GET'); return false;" >
                    {foreach from=$aLanguages item=aLanguage}
                    <option value="{$aLanguage.language_id}" {if $art_for_edit.language_id == $aLanguage.language_id}selected{/if}>{$aLanguage.title}</option>
                    {/foreach}
                </select>
                <span id="loading"></span>
            </div>


            <div class="form-group">
                <label>{required}{phrase var='gettingstarted.title'}</label>
                <input type="text" name="val[title]" cols="30" rows="1" value="{$art_for_edit.title}" id="inner_title" class="form-control" />
            </div>


            <div class="form-group">
                <label>{phrase var="gettingstarted.category"}</label>
                <div id="categories_bylanguage">
                    {$aCats}
                    <span id="loading"></span>
                </div>
            </div>
            <div class="form-group">
                <label>
                    {required}{phrase var='gettingstarted.featured'}
                </label>
                <div id="is_featured">
                    <select  name="val[is_featured]" class="form-control">
                        <option value="0" {if $art_for_edit.is_featured == 0}selected{/if}>{phrase var='gettingstarted.unfeatured'}</option>
                        <option value="1" {if $art_for_edit.is_featured == 1}selected{/if}>{phrase var='gettingstarted.featured'}</option>
                    </select>
                    <span id="loading"></span>
                </div>
            </div>
            <div class="form-group">
                <label>
                    {required}{phrase var='gettingstarted.description'}
                </label>
                {editor id='description'}
            </div>
            <input type="hidden" id="language_hidden_id" />
        </div>


        <div class="panel-footer">
            <input type="submit" id="submit_addarticlecategory"name="submit_addarticlecategory" value="{phrase var='core.submit'}" class="btn btn-primary" />
        </div>
    </div>
</form>
{*{else}
<div class="p_4">
    {phrase var='gettingstarted.no_knowledge_base_categories_have_been_created'} <a href="{url link='admincp.gettingstarted.addarticlecategory'}">Create one now.</a>.
</div>
{/if}*}