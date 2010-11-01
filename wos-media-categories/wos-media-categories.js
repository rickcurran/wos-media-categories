/* MEDIA CATEGORIES JAVASCRIPT */
jQuery(document).ready(function($) {
	function getChecked() {
		var n = $("#wos-media-categories-list input:checked").length;
		var cat_checked = $("#wos-media-categories-list input:checked");
		var cat_arr = $(cat_checked).map(function() {
				return $(this).val();
			}).get().join();
		$('#media-single-form .media-single .media-item tr.category > td.field > input.text').val(cat_arr);
    }
	$('.wos-categories-cb').click(function() {
		getChecked();
	});
	
});

