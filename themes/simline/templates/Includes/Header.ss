		
		<!-- Navigation -->
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
					<% if $ClassName = 'HomePage' %>
						<h1 class="navbar-heading">
							<a class="navbar-brand" href="{$BaseHref}">
								<img src="$ThemeDir/images/logo.png" alt="{$SiteConfig.Title}">
							</a>
						</h1>
					<% else %>
						<a class="navbar-brand" href="{$BaseHref}">
							<img src="$ThemeDir/images/logo.png" alt="{$SiteConfig.Title}">
						</a>
					<% end_if %>
				</div>
				
				<div class="collapse navbar-collapse">
					<% if $CurrentMember %>
					<a class="navbar-btn btn btn-blue pull-right hidden-sm hidden-xs" href="{$BaseHref}Security/logout">
						<% _t('HeaderSS.LOGOUT', 'Sign out') %>
					</a>
					<% else %>
					<a class="navbar-btn btn btn-blue pull-right hidden-sm hidden-xs" href="{$BaseHref}Security/login">
						<% _t('HeaderSS.LOGIN', 'Sign in') %>
					</a>
					<% end_if %>
					
					<% include MainNavigation %>
				</div>
				<!--/.nav-collapse -->
			</div>
		</div>
		<!-- / .navigation -->