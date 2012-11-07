// modules/flat.js
// Module reference argument, assigned at the bottom
(function(Settings) {

Settings.ChangePasswordView = Backbone.View.extend({

	tagName: "div",

  events : {
    "click .form_action" : "form_handler",
  },

	form_handler : function(e){
      var params = {type: "POST", dataType: 'json'};
      var data_send;

      params.url = Settings.params.base_url + "/password";
      params.contentType = 'application/json';
      data_send = this.$el.find(".form-horizontal").serializeObject({include_disabled : true});
      params.data = JSON.stringify(data_send);

      params.success = _.bind(function(data, textStatus, jqXHR){
        this.$spinner.hide();

        // Check if there is any error in the response
        console.log(data);
        console.log(textStatus);
      },this);
      
      params.error = _.bind(function (jqXHR, textStatus, errorThrown){
        this.$spinner.hide();
      },this);

      // Start the progress bar
      this.$spinner.show();
      $.ajax(params);

  },
  initialize:function () {
        this.template = _.template(tpl.get('change_password'));
    },

	render: function() {
		$(this.el).html(this.template());
    this.$spinner = this.$el.find(".progress");
    this.$spinner.hide();
        return this;
	}
});

Settings.Router = Backbone.Router.extend({

    initialize:function () {
      this.$container = $("#settings_content");

    },

    routes:{
        "password":"password",
        "flats":"flats"
    },

    password : function (){
      if(this.activeView)
      {
        this.activeView.close();
      }
      var changePasswordView = new Settings.ChangePasswordView().render();
      this.$container.append(changePasswordView.el);
      this.activeView = changePasswordView;
    },

});

// Function will be called after document load
Settings.start = function(params){
	Settings.params = params;
	tpl.loadTemplates(['change_password'], function() {
		  app = new Settings.Router();
    	Backbone.history.start();
		
	});
};

})(apartment.module("settings"));