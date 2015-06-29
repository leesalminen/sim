<% if $Pages %>
	<ol class="breadcrumb pull-right hidden-xs">
		<li>
			<a href="{$BaseHref}" title="{$SiteConfig.Title}">Home</a>
		</li>
		
	<% loop $Pages %>
		<% if $Last %>
			<li class="active">
				$MenuTitle.XML
			</li>
		<% else %>
			<li>
				<a href="$Link" class="breadcrumb-$Pos" title="{$Title.XML}">
					$MenuTitle.XML
				</a>
			</li>
		<% end_if %>
	<% end_loop %>
	</ol>
<% end_if %>