/* ===== Navbar Search ===== */
$('#navbar-search > #open-search').on('click', function() {
    $(this).toggleClass('show hidden');
    $('#navbar-search > #close-search').toggleClass('show hidden');
    $("#navbar-search-box").toggleClass('show hidden animated fadeInDown');
    return false;
});
$('#navbar-search > #close-search').on('click', function() {
    $(this).toggleClass('show hidden');
    $('#navbar-search > #open-search').toggleClass('show hidden');;
    $("#navbar-search-box").toggleClass('fadeInDown fadeOutUp');
    setTimeout(function(){
        $("#navbar-search-box").toggleClass('show hidden animated fadeOutUp');
    }, 500);
    return false;
});

/* ====== Comments ===== */
$('.comment-textarea').on('focusin', function() {
    $(this).attr('rows', '3');
    $('.comment-send-btn').toggleClass('show hidden');
    $('.comment-form').toggleClass('focusin');
    return false;
});
$('.comment-textarea').on('focusout', function() {
    $(this).attr('rows', '2');
    $('.comment-send-btn').toggleClass('show hidden');
    $('.comment-form').toggleClass('focusin');
    return false;
});

/* ===== Thumbs rating ===== */
$('.rating .voteup').on('click', function () {
    var up = $(this).closest('div').find('.up');
    up.text(parseInt(up.text(),10) + 1);
    return false;
});
$('.rating .votedown').on('click', function () {
    var down = $(this).closest('div').find('.down');
    down.text(parseInt(down.text(),10) + 1);
    return false;
});

/* ===== Height equal ===== */
$('.math-height').matchHeight();

/* ===== Swipebox ===== */
var photobox = {};

$.each($(".swipebox-holder"), function(){
	var holder = $(this).data('swipebox');
	
	if ( typeof photobox[holder] === 'undefined' ) {
		photobox[holder] = holder;
		
		$("a[data-swipebox='"+ holder +"']").swipebox();
	}
});

/* ===== Main navigation tweak ===== */
var mainNavTweak = function(){
   var width  		= $(window).width();
   var dropdown 	= $('.navbar-fixed-top .navbar-nav > li.dropdown');
   
   dropdown.removeClass('open close');
	
	if ( width >= 768 ) {
		dropdown.find('> a').removeAttr('data-toggle');
	}
	else{
		dropdown.find('> a').attr('data-toggle', 'dropdown');
	}
}

mainNavTweak();

/**
 * On window resized
 */ 
$(window).resize(function () {
   mainNavTweak();
});