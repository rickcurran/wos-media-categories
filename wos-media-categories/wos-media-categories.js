/* MEDIA CATEGORIES JAVASCRIPT */
function wos_category_click(cat){
	var container = jQuery(cat).closest("tbody");
	var cat_checked = jQuery(container).find("tr.all_categories input:checked");
	var cat_arr = jQuery(cat_checked).map(function() {
		return jQuery(this).val();
	}).get().join();
	jQuery(container).find("tr.category > td.field > input.text").val(cat_arr);
}