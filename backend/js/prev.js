
function rid_change(id){

        if(id != ""){
            
            id = '#'+id;
        }
     
        link ="";  
      
        link += "numitems=" + jQuery(id+ ' .numitems').attr('value') +"&";

           jQuery(id+ ' .typeWidget').each(function(index, item){
        
               if(jQuery(item).is(':checked')){
                switch(jQuery(item).attr('id')){
                    case 'thumbnails': link += 'riddleLayout=0&'; break;
                    case 'imagelist': link += 'riddleLayout=1&'; break;
                    case 'list': link += 'riddleLayout=2&'; break;
                 }
                }
           });
    
           
   jQuery(id+ ' .typeClass').each(function(index, item){
            if(jQuery(item).is(':checked')){ //
              link +=  jQuery(item).attr('value') + '=1&';
            } else {
              link +=  jQuery(item).attr('value') + '=0&';
           }
        });

         jQuery(id+' .typeCat').each(function(index, item){
            
               if(jQuery(item).is(':checked')){
               
                   link += 'riddleCat'+jQuery(item).attr('id')+'=1&';
               } else{
                   link += 'riddleCat'+jQuery(item).attr('id')+'=0&';
               }
            
           });
           
         
           
          if( jQuery('#openLinksYes').is(':checked')){
           link += 'open=1&';
       }
           else {
               link += 'open=0&';
           }
           
   
     frame = 'http://www.riddle.com/Embed/List/preview?' + link ;
     frame = frame.substring(0,frame.length-1);
     jQuery('iframe').attr('src', frame);
     jQuery(id+' #rid_hidFr').val(frame);
   }


   
 function rid_retFrame(){
     
        link ="";  
      
        link += "numitems=" + jQuery( ' .numitems').attr('value') +"&";

           jQuery('.typeWidget').each(function(index, item){
        
               if(jQuery(item).is(':checked')){
                switch(jQuery(item).attr('id')){
                    case 'thumbnails': link += 'riddleLayout=0&'; break;
                    case 'imagelist': link += 'riddleLayout=1&'; break;
                    case 'list': link += 'riddleLayout=2&'; break;
                 }
                }
           });
    
           
   jQuery( ' .typeClass').each(function(index, item){
            if(jQuery(item).is(':checked')){ //
              link +=  jQuery(item).attr('value') + '=1&';
            } else {
              link +=  jQuery(item).attr('value') + '=0&';
           }
        });

         jQuery('.typeCat').each(function(index, item){
             
               if(jQuery(item).is(':checked')){
                   link += 'riddleCat'+jQuery(item).attr('id')+'=1&';
               } else{
                   link += 'riddleCat'+jQuery(item).attr('id')+'=0&';
               }
           });
           
                 if( jQuery('#openLinksYes').is(':checked')){
           link += 'open=1&';
       }
           else {
               link += 'open=0&';
           }
           
     frame = 'http://www.riddle.com/Embed/List/preview?' + link ;
      return frame;
 }



