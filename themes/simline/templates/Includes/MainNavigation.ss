					<!-- Primary navigation -->
					<ul class="nav navbar-nav navbar-right">
						<% loop $Menu(1) %>
							<% if $Children%>
								<li class="dropdown <% if $LinkingMode == 'section' || $LinkingMode == 'current' %>active<% else %>{$LinkingMode}<% end_if %>">
									<a href="{$Link}" title="{$Title.XML}">
										$MenuTitle.XML <i class="fa fa-angle-down"></i>
									</a>
									
									<ul class="dropdown-menu">
										<% loop $Children %>
											<li class="<% if $LinkingMode == 'section' || $LinkingMode == 'current' %>active<% else %>{$LinkingMode}<% end_if %>">
												<a href="{$Link}" title="{$Title.XML}">
													$MenuTitle.XML
												</a>
											</li>
										<% end_loop %>
									</ul>
								</li>
							<% else %>
								<li class="<% if $LinkingMode == 'section' || $LinkingMode == 'current' %>active<% else %>{$LinkingMode}<% end_if %>">
									<a href="{$Link}" title="{$Title.XML}">
										$MenuTitle.XML
									</a>
								</li>
							<% end_if %>
						<% end_loop %>
						
						<!-- Navbar Search -->
						<li class="hidden-xs" id="navbar-search">
							<a href="#" class="show" id="open-search">
								<i class="fa fa-search"></i>
							</a>
							
							<a href="#" class="hidden" id="close-search">
								<i class="fa fa-times"></i>
							</a>
							
							<div class="hidden" id="navbar-search-box">
								<% loop $SearchForm.addExtraClass(form).setAttribute(id, navbar-search-form) %>
									<form $FormAttributes>
										<input type="text" class="form-control" name="Search" placeholder="Search" />
											
										<button class="btn btn-red btn-sm" type="submit">
											<i class="fa fa-search"></i>
										</button>
									</form>
								<% end_loop %>
							</div>
						</li>
					</ul>
					
					<!-- Mobile Search -->
					<% loop $SearchForm.addExtraClass(navbar-form navbar-right visible-xs).setAttribute(id, mobile-search-form) %>
						<form $FormAttributes>
							<div class="input-group">
								<input type="text" class="form-control" name="Search" placeholder="Search" />
									
								<span class="input-group-btn">
									<button class="btn btn-red" type="submit">Search!</button>
								</span>
							</div>
						</form>
					<% end_loop %>