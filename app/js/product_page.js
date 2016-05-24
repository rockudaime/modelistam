// Данный скрипт создает раскрывающиеся табы для мобильного вида с основным содержимым
// описание, отзывы, характеристики и т.д.


var itemMenuObj = {
    init: function() {
        var self = this;
        var w = $(window);
        var wWidth = w.width();
        var minWidth = 640;
        var isMobile = false;

        self.enableMobileLinks();
    },


    enableMobileLinks: function() {
        var links = $('.ui-icon-tab-menu-item');
        var blocks = $('.item-detail-menu-container');
        var blockab = $('#about');
        var blockch = $('#charachteristic');
        var blockan = $('#answers');
        var blockac = $('#acksesories');
        var blockid = $('#items-detal');
        var blockqw = $('#questions');
        var blockcon = $('#consultation');

        var dataId;
        var currentBlock;
        var cssActiveLink = 'item-detail-menu-item-active';

        blocks.hide();
        blockab.show();
        blockch.hide();
        blockan.hide();
        blockac.hide();
        blockid.hide();
        blockqw.hide();
        blockcon.hide();
        console.log(wWidth);
        if (wWidth < 544){
			  blockab.before('<h2>Описание</h2>');
			  blockch.before('<h2>Характеристики</h2>');
			  blockan.before('<h2>Отзывы</h2>');
			  blockac.before('<h2>Аксессуары</h2>');
			  blockid.before('<h2>Запчасти</h2>');
			  blockqw.before('<h2>Вопросы и ответы</h2>');
			  blockcon.before('<h2>Получить консультацию</h2>');
			  $('.item-detail-menu  h2').click(function (event) {
			        if(false == $(this).next().is(':visible')) {
			          $('.item-detail-menu-container').slideUp(300);
			      }
			      $(this).next().slideToggle(300);
			  });
			}
        links.on('click.mobile', function(e) {
            e.preventDefault();
            blocks.hide();
            links.parent('.item-detail-menu-item').removeClass(cssActiveLink);

            dataId = $(this).data('id');
            currentBlock = $('#'+dataId);

            currentBlock.show();
            $(this).parent('.item-detail-menu-item').addClass(cssActiveLink);
        })
    },
    disableMobileLinks: function() {
        var links = $('.item-detail-menu-item');
        var blocks = $('.item-detail-menu-container');

        blocks.show();
        links.off('click.mobile');
    }
    }
$(function() {
    $('#about').css('color', 'red');
     itemMenuObj.init();

})



var links = ['#about', '#charachteristic', '#acksesories', '#answers', '#items-detal', '#questions', '#consultation'];

$('#about').hide();
if (window.innerWidth < 550) {
    links.forEach(function ( item, i, arr) {
        console.log(item);
        // $(item).hide();
    });
    console.log(window.innerWidth);
}