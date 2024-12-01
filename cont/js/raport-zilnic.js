$('#santiere').change(function(){
	var nrsantier = $(this).val();       
    $('.arata').css({display: 'none'});
    $('.santier-'+ nrsantier).css({display: 'block'});
});