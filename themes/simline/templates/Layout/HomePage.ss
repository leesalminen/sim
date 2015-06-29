		<%-- specific assets for this page type --%>
		$setCustomAssets(javascript/page/index.js, js)
		
		<!-- Wrapper -->
		<div class="wrapper">
			
			<% include HomeSlider %>
			
			<div class="container">
				<% if BoxEnable && Boxes %>
				<div class="hp-boxes">
					<% if BoxHeading %>
					<div class="row features-block-heading">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$BoxHeading</span></h2>
						</div>
					</div>
					<!-- / .features-block-heading -->
					<% end_if %>
					
					<div class="row features-block">
						<% loop $Boxes %>
						<div class="col-md-4 col-sm-6">
							<div class="feature">
								<% if Title %>
								<h3>
									<% if HTMLClass %><i class="{$HTMLClass}"></i><% end_if %>
									
									<% if $LinkTo %>
										<a href="{$LinkTo}" title="$Title.XML"
											<% if $LinkBehaviour == 3 %>
											target="_blank" rel="nofollow"
											<% else_if $LinkBehaviour == 2 %>
											rel="nofollow"
											<% else_if $LinkBehaviour == 1 %>
											target="_blank"
											<% end_if %>
										>
											$Title.XML
										</a>
									<% else %>
										<span>
											$Title.XML
										</span>
									<% end_if %>
								</h3>
								<% end_if %>
								
								<p>
									$Content.XML
								</p>
							</div>
						</div>
						<% end_loop %>
					</div>
				</div>
				<!-- end of .hp-boxes -->
				<% end_if %>
				
				<% if PortfolioItems %>
					<% if PortfolioHeading %>
					<div class="row portfolio-block-heading">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$PortfolioHeading</span></h2>
						</div>
					</div>
					<!-- / .portfolio-block-heading -->
					<% end_if %>
					
					<div class="row portfolio-block">
						<% loop $PortfolioItems %>
						<div class="<% if $Pos < 3 %>col-md-6 col-sm-12<% else %>col-md-4 col-sm-6<% end_if %>">
							<% include PortfolioSingle %>
						</div>
						<% end_loop %>
					</div>
					<!-- / .portfolio-block -->
				<% end_if %>
				
				<% include Timeline %>
			</div>
			<!-- / .container -->
			
			<% if $TestimonialEnable && $Testimonials.Count %>
			<!-- Client Feedback -->
			<div class="feedback-block">
				<div class="container">
					<% if TestimonialHeading %>
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$TestimonialHeading</span></h2>
						</div>
					</div>
					<% end_if %>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<% loop $Testimonials.Limit(3) %>
								<div class="feedback-quote <% if First %>show<% else %>hidden<% end_if %>" id="quote-{$Pos}">
									$Comment
								</div>
								<% end_loop %>
							</div>
							<div class="row">
								<% loop $Testimonials.Limit(3) %>
								<div class="col-sm-4">
									<div class="feedback-author <% if First %>active<% end_if %>" data-quote="#quote-{$Pos}">
										
										<% if $Photo %>
											$Photo.CroppedFocusedImage(190,190)
										<% else %>
											<img src="//placehold.it/190" alt="{$Author}" />
										<% end_if %>
										
										<div class="info">
											<h4>$Author</h4>
											<p>$Company</p>
										</div>
									</div>
								</div>
								<% end_loop %>
							</div>
						</div>
					</div>
					<!-- / .row -->
				</div>
				<!-- / .container -->
			</div>
			<!-- / .feedback-block -->
			<% end_if %>
			
			<!-- Team Persons -->
			<div class="container">
				<% if $TeamEnable && $TeamPersons.Count %>
					<% if $TeamHeading %>
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$TeamHeading</span></h2>
						</div>
					</div>
					<!-- / .row -->
					<% end_if %>
					
					<div class="row">
						<% loop $TeamPersons %>
						<div class="col-sm-4">
							<div class="team-member">
								<div class="team-picture shadow-effect">
									<img class="img-responsive" src="{$Photo.URL}" alt="{$Name}">
								</div>
								
								<h5 class="text-center">$Name <span class="text-red">/ $JobTitle</span></h5>
								
								<p class="text-muted text-center">
									$Bio.XML
								</p>
							</div>
						</div>
						<% end_loop %>
					</div>
					<!-- / .row -->
				<% end_if %>
				
				<!-- Purchase Button -->
				<div class="row">
					<div class="col-sm-12 col-md-8 col-md-offset-2">
						<hr class="hr-gradient" />
						
						<div class="main-content typography">
							$Content
						</div>
					</div>
				</div>
				<!-- . /row -->
			</div>
			<!-- / .container -->
		</div>
		<!-- / .wrapper -->