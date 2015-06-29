		<!-- Wrapper -->
		<div class="wrapper">
			<% include TopicHeader %>
			
			<div class="container" id="main-cn">
				<div class="row primary-content">
					<div class="col-sm-4 col-lg-3">
						<% include HelpSidebar %>
					</div>
					
					<div class="col-sm-8 col-lg-9">
						<h1 class="article-heading first-child">
							<% if $PageHeading %>$PageHeading.XML<% else %>$Title.XML<% end_if %>
						</h1>
						
						<div class="typography">
							$Content
						</div>
						
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