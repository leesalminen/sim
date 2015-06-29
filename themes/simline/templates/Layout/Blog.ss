		<!-- Wrapper -->
		<div class="wrapper blog-holder">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="row">
					<div class="col-sm-9">
						<div class="clearfix blog-filtered-heading">
							<% if $ArchiveYear %>
								<h3>
									<%t Blog.Archive "Archive" %>:
									<% if $ArchiveDay %>
										$ArchiveDate.Nice
									<% else_if $ArchiveMonth %>
										$ArchiveDate.format("F, Y")
									<% else %>
										$ArchiveDate.format("Y")
									<% end_if %>
								</h3>
							<% else_if $CurrentTag %>
								<h3><%t Blog.Tag "Tag" %>: $CurrentTag.Title</h3>
							<% else_if $CurrentCategory %>
								<h3><%t Blog.Category "Category" %>: $CurrentCategory.Title</h3>
							<% else_if $TsCurrentAuthor %>
								<h3><%t Blog.Author "Author" %>: $TsCurrentAuthor</h3>
							<% end_if %>
						</div>
						
						<% if $PaginatedList.Exists %>
							<% loop $PaginatedList %>
							<!-- Blog Post summary -->
							<div class="blog blog-summary">
								<div class="blog-desc">
									<% if $First %>
									<h1 class="blog-title">
										<a href="$Link" title="{$Title.XML}">
											<% if $MenuTitle %>$MenuTitle<% else %>$Title<% end_if %>
										</a>
									</h1>
									<% else %>
									<h2 class="blog-title">
										<a href="$Link" title="{$Title.XML}">
											<% if $MenuTitle %>$MenuTitle<% else %>$Title<% end_if %>
										</a>
									</h2>
									<% end_if %>
									
									<hr>
										
									<% include EntryMeta %>
									
									<div class="blog-summary-content pad-top-15">
										$Content.LimitWordCount(60)
									</div>
									
									<div class="pad-top-15">
										<a href="$Link" title="{$Title.XML}" class="btn btn-lg btn-red">
											<%t Blog.ReadMore "Read More..." %>
										</a>
									</div>
									
									<% if $FeaturedImage %>
									<div>
										<a href="$Link" title="{$Title.XML}">
											<img src="{$FeaturedImage.CroppedFocusedImage(800,400).URL}" class="img-responsive blog-img" alt="{$Title.XML}" />
										</a>
									</div>
									<% end_if %>
								</div>
							</div>
							<% end_loop %>
							
							<% with $PaginatedList %>
								<% include Pagination %>
							<% end_with %>
						<% end_if %>
						
						<div class="clearfix"></div>
					</div>
					
					<% include SideBar %>
					<!-- /.sidebar -->
				</div>
				<!-- / .row -->
			</div>
			<!-- end of #main-cn -->
		</div>