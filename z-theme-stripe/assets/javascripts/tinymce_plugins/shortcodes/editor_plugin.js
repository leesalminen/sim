/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('shortcodes');
	
	// Create plugin
	tinymce.create('tinymce.plugins.ShortCodesPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceShortCodes');
			ed.addCommand('mceShortCodes', function() {
				ed.windowManager.open({
					file : url + '/dialog.htm',
					width : 600 + parseInt(ed.getLang('shortcodes.delta_width', 0)),
					height : 400 + parseInt(ed.getLang('shortcodes.delta_height', 0)),
					inline : 1,
					// scrollbars:true,
					// fullscreen: 'yes'
				}, {
					plugin_url : url, // Plugin absolute URL
					// btnClass: 'btn btn-flat flat-color' // Custom argument
				});
			});

			// Register button
			ed.addButton('shortcodes', {
				title : 'shortcodes.desc',
				cmd : 'mceShortCodes',
				image : url + '/img/button.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('shortcodes', n.nodeName == 'IMG');
			});
			
			// Resize the window
			ed.addCommand( 'ShortCodesPlugin_Resize', function( ui, v ) {
				ed.windowManager.params.mce_height = v.height + 60;
			} );
			
			// Change position of the window
			ed.addCommand('ShortCodesPlugin_Move', function(p) {
				var dialog = document.querySelectorAll('[id^=mce_inlinepopups]');
				
				if ( typeof dialog[0] !== 'undefined' ) {
					if (typeof p.top !== 'undefined') {
						dialog[0].style.top = p.top;
					}
					
					if (typeof p.left !== 'undefined') {
						dialog[0].style.left = p.left;
					}
				}
			} );
		},

		/**
		 * Creates control instances based in the incoming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Short-codes plugin',
				author : 'Anh Le',
				authorurl : 'http://silverbusters.com',
				infourl : 'http://silverbusters.com',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('shortcodes', tinymce.plugins.ShortCodesPlugin);
})();