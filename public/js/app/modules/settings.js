// modules/flat.js
// Module reference argument, assigned at the bottom
(function(Settings,Configs) {

    Settings.ChangePasswordView = Backbone.View.extend({

        tagName: "div",

        events: {
            "click .form_action": "form_handler",
        },

        form_handler: function(e) {
            var config = apartment.module("configs");
            var params = {
                type: "POST",
                dataType: 'json'
            };
            var data_send;

            params.url = Settings.params.base_url + "/password";
            params.contentType = 'application/json';
            data_send = this.$el.find(".form-horizontal").serializeObject({
                include_disabled: true
            });
            data_send.user_id = config.user_id;
            params.data = JSON.stringify(data_send);

            params.success = _.bind(function(data, textStatus, jqXHR) {
                this.$spinner.hide();
                if(data.error == 1) {
                    _.each(data.messages, function(value, key) {
                        var rule = "input[name=" + key + "]";
                        var $elem = this.$el.find(rule);
                        $elem.next().text(value[0]);
                        $elem.closest('.control-group').addClass("error");
                        console.log(rule);
                    }, this);
                } else {

                    toastr.success('Password changed successfully');
                }

                // Check if there is any error in the response
                console.log(data);
            }, this);

            params.error = _.bind(function(jqXHR, textStatus, errorThrown) {
                this.$spinner.hide();
                toastr.error(errorThrown);
            }, this);

            // Start the progress bar
            this.clear_form();
            this.$spinner.show();
            $.ajax(params);

        },

        clear_form: function() {
            //Clear the error messages
            this.$el.find(".help-block").text('');
            //Clear any error blocks
            this.$el.find(".error").removeClass('error');
            this.$el.find("input").val('');
        },
        initialize: function() {
            this.template = _.template(tpl.get('change_password'));
        },

        render: function() {
            $(this.el).html(this.template());
            this.$spinner = this.$el.find(".progress");
            this.$spinner.hide();
            return this;
        }
    });

    Settings.GateWayListView = Backbone.View.extend({

        tagName: "div",

        events : {
            "click button" : "addGateway",

        },

        addGateway : function(){
            var gateway = new Settings.GatewayModel();
            // sync is somehow not working...change:id is triggered after callback from the server
            // I am manually triggering sync event!!
            gateway.on("sync",function(){
                this.collection.add(gateway);
            },this);
            var modal = new Settings.GatewayEditView({model : gateway}).render();
            modal.$el.modal('toggle');
        },

        initialize: function() {
            this.template = _.template(tpl.get('settings_gateways'));
            this.collection.on("reset add remove",this.fetchData,this);
        },

        fetchData : function(param1,param2){
            this.render();
        },

        render: function() {
            var $tbody;
            $(this.el).html(this.template());
            $tbody = this.$el.find("tbody").first();
            _.each(this.collection.models, function (item) {
                $tbody.append(new Settings.GateWayView({model:item}).render().el);
            }, this);
            return this;
        },
        
        beforeClose : function(){
            this.collection.off("fetch");
        }
    });

    Settings.GateWayView = Backbone.View.extend({

        tagName: "tr",

        events : {
            "click button" : "actionHandler",

        },

        actionHandler : function(e)
        {
            // Normalise the event to button element
            var action = $(e.target).closest("button").data("action");
            if(action === "edit")
            {
                // Present the form to edit the data
                var modal = new Settings.GatewayEditView({model : this.model}).render();
                modal.$el.modal('toggle');                

            }
            if (action === "delete")
            {
                if(confirm("Are you sure?"))
                {
                    this.model.destroy();
                }

            }
            
            return false;
        },

        initialize: function() {
            this.template = _.template(tpl.get('settings_gateway'));
            this.model.on("destroy",function(){
                this.close();
            },this);
            // Update the view after server sync
            this.model.on("sync",this.syncFunction,this); 
        },

        syncFunction : function(){
            this.render();
        },

        beforeClose : function(){
            this.model.off();
        },

        render: function() {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        }
    });    

    Settings.GatewayEditView = Backbone.View.extend({

        id : "gateway_form",

        className: "modal hide fade",

        attributes : {
            "tabindex" : -1,
            "role" : "dialog",
            "aria-hidden" : "true"
        },

        events : {
            "click button[data-action='save']" : "save",
            // Close the view by itself, when it is hidden
            "hidden" : function(){
                this.close();
            }

        },

        save : function(){
            var form_data = this.$el.find("form").first().serializeObject({
                include_disabled: true
            });
            this.model.save(form_data,{
                success : _.bind(this.saveConfirmed,this), 
                error : _.bind(function(model, xhr, options){
                    var data = JSON.parse(xhr.responseText);
                    this.render(data.errors.messages);
                },this),
                // silent: true,
                // wait: true
            });
        },

        saveConfirmed : function(model, response, options){
            toastr.success("Updated successfully");
            this.$el.modal('hide');
            // this.model.trigger("sync");

        },

        initialize: function() {
            this.template = _.template(tpl.get('settings_gateway_form'));
            // this.model.on("all",function(event){
            //     alert("Testing model edit events : " + event);
            // },this);                                    

        },

        render: function(errors) {
            // Default options, unless specified.
            errors || (errors = {});
            $(this.el).html(this.template({
                gateway : this.model.toJSON(),
                gateways : Configs.gateways,
                errors : errors
            }));
            return this;
        }
    });    




    Settings.GatewayModel = Backbone.Model.extend({
        urlRoot : function(){ return Settings.params.base_url + "/gateway";},
        defaults: {
            "name": "",
            "user" : "",
            "code": "",
            "type": 0
        }
    });

    Settings.GateWayCollection = Backbone.Collection.extend({
        model : Settings.GatewayModel,
        url : function(){ return Settings.params.base_url + "/gateway";}
    });    

    Settings.Router = Backbone.Router.extend({

        initialize: function() {
            this.$container = $("#settings_content");
            Settings.gateway_collection = new Settings.GateWayCollection();
            Settings.gateway_collection.fetch();
            // Settings.gateway_collection.on("all",function(event){
            //     alert("Testing collection event : " + event);
            // });

        },

        routes: {
            "password": "password",
            "gateways": "gateways"
        },

        gateways: function() {
            if(this.activeView) {
                this.activeView.close();
            }
            var gatewayListView = new Settings.GateWayListView({
                collection : Settings.gateway_collection
            }).render();
            this.$container.append(gatewayListView.el);
            this.activeView = gatewayListView;
        },

        password: function() {
            if(this.activeView) {
                this.activeView.close();
            }
            var changePasswordView = new Settings.ChangePasswordView().render();
            this.$container.append(changePasswordView.el);
            this.activeView = changePasswordView;
        },

    });

    // Function will be called after document load
    Settings.start = function(params) {
        Settings.params = params;
        tpl.loadTemplates(['change_password','settings_gateways','settings_gateway_form','settings_gateway'], function() {
            app = new Settings.Router();
            Backbone.history.start();

        });
    };

})(apartment.module("settings"),apartment.module("configs"));