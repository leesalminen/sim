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
	
	<body class="page-{$URLSegment} page-{$ID} page-type-{$ClassName} {$CustomHTMLClasses}" id="siteFrontend">	
		<% include Header %>
		
		$Layout
		
		<% include Footer %>
	</body>
</html>