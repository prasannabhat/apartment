$(document).ready(function(){
	var ROUTE_FLATS = '/flats';
	var ROUTE_FLAT = '/flat';
	
	$("#flats_table").on("click", "tr", function(event){
		if ($(this).hasClass('flat_entry')) {
			var id = $(this).attr('id');
			// Send a normal get request
			window.location = window.location.href + ROUTE_FLAT + "/" + id;
		} 
	});

	$("#flat_cancel").on('click', function(event) {
		var re = new RegExp(".*?" + ROUTE_FLATS);
		window.location = re.exec(window.location.href)[0];
	});

	$("#flat_delete").on('click', function(event) {
		if (confirm("Are you sure to delete?"))
		{
			$('[name=_method]').val('DELETE');
			$("#flat_edit_form").submit();
		}
	});

	$("#flat_add").on('click', function(event) {
		window.location = window.location + ROUTE_FLAT;
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