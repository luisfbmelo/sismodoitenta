$(document).ready(function(){
    $(".videoItem").click(function(e){

        /*ADD HASH TO URL AND MAKE SCROLL STABLE*/
        var x = pageXOffset, y = pageYOffset;
        location.hash = '#'+$(this).attr("id");
        scrollTo(x,y);
        /*END*/

        var videoId = this.id;
        $.fancybox.showLoading();
        $.getJSON('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+videoId+'&key=AIzaSyAlMSgzWARfVJ81FEGHHqSsO5qjEUtnDLQ',function(data,status,xhr){
        //$.getJSON('http://gdata.youtube.com/feeds/api/videos/'+videoId+'?v=2&alt=jsonc&callback=?'

            var video = data.items[0]["snippet"]["localized"];
            var genericData = data.items[0]["snippet"];
            var desc = htmlEscape(video.description);
            desc = desc.replace(/\n/g, '<br/>');

            var videoEmbed = '<div style="display: inline-block;margin:10px 0;">';
                videoEmbed+='<div class="videoTitle">'+htmlEscape(video.title)+'</div>';
                videoEmbed+='<div class="videoDate">Carregado a '+genericData.publishedAt+'.</div>';
                videoEmbed+='<iframe width="680" height="495" src="http://www.youtube.com/embed/'+videoId+'?autoplay=1&rel=0&vq=large" frameborder="0" allowfullscreen></iframe>';
                videoEmbed+='<div class="videoDesc">'+desc+'</div>';
                videoEmbed+='<div class="fb-like" data-href="http://sismodoitenta.com/emocoes#'+videoId+'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>';
                //videoEmbed+='<div class="faceCom"><div class="fb-comments" data-href="http://sismodoitenta.com/emocoes#'+videoId+'" data-numposts="5"></div></div>';

            videoEmbed+='</div>';
            //ACTIVATE FACEBOOK COMMENTS
            
            $.fancybox(videoEmbed,{
                afterShow: function(){
                    $(".fancybox-inner").attr("tabindex",1).focus();
                    $.fancybox.hideLoading();
                }
            });
            FB.XFBML.parse();

        });

    });

    //ESCAPE TAGS
    function htmlEscape(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }
    function htmlUnescape(value){
        return String(value)
            .replace(/&quot;/g, '"')
            .replace(/&#39;/g, "'")
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&amp;/g, '&');
    }

    /*NAVIGATE MORE ARTICLES IN DETAILS*/
    var controllLeft = 0;
    var distance = 940;
    $(".prevList").click(function(){
        if (controllLeft-distance>=0){
            if (controllLeft-distance==0){
                $(".prevList").css("display","none");
            }

            if($('.nextList').css('display') == 'none'){
                $('.nextList').css("display","block");
            }

            controllLeft-=distance;
            $(".videosMask").animate({left: '+=940'}, 458, 'swing');

        }else{
            $(".videosMask").animate({left: 0}, 458, 'swing');
            controllLeft=0;
            $(".prevList").css("display","none");
            $(".nextList").css("display","block");
        }
    });

    $(".nextList").click(function(){
        if (controllLeft+distance<$(".videosMask").width() && $(".videosMask").width()>930){
            if($('.prevList').css('display') == 'none'){
                $('.prevList').css("display","block");
            }

            if (controllLeft+distance*2>=$(".videosMask").width()){
                $(".nextList").css("display","none");
                $(".videosMask").animate({left: '-'+($(".videosMask").width()-distance)}, 458, 'swing');
                controllLeft=$(".videosMask").width()-distance;
            }else{
                controllLeft+=distance;
                $(".videosMask").animate({left: '-=940'}, 458, 'swing');
            }
        }
    });

});
