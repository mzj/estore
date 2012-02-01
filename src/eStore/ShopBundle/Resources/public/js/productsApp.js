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
    
    var FilterView = Backbone.View.extend({
        el: '#formFilter',

        events : {
            "click #btnFilter" : "changed",
            "change input" : "changed",
            //"change price-filter" : "changed", 
            "change input[type=text]": "changed",
            "change select" : "changed"
        },

        initialize: function () {
            _.bindAll(this, "changed");
            alert('fdf');
        },
        changed:function(e) {
          /* var changed = evt.currentTarget;
           var value = $("#"+changed.id).val();
           var obj = "{\""+changed.id +"\":\""+value+"\"}";
           var objInst = JSON.parse(obj);
           this.model.set(objInst);*/ 
           e.preventDefault();
           alert('kljik');
        }
    });
    
    
    var SliderView = Backbone.View.extend({
        el: '#slider-filter',

        events : {
            "change #slider-filter" : "changed"
        },

        initialize: function () {
            _.bindAll(this, "changed");
            alert('fdf');
        },
        changed:function(e) {
          /* var changed = evt.currentTarget;
           var value = $("#"+changed.id).val();
           var obj = "{\""+changed.id +"\":\""+value+"\"}";
           var objInst = JSON.parse(obj);
           this.model.set(objInst);*/
           alert('jeeej');
        }
    });

    //
    var App = Backbone.Router.extend({
        views: {},
        productsView: null,
        filterView: null,
        sliderView: null,
        routes: {
            ":page/:ppp" : "index"
        },

        initialize: function(data) {
            //this.route(":number", "page", function(number){ alert(number) });
            this.filterView = new FilterView();
            this.sliderView = new SliderView();
        },

        // Index route
        index: function(page, ppp) {
            this.productsView = null;
            products = null;
            page = page > 0 ? page : 1;
            ppp  = ppp > 0 ? ppp : 1;
            products = new Products([], {url: 'api/products.json?page=' + page + '&ppp=' + ppp});
            products.fetch({
                success: function() {
                    this.productsView = new ProductsView({ 
                        collection: products
                    });
                }});
        }
     });

    new App;
    Backbone.history.start();
};
