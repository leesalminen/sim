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
				
				<% with $TimelineData %>
					<% include Timeline %>
					
					<% if $PaginatedList.Exists %>
						<% with $PaginatedList %>
							<% include Pagination %>
						<% end_with %>
					<% end_if %>
				<% end_with %>
			</div>
			<!-- end of #main-cn -->
		</div>