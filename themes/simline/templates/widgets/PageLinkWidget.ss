<% if $Pages %>
<ul class="links">
	<% loop $Pages %>
	<li class="{$LinkingMode}">
		<a href="{$Link}" title="{$Title.XML}">
			$MenuTitle.XML
		</a>
	</li>
	<% end_loop %>
</ul>
<% end_if %>