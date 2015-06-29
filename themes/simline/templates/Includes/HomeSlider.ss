			<% if $BannerSliders.Count %>
			<!-- Home Slider -->
			<div class="home-slider">
				<!-- Carousel -->
				<div id="home-slider" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<% loop $BannerSliders %>
							<li data-target="#home-slider" data-slide-to="{$Pos(0)}" class="<% if $First %>active<% end_if %>"></li>
						<% end_loop %>
					</ol>
					
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<% loop $BannerSliders %>
						<!-- Single slide -->
						<div class="item <% if $First %>active<% end_if %>" id="item-{$Pos}">
							<div class="container">
								<div class="row">
									<div class="col-sm-6 text-{$Align}">
										<% if $Lists.isEnabled && $Lists.Count %>
											<div class="key-features">
												<% loop $Lists.getItems %>
												<span class="animated g-delay_{$Pos} {$HTMLClass}">
													<% if $IconClass %><i class="{$IconClass}"></i><% end_if %>
													
													$Text
												</span> <% if not $Last %><br /><% end_if %>
												<% end_loop %>
											</div>
										<% else %>
											<div class="fully-responsive">
												<% if Title %>
												<h3 class="fully-responsive__title animated slideInDown g-delay_1">
													$Title
												</h3>
												<% end_if %>
												
												<% if SubTitle %>
												<div class="fully-responsive__text animated slideInDown g-delay_2">
													$SubTitle
												</div>
												<% end_if %>
												
												<% if $Content %>
												<p class="animated fadeInUp g-delay_5">
													$Content.XML
												</p>
												<% end_if %>
												
												<% if $Buttons.isEnabled && $Buttons.Count %>
												<div class="fully-responsive__btns">
													<% loop $Buttons.getItems %>
													<a href="{$Link}" title="{$Text.XML}" class="btn btn-lg fully-responsive-btns__btn animated g-delay_{$Pos(5)} {$HTMLClass}"
													<% if $LinkBehaviour == 3 %>
													target="_blank" rel="nofollow"
													<% else_if $LinkBehaviour == 2 %>
													rel="nofollow"
													<% else_if $LinkBehaviour == 1 %>
													target="_blank"
													<% end_if %>
													>
														<% if $IconClass %><i class="{$IconClass}"></i><% end_if %>
														
														$Text
													</a>
													<% end_loop %>
												</div>
												<% end_if %>
											</div>
										<% end_if %>
									</div>
								</div>
								<!-- / .row -->
							</div>
							<!-- / .container -->
							
							<% if Image %>
							<div class="bg-img hidden-xs">
								$Image
							</div>
							<% end_if %>
						</div>
						<!-- / .item -->
						<% end_loop %>
					</div>
					<!-- / .carousel -->
					
					<!-- Controls -->
					<a class="carousel-arrow carousel-arrow-prev" href="#home-slider" data-slide="prev">
						<i class="fa fa-angle-left"></i>
					</a>
					<a class="carousel-arrow carousel-arrow-next" href="#home-slider" data-slide="next">
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</div>
			<!-- / .home-slider -->
			<% end_if %>