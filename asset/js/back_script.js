jQuery(document).ready( function($) {

    function ct_media_upload(button_class) {

        var _custom_media = true,

        _orig_send_attachment = wp.media.editor.send.attachment;

        jQuery('body').on('click', button_class, function(e) {

            var button_id = '#'+jQuery(this).attr('id');

            var send_attachment_bkp = wp.media.editor.send.attachment;

            var button = jQuery(button_id);

            _custom_media = true;

            wp.media.editor.send.attachment = function(props, attachment){

                if ( _custom_media ) {

                    jQuery('#brands-logo-id').val(attachment.id);
                    jQuery('#brands-logo-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    jQuery('#brands-logo-wrapper .custom_media_image').attr('src',attachment.url).css('display','inline-block');
                
                } else {

                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }

            }

            wp.media.editor.open(button);

            return false;

        });
    }
    
    ct_media_upload('.ct_tax_media_button.button'); 

    
    jQuery('body').on('click','.ct_tax_media_remove',function(){

            jQuery('#brands-logo-id').val('');

            jQuery('#brands-logo-wrapper').html('');
   
    });
               // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
    // jQuery(document).ajaxComplete(function(event, xhr, settings) {

    //     var queryStringArr = settings.data.split('&');

    //     if( jQuery.inArray('action=add-tag', queryStringArr) !== -1 ){

    //         var xml = xhr.responseXML;

    //         $response = jQuery(xml).find('term_id').text();

    //         if($response!=""){
    //              // Clear the thumb image
    //             jQuery('#brands-logo-wrapper').html('');
    //         }

    //     }

    // });

});