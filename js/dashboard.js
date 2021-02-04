$(function(){

    // Stats preloader
    function preloader(e){
        var count = 0;
        var goal = $(e).text();
        var counter = setInterval(function() {

          if(count <= goal){
            $(e).text(count);
            count++; 
          }

          else {
            clearInterval(counter);
          }

        }, 10);
    }

    $(document).ready(function(){
        preloader($('#users-counter'));
        preloader($('#orders-counter'));
    });

});