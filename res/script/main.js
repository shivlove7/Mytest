/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

'use strict';

$(function() {

    //settings for slider
    var height = 131;
    var animationSpeed = 2000;
    var pause = 4000;
    var currentSlide = 1;
    
    //cache DOM elements
    var $slider = $('#slider');
    var $slideContainer = $('.slides', $slider);
    var $slides = $('.slide', $slider);
    var $slen = $slides.length;
    var $arrow_up = $('#arrow_up');
    var $arrow_down = $('#arrow_down');
    var interval;

    function startSlider() {
        interval = setInterval(function() {
            $slideContainer.animate({'margin-top': '-='+height}, animationSpeed, function() {
                if (++currentSlide === (($slen)-2)){
                    currentSlide = 1;
                    $slideContainer.css('margin-top',0);   
                }
               
                
            });
        }, pause);
    }
    function pauseSlider() {
        clearInterval(interval);
    }
    //remove arrow_up and arrow_down click events to remove those unexpected behaviors
    if($slen > 3){
        $slideContainer
            .on('mouseenter', pauseSlider)
            .on('mouseleave', startSlider);
        
        $arrow_up.click(function(){
            $slideContainer.animate({'margin-top': '-='+height}, animationSpeed);
            
            if (++currentSlide === (($slen)-2)){
                    currentSlide = 1;
                    $slideContainer.css('margin-top',0);   
                }
                currentSlide++;
        });
        
        $arrow_down.click(function(){
            $slideContainer.animate({'margin-top': '+='+height}, animationSpeed);
            currentSlide--;
            pauseSlider();
            
        });
        
        
        $arrow_up
            .on('mouseenter', pauseSlider)
            .on('mouseleave', startSlider);
    
        $arrow_down
            .on('mouseenter', pauseSlider)
            .on('mouseleave', startSlider);
            
        startSlider();
    }
    
    
});
