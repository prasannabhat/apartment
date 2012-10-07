// modules/flat.js
// Module reference argument, assigned at the bottom
(function(Flat) {

Flat.View = Backbone.View.extend({

	tagName: "tr",

	events: {
		"click .icon-edit" : "edit"
	},

	initialize: function(){
		alert("View created");
	},

	render: function() {
	}
});

 

})(apartment.module("flat"));