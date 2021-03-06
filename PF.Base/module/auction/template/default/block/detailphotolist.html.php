<div class="ynauction-content-photo">
	<div class="ynauction-content-header">
	    <a {if $hidden_select == 'photos'}class="active"{/if} href="{$sLink}">
	    	<div>
				{$iCountPhotos} <span>{phrase var='photo_s'}</span>
			</div>		    
	    </a>

	    <a {if $hidden_select == 'albums'}class="active"{/if} href="{$sLink}albums/">
	    	<div>
				{$iCountAlbums} <span>{phrase var='album_s'}</span>
			</div> 
	    </a>
	</div>
	{if $hidden_select == 'albums'}
		<div class="ynauction-album-list">
			{if count($aAlbums) < 1}
				<div class="extra_info">
					{phrase var='no_item_s_found'}.
				</div>
			{/if}

			<div class="ynauction-content-column3">			
			{foreach from=$aAlbums item=aAlbum name=albums}
				<div class="ynauction-album-item">
					<div class="ynauction-album-item-image">
						<div class="ynauction-album-item-border-1"></div>
						<div class="ynauction-album-item-border-2"></div>
						<div class="ynauction-album-item-border-3"></div>
						<a href="{$aAlbum.link}" 
						    title="{phrase var='photo.name_by_full_name' name=$aAlbum.name|clean full_name=$aAlbum.full_name|clean}" 
						    id="js_album_inner_title_link_{$aAlbum.album_id}"
						    style="background-image:url('{img server_id=$aAlbum.server_id path='photo.url_photo' file=$aAlbum.destination suffix='' max_width=196 max_height=196 return_url=true}'); background-size: cover; display: block; "
						    class="album_a_img_holder {if Phpfox::getParam('photo.show_info_on_mouseover')}photo_clip_holder_big{/if}"
						    >
						</a>

					</div>
					<div class="ynauction-album-item-content">
						<a href="{permalink module='photo.album' id=$aAlbum.album_id title=$aAlbum.name}" id="js_album_inner_title_{$aAlbum.album_id}" class="row_sub_link">{$aAlbum.name|clean|shorten:150:'...'|split:40}</a>	
						<div class="extra_info">
							{if !empty($aAlbum.total_photo)}
								{if $aAlbum.total_photo == '1'}
								<p>1 photo</p>
								{else}
								<p>{$aAlbum.total_photo|number_format} photos</p>
								{/if}
							{/if}
							{if !defined('PHPFOX_IS_USER_PROFILE')}	
								<p>{$aAlbum|user:'':'':50|split:10}</p>
							{/if}
						</div>					
					</div>					
				</div>
			{/foreach}
			</div>

			<div class="clear"></div>
			{module name='auction.paging'}			
		</div>
	{else}
		<div class="ynauction-photo-list">		
			{if count($aPhotos) < 1}
				<div class="extra_info">
					{phrase var='no_item_s_found'}.
				</div>
			{/if}

			<div class="ynauction-content-column3">
			{foreach from=$aPhotos item=aPhoto name=photos}
				<div class="ynauction-photo-item">
					<div class="ynauction-photo-item-image">
						<a href="{$aPhoto.link}{if isset($iForceAlbumId)}albumid_{$iForceAlbumId}/{/if}{if isset($sPhotoCategory)}category_{$sPhotoCategory}/{/if}" title="{$aPhoto.title}" class="photo_set_cover_small">
							<span class="ynauction-photo-span" style="background-image: url({img return_url=true server_id=$aPhoto.server_id path='photo.url_photo' file=$aPhoto.destination suffix='' max_width=150 max_height=150 title=$aPhoto.title});"></span>
						</a>
					</div>
					<div class="ynauction-item-info extra_info_link">
						<p>{phrase var='photo.by_user_info' user_info=$aPhoto|user|shorten:30:'...'|split:20}</p>
						{if !empty($aPhoto.album_name)}
							<p>{phrase var='photo.in'} <a href="{permalink module='photo.album' id=$aPhoto.album_id title=$aPhoto.album_name}" title="{$aPhoto.album_name|clean}">{if $aPhoto.album_profile_id > 0}{phrase var='photo.profile_pictures'}{else}{$aPhoto.album_name|clean|shorten:45:'...'|split:20}{/if}</a></p>
						{/if}
					</div>					
				</div>
			{/foreach}
			</div>

			<div class="clear"></div>
			{module name='auction.paging'}
			
		</div>
	{/if}
</div>

