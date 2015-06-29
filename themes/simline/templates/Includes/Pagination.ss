<%-- NOTE: Before including this, you will need to wrap the include in a with block  --%>

<% if $MoreThanOnePage %>
<div class="pagination-wrapper">
	<ul class="pagination">
		<% if $NotFirstPage %>
			<li>
				<a href="$$PrevLink" title="View the previous page">
					<i class="fa fa-long-arrow-left"></i> Previous
				</a>
			</li>
		<% else %>	
			<li class="disabled">
				<span>
					<i class="fa fa-long-arrow-left"></i> Previous
				</span>
			</li>
		<% end_if %>
	
    	<% loop $PaginationSummary(3) %>
			<% if CurrentBool %>
				<li class="active"><span>$PageNum</span></li>
			<% else %>
				<% if Link %>
					<li>
						<a class="<% if BeforeCurrent %>paginate-left<% else %>paginate-right<% end_if %>" href="$Link">
							$PageNum
						</a>
					</li>
				<% else %>
					<li class="disabled"><span>&hellip;</span></li>						
				<% end_if %>
			<% end_if %>
		<% end_loop %>
	
		<% if $NotLastPage %>
			<li>
				<a class="next paginate-right" href="$$NextLink" title="View the next page">
					Next <i class="fa fa-long-arrow-right"></i>
				</a>
			</li>
		<% else %>
			<li class="disabled">
				<span>
					Next <i class="fa fa-long-arrow-right"></i>
				</span>
			</li>
		<% end_if %>
	</ul>
</div>
<% end_if %>