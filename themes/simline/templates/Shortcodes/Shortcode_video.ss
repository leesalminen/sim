<div class="embed-responsive embed-responsive-16by9">
	<iframe
		width="{$width}"
		height="{$height}"
		webkitallowfullscreen mozallowfullscreen allowfullscreen
	<% if $service == 'youtube' %>
		src="//www.youtube.com/embed/{$id}"
	<% else_if $service == 'vimeo' %>
		src="//player.vimeo.com/video/{$id}?title=0&amp;byline=0&amp;portrait=0"
	<% else_if $service == 'dailymotion' %>
		src="//www.dailymotion.com/embed/video/{$id}"
	<% end_if %>
	</iframe>
</div>