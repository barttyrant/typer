
/**
 *
 * @author: Bart Tyrant
 *
 */


$(function(){
    flashMessages();
    adminIndexTableRowView();
    singleOddChoose();
    betFormSubmit();
})

/**
 * visual effects for flash messages
 */
function flashMessages(){
    //highlighting the flash container when appeares
    $('div.flashMessage').effect('highlight', {color: "#fff"}, 400);
    
    //supporting hover-highlighting and hide-click    
    $('div.flashMessage').bind('mouseover', function(){
        $(this).css({opacity: '0.95', borderBottom: '2px solid #fff'});
    }).bind('mouseout', function(){
        $(this).css({opacity: '0.9', borderBottom: 'none'});
    }).bind('click', function(){
        $(this).slideUp(200);
    });
    
    //autohide
    $('div.flashMessage.autohide').each(function(){
        var classAttr = $(this).attr('class');
        var hideDelay = (classAttr).substring((classAttr).lastIndexOf('hide_') + 5);
        if(hideDelay !== undefined){
            $(this).delay(hideDelay).slideUp(200);
        }
    });
}


function adminIndexTableRowView(){
    $('.admin_index table tr').click(function(event){
        viewActionLink = $(this).find('td.actions a.viewLink').attr('href');
        if(viewActionLink){
            window.location = viewActionLink;
        }        
    });
    
    $('.admin_index table tr td a').click(function(event){
        event.stopPropagation();
    })
}

function singleOddChoose(){
    $('.bet_odd_checkbox').click(function(){
        thisId = $(this).attr('id');
        $parentTr = $(this).parents('tr');
        $parentTr.find('.bet_odd_checkbox:not(#' + thisId + ')').attr('checked', false);
        
        chosenOptionsAmmount = $parentTr.find('input[type=checkbox]:checked').length;
        $stakeInput = $parentTr.find('.stakeInputDiv');
        if(!chosenOptionsAmmount){
            $stakeInput.fadeOut().val('');
            $stakeInput.parents('.stakeInputTd').animate({height: 'auto'});
        }
        else{
            if($stakeInput.is(':not(:visible)')){
                $stakeInput.parents('.stakeInputTd').animate({height: '40px;'});
                $stakeInput.fadeIn();
            }
        }
    });
    
}

function betFormSubmit(){
//    $('input.deal').click(function(){
//        $row = $(this).parents('tr');
//        chosenOptionsAmmount = $row.find('input[type=checkbox]:checked').length;
//        
//        if(chosenOptionsAmmount != 1){
//            alert('Please pick the right ammount of options (actualy... 1 allowed :) )');
//            return false;
//        }
//        else{
//            apprise('Are You sure about this bet? ', {
//                'verify':true,
//            }, function(r)
//
//            {
//                if(r)
//                { 
//                return true;
//                }
//                else
//                { 
//                return false;
//                }
//            });
//        }
//        
//        
//    });
    
}