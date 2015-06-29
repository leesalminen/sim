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
					<div class="col-sm-4 col-lg-3">
						<% include HelpSidebar %>
					</div>
					
					<div class="col-sm-8 col-lg-9">
						<% if $Categories.Count %>
							<% loop $Categories %>
								<% if $HelpArticles.Count %>
									<h3 class="title-block second-child help-category-title">
										<a href="{$Link}" title="{$Title.XML}" class="inherit">$Title</a>
									</h3>
									
									<div class="panel-group" id="category-{$ID}">
										<% loop $HelpArticles.Limit(3) %>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#category-<% with $Up %>{$Up.ID}<% end_with %>" href="#article-<% with $Up %>{$Up.ID}<% end_with %>-{$ID}" class="collapsed">
															$Title.XML
														</a>
													</h4>
												</div>
												
												<div id="article-<% with $Up %>{$Up.ID}<% end_with %>-{$ID}" class="panel-collapse collapse">
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
								<% end_if %>
							<% end_loop %>
						<% else %>
							<p>No help topic.</p>
						<% end_if %>
						
						<div class="clearfix"></div>
					</div>
				</div><!-- end of .primary-content -->
			</div>
			<!-- end of #main-cn -->
		</div>