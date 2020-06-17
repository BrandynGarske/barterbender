<?php
/**
 * Created by PhpStorm.
 * User: thanhnc
 * Date: 13/02/2017
 * Time: 23:46
 */
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<!-- This is a WordPress eXtended RSS file generated by WordPress as an export of your blog. -->
<!-- It contains information about your blog's posts, comments, and categories. -->
<!-- You may use this file to transfer that content from one site to another. -->
<!-- This file is not intended to serve as a complete backup of your blog. -->
<!-- To import this information into a WordPress blog follow these steps. -->
<!-- 1. Log in to that blog as an administrator. -->
<!-- 2. Go to Tools: Import in the blog's admin panels (or Manage: Import in older versions of WordPress). -->
<!-- 3. Choose "WordPress" from the list. -->
<!-- 4. Upload this file using the form provided on that page. -->
<!-- 5. You will first be asked to map the authors in this export file to users -->
<!--    on the blog.  For each author, you may choose to map to an -->
<!--    existing user on the blog or to create a new user -->
<!-- 6. WordPress will then import each of the posts, comments, and categories -->
<!--    contained in this file into your blog -->
<!-- generator="WordPress.com" created="2011-04-26 08:16"-->
<rss version="2.0"
     xmlns:excerpt="http://wordpress.org/export/1.0/excerpt/"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:wp="http://wordpress.org/export/1.0/"
>
    <channel>
        <title><?php echo _p('site_name_s_blogs', ['site_name' => Phpfox::getParam('core.site_title')])?></title>
        <link><?php echo Phpfox::getLib('url')->makeUrl('ynblog');?></link>
        <description>{_p('Just another WordPress.com site')}</description>
        <pubDate><?php echo PHPFOX_TIME ?></pubDate>
        <generator><?php echo "//".$_SERVER['HTTP_HOST']?></generator>
        <language>en</language>
        <wp:wxr_version>1.0</wp:wxr_version>
        <wp:base_site_url><?php echo "//".$_SERVER['HTTP_HOST']?></wp:base_site_url>
        <wp:base_blog_url><?php echo Phpfox::getLib('url')->makeUrl('ynblog');?></wp:base_blog_url>
        <wp:category><wp:category_nicename></wp:category_nicename><wp:category_parent></wp:category_parent><wp:cat_name><![CDATA[]]></wp:cat_name></wp:category>
        {foreach from=$aItems item=aItem}
            <item>
                <title>{$aItem.title|clean}</title>
                <link>{permalink module='ynblog' id=$aItem.blog_id title=$aItem.title|clean}</link>
                <pubDate>{$aItem.time_stamp|date}</pubDate>
                <dc:creator><![CDATA[{$aItem|user}]]></dc:creator>
                <category><![CDATA[]]></category>
                <category domain="category" nicename=""><![CDATA[]]></category>
                <guid isPermaLink="false">{permalink module='ynblog' id=$aItem.blog_id title=$aItem.title|clean}</guid>
                <description></description>
                <content:encoded><![CDATA[{$aItem.text}]]></content:encoded>
                <excerpt:encoded><![CDATA[]]></excerpt:encoded>
                <wp:post_id>{$aItem.blog_id}</wp:post_id>
                <wp:post_date>{$aItem.time_stamp|date}</wp:post_date>
                <wp:post_date_gmt>{$aItem.time_stamp|date}</wp:post_date_gmt>
                <wp:comment_status>open</wp:comment_status>
                <wp:ping_status>open</wp:ping_status>
                <wp:post_name>{$aItem.title|clean}</wp:post_name>
                <wp:status>publish</wp:status>
                <wp:post_parent>0</wp:post_parent>
                <wp:menu_order>0</wp:menu_order>
                <wp:post_type>post</wp:post_type>
                <wp:post_password></wp:post_password>
                <wp:is_sticky>0</wp:is_sticky>
            </item>
        {/foreach}
    </channel>
</rss>
