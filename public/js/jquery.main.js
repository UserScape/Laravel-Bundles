$(function() {
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
				$('#location').val(resp.url);
				$('#summary').val(resp.description);
				$('#website').val(resp.homepage);
				$('.bundle_extras').fadeIn();
			}
		});
	});
	$('#rate').click(function(){
		var id = $(this).attr('data-id');
		var status = $(this).attr('data-active');

		if (status == 'notactive') {
			alert('You must be logged in to rate.');
			return false;
		} else if (status == 'rated') {
			alert('You have already rated this.');
			return false;
		}

		$.ajax({
			beforeSend: function() {
				$('#rate').fadeOut();
			},
			type: "POST",
			url: SITE_URL+'rate',
			data: "id="+id,
			dataType: "json",
			success: function(resp) {
				console.log(resp)
				if (resp.success){
					$('#msg_text').html('Thank you for rating.');
					$('#msg_box').addClass('success').fadeIn();
				} else {
					$('#msg_text').html(resp.error);
					$('#msg_box').addClass('info').fadeIn();
				}
			}
		});
	});
});
