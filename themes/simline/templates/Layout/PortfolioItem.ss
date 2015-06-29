		<%-- specific assets for this page type --%>
		$setCustomAssets(javascript/vendor/isotope/css/style.css, css, 0)
		$setCustomAssets(javascript/vendor/isotope/js/jquery.isotope.min.js, js, 0)
		$setCustomAssets(javascript/page/portfolio.js, js)
		
		<!-- Wrapper -->
		<div class="wrapper portfolio-page-wrapper">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="container">
					<div class="row">
						<% if $Images %>
						<div class="col-sm-6">
							<div class="portfolio-slideshow">
								<!-- Image Carousel -->
								<div data-ride="carousel" class="carousel slide" id="portfolio-slideshow">
									<% if $Images.Count > 1 %>
									<!-- Indicators -->
									<ol class="carousel-indicators">
										<% loop $Images %>
										<li class="<% if $First %>active<% end_if %>" data-slide-to="{$Pos(0)}" data-target="#portfolio-slideshow"></li>
										<% end_loop %>
									</ol>
									
									<!-- Controls -->
									<a data-slide="prev" href="#portfolio-slideshow" class="carousel-arrow carousel-arrow-prev">
										<i class="fa fa-angle-left"></i>
									</a>
									
									<a data-slide="next" href="#portfolio-slideshow" class="carousel-arrow carousel-arrow-next">
										<i class="fa fa-angle-right"></i>
									</a>
									<% end_if %>
									
									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<% loop $Images %>
										<div class="item <% if $First %>active<% end_if %>">
											<a href="{$URL}" class="swipebox-holder" data-swipebox="portfolio-item" title="{$Title.XML}">
												<img alt="{$Title.XML}" class="img-responsive" src="$CroppedFocusedImage(768,512).URL" />
											</a>
											
											<div class="carousel-caption">
												<h3><i class="fa fa-info-circle"></i> {$Title.XML}</h3>
											</div>
										</div>
										<% end_loop %>
									</div>
								</div>
							</div>
							<!-- end of .portfolio-slideshow -->
						</div>
						<% end_if %>
						
						<div class="col-sm-6">
							<h1 class="title-block second-child">
								<span><% if $PageHeading %>$PageHeading.XML<% else %>$Title.XML<% end_if %></span>
							</h1>
							
							<div class="clearfix typography">
								$Content
							</div>
							
							<% if $Attributes.isEnabled && $Attributes.Count %>
							<div class="clearfix portfolio-attribute pad-top-15">
								<h2 class="title-block first-child">
									<%t PortfolioSS.DETAILS "Project details" %>
								</h2>
								
								<table class="table">
									<tbody>
										<% if $Categories.Count %>
										<tr>
											<td>
												<% if $Categories.Count > 1 %>
													<%t PortfolioSS.CATEGORIES "Categories" %> 
												<% else %>
													<%t PortfolioSS.CATEGORIES "Category" %> 
												<% end_if %>
											</td>
											
											<td></td>
											
											<td>
												<% loop $Categories %>
													{$Title}<% if not $Last %>, <% end_if %>
												<% end_loop %>
											</td>
										</tr>
										<% end_if %>
										
										<% loop $Attributes.Items %>
										<tr>
											<td>$Name</td>
											
											<td></td>
											
											<td>$Value</td>
										</tr>
										<% end_loop %>
									</tbody>
								</table>
							</div>
							<% end_if %>
						</div>
					</div>
					<!-- / .row -->
					
					<!-- Feedback -->
					<% if $Testimonials.Count %>
					<div class="client-feedback-wrapper pad-top-15">
						<div class="row">
							<% loop $Testimonials %>
							<div class="col-sm-6">
								<div class="feedback">
									<div class="feedback-bubble match-height" data-match-height="feedback-bubble">
										<% if $Photo %>
											$Photo.CroppedFocusedImage(190,190)
										<% else %>
											<img src="//placehold.it/190" alt="{$Author}" />
										<% end_if %>
											
										<div class="text">
											<h3>$Title</h3> $Comment
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="text-right poster">
										$Author | $Company
									</div>
								</div>
							</div>
							<% end_loop %>
						</div><!-- / .row -->
					</div><!-- end of .client-feedback-wrapper -->
					<% end_if %>
					
					<% if $RelatedItems.Count %>
					<div class="row portfolio-related">
						<div class="col-sm-12">
							<h2 class="title-block"><%t PortfolioSS.RELATEDITEMS "Related works" %></h2>
							<hr class="title-hr" />
						</div>
						
						<% loop $RelatedItems %>
						<div class="col-sm-4">
							<% include PortfolioSingle %>
						</div>
						<% end_loop %>
					</div>
					<!-- / .portfolio-related -->
					<% end_if %>
				</div>
				<!-- end of .portfolio-item -->
			</div>
			<!-- end of #main-cn -->
		</div>