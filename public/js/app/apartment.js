var apartment = {
 // Create this closure to contain the cached modules
 module: function() {
    // Internal module cache.
    var modules = {};
  
    // Create a new module reference scaffold or load an
    // existing module.
    return function(name) {
      // If this module has already been created, return it.
      if (modules[name]) {
        return modules[name];
      }

      // Create a module and save it under this name
      return modules[name] = { Views: {} };
    };
  }()
};

Backbone.View.prototype.close = function () {
    if (this.beforeClose) {
        this.beforeClose();
    }
    this.remove();
    this.unbind();
};

$(document).ready(function(){
	var ROUTE_FLATS = '/flats';
	var ROUTE_FLAT = '/flats/flat';
	var ROUTE_MEMBER = '/members/member';
	var ROUTE_FLAT_MEMBERS = '/flats/members';
	var ROOT_URL = get_root_url();
	
	$("#app-top-nav").on("click", "a", function(event){
		var value = $(this).text();
		switch(value){
			case "Members":
			break;

			case "Flats":
			break;
		}
	});

	$("#flats_table").on("click", "button", function(event){
		var id = $(this).closest("tr").attr('id');
		if($(this).hasClass("app-edit-flat")){
			window.location = ROOT_URL + ROUTE_FLAT + "/" + id;
		}

		if($(this).hasClass("app-edit-flat-members")){
			var new_location = ROOT_URL + ROUTE_FLAT_MEMBERS + "/" + id;
			sessionStorage.setItem("back-url",new_location);
			window.location = new_location;
		}		
	});
	
	$("#flat_members_table").on("click", "button", function(event){
		var id = $(this).closest("tr").attr('id');
		if($(this).hasClass("app-edit-member")){
			window.location = ROOT_URL + ROUTE_MEMBER + "/" + id;
		}
	});	

	$("#flat_cancel").on('click', function(event) {
		window.location = ROOT_URL + ROUTE_FLATS;
	});

	$("#flat_delete").on('click', function(event) {
		if (confirm("Are you sure to delete?"))
		{
			$('[name=_method]').val('DELETE');
			$("#flat_edit_form").submit();
		}
	});

	$("#flat_add_member").on('click',function(event){
// Store the current URL...use it when the cancel button is pressed
		var new_location = ROOT_URL + ROUTE_MEMBER; 
		location.href = new_location;
		return false;

	});
	

	$("#member_cancel").on('click', function(event) {
		location.href = sessionStorage.getItem("back-url");
		return false;
	});

	$("#flat_add").on('click', function(event) {
		window.location = ROOT_URL + ROUTE_FLAT;
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

	function get_root_url(){
		// If it is not already part of session, calculate it
		if (!sessionStorage.getItem("root_url"))
		{
			var url = window.location.href;
			var re = /^(.*?)\/(?:login|flats|members)/;
			sessionStorage.setItem("root_url", url.match(re)[1]);
		}
		return sessionStorage.getItem("root_url");
	}

});