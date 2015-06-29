	<!-- Wrapper -->
    <div class="wrapper">
		<% if $EmbedMapURL %>
		<div id="map_canvas" class="section google-map">
			<iframe class="contact-map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{$EmbedMapURL}"></iframe>
			
			<div class="touchable-area touchable-area-left visible-xs-block visible-sm-block"></div>
			<div class="touchable-area touchable-area-right visible-xs-block visible-sm-block"></div>
		</div>
		<!-- end of #map_canvas -->
		<% end_if %>
      
		<div class="container">
			<% if $Action = 'finished' %>
				<div class="row">
					<div class="col-sm-12">
						<h1 class="title-lg first-child">
							<span>$OnCompleteHeading</span>
						</h1>
						
						<div class="primary-content typography">
							$OnCompleteMessage
						</div>
					</div>
				</div> <!-- / .row -->
			<% else %>
				<div class="row">
					<div class="col-sm-12">
						<h1 class="title-lg first-child">
							<span><% if $PageHeading %>$PageHeading.XML<% else %>$Title.XML<% end_if %></span>
						</h1>
					</div>
				</div> <!-- / .row -->
				
				<div class="row">
					<% if $Attributes.isEnabled && $Attributes.Count %>
					<div class="col-sm-6">
						<!-- Contact Info -->
						<% if $Attributes.Heading %>
							<h3 class="title-block first-child">$Attributes.Heading</h3>
						<% end_if %>
						
						<ul class="contact-info">
							<% loop $Attributes.Items %>
							<li>
								<% if $IconClass %><i class="{$IconClass}"></i><% end_if %>
								
								<div class="contact-info-content">
									<div class="title">{$Label}</div>
									<div class="description">{$Value}</div>
								</div>
							</li>
							<% end_loop %>
						</ul>
					</div>
					<% end_if %>
					
					<div class="col-sm-6">
						<div class="primary-content typography">
							$Content
						</div>
						
						<!-- Contact Form -->
						<div class="contact-form">
							<% with $Form %>
							<form $FormAttributes>
								<% if $Message %>
									<p id="{$FormName}_error" class="message $MessageType">$Message</p>
								<% else %>
									<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
								<% end_if %>
								
								<fieldset>
									<% loop $Fields %>
										$FieldHolder
									<% end_loop %>
								</fieldset>
								
								<div class="form-actions">
									<% loop $Actions %>
										<button $addExtraClass(btn btn-red).AttributesHTML>
											<% if $ButtonContent %>$ButtonContent<% else %>$Title<% end_if %> <i class="fa fa-paper-plane-o"></i>
										</button>
									<% end_loop %>
								</div>
							</form>
							<% end_with %>
						</div>
					</div>
				</div> <!-- / .row -->
			<% end_if %>
		</div> <!-- / .container -->
    </div> <!-- / .wrapper -->