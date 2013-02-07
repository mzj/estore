/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var cartStatus;
var yourUrl = location.href;
var parse_url = /^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;
var parts = parse_url.exec( yourUrl );
var result = parts[1]+':'+parts[2]+parts[3]+'/' ;

var baseUrl = result;
var hashless_url = result;

function add2Cart() {
    $('.add-to-cart-view').click(function() {
        var id = $(this).attr('id');
        
        if(cartStatus) {
           removeFromCartView(id); 
        } else {
           addToCartView(id);
        }
    });
}

    function addToCartView(id) 
    {
        $.ajax({
            url: baseUrl + 'cart/add/' + id,
            
            beforeSend: function() { 
                $('#'+id).attr('src', hashless_url + '/bundles/estoreshop/img/loading.gif');
            },
            success: function( data ) {
                $('.cart-items-number').text(data);
                $('#'+id).attr('src', hashless_url + '/bundles/estoreshop/img/icon-cart-remove.png');
                cartStatus = true;
            }
            
        });
    }
    
    function removeFromCartView(id) 
    {
        $.ajax({
            url: baseUrl + 'cart/remove/' + id,
            beforeSend: function() { 
                $('#'+id).attr('src', hashless_url + '/bundles/estoreshop/img/loading.gif');
            },
            success: function( data ) {
                $('.cart-items-number').text(data);
                $('#'+id).attr('src', hashless_url + '/bundles/estoreshop/img/icon-cart-add.png');
                cartStatus = false;
            }
            
        });
    }