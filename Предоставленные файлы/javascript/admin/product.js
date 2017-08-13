$(function(){
	$('#catUrl').on('change', changeCategory);
	$('.productDel').on('click', confirmProductDel);
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
}

function confirmProductDel(e){
	//e.preventDefault();
	var product = $(this).parents('tr').find('.productName a').text();

	return confirm("Вы действительно хотиет удалть " + product + "?");


}