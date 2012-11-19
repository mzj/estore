/**
 * File: productsApp.js
 * Desc: Main application for real time products presentation/filtering
 * Using backbone.js as structure framework
 * Author: markozjovanovic@gmail.com	
 * Date: Nov. 2012
 */

function productsApp() {
    var baseUrl = location.href;
    var hash = window.location.hash;
    var index_of_hash = baseUrl.indexOf(hash) || baseUrl.length;
    var hashless_url = baseUrl.substr(0, index_of_hash);
    
    baseUrl = hashless_url.replace(/\/$/g, '');
    baseUrlWithoutApp = hashless_url.replace(/app_dev.php/g, '');
    baseUrlWithoutApp = baseUrlWithoutApp.replace(/\/$/g, '');
    baseUrlWithoutApp = baseUrlWithoutApp.replace(/\/$/g, '');
    
    var cartProducts;
    var pagerfanta;
    
    /**
     * Product model
     */
    var Product = Backbone.Model.extend({
    });

    /**
     * Products collection
     */
    var Products = Backbone.Collection.extend({
        
        
        model: Product,
        url: baseUrl + '/api/products.json',
        
         /**
          *  This is the place where you can play with returned JSON
          *  Example: 
          *  pagerefanta = response.pagerfanta
          *  return response.products
          */
        parse: function(response) {
           var pagination = new Pagination(response.pagerfanta);
           pagination.render();
           cartProducts = response.cart;
           return response.products;
        }
    });


    /**
     * Backbone product view
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
                   addCartIcon();
                   sg.el.fadeIn('fast');
                });
                return this;
        }
    });
    
    /**
     * Backbone filter view
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
     * Application - backbone router
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
    
    /**
     * Adding/removing from cart
     */
    function cartAction(el)
    {
        var id  = $(el).attr('id');
        var img = $(el).attr('src');
        
        if(img == 'http://estore.com/bundles/estoreshop/img/icon-cart-add.png' || 
           img == '/bundles/estoreshop/img/icon-cart-add.png') {
           addToCart(id);
        } else {
           removeFromCart(id);
        }
    }
    
    /**
     * 
     */
    function addToCart(id) 
    {
        $.ajax({
            url: baseUrl + '/cart/add/' + id,
            
            beforeSend: function() { 
                $('#'+id).attr('src', baseUrlWithoutApp + '/bundles/estoreshop/img/loading.gif');
            },
            success: function( data ) {
                $('.cart-items-number').text(data);
                $('#'+id).attr('src', baseUrlWithoutApp + '/bundles/estoreshop/img/icon-cart-remove.png');
            }
            
        });
    }
    
    
    /**
     * 
     */
    function removeFromCart(id) 
    {
        $.ajax({
            url: baseUrl + '/cart/remove/' + id,
            beforeSend: function() { 
                $('#'+id).attr('src', baseUrlWithoutApp + '/bundles/estoreshop/img/loading.gif');
            },
            success: function( data ) {
                $('.cart-items-number').text(data);
                $('#'+id).attr('src', baseUrlWithoutApp + '/bundles/estoreshop/img/icon-cart-add.png');
            }
            
        });
    }
    
    /**
     * 
     */
    function addCartIcon() 
    {
        $('.add-to-cart').each(function() {
            var id = $(this).attr('id');
            
            $.each(cartProducts, function(index, value, sg) {
                if(id == value) {
                    $('#' + id).attr('src', baseUrlWithoutApp + '/bundles/estoreshop/img/icon-cart-remove.png');
                }
            });
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
    
    //
    $(document).on("click", '.add-to-cart', function(event){
        cartAction(this);
    });
    
    //
    new App;
    //
    Backbone.history.start();
};
