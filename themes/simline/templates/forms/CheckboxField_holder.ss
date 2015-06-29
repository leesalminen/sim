<div id="$Name" class="field<% if extraClass %> $extraClass<% end_if %> checkbox">
	<label class="right" for="$ID">
		$Field
		$Title
	</label>
	
	<% if $Message %><span class="message $MessageType">$Message</span><% end_if %>
	<% if $Description %><p class="help-block">$Description</p><% end_if %>
</div>
