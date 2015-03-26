$j=jQuery.noConflict();

function addFigureClassToImages() {
	$j('img.size-thumbnail').each(function(){
		$j(this).parents('figure.wp-caption').addClass('figure-thumbnail');
	});
	$j('img.size-medium').each(function(){
		$j(this).parents('figure.wp-caption').addClass('figure-medium');
	});
	$j('img.size-large').each(function(){
		$j(this).parents('figure.wp-caption').addClass('figure-large');
	});
	$j('img.size-full').each(function(){
		$j(this).parents('figure.wp-caption').addClass('figure-full');
	});
}
$j(document).ready(function(){
	addFigureClassToImages();
});