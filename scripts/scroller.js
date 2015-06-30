$(document).ready(function(){

    function isScrolledIntoView(elem)
    {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    /*SCROLLING ANIMATIONS*/
    //controlVars
    var box5 = false,
        box8 = false;

    //elements array
    var elements = [$(".deads"),$(".escudos"),$(".euros"),];

    //animate first
    animateEle($(".richter"),7.2,1000,1);
    animateEle($(".mercali"),9,1000,0);

    $(window).scroll(function(){
        if (box5==false && isScrolledIntoView(elements[0])){
            animateEle(elements[0],73,1000,0);
            box5=true;
        }

        if (box8==false && isScrolledIntoView(elements[1]) && isScrolledIntoView(elements[2])){
            animateEle(elements[1],257608914.50,2000,2);
            animateEle(elements[2],1284947.85,2000,2);
            box8=true;
        }
    });

    function animateEle(elem,toNum,speedNum,dec){
        elem.countTo({
            from: 0,
            to: toNum,
            speed: speedNum,
            refreshInterval: 10,
            decimals: dec
        });
    }

});