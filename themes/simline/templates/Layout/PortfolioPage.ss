		<%-- specific assets for this page type --%>
		$setCustomAssets(javascript/vendor/isotope/css/style.css, css, 0)
		$setCustomAssets(javascript/vendor/isotope/js/jquery.isotope.min.js, js, 0)
		$setCustomAssets(javascript/page/portfolio.js, js)
		
		<!-- Wrapper -->
		<div class="wrapper portfolio-page-wrapper">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="row primary-heading">
					<div class="col-sm-12">
						<h1 class="title-lg first-child">
							<span><% if $PageHeading %>$PageHeading.XML<% else %>$Title.XML<% end_if %></span>
						</h1>
					</div>
				</div><!-- end of .primary-heading -->
				
				<div class="row primary-content">
					<div class="col-sm-12">
						<div class="typography">
							$Content
						</div>
					</div>
				</div><!-- end of .primary-content -->
				
				<% if $Children %>
				<div class="portfolio-holder clearfix pad-top-25">
					<% if $Categories %>
					<div class="row portfolio-filter">
						<div class="col-sm-12">
							<ul id="filters" class="list-inline text-center">
								<li><a href="#" class="btn-glass" data-filter="*"><%t PortfolioSS.ALL "Show all" %></a></li>
								
								<% loop $Categories %>
									<li><a href="#" class="btn-glass" data-filter=".category_{$ID}">$Title</a></li>
								<% end_loop %>
							</ul>
						</div>
					</div>
					<!-- / .portfolio-filter -->
					<% end_if %>
					
					<div class="row" id="isotope-container">
						<% loop $Children %>
						<div class="col-sm-6 col-md-4 isotope-item <% if $Categories %><% loop $Categories %>category_{$ID} <% end_loop %><% end_if %>">
							<% include PortfolioSingle %>
						</div>
						<% end_loop %>
					</div>
					<!-- / .row -->
				</div>
				<!-- end of .portfolio-holder -->
				<% end_if %>
			</div>
			<!-- end of #main-cn -->
		</div>