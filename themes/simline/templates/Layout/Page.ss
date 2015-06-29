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
						
						<% if $Images %>
						<div class="page-images clearfix">
							<div class="row">
								<% loop $Images %>
								<div class="col-lg-3 col-md-4 col-xs-6 pi-thumb">
									<a class="thumbnail swipebox-holder" href="{$URL}" data-swipebox="page-images" title="{$Title}">
										<img alt="{$Title.XML}" src="{$CroppedFocusedImage(400,300).URL}" class="img-responsive" />
									</a>
								</div>
								<% end_loop %>
							</div>
						</div>
						<% end_if %>
						
						<div class="clearfix main-form">
							$Form
						</div>
						
						<div class="clearfix comment-section">
							$CommentsForm
						</div>
					</div>
				</div><!-- end of .primary-content -->
			</div>
			<!-- end of #main-cn -->
		</div>