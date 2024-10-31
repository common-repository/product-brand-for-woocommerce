jQuery(document).ready(function() {
	if(OCBRANDWdata.ocpbrandw_autoplay_slider == "yes"){
        var slider_true = true;
    }else{
        var slider_true = false;
    }

    if(OCBRANDWdata.ocpbrandw_autopaly_speed == ""){
    	var ocpbrandw_autopaly_speed = 5000;
    }else{
        var ocpbrandw_autopaly_speed = OCBRANDWdata.ocpbrandw_autopaly_speed;
    }

    if(OCBRANDWdata.ocpbrandw_navi == "arrows"){
        var ocpbrandw_naviarrow = true;
    }else{
        var ocpbrandw_naviarrow = false;
    }

    if(OCBRANDWdata.ocpbrandw_navi == "dots"){
        var ocpbrandw_navidots = true;
    }else{
        var ocpbrandw_navidots = false;
    }

    if(OCBRANDWdata.ocpbrandw_autoscrollfocus == ""){
   		var ocpbrandw_autoscrollfocus = false;
    }else{
    	var ocpbrandw_autoscrollfocus = true;
    }

    if(OCBRANDWdata.ocpbrandw_tablet == ""){
   		var ocpbrandw_tablet = 2;
    }else{
        var ocpbrandw_tablet = OCBRANDWdata.ocpbrandw_tablet;
    }

    if(OCBRANDWdata.ocpbrandw_mobile == ""){
   		var ocpbrandw_mobile = 2;
    }else{
        var ocpbrandw_mobile = OCBRANDWdata.ocpbrandw_mobile;
    }

    if(OCBRANDWdata.ocpbrandw_desktop == ""){
   		var ocpbrandw_desktop = 3;        
    }else{
    	var ocpbrandw_desktop = OCBRANDWdata.ocpbrandw_desktop;
    }

	jQuery('.wpb_slider').owlCarousel({
       	loop: true,
        margin: 10,
        nav: ocpbrandw_naviarrow,
        dots: ocpbrandw_navidots,
        autoplay: slider_true,
  		autoplayTimeout: ocpbrandw_autopaly_speed,
  		autoplayHoverPause: ocpbrandw_autoscrollfocus,
       	responsive:{
            0:{
                items: ocpbrandw_mobile
            },
            600:{
                items: ocpbrandw_tablet
            },
            1000:{
                items: ocpbrandw_desktop
            }
        }
    });
});