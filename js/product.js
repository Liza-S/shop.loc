
function addToBasket() {
	var productId = $('.productId').val();
	var basketPrice = $('#basketPrice').text();
	$.ajax({
			type: 'POST',
			dataType: "json",
			url: '/product/add_to_basket',
			data: {'id':productId, 'basketPrice': basketPrice },
			success: function (data){
				
				// в случае ошибки
				if(data.status == false) {
					alert(data.error_desc);
					return;
				} else {
					$('#basketPrice').text('$' + data.price);
				}
			}
	});	
}