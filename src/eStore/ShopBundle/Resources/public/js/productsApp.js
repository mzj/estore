function productsApp() {
    //
    var Product = Backbone.Model.extend({
             // url: 'api/products'
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
           //console.log(response.pagerfanta);
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
                    ":page" : "index",
                   "test" : "testR"
            },

            initialize: function(data) {
                //this.route(":number", "page", function(number){ alert(number) });
                
            },

            // Index route
            index: function(page) {
                this.productsView = null;
                products = null;
                page = page > 0 ? page : 1;
                products = new Products([], {url: 'api/products/' + page + '.json'});
                products.fetch({
                    success: function() {
                            this.productsView = new ProductsView({ 
                                collection: products
                            });
                        
                    }});
            },
            
            // Index route
            testR: function() {
               alert("Test route!");
            }
            
            
    });

    new App;
    Backbone.history.start();	 


};
