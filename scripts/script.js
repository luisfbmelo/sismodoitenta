jQuery(window).load(function(){
    $(document).ready(function(){
      $(".owl-carousel").owlCarousel({

        nav: true,
        dots: false,
        items: 4,
        navText: ['<i class="fa fa-chevron-left fa-2x"></i>', '<i class="fa fa-chevron-right fa-2x"></i>'],
        responsive : {
            // breakpoint from 0 up
            0 : {
                items : 2,
            },
            // breakpoint from 480 up
            480 : {
                items : 2,
                
            },
            // breakpoint from 768 up
            768 : {
                items : 4,
            }
        }
      });
    });
	//$.backstretch("img/bg.jpg");

    /*DISABLE RIGHT CLICK ON IMAGES*/
    $("img").bind("contextmenu",function(e){
        e.preventDefault();
    });

	/*MENU ANIMATION*/
	var l = 5;
	$( "nav ul li a" ).hover(function(){
		if ($.browser.msie && $.browser.version.substr(0,1)<10) {

	   		for( var i = 0; i < 5; i++ ){
	     		$(this).animate( { 'margin-left': "+=" + ( l = -l ) + 'px' }, 70);
	     	}
	     	$(this).stop();
	     	$(this).removeAttr('style');
	   	}
	},function(){
		if ($.browser.msie && $.browser.version.substr(0,1)<10) {
	     	$(this).stop();
	     	$(this).removeAttr('style');
	   	}
	});

    /*MAP CONSTRUCTER*/
    if ($('#map').length>0){
        /*MOMENTS MAP DEPLOY*/
          //maxBounds:[[39.074445, -27.687002],[38.261705, -26.503225]],
          //minZoom: 12,
        var map = new L.Map('map', {center: new L.LatLng(38.72194763, -27.22892761), zoom: 12,minZoom: 2, zoomAnimation: false,markerZoomAnimation: false,zoomControl:false});
        /* var googleLayer = new L.Google('ROADMAP');
        map.addLayer(googleLayer); */
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        //MARKERS
        var picMap='img/picMap.png',
            compareMap='img/compareMap.png'

        //CUSTOM MARKERS
        //setting the class
        var photoIcon = L.Icon.extend({
            options: {
                iconSize:     [38, 42], // size of the icon
                shadowSize:   [30, 34], // size of the shadow
                iconAnchor:   [15, 30], // point of the icon which will correspond to marker's location
                shadowAnchor: [12, 33],  // the same for the shadow
                popupAnchor:  [0, -33] // point from which the popup should open relative to the iconAnchor
            }
        });

        //icons instances
        var picIcon = new photoIcon({iconSize: [30, 33],iconUrl: picMap}),
        compareIcon = new photoIcon({iconSize: [30, 33],iconUrl: compareMap});

        var markers = [];
        var targets = [];
        var itemId = [];
        var markersGroup = new L.MarkerClusterGroup({
            maxClusterRadius: 25,
            spiderfyOnMaxZoom: true,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            disableClusteringAtZoom: 16
        });



        //ASK FOR OBJECTS
        $.ajax({
          url: 'includes/requests/fotos.php',
          type:"POST",
          dataType: 'json',
          data:{ get: "maps" },
          success: function(data){



            for (var a=0;a<data.length;a++){
                if(data[a].lat && data[a].lon){
                    if (data[a].type==1){
                        markers[a] = L.marker([data[a].lat, data[a].lon], {icon: compareIcon});
                        markersGroup.addLayer(markers[a]);
                        targets[a] = "#data_"+(data[a].id);
                        itemId[a] = data[a].id;

                    }else{
                        markers[a] = L.marker([data[a].lat, data[a].lon], {icon: picIcon});
                        markersGroup.addLayer(markers[a]);

                        targets[a] = "#data_"+(data[a].id);
                        itemId[a] = data[a].id;
                    }

                    var title = data[a].titulo || "Título desconhecido";

                    //bind popup
                    //var divNode = document.createElement('DIV');
                    //divNode.innerHTML = '<div class="minDataTitle">'+data[a].titulo+'</div><div class="minImg"><img src="img/mapPics/'+data[a].id+'/'+data[a].foto1+'" width="150"/></div>';
                    var divNode = '<div class="minDataTitle">'+title+'</div><div class="minImg"><img src="img/mapPics/'+data[a].id+'/'+data[a].foto1+'" width="150"/></div>';
                    markers[a].bindPopup(divNode);

                    //onmouseover
                    markers[a].on("mouseover",function(){
                        this.openPopup();
                    });

                    //onmouseout
                    markers[a].on("mouseout",function(){
                        this.closePopup();
                    });

                    //onclick

                    //NEED THIS CALL BACK BECAUSE THE LOOP INCREMENT DOESN'T GO TO THE MARKER IF NOT CLICKED
                    //SO IT GET'S THE LAST VALUE OF THE LOOP
                    function markerClick(a){
                      return function(){
                          $.fancybox.showLoading();
                          /*ADD HASH TO URL AND MAKE SCROLL STABLE*/
                          var x = pageXOffset, y = pageYOffset;
                          location.hash = '#'+itemId[a];
                          scrollTo(x,y);
                          /*END*/

                          var thisEl = this;

                          //EMPTY FOTOS BOX
                          $(".picBoxesMoments").empty();


                          //REQUEST FOTOS TO COMPARE
                          $.ajax({
                              url: 'includes/requests/singleFoto.php',
                              type:"POST",
                              dataType: 'json',
                              data:{ fotoId: itemId[a] },
                              success: function(infoPrint){
                                  //APPEND HTML TO BODY
                                  $(".picBoxesMoments").append(infoPrint);

                                  

                                  //CLOSE ALL POPUPS
                                  thisEl.closePopup();

                                  //ACTIVATE FACEBOOK COMMENTS
                                  FB.XFBML.parse(document,function(){
                                      $.fancybox(targets[a],{
                                        afterShow: function(){
                                            $(".fancybox-inner").attr("tabindex",1).focus();
                                            
                                            //EXECUTE THE COMPARE FUNCTION
                                            $(targets[a]+' .imagesToCompare').beforeafter({
                                                message: "Arraste"
                                            });

                                            /*DISABLE RIGHT CLICK ON IMAGES*/
                                            $("img").bind("contextmenu",function(e){
                                                e.preventDefault();
                                            });
                                        }
                                      });
                                      
                                      $.fancybox.hideLoading();
                                  });

                                  //$.fancybox.hideLoading();
                              },
                              error: function(){
                                  //$.fancybox.hideLoading();
                              }
                          });
                      }
                    }
                    markers[a].on("click",markerClick(a));
                }
            }

            map.addLayer(markersGroup);
          }
        });
    }




    /*TESTIMONIALS*/
    //NEW
    $(".newPost").click(function(){
        /*ADD HASH TO URL AND MAKE SCROLL STABLE*/
        var x = pageXOffset, y = pageYOffset;
        location.hash = '#novo';
        scrollTo(x,y);
        /*END*/

        $.fancybox.showLoading();
        $.ajax({
            url: 'includes/requests/formTest.php',
            type:"POST",
            dataType: 'json',
            data:{ form: true },
            success: function(data){
                $(".testForm").empty();
                $(".testForm").append(data);
                $.fancybox($(".testForm"),{
                    afterShow: function(){
                        $(".fancybox-inner").attr("tabindex",1).focus();
                    }
                });
                $.fancybox.hideLoading();
            },
            error: function(err){
                console.error(err);
            }
        });
        //$.fancybox($(".testForm"));
    });

    //VIEW
    $(document).on('click', '.testemunhoBox', function(){

      /*ADD HASH TO URL AND MAKE SCROLL STABLE*/
      var x = pageXOffset, y = pageYOffset;
      location.hash = '#'+$(this).attr("id");
      scrollTo(x,y);
      /*END*/

      $.fancybox.showLoading();
      var targetId = this.id;
      //ASK FOR OBJECTS

      //EMPTY EMOTIONS BOX
      $(".boxEmotions").empty();


      $.ajax({
          url: 'includes/requests/testemunho.php',
          type:"POST",
          dataType: 'json',
          data:{ id: targetId },
          success: function(data){
            //APPEND HTML TO BODY
            $(".boxEmotions").append(data);

            var bodyId = "#details-box_"+(targetId);
            FB.XFBML.parse(document,function(){
                $.fancybox(bodyId,{
                    afterShow: function(){
                        $(".fancybox-inner").attr("tabindex",1).focus();
                    }
                });
                $.fancybox.hideLoading();
            });

          },
          error: function(err){
              $.fancybox.hideLoading();
          }
      });
    });

    /*IF THERE IS ANY HASH FROM FACEBOOK SHARE*/
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

    if(window.location.hash) {
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
        var targetId = hash;

        if (hash=="novo"){
            $.fancybox.showLoading();
            $.ajax({
                url: 'includes/requests/formTest.php',
                type:"POST",
                dataType: 'json',
                data:{ form: true },
                success: function(data){
                    $(".testForm").empty();
                    $(".testForm").append(data);
                    $.fancybox($(".testForm"),{
                        afterShow: function(){
                            $(".fancybox-inner").attr("tabindex",1).focus();
                        }
                    });
                    $.fancybox.hideLoading();
                },
                error: function(err){
                    console.error(err);
                }
            });
        }else if (hash.match(/^\d+$/)){
            if ($(".testemunhoBox").length>0){
                $.fancybox.showLoading();

                //ASK FOR OBJECTS

                //EMPTY EMOTIONS BOX
                $(".boxEmotions").empty();

                $.ajax({
                    url: 'includes/requests/testemunho.php',
                    type:"POST",
                    dataType: 'json',
                    data:{ id: targetId },
                    success: function(data){
                        //APPEND HTML TO BODY
                        $(".boxEmotions").append(data);
                        var bodyId = "#details-box_"+(targetId);
                        FB.XFBML.parse(document,function(){
                            $.fancybox(bodyId,{
                                afterShow: function(){
                                    $(".fancybox-inner").attr("tabindex",1).focus();
                                }
                            });
                            $.fancybox.hideLoading();
                        });

                    },
                    error: function(){
                        $.fancybox.hideLoading();
                    }
                });
            }else if ($(".picBoxesMoments").length>0){
                var target = hash;
                $.fancybox.showLoading();

                //EMPTY FOTOS BOX
                $(".picBoxesMoments").empty();

                //REQUEST FOTOS TO COMPARE
                $.ajax({
                    url: 'includes/requests/singleFoto.php',
                    type:"POST",
                    dataType: 'json',
                    data:{ fotoId: hash },
                    success: function(infoPrint){
                        //APPEND HTML TO BODY
                        $(".picBoxesMoments").append(infoPrint);


                        //ACTIVATE FACEBOOK COMMENTS
                        FB.XFBML.parse(document,function(){
                            $.fancybox("#data_"+target,{
                                afterShow: function(){
                                    $(".fancybox-inner").attr("tabindex",1).focus();

                                    //EXECUTE THE COMPARE FUNCTION
                                    $("#data_"+target+' .imagesToCompare').beforeafter({
                                        message: "Arraste"
                                    });

                                    /*DISABLE RIGHT CLICK ON IMAGES*/
                                    $("img").bind("contextmenu",function(e){
                                        e.preventDefault();
                                    });
                                }
                            });
                            $.fancybox.hideLoading();
                        });

                        //$.fancybox.hideLoading();
                    },
                    error: function(){
                        //$.fancybox.hideLoading();
                    }
                });
            }
        }else{
            var videoId = hash;
            $.fancybox.showLoading();

            $.getJSON('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+videoId+'&key=AIzaSyAlMSgzWARfVJ81FEGHHqSsO5qjEUtnDLQ',function(data,status,xhr){
            //$.getJSON('http://gdata.youtube.com/feeds/api/videos/'+videoId+'?v=2&alt=jsonc&callback=?',function(data,status,xhr){


                var video = data.items[0]["snippet"]["localized"];
                var genericData = data.items[0]["snippet"];
                var desc = htmlEscape(video.description);
                desc = desc.replace(/\n/g, '<br/>');

                var d = new Date(genericData.publishedAt);
                var date = (d.getDate())+"-"+(d.getMonth()+1)+"-"+d.getFullYear();

                var videoEmbed = '<div style="display: inline-block;margin:10px 0;">';
                videoEmbed+='<div class="videoTitle">'+htmlEscape(video.title)+'</div>';

                videoEmbed+='<div class="videoDate">Carregado a '+date+'.</div>';
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
        }
    } else {
        // No hash found
    }

    var fullInfo=false;
    var isLoading = false;

    $(window).scroll(function() {
        if ($(".testemunhoBox").length>0){
            if($(window).scrollTop() + $(window).height() > $(document).height()-100) {
                if (!isLoading && !fullInfo){
                    $.fancybox.showLoading();
                    var lastEl = $('.testemunhoBox:last');
                    var numItems = $('.testemunhoBox').length;
                    isLoading=true;

                    $.ajax({
                        url: 'includes/requests/getMore.php',
                        type:"POST",
                        dataType: 'json',
                        data:{ totalItems: numItems },
                        success: function(infoPrint){
                            //check if no more items
                            if (infoPrint!==false){
                                //APPEND HTML TO BODY
                                lastEl.after(infoPrint);

                                isLoading=false;
                                //$('html, body').animate({scrollTop: '+=588px'}, 1500);
                                //$('html, body').animate({scrollTop: '+=344px'}, 1500);


                            //no more items
                            }else{
                                fullInfo=true;
                            }

                            $.fancybox.hideLoading();

                        },
                        error: function(){
                            $.fancybox.hideLoading();
                            isLoading=false;
                        }
                    });
                }
            }
        }

    });

});