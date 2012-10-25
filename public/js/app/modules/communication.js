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

Comm.FlatsView = Backbone.View.extend({

	tagName: "div",

	className: "tab-pane active",

	id	: "flats",

	initialize:function () {
        this.template = _.template(tpl.get('comm_flats'));
    },

	render: function() {
		$(this.el).html(this.template());
        return this;
	}
});

Comm.UsersView = Backbone.View.extend({

	tagName: "div",

	className: "tab-pane",

	id	: "users",	

	className: "tab-pane",	

	initialize:function () {
        this.template = _.template(tpl.get('comm_users'));
    },

	render: function() {
		$(this.el).html(this.template());
        return this;
	}
});

Comm.Router = Backbone.Router.extend({

    initialize:function () {
        var mainView,flatsView,usersView;
		mainView = new Comm.MainView({el : $("#comm_content")}).render();
		
		flatsView = new Comm.FlatsView().render();
		mainView.$el.find(".tab-content").append(flatsView.el);
		
		usersView = new Comm.UsersView().render();
		mainView.$el.find(".tab-content").append(usersView.el);

		this.mainView = mainView;
		this.flatsView = flatsView;
		this.usersView = usersView;
    },

    routes:{
        "users":"users",
        "flats":"flats"
    },

    users : function (){
    	this.mainView.$el.find('a[href="#users"]').tab('show');
    },

    flats : function(){
    	this.mainView.$el.find('a[href="#flats"]').tab('show');
    }

});

// Function will be called after document load
Comm.start = function(){
	var that = this;
	tpl.loadTemplates(['communication','comm_flats','comm_users'], function() {
		app = new Comm.Router();
    	Backbone.history.start();
		
	});
};

})(apartment.module("communication"));