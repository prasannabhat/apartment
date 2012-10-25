// modules/flat.js
// Module reference argument, assigned at the bottom
(function(Comm) {

Comm.MainView = Backbone.View.extend({

	tagName: "div",

	initialize:function () {
        this.template = _.template(tpl.get('communication'));
    },

	render: function() {
		$(this.el).html(this.template());
        return this;
	}
});

Comm.Router = Backbone.Router.extend({

    initialize:function () {
        var mainView;
		mainView = new Comm.MainView({el : $("#comm_content")}).render();
    },

    routes:{
        "users":"users",
        "flats":"flats"
    },

    users : function (){

    },

    flats : function(){

    }

});

// Function will be called after document load
Comm.start = function(){
	var that = this;
	tpl.loadTemplates(['communication'], function() {
		app = new Comm.Router();
    	Backbone.history.start();
		
	});
};

})(apartment.module("communication"));