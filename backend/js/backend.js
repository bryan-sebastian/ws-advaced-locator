jQuery.noConflict();
var $ = jQuery;

var mediaUploader;
$( '#select-image' ).on( 'click', function( e ){
    e.preventDefault();

    if( mediaUploader ) {
      mediaUploader.open();
      return;
    }

    mediaUploader = wp.media.frames.file_frame = wp.media( {
      title: 'Choose a profile picture',
      button: {
        text: 'Choose Picture'
      },
      multiple: false
    } );

    mediaUploader.on( 'select', function() {
  		//This alert does not fire.
  		var attachment = mediaUploader.state().get('selection').first().toJSON();

  		imageUrl = ( typeof img == 'object' ) ? img.url : attachment.url;

  		jQuery( '#select-image-container img' ).attr( 'src', imageUrl );

  		jQuery( '#select-image-container [type="hidden"]' ).val( imageUrl );
    } );

    mediaUploader.open();
} );

$( '#remove-image' ).on( 'click', function(e) {
	e.preventDefault();
	$( '#select-image-container img' ).attr( 'src', '' );
	$( '#select-image-container [type="hidden"]' ).val( '' );
} );