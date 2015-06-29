<div class="{$wrapperClass}">
	<% if $link %>
		<a href="{$link}" class="{$classes}" <% if $newWindow %>target="_blank" <% end_if %><% if $noFollow %>rel="nofollow" <% end_if %>>
			<% if $iconClass %><i class="{$iconClass}"></i><% end_if %> $content
		</a>
	<% else %>
		<button class="{$classes}">
			<% if $iconClass %><i class="{$iconClass}"></i><% end_if %> $content
		</button>
	<% end_if %>
</div>