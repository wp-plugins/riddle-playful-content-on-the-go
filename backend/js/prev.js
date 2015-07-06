


function rid_getValPage() {

    id = jQuery('#pageSelection').val();
    fr = rid_retFrame();
    temp = "<input type='hidden' value='" + id + "' name='hidPageID'><input type='hidden' value='" + fr + "' name='hidPageFr'><input style='position: relative;  margin-top: 3px; ' type='submit' class='button' id='rid_pageSendImp'name='PageSend' value='Implement'>"
    if (!(jQuery("#rid_pageSendImp").length)) {
        jQuery('#riddle_widg_wp').append(temp);
    }
}

function rid_getValPage1() {

    id = jQuery('#pageSelection').val();
    fr = rid_retFrame();
    temp = "<input type='hidden' value='" + id + "' name='hidPageID'><input type='hidden' value='" + fr + "' name='hidPageFr'><input style='position: relative;  margin-top: 3px; ' type='submit' class='button' id='rid_pageSendImp'name='PageSend1' value='Implement'>"
    if (!(jQuery("#rid_pageSendImp").length)) {
        jQuery('#riddle_widg_wp').append(temp);
    }
}


function showRiddleOptions(aRID) {

    jQuery('.addedRiddlePostForm').css('visibility', 'hidden');
    jQuery('#addedRiddlePostForm_' + aRID).css('visibility', 'visible');
    jQuery('.addedRiddle_').css('background-color', 'transparent');
    jQuery('#addedRiddle_' + aRID).css('background-color', '#bbb');
    //alert('#addedRiddlePostForm_'+aRID);
}


function rid_refresh() {

    window.location.href = window.location.href;
}

jQuery('#ridPopUpWrapper').on('click', function(){
     jQuery('#ridPopUpWrapper').css('display', 'none');
  jQuery('div#ridPopUp').css('display', 'none');
});

function ridClosePopup() {
 jQuery('#ridPopUpWrapper').css('display', 'none');
  jQuery('div#ridPopUp').css('display', 'none');
}
  $(document).ready(function () {
    
    });
function rid_getShortcode(id) {


jQuery("#ridPopUpTextbox").val('[riddle id="'+id.trim()+'"]');
   setTimeout(function(){   jQuery("#ridPopUpTextbox").select();
       jQuery('#rid_CopytoClipboardButton').zclip({
            path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
            copy:function(){return jQuery('#ridPopUpTextbox').val();}
        });
   }, 200);
  
                

     jQuery('#ridPopUpWrapper').css('display', 'block');
  jQuery('div#ridPopUp').css('display', 'block');
}

window.onload = function () {
    if ((jQuery("#ridPopUp").length)) {
        jQuery("#ridPopUpTextbox").select();
    }


};

function rid_showSub(id) {
if( jQuery('#' + id).css('display') == 'block'){
    jQuery('#' + id).css('display', 'none');
     jQuery(" .rid_ContainerSubcategory").css('display', 'none');
    
}else{
     jQuery(" .rid_ContainerSubcategory").css('display', 'none');
       jQuery('#' + id).css('display', 'block');
}
}

function rid_showSub1(id) {
    /*if ((jQuery(" .rid_ContainerSubcategory_").length) ) {
        jQuery(" .rid_ContainerSubcategory_").css('display', 'none');
    }*/

if( jQuery('#' + id).css('display') == 'block'){
    jQuery('#' + id).css('display', 'none');
     jQuery(" .rid_ContainerSubcategory_").css('display', 'none');
    
}else{
     jQuery(" .rid_ContainerSubcategory_").css('display', 'none');
       jQuery('#' + id).css('display', 'block');
}
}

function rid_ShowAddButton(id) {
    jQuery('.ridAddButtonHidden').css('display', 'none');
    jQuery('#' + id).css('display', 'block');
}

jQuery(document).ready(function () {
    jQuery('#rid_CopytoClipboardButton').zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: jQuery('#ridPopUpTextbox').text()
    });
    
  
//*/ The link with ID "copy-description" will copy
// the text of the paragraph with ID "description"
//jQuery('a#rid_CopytoClipboardButton').zclip({
//path:'js/ZeroClipboard.swf',
//copy:function(){return jQuery('input#ridPopUpTextbox').val();}
//});
// The link with ID "copy-dynamic" will copy the current value
// of a dynamically changing input with the ID "dynamic"
});

jQuery(document).ready(function () {
    jQuery("a#copy-callbacks").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: jQuery('#callback-paragraph').text(),
        beforeCopy: function () {
            jQuery('#callback-paragraph').css('background', 'yellow');
            jQuery(this).css('color', 'orange');
        },
        afterCopy: function () {
            jQuery('#callback-paragraph').css('background', 'green');
            jQuery(this).css('color', 'purple');
            jQuery(this).next('.check').show();
        }
    });
});

function changeLang() {
    val = jQuery('#ridLang').val();

    if (val == 'de-DE') {

        jQuery('#ridLang:nth-child(2)').attr("selected", "selected");
    }

    jQuery('#ridSearchForm').submit();

    if (val == 'de-DE') {

        jQuery('#ridLang:nth-child(2)').attr("selected", "selected");
    }
}


function readmore(){



jQuery('#more').show('slow');
jQuery('#show').css('display', 'none');
jQuery('#hide').css('display', 'inline');

}


function readless(){
  jQuery('#more').hide('slow');
jQuery('#hide').css('display', 'none');
jQuery('#show').css('display', 'inline');

}