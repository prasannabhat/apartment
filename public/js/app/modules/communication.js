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

	events: {
       "submit form":  function(e){
        e.preventDefault();
        return false;
       },
      "change input:radio" : "smsTypeChanged",
      "click #add_flat" : "addFlat",
      "click #edit_selected_flats" : "editSelectedFlats",
      "click .form_action" : "form_button_handler",
      // "keyup #flat" : function(e){
      //   if(e.keyCode == 13) {
      //    alert('Enter key detected');
      //   }
      //   return false;
      //   // addFlat(e);
      // },
      "blur #selected_flats" : function(e){
        // Back to uneditable, after the element looses focus
        $(e.target).attr("disabled",true);
      }
  	},

    form_button_handler : function(e){
      var action = $(e.target).data("action");
      e.preventDefault();
      // If the button is not relevant , then skip
      if((action != "list_users") && (action != "send_message")){
        return false;
      }
      var params = {type: "POST", dataType: 'json'};
      var data_send;

      // Clear the message
      this.$message.text('');
      params.url = Comm.params.base_url;
      params.contentType = 'application/json';
      data_send = this.$el.find(".form-horizontal").serializeObject({include_disabled : true});
      // data_send = this.$el.find("form").serializeObject({include_disabled : true});
      // Target to send the message to
      data_send.target = "flats";
      data_send.action = action;
      params.data = JSON.stringify(data_send);

      params.success = _.bind(function(data, textStatus, jqXHR){
        // List the selected users, based on the action
        if(data_send.action == "list_users"){
          if(this.user_list_view){
            this.user_list_view.close();
          }
          this.user_list_view = new Comm.UserListView({collection: data}).render();
          this.$el.append(this.user_list_view.el);
        }
        else{
          this.$message.text(data.message);
          if(data.error){
            this.$message.css('color','red');
          }
          else{
            this.$message.css('color','green'); 
          }
        }
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

    editSelectedFlats : function(e){
      var $selected_flats = this.$el.find('input[name="selected_flats"]');
      // Make it editable
      $selected_flats.removeAttr("disabled");

    },

    addFlat : function(e){
      var $current_flat = this.$el.find('input[name="flat"]');
      var current_flat = $current_flat.val();

      // element holding already selected flats
      var $selected_flats = this.$el.find('input[name="selected_flats"]'); 
      var selected_flats = $selected_flats.val();
      
      // Dont seperate by comma for the first entry 
      var delimiter = selected_flats ? "," : "";
      // Add the currently selected flat
      selected_flats = selected_flats + delimiter + current_flat;
      $selected_flats.val(selected_flats);

      // Clear the current flat
      $current_flat.val("");


    },

    smsTypeChanged : function(e){
      var checkedValue = $(e.target).val();
      switch(checkedValue){
        case 'single':
          $(".hide_single").hide();
          $(".hide_group").show();
        break;

        case 'group':
          $(".hide_group").hide();
          $(".hide_single").show();
        break;
      }

    },

	initialize:function () {
        this.template = _.template(tpl.get('comm_flats'));
    },

	render: function() {
		$(this.el).html(this.template());
    this.$el.find("#flat").typeahead({source:Comm.params.flats_array});
    //cache the progress bar
    this.$spinner = this.$el.find(".progress");
    this.$message = this.$el.find(".action_result");
    this.$spinner.hide();
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

// View to display the list of selected members
Comm.UserListView = Backbone.View.extend({

  tagName: "div",

  initialize:function () {
        this.template = _.template(tpl.get('user_list'));
    },

  render: function() {
    $(this.el).html(this.template({users : this.collection}));
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
Comm.start = function(params){
	Comm.params = params;
	tpl.loadTemplates(['communication','comm_flats','comm_users','user_list'], function() {
		app = new Comm.Router();
    	Backbone.history.start();
		
	});
};

})(apartment.module("communication"));