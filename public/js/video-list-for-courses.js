(function( $ ) {
	'use strict';

	$(document).on('click','.course-list-items .islink',function(e){
	 	e.preventDefault();

		$.ajax({
			url : vlfc_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'vlfc_ajax_get_data',
				security: vlfc_vars.ajax_nonce,
				item: this.dataset.id,
				course: document.querySelector('.course-list-items').dataset.id
			},
			beforeSend: function(){
				$('.vlfc-video').html('Cargando ...');
				$('.vlfc-notes').html('');
			},
			success: function(res){

				if ( res.success ){
					$('.vlfc-video').html(res.data.code);
					$('.vlfc-notes').html(res.data.notes);
				}
				else {
				 	$('.vlfc-video').html(res.data);
				 	console.log(res.data);
				}

			},
			error: function( err ){
				 $('.vlfc-video').html('Error: ' + err.statusText);
			}

		});

	});


})( jQuery );
