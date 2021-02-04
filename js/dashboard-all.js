$(function(){

    var windowHeight = $(window).height();
    
    // Making dashboard sidebar full height
    $('.dashboard').height(windowHeight);

    var current = location.pathname;
    
    $('.dashboard ul a').each(function(){
        var $this = $(this);

        // if the current path is like this link, make it active
        if(current.indexOf($this.attr('href')) !== -1){
            $this.children().addClass('active');
        }
    })

});