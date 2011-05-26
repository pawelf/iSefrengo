$(document).ready(function(autoload) {
// confirm dialog depends on browser language
var language = (navigator.language || navigator.browserLanguage).split('-', 1)[0]; 
var localizedStrings={
    confirmMessage:{
        'en':'Are you sure?',
        'fr':'Est-ce que vous est certain?',
        'de':'Sind Sie sicher?'
    },

}
var message=localizedStrings['confirmMessage'][language];
$('.delete').click(function() {
            return confirm(message);
        });
// for Tabs
 $('div.sftabs').tabs();// end click
});//end function autoload

// Help function for Tabsheight
$.fn.tabs = function () {
            return this.each(function () {
               var $tabwrapper = $(this); 
               
               var $panels = $tabwrapper.find('> div');
               var $tabs = $tabwrapper.find('> ul a');
               
               $tabs.click(function () {  
                   $tabs.removeClass('selected');
                   $(this).addClass('selected');
                                    
                   $panels
                    .hide() // hide ALL the panels
                    .filter(this.hash) // filter down to 'this.hash'
                        .show(); // show only this one
                   
                   return false;
               }).filter(window.location.hash ? '[hash=' + window.location.hash + ']' : ':first').click();
            });
        };
        
   



