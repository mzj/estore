function productsApp() {
	//
	var Product = Backbone.Model.extend({
		//collection: Messages,
		/*url: function() {
			if (this.isNew()) return 'api/messages';
			return 'api/messages/'+this.get('id');
		  }	*/
		  
		  url: 'api/products'
	});
	
	//
	var Messages = Backbone.Collection.extend({
		model: Message,
		
        initialize: function(models, options) {
        	this.url = options.url;
        },
		
		create : function(model, options) {
			var coll = this;
			options || (options = {});
			if (!(model instanceof Backbone.Model)) {
				model = new this.model(model, {collection: coll});
			} else {
				model.collection = coll;
			}
			var success = function(nextModel, resp) {
				coll.add(nextModel);
				if (options.success) options.success(nextModel, resp);
			};
			return model.save(null, {success : success, error : options.error});
		}
	});
	
	//	
	var MessagesView = Backbone.View.extend({
		template: $("#main_template").html(),
		el: $('#main'),
		
		events: {
			"click #btn-add" : "add"
		},
		
		initialize: function() {
			this.collection.bind('add', this.render, this);
			this.collection.bind('reset', this.render, this);
			this.render();
		},
		
		add: function(e) {
			e.preventDefault();
			
			message = new Message({
			  subject: $('#subject-add').val(),
			  body: $('#body-add').val()
			});
			
			this.collection.create(message);
		},
		
		render: function() {
			this.el.html(_.template(this.template, {'messages': this.collection.toJSON()}));
			return this;
		}
		
	
	});
	
	//
	var MessageView = Backbone.View.extend({
		template: $("#message_template").html(),
		el: $('#main'),
		
		initialize: function() {
			this.render();
		},
		
		render: function() {
			this.el.html(_.template(this.template, {'message': this.model.toJSON()}));
			return this;
		}
	});
	
	//
	var App = Backbone.Router.extend({
		views: {},
		messagesView: null,
		routes: {
			"" : "index",
			"msg/:id" : "message"
		},
		
		// Ovde stavis index stranu ili 
		// mozes cak da je i izdvojis u posebnu metodu/funkc
		initialize: function(data) {
			messages = new Messages([], {url: 'api/messages'});		
		},
		 
		// Index route
		index: function() {
			messages.fetch({success: function(){
				if(!this.messagesView) {
					this.messagesView = new MessagesView({ 
						collection: messages
					});
				}
			}});
		},
		
		// Ovde je za pojedinacnu poruku
		// Kreiras modele/kolekciju i view i povezs 
		message: function(id) {
			messageView = new MessageView({
					model: messages.get(id)
				});	 
		}
	});
	
	Backbone.history.start();	 

	
};
