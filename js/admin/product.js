$(function(){
	$('#catUrl').on('change', changeCategory);
	$('.productDel').on('click', confirmProductDel);
	$('.hideProduct').on('click', hide_showProduct);
	$('.hideMainProduct').on('click', hide_showMainProduct);
})


function changeCategory(){
	var cat = $(this).val();
	var arr = window.location.pathname.replace(/\//gm,' ').trim().split(' ');
	var url = '/';
	for (var i = 0, len = arr.length; i < len; i++) {
		url += arr[i] + '/';
		if( 'products' == arr[i]) break;
	}

	url += cat + '/';

	window.location.href = url;

	$('#products tbody').html('');
	

}

function confirmProductDel(e){
	e.preventDefault();
	var product = $(this).parents('tr').find('.productName a').text();
	var delProdConf = confirm("Вы действительно хотите удалить " + product + "?");
	var productId = $(this).data('prodid');

	if (delProdConf == true) {
		//alert('ee');
		
			$.ajax({
					type: 'POST',
					url: '/admin/delete_product',
					data: {'iD': productId},
					success: function (data){
						//alert('sss');
						$(e.target).parents('tr').remove();
					}
			});

	}
}

function hide_showProduct(e) {
	e.preventDefault();
	var productId = $(this).data('prodid');
	//var category = $(this).parents('tr').find('.categoryName').text();
	var $that = $(this);
	if ($(this).data('action') == 'hide') {
		$.ajax({
					type: 'POST',
					url: '/admin/hide_product',
					data: {'id':productId},
					success: function (data){
						console.log(data);
						$that.data('action', 'show').text('Показать');
						$(e.target).text("Показать");
					}
			});	
	}
	else if ($(this).data('action') == 'show') {
		$.ajax({
					type: 'POST',
					url: '/admin/show_product',
					data: {'id':productId},
					success: function (data){
						console.log(data);
						$that.data('action', 'hide').text('Скрыть');
						$(e.target).text("Скрыть");
					}
			});	
	}
}

function hide_showMainProduct(e) {
	e.preventDefault();
	var productId = $(this).data('prodid');
	var $that = $(this);
	if ($(this).data('action') == 'hide') {
		$.ajax({
					type: 'POST',
					url: '/admin/hide_main_product',
					data: {'id':productId},
					success: function (data){
						console.log(data);
						$that.data('action', 'show').text('Показать на гл. странице');
						$(e.target).text("Показать на гл. странице");
					}
			});	
	}
	else if ($(this).data('action') == 'show') {
		$.ajax({
					type: 'POST',
					url: '/admin/show_main_product',
					data: {'id':productId},
					success: function (data){
						console.log(data);
						$that.data('action', 'hide').text('Скрыть с гл. страницы');
						$(e.target).text("Скрыть с гл. страницы");
					}
			});	
	}
}