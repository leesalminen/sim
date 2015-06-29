		<!-- Wrapper -->
		<div class="wrapper">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="row primary-heading">
					<div class="col-sm-12">
						<h1 class="title-lg first-child">
							<span>$Category.Title</span>
						</h1>
					</div>
				</div><!-- end of .primary-heading -->
				
				<div class="row primary-content">
					<div class="col-sm-4 col-lg-3">
						<% include HelpSidebar %>
					</div>
					
					<% with $Category %>
					<div class="col-sm-8 col-lg-9">
						<% if $Articles %>
							<div class="panel-group" id="category-{$ID}">
								<% loop $Articles %>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#category-{$Up.ID}" href="#article-{$ID}" class="collapsed">
													$Title.XML
												</a>
											</h4>
										</div>
										
										<div id="article-{$ID}" class="panel-collapse collapse">
											<div class="panel-body">
												<div class="typography">
													<% if $ShortDescription %>
														$ShortDescription
													<% else %>
														$Content.LimitWordCount(60)
													<% end_if %>
												</div>
												
												<div class="text-right help-readmore">
													<a href="{$Link}" class="btn btn-primary btn-xs" title="{$Title.XML}">
														<%t HelpPage.READMORE "Read more..." %>
													</a>
												</div>
											</div>
										</div>
									</div>
								<% end_loop %>
							</div>
							
							<% with $Articles %>
								<% include Pagination %>
							<% end_with %>
						<% else %>
							<p>No help topic.</p>
						<% end_if %>
						
						<div class="clearfix"></div>
					</div>
					<% end_with %>
					
				</div><!-- end of .primary-content -->
			</div>
			<!-- end of #main-cn -->
		</div>