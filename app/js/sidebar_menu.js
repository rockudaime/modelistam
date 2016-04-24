/* Этот скрипт из 
/bitrix/templates/modelistam/components/bitrix/catalog.section.list/template_icons_custom/template.php
Он отвечает за отображения бокового меню. В основном обработка событий наведения.
 */

$(".item:first").offset(function(i,val){
  return {top:val.top + 30, left:val.left};
});


$("#parent2").mouseout(function(e) {
    $("#parent1").removeClass("icon-hover-element-item_two");
});

$("#parent2").mousemove(function(e) {
    $("#parent1").addClass("icon-hover-element-item_two");
});

$(document).mouseover(function() {
    $('.icon-hover-element-item .icons-catalog-menu__link').removeClass("icon-hover-element");
    $('.icons-catalog-menu__item').removeClass("icon-hover-element-item");
    $('.icons-catalog-menu__item:hover').addClass("icon-hover-element-item");
    $('.icon-hover-element-item .icons-catalog-menu__link').addClass("icon-hover-element");
});

$(document).mouseover(function() {
    $('.icon-hover-element-item-level_2 .icons-catalog-menu__link-level_2').removeClass("icon-hover-element-level_2");
    $('.icons-catalog-menu__item-level_2').removeClass("icon-hover-element-item-level_2");
    $('.icons-catalog-menu__item-level_2:hover').addClass("icon-hover-element-item-level_2");
    $('.icon-hover-element-item-level_2 .icons-catalog-menu__link-level_2').addClass("icon-hover-element-level_2");
});

var menuCustomModule = {
    elems: {
        dropDown: {},
        itemsKlm1: {},
        itemsKlm2innerElems: {},
        itemsKlm2: {},
        lisDesc: {},
        linkDesc: {}
    },
    init: function() {
        var wWidth = $(window).width();
        //populate elems
        this.elems.dropDown =  $('#main-menu').find('ul.dropdown-vertical');
        this.elems.itemsKlm1 = this.elems.dropDown.find('.klm1');
        this.elems.itemsKlm2innerElems = this.elems.itemsKlm1.find('.dropdown-level_2');
        this.elems.itemsKlm2 = this.elems.dropDown.find('.klm2');
        this.elems.lisDesc = this.elems.dropDown.find('>li');
        this.elems.linksDesc = this.elems.lisDesc.find('.dropdown__gen__link');

        //invoke methods
        this.addCssClassForItems();
        if (wWidth <= 755) {
            this.menuHoverDelayMobile();
        } else {
            this.menuHoverDelayDesktop();
        }
        this.hoverMenuChilds();
        this.addActiveMenuItem();
    },
    addActiveMenuItem: function() {
        var menu = $('#main-menu').find('>.dropdown ');
        var items = menu.find('.dropdown__gen');
        var curUrl = document.location.href;
        var curItemUrl;
        items.each(function() {
            curItemUrl = $.trim($(this).find('.dropdown__gen__link').attr('href'));
            if (curUrl.indexOf(curItemUrl) != -1) {
                $(this).addClass('active');
            }
        })
    },
    addCssClassForItems: function() {
        this.elems.itemsKlm1.has('.klm2').find('.dropdown-level_2').addClass('has-sub-menu');
    },
    menuHoverDelayDesktop: function() {
        var self = this,
            related,
            curItem;
        self.elems.lisDesc.hoverIntent({
            over: function(e) {
                e = e || window.event;
                related = e.relatedTarget || e.fromElement;
                curItem = $(this);

                try {
                    if (related.tagName == 'A' || related.tagName == 'LI'); {
                        self.elems.lisDesc.find('>ul').hide();
                    }
                } catch(e) {
                        //nothing
                }

                curItem.find('>ul').show();
            },
            out: function() {
                $(this).find('>ul').hide();
            },
            timeout: 300
        });
    },
    menuHoverDelayMobile: function() {
        var self = this;

        self.elems.linksDesc.on({
            'click': function(e) {
                e.preventDefault();
                $(this).parents('.dropdown__gen').find('>ul').toggle();
            }
        });
    },
    hoverMenuChilds: function() {
        var sibling;
        this.elems.itemsKlm2.on({
            'mouseenter': function(e) {
                sibling = $(e.currentTarget).siblings('.dropdown-level_2').addClass('active');
            },
            'mouseleave': function() {
                sibling.removeClass('active');
            }
        });
    }
}

//init menuCustomModule
$(function() {
    menuCustomModule.init();
});
