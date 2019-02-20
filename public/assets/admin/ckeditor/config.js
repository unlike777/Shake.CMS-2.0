/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	
	config.extraPlugins = 'autogrow,justify,colorbutton';
	
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [

		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'styles'},
		{ name: 'colors' },
		{ name: 'paragraph',   groups: [ 'list', /*'indent',*/ 'blocks', 'align', 'bidi', 'justify' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'forms' },
		{ name: 'others' },
		{ name: 'clipboard',   groups: [ 'clipboard' ] },
		{ name: 'editing',     groups: [ 'find', 'selection'] },
		{ name: 'tools' },
	];
	
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript,Cut,Copy,Paste,SpecialChar,PasteFromWord';
	
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	config.filebrowserBrowseUrl = '/elfinder/ckeditor';
};
