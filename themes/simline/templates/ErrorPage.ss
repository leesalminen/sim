<!DOCTYPE html>
<html lang="en">
	<head>
		<% if not browser_lt_ie(8) %>
			<% base_tag %>
		<% end_if %>
		
		<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		$MetaTags(false)
		
		<!-- Favicon -->  
		<link rel="shortcut icon" href="$ThemeDir/images/ico/favicon.png" />
		
		<!-- Google Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css' />
			
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!--
		<link rel="stylesheet/less" type="text/css" href="$ThemeDir/less/style.less" />
		<script src="$ThemeDir/javascript/vendor/less.min.js" type="text/javascript"></script>
		-->
	</head>
	
	<body class="page-{$URLSegment} page-{$ID} page-type-{$ClassName} {$CustomHTMLClasses} alt error-page">	
		<!-- Page Curl -->
		<img class="page-curl" src="$ThemeDir/images/page-curl.png" alt="Error" />
			
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<h1>$Title.XML</h1>
					
					<p class="lead">
						<% if ErrorCode = 404 %>
							The page you are trying to reach is not found.
						<% else %>
							Oops! Something went wrong.
						<% end_if %>
					</p>
					
					<p class="links">
						<a href="{$BaseHref}" class="btn-glass">Back to homepage</a>
					</p>
					
					<a href="{$BaseHref}">
						<img class="logo" src="$ThemeDir/images/logo.png" alt="{$SiteConfig.Title}">
					</a>
				</div>
			</div>
			<!-- / .row -->
		</div>
		<!-- / .container -->
	</body>
</html>