
jQuery(document).ready(function($) {
/*---------------------slider--------------------------*/
                            var quantitySliders= jQuery(".slide").length;
                            var activeSlide=1;
                            jQuery("#right-ctrl").click(function(event) {
                                    
                                    jQuery(".slide:nth-child("+ activeSlide +")").hide('fast', function() {
                                        if(activeSlide==quantitySliders){
                                                activeSlide=0;
                                            }
                                        jQuery(".slide:nth-child("+ ++activeSlide +")").show('fast', function() {
                                            
                                            
                                        });
                                    });
                                
                                    
                                
                                return false;
                            });
                            jQuery("#left-ctrl").click(function(event) {
                                


                                jQuery(".slide:nth-child("+ activeSlide +")").hide('fast', function() {
                                        if(activeSlide==1){
                                                activeSlide=quantitySliders+1;
                                            }
                                        jQuery(".slide:nth-child("+ --activeSlide +")").show('fast', function() {
                                            
                                            
                                        });
                                    });
                                
                                
                                return false;
                            });
/*---------------------slider end--------------------------*/
    var a = jQuery("#item2");
    var b=a.offset();
    /*jQuery(a+":after").width(b.right);*/




                          });
