(function( $ ) {
	'use strict';

	

	$( document ).ready(function() {

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
						$('.course-list-items .islink').removeClass('current');
						$(e.currentTarget).addClass('current');
						vlfc_validate_next_prev();

						$('.vlfc-name').html(res.data.name);
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

			}); //ajax

		}); // click


		// default first-item
		$( ".course-list-items .islink" ).first().addClass('first-item').trigger('click');
		$( ".course-list-items .islink" ).last().addClass('last-item');


		$('#prev').click( function(e) {
			e.preventDefault();
			$('.course-list-items .current').prev('.islink').trigger('click');
		});

		$('#next').click( function(e) {
			e.preventDefault();
			$('.course-list-items .current').next('.islink').trigger('click');
		});

		function vlfc_validate_next_prev(){
			$('#prev').show();
			$('#next').show();

			if ( $('.course-list-items .current').hasClass('first-item') ){
				$('#prev').hide();
			} 

			if ( $('.course-list-items .current').hasClass('last-item') ){
				$('#next').hide();
			}
			
		}


	});




})( jQuery );
