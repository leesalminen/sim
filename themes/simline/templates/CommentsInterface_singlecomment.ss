<div class="comment {$FirstLast}">
	<% if $Author %>
		<a href="{$Author.BlogAuthorLink}" class="user-avatar">
			<% if $Gravatar %>
				<img src="$Gravatar" alt="Gravatar for $Name" title="Gravatar for $Name" class="img-responsive" />
			<% else %>
				<img src="<% if Author.Photo %>$Author.Photo.URL<% else %>//placehold.it/50<% end_if %>" alt="{$Name}" class="img-responsive" />
			<% end_if %>
		</a>
		
		<div class="comment-body">
			<a class="profile-link" href="{$Author.BlogAuthorLink}">$Name</a>
			
	<% else %>
		<% if $Gravatar %>
			<img class="user-avatar img-responsive" src="$Gravatar" alt="Gravatar for $Name" title="Gravatar for $Name" />
		<% else %>
			<img class="user-avatar img-responsive" src="//placehold.it/60" alt="{$Name}" />
		<% end_if %>
		
		<div class="comment-body">
			<a class="profile-link" href="#">$Name</a>
	<% end_if %>
			<span class="text-muted time">$Created.Nice ($Created.Ago)</span>
			
			<div class="comment-text">
				$EscapedComment
			</div>
			
			<% if $ApproveLink || $SpamLink || $HamLink || $DeleteLink %>
			<ul class="list-inline comment-actions">
				<% if ApproveLink %>
					<li>
						<a href="$ApproveLink.ATT" class="approve">
							<i class="fa fa-check-circle"></i>
							<% _t('Comments.ACTAPPROVE', 'approve this comment') %>
						</a>
					</li>
				<% end_if %>
				<% if SpamLink %>
					<li>
						<a href="$SpamLink.ATT" class="spam">
							<i class="fa fa-ban"></i>
							<% _t('Comments.ACTSPAM', 'this comment is spam') %>
						</a>
					</li>
				<% end_if %>
				<% if HamLink %>
					<li>
						<a href="$HamLink.ATT" class="ham">
							<i class="fa fa-shield"></i>
							<% _t('Comments.ACTISNTSPAM', 'this comment is not spam') %>
						</a>
					</li>
				<% end_if %>
				<% if DeleteLink %>
					<li class="last">
						<a href="$DeleteLink.ATT" class="delete">
							<i class="fa fa-trash-o"></i>
							<% _t('Comments.ACTREMOVE', 'remove this comment') %>
						</a>
					</li>
				<% end_if %>
			</ul>
			<% end_if %>
		</div>
</div>