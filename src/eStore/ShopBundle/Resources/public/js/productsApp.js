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
        url: 'api/products.json',
        
        initialize: function(models, options) {
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
                    category: $('#estore_shopbundle_filtertype_categories').val(),
                    ppp: $("#per-page").val(),
                    minprice: $("#slider-range").slider("values", 0), 
                    maxprice: $("#slider-range").slider("values", 1),
                    gender: $('input:radio[name=estore_shopbundle_filtertype[gender]]:checked').val(),
                    size: $('#filter-size').val(),
                    obp: $('#filter-price-order').val(),
                    colours: getColoursStr()
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
            products = new Products;
            
            products.fetch({
                data: { 
                    page: 1,
                    category: $('#estore_shopbundle_filtertype_categories').val(),
                    ppp: $("#per-page").val(),
                    minprice: $("#slider-range").slider("values", 0),
                    maxprice: $("#slider-range").slider("values", 1),
                    gender: $('input:radio[name=estore_shopbundle_filtertype[gender]]:checked').val(),
                    size: $('#filter-size').val(),
                    obp: $('#filter-price-order').val(),
                    colours: getColoursStr()
                },
                processData: true,
                success: function() {
                    this.productsView = new ProductsView({ 
                        collection: products
                    });
               }
           });
        }
     });

    function getColoursStr() {
        var coloursVals = '';
         $('input:checkbox[name=estore_shopbundle_filtertype[colours]]:checked').each(function() {
           coloursVals += '-' + $(this).val();
         });
        coloursVals = coloursVals.substring(1);
        
        return coloursVals;
    }
    
    $('input:checkbox[name=estore_shopbundle_filtertype[colours]]').each(function() {
           $(this).attr('checked', true);
           $(this).parent().addClass('checked');
    });
    
     $('#estore_shopbundle_filtertype_gender_4').attr('checked', true);
     $('#estore_shopbundle_filtertype_gender_4').parent().addClass('checked');
    
    new App;
    Backbone.history.start();
};
