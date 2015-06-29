<!-- Wrapper -->
<div id="results-page" class="wrapper">
	<% include TopicHeader %>
	
	<div class="container" id="main-cn">
		<div class="row primary-heading">
			<div class="col-sm-12">
				<h1 class="title-lg first-child">
					<span>
						<% if $Query %>
							Results for &quot;{$Query}&quot;
						<% else %>
							$Title
						<% end_if %>
					</span>
				</h1>
			</div>
		</div><!-- end of .primary-heading -->
		
		<div class="row primary-content">
			<div class="col-sm-12">
				<div class="search-results-wrapper clearfix">
					<% if $Query && $Results %>
						<ul class="search-results">
							<% loop $Results %>
							<li>
								<h4>
									<a href="$Link">
										<% if $MenuTitle %>
										$MenuTitle
										<% else %>
										$Title
										<% end_if %>
									</a>
								</h4>
								<% if $Content %>
									<p>$Content.LimitWordCountXML</p>
								<% end_if %>
								<a class="readMoreLink" href="$Link" title="Read more about &quot;{$Title}&quot;">Read more about &quot;{$Title}&quot;...</a>
							</li>
							<% end_loop %>
						</ul>
					<% else %>
						<p>
							Sorry, your search did not match any documents. Please try with another keywords.
						</p>
					<% end_if %>
				</div>
				<!-- /.search-results-wrapper -->
				
				<% if $Query %>
					<% with $Results %>
						<% include Pagination %>
					<% end_with %>
				<% end_if %>
			</div>
		</div><!-- end of .primary-content -->
	</div>
	<!-- end of #main-cn -->
</div>