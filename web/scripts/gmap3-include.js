
      $(function(){
      
        $('#atelier-45')
          .gmap3(
          { action:'init',
            options:{
              center:[47.867509, 1.89252],
              zoom: 16
            }
          },
          { action: 'addMarkers',
            markers:[
{
		lat:47.867509, lng:1.89252, 
		data:'<p><img src="images/favicon.jpg" alt="Collège La Providence" /><br /><br />Collège La Providence<br />46, rue Pierre Beaulieu<br />45160 Olivet</p>'}
            ],
            marker:{
              options:{
                draggable: false
              },
              events:{
                mouseover: function(marker, event, data){
                  var map = $(this).gmap3('get'),
                      infowindow = $(this).gmap3({action:'get', name:'infowindow'});
                  if (infowindow){
                    infowindow.open(map, marker);
                    infowindow.setContent(data);
                  } else {
                    $(this).gmap3({action:'addinfowindow', anchor:marker, options:{content: data}});
                  }
                },
                mouseout: function(){
                  var infowindow = $(this).gmap3({action:'get', name:'infowindow'});
                  if (infowindow){
                    infowindow.close();
                  }
                }
              }
            }
          }
        );
      });

