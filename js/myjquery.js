$(document).ready(function(){

    console.log('i am here');

    

    $("#div1Image").animate({right: '274px'}, 2000);

    $("#div2Image").animate({left: '274px'}, 2000);

    $("#brandStoryheading").animate({right: '274px'}, 2000);

    $("#brandStoryPara").animate({right: '274px'}, 2000);

$("#organicSelectionHeading ").animate({left: '274px'}, 2000);

$(".organicProducts").mouseenter(function(){
    $(".productTitle").fadeIn(2000);
$(".productDescription").fadeIn(2000);

})






    $("#contactSection").animate({left: '274px'}, 2000);

    $("#getInTouchHeading").animate({right: '274px'}, 2000);

    // Animation for footer content
    $("#div4").animate({bottom: '50px'}, 2000);

    // Animation for product section
    $(".product").animate({opacity: 1}, 2000);


    $(".remove-item").click(function(){
        console.log('remove btn clicked');
    })
});
