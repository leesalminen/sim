						<h3 class="title-block first-child">Quick Search</h3>
						
						<% loop $SearchForm.addExtraClass(form).setAttribute(id, help-search-form) %>
							<form $FormAttributes>
								<input type="text" class="form-control" name="Search" placeholder="" />
								<input type="hidden" name="ClassName" value="HelpArticle" />
									
								<button class="btn btn-red btn-sm" type="submit">
									<i class="fa fa-search"></i>
								</button>
							</form>
						<% end_loop %>
						
						<h3 class="title-block">Helpful Links</h3>
						
						<div class="menu-lg">
							<div class="item">
								<i class="fa fa-users"></i>
								<div class="content">
									<div class="title">
										<a href="#"><span class="text-red">Online</span> Support</a>
									</div>
									<div class="description">
										 Lorem ipsum dolor sit amet, consectetur.
									</div>
								</div>
							</div>
							<div class="item">
								<i class="fa fa-unlock-alt"></i>
								<div class="content">
									<div class="title">
										<a href="#"><span class="text-red">Data</span> Protection</a>
									</div>
									<div class="description">
										 Lorem ipsum dolor sit amet, consectetur.
									</div>
								</div>
							</div>
							<div class="item">
								<i class="fa fa-legal"></i>
								<div class="content">
									<div class="title">
										<a href="#"><span class="text-red">Legal</span> Info</a>
									</div>
									<div class="description">
										 Lorem ipsum dolor sit amet, consectetur.
									</div>
								</div>
							</div>
						</div>