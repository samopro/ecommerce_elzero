$(function () {

	'use strict';

	// Switch Between Login & Signup
	$('.login-page h1 span').click(function () {
		$(this).addClass('selected').siblings().removeClass('selected'); 

		if ($('.login-page span.signup').hasClass('selected')) {
			$('form.login').hide();
			$('form.signup').show();
		} else {
			$('form.login').show();
			$('form.signup').hide();
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

	

	// Confirmation Message On Button
	$('.confirm').click(function () {
		return confirm('Are You Sure!'); 
	});

	// Live preview
	$('.live-name').keyup(function () {
		$('.live-preview .caption h3').text($(this).val());
	});

	$('.live-desc').keyup(function () {
		$('.live-preview .caption p').text($(this).val());
	});

	$('.live-price').keyup(function () {
		$('.live-preview .price-tag').text('$' + $(this).val());
	});

});