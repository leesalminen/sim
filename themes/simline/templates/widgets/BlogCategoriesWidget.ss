<% if $Categories %>
	<ul class="categories">
		<% loop $Categories %>
			<li>
				<a href="$Link" title="$Title">
					$Title
				</a>
			</li>
		<% end_loop %>
	</ul>
<% end_if %>