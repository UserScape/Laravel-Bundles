$(function() {

	// Header pull down
	$('#topbar').dropdown();

	// Bundle detail page tabs
	$('.tabs a').tabs('show');

	// Adding / Editing Bundles
	$('#tags').tagit({tagSource: SITE_URL+"tags", select: true, initialTags: initialTags});
	$('#dependencies').tagit({tagSource: SITE_URL+"dependencies", select: true, initialTags: initialDependenciesTags});
	$('#repo').change(function(){
		var id = $(this).find("option:selected").text();
		$.ajax({
			beforeSend: function() {
				$('#ajax-loader').fadeIn();
				$('.info').fadeOut();
				$('.bundle_extras').fadeOut();
			},
			type: "POST",
			url: SITE_URL+'bundle/repo',
			data: "repo="+id,
			dataType: "json",
			success: function(resp) {
				$('#ajax-loader').fadeOut();
				$('#title').val(id);
				$('#path').val(id);
				$('#location').val(resp.url);
				$('#summary').val(resp.description);
				$('#description').val(resp.readme);
				$('#website').val(resp.homepage);
				$('.bundle_extras').fadeIn();
			}
		});
	});

	// Bundle Rating
	$('#rate').click(function(){
		var id = $(this).attr('data-id');
		var status = $(this).attr('data-active');

		if (status == 'notactive') {
			$('#modal-from-dom h3.title').html('Error');
			$('.modal-body').html('<p>You must be logged in to rate.</p>');
			$('.modal-footer').hide();
			$('#modal-from-dom').modal({
				show: true,
				backdrop: true
			});
			return false;
		} else if (status == 'rated') {
			$('#modal-from-dom h3.title').html('Error');
			$('.modal-body').html('<p>You have already rated this.</p>');
			$('.modal-footer').hide();
			$('#modal-from-dom').modal({
				show: true,
				backdrop: true
			});
			return false;
		}

		$.ajax({
			beforeSend: function() {
				$('#rate').addClass('rated');
			},
			type: "POST",
			url: SITE_URL+'rate',
			data: "id="+id,
			dataType: "json",
			success: function(resp) {
				if (resp.success){
					$('#ratings').html(resp.ratings +' likes');
					$('#msg_text').html('Thank you for rating.');
					$('#msg_box').addClass('alert-success').fadeIn();
				} else {
					$('#msg_text').html(resp.error);
					$('#msg_box').addClass('alert-info').fadeIn();
				}
			}
		});
	});

	// Dependency roll over.
	$("a[rel=dependency]")
		.popover({
		offset: 10
	});

	// Delete from the grid
	$('a.delete, a.remove').live('click', function () {
		var link = this;
		var id = $(link).attr("data-id");
		removemsg = "Are you sure you want to delete this record? \n It cannot be undone!";
		if (confirm(removemsg)) {
			if (link.href) {
				$.ajax({
					type: "POST",
					url: link.href,
					data: "confirm=true",
					dataType: "json",
					success: function(resp) {
						if (resp.success === true) {
							$(link).closest('tr').fadeOut();
						}
					}
				});
				return false;
			}
		}
		return false;
	});

	// Delete a category
	$('.delete-cat').live('submit', function(){
		var form_data = $(this).serialize();
		$.ajax({
			type: "POST",
			url: SITE_URL+'admin/cats/delete',
			data: form_data,
			dataType: "json",
			success: function(resp) {
				if (resp.success === true) {
					$(this).closest('tr').fadeOut();
					// reload the page so totals are updated
					location.reload();
				}
			}
		});
		return false;
	});
});


// jquerytools bootstrap validation
// http://bit.ly/wNYDE9
$(function () {
	function find_container(input) {
		return input.parent().parent();
	}
	function remove_validation_markup(input) {
		var cont = find_container(input);
		cont.removeClass('error success warning');
		$('.help-inline.error, .help-inline.success, .help-inline.warning',
			cont).remove();
	}
	function add_validation_markup(input, cls, caption) {
		var cont = find_container(input);
		cont.addClass(cls);
		input.addClass(cls);

		if (caption) {
			var msg = $('<span class="help-inline"/>');
			msg.addClass(cls);
			msg.text(caption);
			input.after(msg);
		}
	}
	function remove_all_validation_markup(form) {
		$('.help-inline.error, .help-inline.success, .help-inline.warning',
			form).remove();
		$('.error, .success, .warning', form)
			.removeClass('error success warning');
	}
	$('form').each(function () {
		var form = $(this);

		form
			.validator({
			})
			.bind('reset.validator', function () {
				remove_all_validation_markup(form);
			})
			.bind('onSuccess', function (e, ok) {
				$.each(ok, function() {
					var input = $(this);
					remove_validation_markup(input);
					// uncomment next line to highlight successfully
					// validated fields in green
					//add_validation_markup(input, 'success');
				});
			})
			.bind('onFail', function (e, errors) {
				$.each(errors, function() {
					var err = this;
					var input = $(err.input);
					remove_validation_markup(input);
					add_validation_markup(input, 'error',
						err.messages.join(' '));
				});
				return false;
			});
	});
});
