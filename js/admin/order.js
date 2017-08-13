$(function(){
	$('.paid').on('change', paidForOrder);
})

function paidForOrder(){
	var orderId = $(this).data('orderid');
	var $self = $(this);
	console.log($self);

	$.ajax({
		type: 'POST',
		url: '/admin/paid',
		data: {'id':orderId},
		success: function(data) {
			$self.parents('div').eq(0).html('Да');
		}
	});
}