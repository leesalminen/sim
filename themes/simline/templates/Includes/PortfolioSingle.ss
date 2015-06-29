<div class="portfolio-item">
	<a href="{$Link}" title="{$Title.XML}">
		<div class="img">
			<% if Images.First %>
				<% loop Images.First %>
					<img class="img-responsive" src="{$CroppedFocusedImage(768,512).URL}" alt="{$Title.XML}" />
				<% end_loop %>
			<% else %>
				<img class="img-responsive" src="https://placehold.it/768x512" alt="{$Title.XML}" />
			<% end_if %>
		</div>
		<div class="info">
			<h4>{$Title.XML}</h4>
			<p class="text-muted">$ShortDescription.LimitCharacters(30)</p>
		</div>
	</a>
</div>