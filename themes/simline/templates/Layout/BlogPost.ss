		<!-- Wrapper -->
		<div class="wrapper blog-holder">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="row">
					<div class="col-sm-9">
						<div class="blog blog-summary">
							<div class="blog-desc">
								<h1 class="blog-title">
									<a href="$Link" title="{$Title.XML}">
										<% if $MenuTitle %>$MenuTitle<% else %>$Title<% end_if %>
									</a>
								</h1>
								
								<hr>
									
								<% include EntryMeta %>
								
								<% if $FeaturedImage %>
								<div>
									<a class="swipebox-holder" href="{$FeaturedImage.URL}" data-swipebox="page-images" title="{$Title.XML}">
										<img src="{$FeaturedImage.CroppedFocusedImage(800,400).URL}" class="img-responsive blog-img" alt="{$Title.XML}" />
									</a>
								</div>
								<% end_if %>
								
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
								
								<div class="blog-content typography pad-top-15">
									$Content
								</div>
								
								<div class="clearfix main-form">
									$Form
								</div>
								
								<div class="clearfix comment-section">
									$CommentsForm
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div>
					</div>
					
					<% include SideBar %>
					<!-- /.sidebar -->
				</div>
				<!-- / .row -->
			</div>
			<!-- end of #main-cn -->
		</div>