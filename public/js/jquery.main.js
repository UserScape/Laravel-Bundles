$(function() {
	$('#tags').tagit({tagSource: SITE_URL+"tags", select: true, initialTags: initialTags});
	$('#dependencies').tagit({tagSource: SITE_URL+"dependencies", select: true, initialTags: initialDependenciesTags});
});
