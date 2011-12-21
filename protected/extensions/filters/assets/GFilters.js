$(document).on('change','.filter .gfdropdown',function(){
    $.ajax(location.href,{
        'data':jQuery(this).parents("form").serialize(),
        'cache':false,
        'success': function(content){
            $('#main').html(content)
        }
    });
});
$.gfilters = function(options){
    $.extend($.gfilters.options,{},options)
};
$.gfilters.tree = function(options){
    $.extend($.gfilters.tree.options,{},options)
};
$.gfilters.options = {
    'url':location.href,
    'target':'#main'
};
$.gfilters.tree.options = {
  'speed':500,
  'width':'200px'
};
$.gfilters.tree.down = function(object,id){
    //$(object).parentsUntil('.actual').parent().removeClass('actual');
    var old = $(object).parents('div.actual');
    console.log(old);
    var filter = jQuery(object).parents(".filter.tree");
    filter.find('.category .value[value='+id+']').parent().removeClass('hidden').addClass('actual');
    filter.children('.content').animate({'margin-left':'-'+$.gfilters.tree.options.width},$.gfilters.tree.options.speed,function(){
       $(this).css('margin-left','0px'); 
       old.removeClass('actual').addClass('hidden');
    });
    
    
};
$.gfilters.tree.up = function(object,id){
    //$(object).parentsUntil('.actual').parent().removeClass('actual');
    var old = $(object).parents('div.actual');
    var filter = jQuery(object).parents(".filter.tree");
    console.log(old);
    filter.find('.category .value[value='+id+']').parent().removeClass('hidden').addClass('actual');
    filter.children('.content').css('margin-left','-'+$.gfilters.tree.options.width); 
    filter.children('.content').animate({'margin-left':'0px'},$.gfilters.tree.options.speed,function(){
       old.removeClass('actual').addClass('hidden');
    });
};

$.gfilters.tree.select = function(object,id){
    jQuery(object).parents(".filter.tree").children('.filter-field').val(id);
    console.log(jQuery(object).parents(".filter.tree").children('.filter-field'));
    console.log(id);
    $.ajax($.gfilters.options.url,{
            'data':jQuery(object).parents("form").serialize(),
            'cache':false,
            'success': function(content){
                $($.gfilters.options.target).html(content);
            }
        });
};

$(document).on('click','.filter.tree h2 a',function(){
        $.gfilters.tree.select(this,$(this).parent().siblings('.value').val());
        return false;
});
$(document).on('click','.filter.tree li a',function(){
    $.gfilters.tree.select(this,$(this).siblings('.value').val());
        return false;
});
$(document).on('click','.filter.tree li .explore',function()
{
    $.gfilters.tree.down(this,$(this).siblings('.value').val());
    return false;
});
$(document).on('click','.filter.tree h2 .explore',function()
{
    $.gfilters.tree.up(this,$(this).parent().siblings('.parent').val());
});
