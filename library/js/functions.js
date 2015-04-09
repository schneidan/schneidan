$j=jQuery.noConflict();

// Add classes to image-containing wp-caption elements for responsive styling
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

// clear the search box when it's focused
$j('input#s').focus( function() {
	var save_this = $j(this);
    window.setTimeout (function(){ 
       save_this.val(''); 
    },10);
});

// show the search box and focus it when the button is clicked
$j('.show-search').on('click', function(){
	$j(this).hide();
	$j('.hidden-form').animate({
		width:'100%'
	},50,function(){
		$j('.hidden-form input#s').focus();
	});
});

// don't submit the search form if it's empty
$j('#searchform').submit(function() {
    if ($j.trim($j("#s").val()) === "") {
    	$j('input#s').focus();
	    return false;
    }
});