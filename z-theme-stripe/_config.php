<?php
// Including Helper libs
require_once( dirname(__FILE__).'/code/helpers/firephp/fb.php' );
require_once( dirname(__FILE__).'/code/helpers/browser-detection/browser-detection.php' );
require_once( dirname(__FILE__).'/code/helpers/GoogleURL.php' );
require_once( dirname(__FILE__).'/code/helpers/Helper.php' );

// Set ThemeStripe folder name
define('TSModule', basename(__DIR__));

// Set site enviroment
Director::set_environment_type("dev");

// Set default theme
Config::inst()->update('SSViewer', 'theme', 'simline');

// Set the resizing image quality
GD::set_default_quality(100);

// Enable full-text search
FulltextSearchable::enable();

// Comments module
Config::inst()->update('SiteTree', 'comments', array(
    'require_login' => false, // boolean, whether a user needs to login
    'required_permission' => false,  // required permission to comment (or array of permissions)
    'include_js' => false, // Enhance operation by ajax behaviour on moderation links
    'show_comments_when_disabled' => false, // when comments are disabled should we show older comments (if available)
    'order_comments_by' => "\"Created\" DESC",
    'comments_per_page' => 10,
    'comments_holder_id' => "comments-holder", // id for the comments holder
    'comment_permalink_prefix' => "comment-", // id prefix for each comment. If needed make this different
    'require_moderation' => true,
    'html_allowed' => false, // allow for sanitized HTML in comments
    'html_allowed_elements' => array('i', 'b'),
    'use_preview' => false, // preview formatted comment (when allowing HTML). Requires include_js=true
    'use_gravatar' => false,
    'gravatar_size' => 64
));

// Shortcodes
ShortcodeParser::get('default')->register('button', array('ShortCodes', 'Button'));
ShortcodeParser::get('default')->register('video', array('ShortCodes', 'Video'));

// HTML Editor
$HTMLEditor = HtmlEditorConfig::get('cms');
$HTMLEditor->addButtonsToLine(3, array('separator','fontsizeselect','forecolor','backcolor','shortcodes'));
$HTMLEditor->setOption('theme_advanced_blockformats', 'div,p,h1,h2,h3,h4,h5,h6,blockquote,pre,code');
$HTMLEditor->enablePlugins(array('shortcodes' => '../../../'.TSModule.'/assets/javascripts/tinymce_plugins/shortcodes/editor_plugin.js'));