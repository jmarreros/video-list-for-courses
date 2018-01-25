
//TODO - open all - close all

// template
var template = `
<li class="item">
	<div class="links my-handle menu-item-handle">
		<a href="#" class="item-link"></a>
		<a href="#" class="item-arrow down"></a>
	</div>
	<div class="controls hide">
		<p class="control-name">
			<label>Item name</label><input type="text" value=""/>
		</p>
		<p class="control-check-header">
			<input type="checkbox"><label>Is header?</label>
		</p>
		<p class="control-code">
			<label>Video Embebed code</label><textarea cols="30" rows="4"></textarea>
		</p>
		<p class="control-duration">
			<label>Duration</label><input maxlength=5 type="text" value="" placeholder="00:00">
		</p>
		<p class="control-notes">
			<label>Video Notes</label><textarea cols="30" rows="4"></textarea>
		</p>
		<p class="control-check-lock">
			<input type="checkbox">
			<label>Locked for guests?</label>
		</p>
		<hr>
		<div class="control-options">
			<div><a href="#" class="remove">Remove</a> <a href="#" class="cancel">Cancel</a></div>
			<div><a href="#" class="preview">Preview</a></div>
		</div>
	</div>
</li>`;




(function( $ ) {
	'use strict';

	let obj_items = null; // existent objects
	let items = null; // dynamic items objects

	$( document ).ready(function() {

		if ( $('#content').length > 0 && $('#content').text() ){
			obj_items = JSON.parse($('#content').text());
		}



		items = $('#list-items');

		if ( items.length > 0 ){

			items.click( function(e){

				e.preventDefault();

				// show/hide controls link 
 				if ( e.target.matches('.item .item-arrow') ){

					const item = $(e.target.parentNode.parentNode);

					item.find('.links .item-arrow').toggleClass('down');
					item.find('.controls').toggleClass('hide');

					// if ( ! link.classList.contains('down') ) {
					// 	//close_opens(item.dataset.id);
					// }
					
 				}


	 			// show/hide controls link
				// if ( e.target.matches('.item .item-arrow') ){

				// 	let item = e.target.parentNode.parentNode;

				// 	const link = item.querySelector('.links .item-arrow');
				// 	const controls = item.querySelector('.controls');

				// 	link.classList.toggle('down');
				// 	controls.classList.toggle('hide');

				// 	if ( ! link.classList.contains('down') ) {
				// 		//close_opens(item.dataset.id);
				// 	}

				// 	//e.target.preventDefault();

				// }

			// // isheader conditional show/hide controls
			// if ( e.target.matches('.item .control-check-header input') ){
			// 	const item = e.target.parentNode.parentNode.parentNode;
			// 	set_header(item);
			// }

			// // islock conditional to hide/show lock icon
			// if ( e.target.matches('.item .control-check-lock input') ){	
			// 	const item = e.target.parentNode.parentNode.parentNode;
			// 	item.querySelector('.links .item-link').classList.toggle('islock');
			// }

			// //Cancel element
			// if ( e.target.matches('.item .cancel') ){
			// 	const item = e.target.parentNode.parentNode.parentNode.parentNode;
				
			// 	// console.log(item.dataset.oldId);
			// 	if ( item.dataset.oldId ){
			// 		const obj_item = obj_items[item.dataset.oldId];
			// 		update_values( item, obj_item);
			// 	}

			// }

			// //Remove element
			// if ( e.target.matches('.item .remove') ){
			// 	const confirmation = confirm("Are you sure to remove this item?");

			// 	if ( confirmation ){
			// 		const item = e.target.parentNode.parentNode.parentNode.parentNode;
			// 		item.parentNode.removeChild(item);
			// 		reorder_list(items);
			// 		document.getElementById('video-container').classList.add('hide');
			// 		if ( items.childElementCount == 0 ) add_empty_class();
			// 	}

			// }

			// // preview link
			// if ( e.target.matches('.control-options .preview') || e.target.matches('.links .item-link') ){
				
			// 	const isheader = e.target.classList.contains('isheader');
				
			// 	if ( ! isheader ){

			// 		document.getElementById('video-container').classList.remove('hide');


			// 		let item = e.target.parentNode.parentNode;
			// 		if ( ! item.classList.contains('item') ){
			// 			item = e.target.parentNode.parentNode.parentNode.parentNode;
			// 		}

			// 		const loading = document.createElement('img');
			// 		loading.src = vars_wp.assets_path + 'loading.gif';

			// 		const title = document.querySelector('#video-container .title');
			// 		title.innerHTML = item.querySelector('.control-name input').value;
			// 		title.appendChild(loading);

			// 		const video = document.querySelector('#video-container .video');
			// 		video.innerHTML = item.querySelector('.control-code textarea').value;
					
			// 		const notes = document.querySelector('#video-container .notes');
			// 		notes.innerHTML = item.querySelector('.control-notes textarea').value;

			// 		setTimeout(function(){
			// 			loading.parentNode.removeChild(loading);
			// 		}, 400);
			// 	}
			// 	else{
			// 		e.preventDefault();
			// 	} 

			// }// preview - link





			});

		}



		if ( obj_items ){
			obj_items.forEach( function( obj_item, index) {
				add_course( obj_item );
			});
		}
		else{
			add_empty_class();
		}




	}); //ready




	// function for adding new course
	function add_course( obj_item = null ){

		items.append(template);
		
		const item = items.find('li').last();
		const count = items.children().length;
		
		update_ids(item, count - 1);

		// // update values
		if ( obj_item ){
			update_values( item, obj_item );
		}
		else{
			item.find('.links .item-link').text( `Untitled-${count}` );
			item.find('.control-name input').val(`Untitled-${count}`);
			item.find('.control-options .cancel').addClass('hide');
		}
	}

	// add empty square
	function add_empty_class( empty = true){
		if ( empty )
			$('#list-items').addClass('empty');
		else
			$('#list-items').removeClass('empty');
	}


	// function to udpate ids attributes for the HTML item
	function update_ids( item, id){
		
		item.attr('data-id',id);
		
		item.find('.control-name label').attr('for', `name-${id}`);
		item.find('.control-name input').attr('id', `name-${id}`);
		item.find('.control-check-header label').attr('for', `isheader-${id}`);
		item.find('.control-check-header input').attr('id', `isheader-${id}`);
		item.find('.control-code label').attr('for', `code-${id}`);
		item.find('.control-code textarea').attr('id', `code-${id}`);
		item.find('.control-duration label').attr('for', `duration-${id}`);
		item.find('.control-duration input').attr('id', `duration-${id}`);
		item.find('.control-notes label').attr('for', `notes-${id}`);
		item.find('.control-notes textarea').attr('id', `notes-${id}`);
		item.find('.control-check-lock label').attr('for', `islock-${id}`);
		item.find('.control-check-lock input').attr('id', `islock-${id}`);
	}


	// for update item with object values
	function update_values( item, obj_item ){
		item.attr('data-old-id', obj_item.id_item);

		item.find('.links .item-link').text( obj_item.name );
		item.find('.control-name input').val( obj_item.name );
		item.find('.control-code textarea').val( obj_item.code );
		item.find('.control-duration input').val( (obj_item.duration) ? obj_item.duration: '' );
		item.find('.control-notes textarea').val( obj_item.notes );

		if ( obj_item.isheader) {
			item.find('.control-check-header input').prop( 'checked', true );
			set_header(item, false, true);
		} else {
			item.find('.control-check-header input').prop( 'checked', false );
			set_header(item, false, false);
		}

		if ( obj_item.islock ){
			item.find('.control-check-lock input').prop( 'checked', true );
			item.find('.links .item-link').addClass('islock');
		} else {
			item.find('.control-check-lock input').prop( 'checked', false );
			item.find('.links .item-link').removeClass('islock');
		}

	}

	// show/hide controls when is header
	function set_header( item , toogle = true , isheader = false ){
		
		const hasclass =  item.find('.links .item-link').hasClass('isheader');

		if ( ! toogle ) {
			if ( (isheader && ! hasclass) || (! isheader && hasclass) ){
				toogle = true;
			}
		}

		if ( toogle ) {
			item.find('.links .item-link').toggleClass('isheader');
			item.find('.control-code').toggleClass('hide');
			item.find('.control-duration').toggleClass('hide');
			item.find('.control-notes').toggleClass('hide');
			item.find('.control-check-lock').toggleClass('hide');
			item.find('.control-options .preview').toggleClass('hide');
		} 

	}



})( jQuery );





