// TOP HEADER
$(window).scroll(function(){
    if($(document).scrollTop() > 600){
        $('#headerBackground').fadeIn();
        $('#btn2').show();
        $('#btn1').hide();
    } else {
        $('#headerBackground').fadeOut();
        $('#btn2').hide();
        $('#btn1').show();
    }
});

// BRUTE FORCE AUTOPLAY
document.getElementById('autoPlayForce').play();
document.getElementById('autoPlayForce2').play();

$(document).ready(function(){
    $("#action-toggle").click(function(event){
        event.preventDefault();
        $(".model-menu").fadeToggle();
    });
});

$(document).ready(function(){
    $("#btn-search-toggle-in").click(function(event){
        event.preventDefault();
        $("#search-top-toggle").fadeIn();
        $("#menu-top-toggle").hide();
        $("#btn-search-toggle-out").show();
        $("#btn-search-toggle-in").hide();
    });
});

$(document).ready(function(){
    $("#btn-search-toggle-out").click(function(event){
        event.preventDefault();
        $("#menu-top-toggle").fadeIn();
        $("#search-top-toggle").hide();
        $("#btn-search-toggle-in").show();
        $("#btn-search-toggle-out").hide();
    });
});

$(document).ready(function(){
    $(".home-menu, #list-cascata").mouseover(function(event){
        event.preventDefault();
        $(".sub-menu-btns").show();

    });
});

$(document).ready(function(){
    $("#time-menu, #about-menu, #contact-menu, #products-menu, #home-menu").mouseover(function(event){
        event.preventDefault();
        $(".sub-menu-btns").hide();
    });
});

$(document).ready(function(){
    $("#list-cascata").mouseout(function(event){
        event.preventDefault();
        $(".sub-menu-btns").hide();
    });
});

jQuery(function($){
	$("#date").mask("99/99/9999",{placeholder:"dd/mm/aaaa"});
	$("#code").mask("999999");
 });
