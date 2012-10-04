$(document).ready(function(){
	var BASE_URL = 'http://localhost/apartment/public';
	var ROUTE_FLATS = '/flats';
	$("#flats_table").on("click", "tr", function(event){
		if ($(this).hasClass('flat_entry')) {
			var params = {type: "GET",async : false};
			var id = $(this).attr('id')
			params.url = "flats/flat/" + id;
			// Send a normal get request
			window.location = window.location + "/flat/" + id;
			// $.ajax(params);
		} 
	});

	$("#flat_cancel").on('click', function(event) {
		window.location = BASE_URL + ROUTE_FLATS;
	});

	$("#flat_delete").on('click', function(event) {
		if (confirm("Are you sure to delete?"))
		{
			$('[name=_method]').val('DELETE');
			$("#flat_edit_form").submit();
		}
	});

	$("#flat_add").on('click', function(event) {
		window.location = window.location + "/flat";
		// var form = $('<form></form>');

	 //    form.attr("method", "post");
	 //    form.attr("action", window.location);

	    // $.each(parameters, function(key, value) {
	    //     var field = $('<input></input>');

	    //     field.attr("type", "hidden");
	    //     field.attr("name", key);
	    //     field.attr("value", value);

	    //     form.append(field);
	    // });

	    // The form needs to be apart of the document in
	    // order for us to be able to submit it.
	    // $(document.body).append(form);
	    // form.submit();
	    // form.remove();		
		return false;
	});

});