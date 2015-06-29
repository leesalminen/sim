<% if $wgBlogEntries %>
<div class="top-stories">
	<% loop $wgBlogEntries %>
	<div class="item">
		<% if $FeaturedImage %>
			$FeaturedImage.CroppedFocusedImage(50,50)
		<% else %>
			<img src="//placehold.it/50" alt="{$Title}" />
		<% end_if %>
		
		<div class="text">
			<h3>
				<a href="$Link" title="$Title.XML">
					$MenuTitle.XML
				</a>
			</h3>
			
			<%t Blog.By "by" %>
			
			<% if $Authors %>
				<% loop $Authors %>
					<a href="{$BlogAuthorLink}">$Name.XML</a><% if not $Last %>, <% end_if %>
				<% end_loop %>
			<% end_if %>	
		</div>
	</div>
	<% end_loop %>
</div>
<% end_if %>