function htmlspecialchars(str) {
 if (typeof(str) == "string") {
  str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
str = str.replace(/"/g, "&quot;");
  str = str.replace(/'/g, "&#039;");
  str = str.replace(/</g, "&lt;");
  str = str.replace(/>/g, "&gt;");
  }
 return str;
 }

function rid_implementSite(pages){
    

    t = '<label style="position: relative;"> Riddle Title <input type="text" style="position: relative;left: 30px; width: 130px;" name="ridImpSite_Title" id="ridImpSite_Title" ></label><br/>';
    if(!(jQuery("#ridImpSite_Title" ).length ) ){
         jQuery('#riddle_widg_wp').append(t);
    }
    temp = jQuery('#hidPaId').val();
    jQuery("#pageSelection" ).remove();
        jQuery('#rid_selPageStyle').remove();
    jQuery('#postSite').append('<div id="rid_selPageStyle" "><span style="margin-right: 16px;">Implement to </span></div>');
    jQuery('#rid_selPageStyle').append(temp);
    
    
    

}

function rid_implementPost(pages){
    

    t = '<label style="position: relative;"> Riddle Title <input type="text" style="position: relative;left: 30px; width: 130px;" name="ridImpSite_Title" id="ridImpSite_Title" ></label><br/>';
    if(!(jQuery("#ridImpSite_Title" ).length ) ){
         jQuery('#riddle_widg_wp').append(t);
    }
    temp = jQuery('#hidPaId1').val();
    jQuery("#pageSelection" ).remove();
            jQuery('#rid_selPageStyle').remove();
    jQuery('#postSite').append('<div id="rid_selPageStyle" "><span style="margin-right: 16px;">Implement to </span></div>');
    jQuery('#rid_selPageStyle').append(temp);
    
    
    

}

function rid_getValPage(){
    
    id = jQuery('#pageSelection').val();
    fr = rid_retFrame();
    temp = "<input type='hidden' value='"+id+"' name='hidPageID'><input type='hidden' value='"+fr+"' name='hidPageFr'><input style='position: relative;  margin-top: 3px; ' type='submit' class='button' id='rid_pageSendImp'name='PageSend' value='Implement'>"
   if(!(jQuery("#rid_pageSendImp" ).length ) ){
        jQuery('#riddle_widg_wp').append(temp);
   }
}

function rid_getValPage1(){
    
    id = jQuery('#pageSelection').val();
    fr = rid_retFrame();
    temp = "<input type='hidden' value='"+id+"' name='hidPageID'><input type='hidden' value='"+fr+"' name='hidPageFr'><input style='position: relative;  margin-top: 3px; ' type='submit' class='button' id='rid_pageSendImp'name='PageSend1' value='Implement'>"
   if(!(jQuery("#rid_pageSendImp" ).length ) ){
        jQuery('#riddle_widg_wp').append(temp);
   }
}

function searchRiddle(){
    
   jQuery("#riddlecontent").empty();
   temp='<h2>Search Riddle</h2><form method="POST"><input type="text" id="text_searchRiddle" name="text_searchRiddle"><input type="submit" id="sub_searchRiddle" name="sub_searchRiddle" value="Search Riddle" class="button"> </form>';
   jQuery('#riddlecontent').append(temp);
   
}

function showRiddleOptions(aRID){
    
   jQuery('.addedRiddlePostForm').css('visibility', 'hidden');
   jQuery('#addedRiddlePostForm_'+aRID).css('visibility', 'visible');
  jQuery('.addedRiddle_').css('background-color', 'transparent');
   jQuery('#addedRiddle_'+aRID).css('background-color', '#bbb');
   //alert('#addedRiddlePostForm_'+aRID);
}

function rid_emptyRiddleSearch(){
    
    jQuery('#riddleSearch').remove();
}

function rid_refresh(){
    
    window.location.href=window.location.href;
}

function rid_ShowForm(nrOfPost){

   jQuery('.rid_yourCatPost_').css('visibility', 'hidden');
      jQuery('.rid_yourCatPost1_').css('visibility', 'hidden');
       jQuery('#rid_yourCatPost2__'+nrOfPost).css('visibility', 'hidden');
      jQuery('#rid_yourCatPost1__'+nrOfPost).css('visibility', 'hidden');
   jQuery('#rid_yourCatPost_'+nrOfPost).css('visibility', 'visible');
  jQuery('.addedRiddle__').css('background-color', 'transparent');
  jQuery('.addedRiddle1__').css('background-color', 'transparent');
   jQuery('#rid_yourCatPostNav_'+nrOfPost).css('background-color', '#bbb');

}

function rid_ShowFormPage(nrOfPost){
 jQuery('.rid_yourCatPost_').css('visibility', 'hidden');
 jQuery('.rid_yourCatPost1_').css('visibility', 'hidden');
  jQuery('#rid_yourCatPost2__'+nrOfPost).css('visibility', 'hidden');
 jQuery('#rid_yourCatPost1__'+nrOfPost).css('visibility', 'hidden');
   jQuery('#rid_yourCatPost__'+nrOfPost).css('visibility', 'visible');
  jQuery('.addedRiddle__').css('background-color', 'transparent');
  jQuery('.addedRiddle1__').css('background-color', 'transparent');
   jQuery('#rid_yourCatPostNav__'+nrOfPost).css('background-color', '#bbb');

}

function rid_ShowFormPost(nrOfPost){
 jQuery('.rid_yourCatPost_').css('visibility', 'hidden');
  jQuery('.rid_yourCatPost1_').css('visibility', 'hidden');
   jQuery('#rid_yourCatPost1__'+nrOfPost).css('visibility', 'hidden');
    jQuery('#rid_yourCatPost2__'+nrOfPost).css('visibility', 'visible');
  jQuery('.addedRiddle1__').css('background-color', 'transparent');
  jQuery('.addedRiddle__').css('background-color', 'transparent');
     jQuery('#rid_yourCatPostNav1__'+nrOfPost).css('background-color', 'transparent');
   jQuery('#rid_yourCatPostNav2__'+nrOfPost).css('background-color', '#bbb');

}

function ridClosePopup(){
  //  alert("hallo");
        jQuery("#ridPopUp" ).remove();
}

function rid_getShortcode(id){

     if(!(jQuery("#ridPopUp" ).length ) ){
         jQuery("#ridPopUp" ).remove();
     }
    val = jQuery('#rid_hiddenShortcodePostriddle'+id).val();
    //alert(val);
    rid_Popup = '<div id="ridPopUp"><h3>Your Shortcode</h3>';
    rid_Popup += '<div style="width: 450px">Copy the code below and paste it in a blog post or a blog page where you want your Riddle to appear.</div></br>';
   rid_Popup += '<textarea id="ridPopUpTextbox" style=" position: relative;width: 450px; height:150px; top: 5px;" rows ="6" readonly="readonly">   '+val+'</textarea><input type="button" class="button" style="position: relative; top: 10px;left: 120px" id="rid_CopytoClipboardButton" value="Copy to Clipboard"> <input type="button" class="button" style="position: relative; top: 10px;left: 120px" onClick="ridClosePopup()" value="Close"> </div>'; //
  
    // rid_Popup = '<div id="ridPopUp"><h3>Your Shortcode</h3><div style="width: 450px">Copy the code below and paste it in a blog post or a blog page where you want your Riddle to appear.</div></br><textarea style="width: 450px; height:"200px" rows ="6">'+val+' </textarea><input type="button" class="button" style="position: absolute; top: 250px;left: 250px"onclick="ridClosePopup()" value=" OK"></div>'; //
     jQuery('body').append(rid_Popup);
      jQuery("#ridPopUpTextbox").select();
      jQuery('#rid_CopytoClipboardButton').zclip({
path:'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
copy:jQuery('#ridPopUpTextbox').text()});
 /*}
 else{
     jQuery('#ridPopUp').css('visibility', 'visible');
    jQuery('#ridPopUp').css('zIndex', '10'); 
 }*/
}

window.onload = function(){
    if((jQuery("#ridPopUp" ).length ) ){
    jQuery("#ridPopUpTextbox").select();
    }
};

function rid_showSub(id){
    if((jQuery(" .rid_ContainerSubcategory" ).length ) ){
      jQuery(" .rid_ContainerSubcategory" ).css('display', 'none');
    }
    
     jQuery('#'+id).css('display', 'block');
}

function rid_showSub1(id){
    if((jQuery(" .rid_ContainerSubcategory_" ).length ) ){
      jQuery(" .rid_ContainerSubcategory_" ).css('display', 'none');
    }
    
     jQuery('#'+id).css('display', 'block');
}

function rid_ShowAddButton(id){
    jQuery('.ridAddButtonHidden').css('display', 'none');
     jQuery('#'+id).css('display', 'block');
}

jQuery(document).ready(function(){
jQuery('#rid_CopytoClipboardButton').zclip({
path:'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
copy:jQuery('#ridPopUpTextbox').text()
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

jQuery(document).ready(function(){
jQuery("a#copy-callbacks").zclip({
path:'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
copy:jQuery('#callback-paragraph').text(),
beforeCopy:function(){
jQuery('#callback-paragraph').css('background','yellow');
jQuery(this).css('color','orange');
},
afterCopy:function(){
jQuery('#callback-paragraph').css('background','green');
jQuery(this).css('color','purple');
jQuery(this).next('.check').show();
}
});
});
