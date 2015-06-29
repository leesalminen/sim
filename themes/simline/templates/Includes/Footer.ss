		<!-- Footer -->
		<footer>
			<% loop $SiteConfig %>
			<div class="container">
				<div class="row">
					<% loop $FooterWidget.Widgets %>
					<div class="col-sm-3">
						$WidgetHolder
					</div>
					<!-- /.col-sm-3 -->
					<% end_loop %>
					
					<div class="col-sm-3">
						<img class="footer-brand" src="$ThemeDir/images/logo.png" alt="{$Title}" />
						
						<div class="clearfix">
							$CopyrightText
						</div>
						
						<% if $SocialFB || $SocialGP || $SocialTW || $SocialPI %>
							<ul class="social-links">
								<% if $SocialFB %>
								<li class="facebook">
									<a href="{$SocialFB}" title="Follow Us on Facebook" rel="nofollow" target="_blank">
										<i class="fa fa-facebook"></i>
									</a>
								</li>
								<% end_if %>
								
								<% if $SocialTW %>
								<li class="twitter">
									<a href="{$SocialTW}" title="Follow Us on Twitter" rel="nofollow" target="_blank">
										<i class="fa fa-twitter"></i>
									</a>
								</li>
								<% end_if %>
								
								<% if $SocialLI %>
								<li class="linkedin">
									<a href="{$SocialLI}" title="Follow Us on LinkedIn" rel="nofollow" target="_blank">
										<i class="fa fa-linkedin"></i>
									</a>
								</li>
								<% end_if %>
							</ul>
						<% end_if %>
					</div>
				</div>
				<!-- / .row -->
			</div>
			<!-- / .container -->
			<% end_loop %>
		</footer>