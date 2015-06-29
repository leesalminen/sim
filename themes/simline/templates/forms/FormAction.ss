<% if $UseButtonTag %>
	<button $addExtraClass(btn btn-default).AttributesHTML>
		<% if $ButtonContent %>$ButtonContent<% else %>$Title<% end_if %>
	</button>
<% else %>
	<input $addExtraClass(btn btn-default).AttributesHTML />
<% end_if %>
