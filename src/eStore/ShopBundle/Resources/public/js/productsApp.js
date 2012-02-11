function productsApp() {
    
    var pagerfanta;
    
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
        
         /**
          *  This is the place where you can play with returned JSON
          *  Example: 
          *  pagerefanta = response.pagerfanta
          *  return response.products
          */
        parse: function(response) {
           var pagination = new Pagination(response.pagerfanta);
           pagination.render();
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
                console.log(this.collection);
                this.el.fadeOut('fast', function(){
                   sg.el.empty(); 
                   sg.el.html(_.template(sg.template, {'products': sg.collection.toJSON()}));
                   if(sg.collection.length == 0) {
                       sg.el.html("No products found.");
                   }
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
            // Resets page to one, and that
            // trigers index route
            Backbone.history.loadUrl('1');
            window.location.replace('#1')
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
            ":pageQs" : "index"
        },

        initialize: function(data) {
            this.filterView = new FilterView();
            products = null;
            products = new Products;
        },

        index: function(pageQs) {
            pageQs = pageQs ? pageQs : 1;
            
            products.fetch({
                data: { 
                    page: pageQs,
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
                    if(this.productsView == null) {
                        this.productsView = new ProductsView({ 
                            collection: products
                        });
                    }
               }
           });
        }
     });
     
    /**
     * 
     */
    function getColoursStr() {
        var coloursVals = '';
         $('input:checkbox[name=estore_shopbundle_filtertype[colours]]:checked').each(function() {
           coloursVals += '-' + $(this).val();
         });
        coloursVals = coloursVals.substring(1);
        
        return coloursVals;
    }
    
    /**
     *
     */
    function Pagination(pagerfanta) {
        var page = pagerfanta.currentPage;
        var prevPage = page - 1;
        var nextPage = page + 1;
        var nbPages = pagerfanta.nbPages;
        var nbResults = pagerfanta.nbResults;
        var el = $('#pagination');
        var html = '';
        
        this.render = function() {
            if(page > 1) {
                html += '<li><a href="#' + (page-1) + '">' + '<img src="/bundles/estoreshop/img/arrow-left.png" />' + '</a></li>';
            }

            for(i = 1; nbPages >= i; i++) {
                html += '<li><a href="#' + i + '">' + i + '</a></li>';
            }

            if(page < nbPages) {
                html += '<li><a href="#' + (page+1) + '">' + '<img src="/bundles/estoreshop/img/arrow-right.png" />' + '</a></li>';
            }
            el.html(html);
        };
    }
    
    function add2Cart(id) 
    {
        var baseUrl = location.href;
        baseUrl = baseUrl.replace(/\/$/g, '');
            
        $.ajax({
            url: baseUrl + '/cart/add/' + id,
            
            success: function( data ) {
                $('.cart-items-number').text(data);
            }
            
        });
    }
    
    
    //
    $('input:checkbox[name=estore_shopbundle_filtertype[colours]]').each(function() {
           $(this).attr('checked', true);
           $(this).parent().addClass('checked');
    });
    
    //
    $('#estore_shopbundle_filtertype_gender_4').attr('checked', true);
    $('#estore_shopbundle_filtertype_gender_4').parent().addClass('checked');
    
    
    $(document).on("click", '.add2Cart', function(event){
        add2Cart($(this).attr('id'));
    });
    
    //
    new App;
    //
    Backbone.history.start();
};
