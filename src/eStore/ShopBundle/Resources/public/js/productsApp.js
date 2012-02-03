function productsApp() {

    /**
     *
     */
    var Product = Backbone.Model.extend({
    });

    /**
     *
     */
    var Products = Backbone.Collection.extend({
        model: Product,

        initialize: function(models, options) {
            this.url = options.url;
        },
        
         /**
          *  This is the place where you can play with returned JSON
          *  Example: 
          *  pagerefanta = response.pagerfanta
          *  return response.products
          */
        parse: function(response) {
           return response.products;
        }
    });

    /**
     *
     */	
    var ProductsView = Backbone.View.extend({
        template: $("#products-template").html(),
        el: $('#products'),
        fadeState: false,
        
        initialize: function() {
                this.collection.bind('reset', this.render, this);
                this.render();
        },

        render: function() {
                var sg = this;
                this.el.fadeOut('fast', function(){
                   sg.el.empty(); 
                   sg.el.html(_.template(sg.template, {'products': sg.collection.toJSON()}));
                   sg.el.fadeIn('fast');
                });
                return this;
        }
    });
    
    /**
     *
     */
    var FilterView = Backbone.View.extend({
        el: '#formFilter',

        events : {
            "click #btnFilter" : "changed",
            "change input" : "changed",
            "slidechange #slider-range" : "changed", 
            "change input[type=text]": "changed",
            "change select" : "changed"
        },

        initialize: function () {
            _.bindAll(this, "changed");
        },
        
        changed:function(e) {
            e.preventDefault();
            console.log("Changed event");
            products.fetch({
                data: { 
                    page: 1, 
                    ppp: $("#per-page").val() 
                },
                processData: true,
                success: function() {
                    console.log("Data fetched");
                }
            });
            }
        });
    

    /**
     *
     */
    var App = Backbone.Router.extend({
        views: {},
        productsView: null,
        filterView: null,
        sliderView: null,
        routes: {
            "" : "index"
        },

        initialize: function(data) {
            this.filterView = new FilterView();
        },

        index: function() {
            this.productsView = null;
            products = null;
            products = new Products([], {url: 'api/products.json?page=1&ppp=2' });
            products.fetch({
                success: function() {
                    this.productsView = new ProductsView({ 
                        collection: products
                    });
               }
           });
        }
     });

    new App;
    Backbone.history.start();
};
