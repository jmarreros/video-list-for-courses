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
					$('.vlfc-video').html('<img class="spin" src="' + vlfc_vars.assets_path + 'spin.svg' + '" />');
					$('.vlfc-notes').html('');
				},
				success: function(res){
					if ( res.success ){
						$('.course-list-items .islink').removeClass('current');
						$(e.currentTarget).addClass('current');
						vlfc_validate_next_prev();

						$('.vlfc-name').html(res.data.name);

						if ( res.data.code ){
							$('.vlfc-video').html(res.data.code);
						} else {
							$('.vlfc-video').html('<img class="spin" src="' + vlfc_vars.assets_path + 'locked-white.svg' + '" />')
						}

						if ( res.data.notes ){
							$('.vlfc-notes').html('<div>' + res.data.notes + '</div>');
						}
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


		$('#next').click( function(e) {
			e.preventDefault();
			vlfc_sel_item(1);
		});


		$('#prev').click( function(e) {
			e.preventDefault();
			vlfc_sel_item(-1);
		});


		// default first-item
		$( ".course-list-items .islink" ).first().addClass('first-item').trigger('click');
		$( ".course-list-items .islink" ).last().addClass('last-item');


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

		function vlfc_sel_item( add ) {
			var sel = $('.course-list-items .current').data('number') + add;
			var el = $('.course-list-items .islink[data-number="' + sel + '"]');
			if ( el ) el.trigger('click');
		}


		$('.vlfc-toggle').on('click', function(){

			$('.vlfc-list').toggle('fast', function(){
				$('.vlfc-toggle > div').toggleClass('arrow-left');
				$('.vlfc-toggle > div').toggleClass('arrow-right');
			});

		});

	}); //ready



})( jQuery );
