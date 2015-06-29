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
				
				<% if Services %>
				<div class="row features-block features-block_small service-box">
					<% loop $Services %>
					<div class="col-md-4 col-sm-6 math-height" data-mh="service-box">
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
				</div> <!-- end of .features-block-->
				<% end_if %>
			</div>
			<!-- end of #main-cn -->
		</div>