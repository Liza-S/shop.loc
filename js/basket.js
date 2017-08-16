$(function(){

	$('.product .count input').on('input', changeCount);
	$('.product .delete').on('click', deleteItem);
	$('.basket_control .clear_basket').on('click', deleteAllItem);

	//if(window.location.pathname.replace(/\//gm,' ').trim().split(' ')[1] == 'makeBid'){
		//$("#order_modal").modal('show');
	//}

})

function changeCount(){

	// изменение стоимости продукта, у которого меняем количество
	var $this = $(this),
		count = Math.floor(Math.abs(+$this.val())),
		price = $this.parents('.row.product').eq(0).data('item-price'),
		elId  = $this.parents('.row.product').eq(0).data('prodid');

	if(isNaN(count) || count> 999999 || count<= 0) return;
	var common_price =  (price * count).toFixed(2);
	console.log(common_price);
	$(".product[data-prodid='"+elId+"']").find('.common_price').text('$' + common_price);

    $.ajax({
    	type: 'POST',
    	url: '/basket/change_count',
    	dataType: "json",
    	data: {'id': elId, 'count': count},
    	success: function(data) {
    		if(data.status == false) {
				alert(data.error_desc);
				return;
			} 
			else $('#basketPrice').text('$' + data.price);
		}
    });
}

function deleteItem(e){
	e.preventDefault();
	var productName = $(this).parent('div').find('.prodTitle').text();
	var delProdBaskConf = confirm("Вы действительно хотите удалить " + productName + "?");
	var prodBaskId = $(this).parent('div').data('prodid');
	/*alert(prodBaskId);*/
	if (delProdBaskConf == true) {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '/basket/delete_product',
			data: {'id':prodBaskId},
			success: function (data){
				$('#basketPrice').text('$' + data.price);
				$(".product[data-prodid='"+prodBaskId+"']").remove();
			}
		});
	}
}

function deleteAllItem(e) {
	e.preventDefault();
	var delAllProd = confirm("Вы действительно хотите очистить корзину?");
	if (delAllProd == true) {
		$.ajax({
			type: 'POST',
			url: '/basket/delete_all_products',
			dataType: 'json',
			success: function (data){
				/*$(e.target).parents('div').remove();*/
				$('.product').remove();
				$('#basketPrice').text('$' + data.price);
			}
		});
	}
}