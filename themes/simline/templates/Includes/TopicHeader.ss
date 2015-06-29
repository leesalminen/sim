<!-- Topic Header -->
<div class="topic">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<h3><% if $Query %> Search <% else %> $MenuTitle.XML <% end_if %></h3>
			</div>
			
			<div class="col-sm-8">
				<% if $Level(2) %>
					$Breadcrumbs
				<% else %>
				<ol class="breadcrumb pull-right hidden-xs">
					<li>
						<a href="{$BaseHref}" title="{$SiteConfig.Title}">Home</a>
					</li>
					
					<li class="active">
						<% if $Query %> Search <% else %> $MenuTitle.XML <% end_if %>
					</li>
				</ol>
			<% end_if %>
			</div>
		</div>
	</div>
</div>
<!-- end of .topic -->