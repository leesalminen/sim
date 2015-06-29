		<!-- Wrapper -->
		<div class="wrapper">
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
				
				<% if $PersonEnable && $Persons.Count %>
				<div class="team-person-wrapper">
					<% if $PersonHeading %>
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$PersonHeading</span></h2>
						</div>
					</div>
					<!-- / .row -->
					<% end_if %>
					
					<div class="row">
						<% loop $Persons %>
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
				</div><!-- end of .team-person-wrapper -->
				<% end_if %>
				
				
				<% if $TestimonialEnable && $Testimonials.Count %>
				<div class="client-feedback-wrapper">
					<% if $TestimonialHeading %>
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title-lg"><span>$TestimonialHeading</span></h2>
						</div>
					</div>
					<!-- / .row -->
					<% end_if %>
					
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
			</div>
			<!-- end of #main-cn -->
		</div>