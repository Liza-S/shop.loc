$(function(){

	$('.product .count input').on('input', changeCount);
	$('.product .delete').on('click', deleteItem);
	$('.basket_control .clear_basket').on('click', deleteAllItem);

	if(window.location.pathname.replace(/\//gm,' ').trim().split(' ')[1] == 'makeBid'){
		$("#order_modal").modal('show');
	}

})

function changeCount(){

	// изменение стоимости продукта, у которого меняем количество
	var $this = $(this),
		count = Math.abs(+$this.val()),
		price = $this.parents('.row.product').eq(0).data('item-price'),
		elId  = $this.parents('.row.product').eq(0).data('item-id');

	if(isNaN(count) || count> 999999 || count<= 0) return;
	var common_price =  (price * count).toFixed(2);
	$(".product[data-item-id='"+elId+"']").find('.common_price').text('$' + common_price);
	// ---

    $.ajax({
    	type: 'POST',
    	url: 'changeCount/',
    	data: {'productId': elId, 'count': count},
    	success: function(basketPrice) {
    		$('#basketPrice').text('$' + basketPrice);
    	}
    });
	
}

function deleteItem(){

	var wrapper = $(this).parents('.row.product').eq(0);
	var id = wrapper.data('item-id');

	location.href = 'delete/' + id;

}

function deleteAllItem() {

	location.href = 'delete/all/';

}