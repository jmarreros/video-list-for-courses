(function( $ ) {
	'use strict';

	$(document).on('click','.course-item .islink',function(e){
	 	e.preventDefault();

		$.ajax({
			url : vlfc_vars.ajaxurl,
			type: 'post',
			data: {
				action : 'vlfc_ajax_get_data',
				item: this.parentNode.dataset.id,
				course: this.parentNode.parentNode.dataset.id
			},
			beforeSend: function(){
				$('.vlfc-video').html('Cargando ...');
			},
			success: function(res){
				 var data = $.parseJSON(res);
				 console.log(data.notes);
			},
			error: function( err ){
				 $('.vlfc-video').html('Error: ' + err.statusText);
			}

		});

	});


})( jQuery );
