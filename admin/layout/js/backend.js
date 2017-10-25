$(function () {

	'use strict';

	// Dashboard
	$('.toggle-info').click(function () {
		$(this).toggleClass('selected').parent().next('.panel-body').slideToggle(200);
		if ($(this).hasClass('selected')) {
			$(this).html('<i class="fa fa-plus fa-lg"></i>' );
		} else {
			$(this).html('<i class="fa fa-minus fa-lg"></i>' );
		}
	});

	// Hide placeholder on form focus
	$('[placeholder]').focus(function () {
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function () {
		$(this).attr('placeholder', $(this).attr('data-text'));
	});


	// Add Asterisk On Required Fields
	$('input').each(function () {
		if ($(this).attr('required') === 'required') {
			$(this).after('<span class="asterisk">*</span>');
		}
	});

	// Convert password field to text field on (eye)hover
	var passField = $('.password');

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});

	// Confirmation Message On Button
	$('.confirm').click(function () {
		return confirm('Are You Sure!'); 
	});

	// Cetgory view option 
	$('.cat h3').click(function() {
		$(this).next('.full-view').fadeToggle(200);
	});

	$('.option span').click(function() {

		$(this).addClass('active').siblings('span').removeClass('active');

		if ($(this).data('view') === 'full') {
			$('.cat .full-view').fadeIn(200);
		} else {
			$('.cat .full-view').fadeOut(200);
		}
	});

});