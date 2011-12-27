function productsApp() {
    //
    var Product = Backbone.Model.extend({
              url: 'api/products.json'
    });

    //
    var Products = Backbone.Collection.extend({
        model: Product,

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
            },
         /**
          *  This is the place where you can play with returned JSON
          *  Example: 
          *  pagerefanta = response.pagerfanta
          *  return response.products
          */
        parse: function(response) {
            console.log(response.pagerfanta);
           return response.products;
        }
    });

    //	
    var ProductsView = Backbone.View.extend({
            template: $("#products-template").html(),
            el: $('#products'),



            initialize: function() {
                    this.collection.bind('reset', this.render, this);
                    this.render();
            },

            render: function() {
                    this.el.html(_.template(this.template, {'products': this.collection.toJSON()}));
                    return this;
            }


    });



    //
    var App = Backbone.Router.extend({
            views: {},
            productsView: null,
            routes: {
                    "" : "index",
                    "product/:id" : "product"
            },

            // Ovde stavis index stranu ili 
            // mozes cak da je i izdvojis u posebnu metodu/funkc
            initialize: function(data) {
                    products = new Products([], {url: 'api/products.json?page=2'});		
            },

            // Index route
            index: function() {
                    products.fetch({success: function(){
                            if(!this.productsView) {
                                    this.messagesView = new ProductsView({ 
                                            collection: products
                                    });
                            }
                    }});
            }

    });

    new App;
    Backbone.history.start();	 


};