/*
let obj_items = null; // existent objects
let items = null; // dynamic items objects

window.addEventListener('load', function(){
	
	const content = document.getElementById('content');
	if ( content && content.value ){
		obj_items = JSON.parse(content.value);	
	}
	
	items = document.getElementById('list-items');

	if ( items ) {

		// Click Events for the link show/hide controls
		items.addEventListener('click', function(e) {
		
			// var scrollx = document.documentElement.scrollTop;

			if ( ! e.target ) return;

			//e.target.preventDefault();

			// show/hide controls link
			if ( e.target.matches('.item .item-arrow') ){

				let item = e.target.parentNode.parentNode;

				const link = item.querySelector('.links .item-arrow');
				const controls = item.querySelector('.controls');

				link.classList.toggle('down');
				controls.classList.toggle('hide');

				if ( ! link.classList.contains('down') ) {
					close_opens(item.dataset.id);
				}

				e.target.preventDefault();

			}

			// isheader conditional show/hide controls
			if ( e.target.matches('.item .control-check-header input') ){
				const item = e.target.parentNode.parentNode.parentNode;
				set_header(item);
			}

			// islock conditional to hide/show lock icon
			if ( e.target.matches('.item .control-check-lock input') ){	
				const item = e.target.parentNode.parentNode.parentNode;
				item.querySelector('.links .item-link').classList.toggle('islock');
			}

			//Cancel element
			if ( e.target.matches('.item .cancel') ){
				const item = e.target.parentNode.parentNode.parentNode.parentNode;
				
				// console.log(item.dataset.oldId);
				if ( item.dataset.oldId ){
					const obj_item = obj_items[item.dataset.oldId];
					update_values( item, obj_item);
				}

			}

			//Remove element
			if ( e.target.matches('.item .remove') ){
				const confirmation = confirm("Are you sure to remove this item?");

				if ( confirmation ){
					const item = e.target.parentNode.parentNode.parentNode.parentNode;
					item.parentNode.removeChild(item);
					reorder_list(items);
					document.getElementById('video-container').classList.add('hide');
					if ( items.childElementCount == 0 ) add_empty_class();
				}

			}

			// preview link
			if ( e.target.matches('.control-options .preview') || e.target.matches('.links .item-link') ){
				
				const isheader = e.target.classList.contains('isheader');
				
				if ( ! isheader ){

					document.getElementById('video-container').classList.remove('hide');


					let item = e.target.parentNode.parentNode;
					if ( ! item.classList.contains('item') ){
						item = e.target.parentNode.parentNode.parentNode.parentNode;
					}

					const loading = document.createElement('img');
					loading.src = vars_wp.assets_path + 'loading.gif';

					const title = document.querySelector('#video-container .title');
					title.innerHTML = item.querySelector('.control-name input').value;
					title.appendChild(loading);

					const video = document.querySelector('#video-container .video');
					video.innerHTML = item.querySelector('.control-code textarea').value;
					
					const notes = document.querySelector('#video-container .notes');
					notes.innerHTML = item.querySelector('.control-notes textarea').value;

					setTimeout(function(){
						loading.parentNode.removeChild(loading);
					}, 400);
				}
				else{
					e.preventDefault();
				} 

			}// preview - link

			// window.scroll(100,scrollx);
			// console.log(scrollx);

		} ); // click event listener


		// keyup for change link text with input name value
		items.addEventListener( 'keyup', function(e){
			
			if ( ! e.target ) return;

			if ( e.target.matches('.item .control-name input') ){
				const input = e.target;
				const item = input.parentNode.parentNode.parentNode;
				const link = item.querySelector('.item-link');
				link.innerHTML = input.value;
			};

		}); // keyup event listener


		// Order list with sorteable
		Sortable.create(items, {
			handle: ".my-handle",
			onEnd: function ( evt ) {
				if ( evt.oldIndex != evt.newIndex ){
					reorder_list( items );
				}
			}
		}); // sortable


	} // end-if items is not null 



	// Adding new item
	const addnew =  document.getElementById('add-item');
	if ( addnew ) {
			addnew.addEventListener('click', function(){
				add_empty_class(false);
				add_course();
		});
	}


	if ( obj_items ){
		obj_items.forEach( function( obj_item, index) {
			add_course( obj_item );
		});
	}
	else{
		add_empty_class();
	}


	//Submit event save
	const save = document.getElementById('vlfc-save');
	if ( save ){
		save.addEventListener('click', function(e) {
			e.preventDefault();

		  	const final_items = update_object();
		  	const content = document.getElementById('content');
		  	content.value = JSON.stringify(final_items);
		  	
		  	// send submit form
			document.getElementById('vlfc-admin-form-element').submit();
		});

	}

	document.getElementById('video-container').classList.add('hide');

}); //window.load

function add_empty_class( empty = true){
	if ( empty )
		document.getElementById('list-items').classList.add('empty');
	else
		document.getElementById('list-items').classList.remove('empty');
}

// show/hide controls when is header
function set_header( item , toogle = true , isheader = false ){
	
	const hasclass =  item.querySelector('.links .item-link').classList.contains('isheader');

	if ( ! toogle ) {
		if ( (isheader && ! hasclass) || (! isheader && hasclass) ){
			toogle = true;
		}
	}

	if ( toogle ) {
		item.querySelector('.links .item-link').classList.toggle('isheader');
		item.querySelector('.control-code').classList.toggle('hide');
		item.querySelector('.control-duration').classList.toggle('hide');
		item.querySelector('.control-notes').classList.toggle('hide');
		item.querySelector('.control-check-lock').classList.toggle('hide');
		item.querySelector('.control-options .preview').classList.toggle('hide');
	} 

}


// function for adding new course
function add_course( obj_item = null ){
	const listhtml = document.createRange().createContextualFragment(template);

	items.appendChild(listhtml);
	
	const item = items.lastChild;
	const count = items.childElementCount;

	update_ids(item, count - 1);

	// update values
	if ( obj_item ){
		update_values( item, obj_item );
	}
	else{
		item.querySelector('.links .item-link').innerText = `Untitled-${count}`;
		item.querySelector('.control-name input').value = `Untitled-${count}`;
		item.querySelector('.control-options .cancel').style.display = 'none';
	}
}

// for update item with object values
function update_values( item, obj_item ){
	item.setAttribute('data-old-id', obj_item.id_item);

	item.querySelector('.links .item-link').innerText = obj_item.name;
	item.querySelector('.control-name input').value = obj_item.name;
	item.querySelector('.control-code textarea').value = obj_item.code;
	item.querySelector('.control-duration input').value = (obj_item.duration) ? obj_item.duration: '';
	item.querySelector('.control-notes textarea').value = obj_item.notes;

	if ( obj_item.isheader) {
		item.querySelector('.control-check-header input').checked = true;
		set_header(item, false, true);
	} else {
		item.querySelector('.control-check-header input').checked = false;
		set_header(item, false, false);
	}

	if ( obj_item.islock ){
		item.querySelector('.control-check-lock input').checked = true;
		item.querySelector('.links .item-link').classList.add('islock');
	} else {
		item.querySelector('.control-check-lock input').checked = false;
		item.querySelector('.links .item-link').classList.remove('islock');
	}

}

// for hidden items open except id
function close_opens(id){
	items.querySelectorAll('.item').forEach( function( item, index) {
		if ( index != id ){
			item.querySelector('.links .item-arrow').classList.add('down');
			item.querySelector('.controls').classList.add('hide');
		}
	});
}

// function to udpate ids attributes for the HTML item
function update_ids( item, id){
	item.setAttribute('data-id', id);
	item.querySelector('.control-name label').setAttribute('for', `name-${id}`);
	item.querySelector('.control-name input').setAttribute('id', `name-${id}`);
	item.querySelector('.control-check-header label').setAttribute('for', `isheader-${id}`);
	item.querySelector('.control-check-header input').setAttribute('id', `isheader-${id}`);
	item.querySelector('.control-code label').setAttribute('for', `code-${id}`);
	item.querySelector('.control-code textarea').setAttribute('id', `code-${id}`);
	item.querySelector('.control-duration label').setAttribute('for', `duration-${id}`);
	item.querySelector('.control-duration input').setAttribute('id', `duration-${id}`);
	item.querySelector('.control-notes label').setAttribute('for', `notes-${id}`);
	item.querySelector('.control-notes textarea').setAttribute('id', `notes-${id}`);
	item.querySelector('.control-check-lock label').setAttribute('for', `islock-${id}`);
	item.querySelector('.control-check-lock input').setAttribute('id', `islock-${id}`);
}

function reorder_list( items ){
	items.querySelectorAll('.item').forEach( function(item, index) {
		update_ids(item, index);
	});
}


// update object data, pass data to object
function update_object(){
	let obj_items = new Array();

	items.querySelectorAll('.item').forEach( function ( item, index){
			obj_items.push(
				{
					id_item: index,
					name: item.querySelector('.control-name input').value,
					isheader: item.querySelector('.control-check-header input').checked,
					islock: item.querySelector('.control-check-lock input').checked,
					code: item.querySelector('.control-code textarea').value,
					duration: item.querySelector('.control-duration input').value,
					notes:item.querySelector('.control-notes textarea').value
				});
	});
	
	return obj_items;
}



*/


