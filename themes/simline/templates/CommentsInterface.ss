<% if CommentsEnabled %>
<div id="$CommentHolderID" class="comments-holder-container clearfix comments">
	
	<div class="post-comments comments-holder">
		<% if $Comments %>
			<div class="comments-count">
				<h3>$Comments.count <% _t('COMMENTS','Comments') %></h3>
				<hr />
			</div>
			
			<% loop Comments %>
				<% include CommentsInterface_singlecomment %>
			<% end_loop %>
			
			<% with $Comments %>
				<% include Pagination %>
			<% end_with %>
			<!-- /.comment-pagination -->
		<% end_if %>
		
		<div class="no-comments-yet"<% if $Comments.Count %> style="display: none" <% end_if %> >
			<div class="pad-top-15 text-right">
				<strong><% _t('CommentsInterface_ss.NOCOMMENTSYET','No one has commented on this page yet.') %></strong>
			</div>
		</div>
	</div>
	<!-- /.post-comments -->
	
	<div class="clearfix comment-form-wrapper">
		<% if AddCommentForm %>
			<hr />
			
			<h4><% _t('CommentsInterface_ss.POSTCOM','Post your comment') %></h4>
			
			<div class="comment-form-section pad-top-15">
				<% if canPostComment %>
					<% if ModeratedSubmitted %>
					<div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						
						<% _t('CommentsInterface_ss.AWAITINGMODERATION', 'Your comment has been submitted and is now awaiting moderation.') %>
					</div>
					<% end_if %>
					
					<% loop $AddCommentForm %>
						<form $FormAttributes>
							<% if $Message %>
								<div id="{$FormName}_error" class="alert alert-{$MessageType} alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									$Message
								</div>
							<% else %>
								<div id="{$FormName}_error" class="alert alert-{$MessageType} alert-dismissable hide">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								</div>
							<% end_if %>
							
							<fieldset>
								<% loop $Fields %>
									<% if $Type = 'composite' %>
										<% loop $FieldList %>
											<% if $Name = 'Name' || $Name = 'Email' || $Name = 'URL' %>
												<% if $Name = 'Name' %>
													<div class="row form-group">
												<% end_if %>		
													<div class="col-md-4">
														<span><input $addExtraClass(form-control).AttributesHTML placeholder="{$Title}" /></span>
														
														<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
														<% if $Description %><span class="description">$Description</span><% end_if %>
													</div>
												<% if $Name = 'URL' %>
													</div>
												<% end_if %>	
											<% else %>
												<div class="row form-group">
													<div class="col-md-12">
														<% if $Name = 'Comment' %>
															$addExtraClass(form-control).Field
															<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
															<% if $Description %><span class="description">$Description</span><% end_if %>
														<% else %>
															$FieldHolder
														<% end_if %>
													</div>
												</div>
											<% end_if %>
										<% end_loop %>
									<% else_if $Type = 'hidden' %>
										$FieldHolder
									<% else %>
										<div class="row form-group">
											<div class="col-md-12">$FieldHolder</div>
										</div>
									<% end_if %>
								<% end_loop %>
								
								<div class="form-actions">
									<% loop $Actions %>
										$addExtraClass(btn btn-red).Field
									<% end_loop %>
								</div>
							</fieldset>
						</form>
					<% end_loop %>
					
				<% else %>
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					
					<% _t('CommentsInterface_ss.COMMENTLOGINERROR', 'You cannot post comments until you have logged in') %><% if PostingRequiresPermission %>, <% _t('CommentsInterface_ss.COMMENTPERMISSIONERROR', 'and that you have an appropriate permission level') %><% end_if %>. 
					<a href="Security/login?BackURL={$Parent.Link}" title="<% _t('CommentsInterface_ss.LOGINTOPOSTCOMMENT', 'Login to post a comment') %>">
						<% _t('CommentsInterface_ss.COMMENTPOSTLOGIN', 'Login Here') %>
					</a>
				</div>
				<% end_if %>
			<% else %>
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					
					<% _t('CommentsInterface_ss.COMMENTSDISABLED', 'Posting comments has been disabled') %>
				</div>
			<% end_if %>
		</div>
		<!-- end of .comment-form -->
		
		<div class="clearfix" id="PreviewComment"></div>
	</div>
	<!-- /.clearfix comment-form-wrapper -->
	
	<div class="comments-rss-feed pad-top-25 text-right">
		<a href="$CommentRSSLinkPage"><% _t('CommentsInterface_ss.RSSFEEDCOMMENTS', 'RSS feed for comments on this page') %></a> | 
		<a href="$CommentRSSLink"><% _t('CommentsInterface_ss.RSSFEEDALLCOMMENTS', 'RSS feed for all comments') %></a>
		
		<% if DeleteAllLink %>
			| <a href="$DeleteAllLink"><% _t('CommentsInterface_ss.PageCommentInterface.DELETEALLCOMMENTS','Delete all comments on this page') %></a>
		<% end_if %>
	</div>
	<!-- /.comments-rss-feed -->
</div>
<% end_if %>
	
