				<% if TimelineEvents %>
				<div class="timeline-section">
					<% if TimelineHeading %>
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$TimelineHeading</span></h2>
						</div>
					</div>
					<% end_if %>
					
					<div class="row">
						<div class="col-sm-12 timeline-wrapper">
							<% loop $TimelineEvents %>
							<ul class="timeline">
								<li class="year">
									<span>$Year</span>
								</li>
								<li></li>
								
								<% loop $Events %>
								<li class="event">
									<h3>
										<a href="{$Link}" title="{$Title.XML}">$Title.XML</a>
									</h3>
									
									<time datetime="{$Date.Format(Y-m-d)}">
										{$Date.Format(M d)}, $Up.Year
									</time>
									
									<p class="event-description">
										<% if Images.First %>
											<% loop $Images.First %>
												<img alt="{$Title.XML}" src="{$CroppedFocusedImage(1024,683).URL}" class="img-responsive" />
											<% end_loop %>
										<% end_if %>
										
										$ShortDescription.XML
									</p>
									
									<% if Links.isEnabled && Links.Count %>
									<div class="event-links">
										<% loop Links.getItems %>
											<a href="{$Link}" title="{$Text}" class="{$HTMLClass}"
												<% if $LinkBehaviour == 3 %>
												target="_blank" rel="nofollow"
												<% else_if $LinkBehaviour == 2 %>
												rel="nofollow"
												<% else_if $LinkBehaviour == 1 %>
												target="_blank"
												<% end_if %>
											>
												$Text
											</a>
										<% end_loop %>
									</div>
									<% end_if %>
								</li>
								<% end_loop %>
							</ul>
							<% end_loop %>
						</div>
					</div>
				</div>
				<!-- end of .timeline-section -->
				<% end_if %>