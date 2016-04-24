<ul class="footer__socials">
    <li class="social-menu-item socials-active">
        <a  data-id="fb" href="#" rel="#" class="ui-icon-social icon-fb"></a>
    </li>
    <li class="social-menu-item">
        <a  data-id="vk" href="#" rel="#" class="ui-icon-social icon-vk"></a>
    </li>
    <li class="social-menu-item">
        <a  data-id="tw" href="#" rel="#" class="ui-icon-social icon-tw"></a>
    </li>
    <li class="social-menu-item">
        <a  data-id="youtube" href="#" rel="#"  class="ui-icon-social icon-youtube"></a>
    </li>
    <li class="social-menu-item">
        <a  data-id="lj" href="#" rel="#"  class="ui-icon-social icon-lj"></a>
    </li>
</ul>

<div id="fb" class="socials-container">
    <div class="fb-page" data-href="https://www.facebook.com/pages/%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-%D1%80%D0%B0%D0%B4%D0%B8%D0%BE%D1%83%D0%BF%D1%80%D0%B0%D0%B2%D0%BB%D1%8F%D0%B5%D0%BC%D1%8B%D1%85-%D0%BC%D0%BE%D0%B4%D0%B5%D0%BB%D0%B5%D0%B9-Planeta-Hobby/545496968937973" data-width="235" data-height="241"  data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/pages/%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-%D1%80%D0%B0%D0%B4%D0%B8%D0%BE%D1%83%D0%BF%D1%80%D0%B0%D0%B2%D0%BB%D1%8F%D0%B5%D0%BC%D1%8B%D1%85-%D0%BC%D0%BE%D0%B4%D0%B5%D0%BB%D0%B5%D0%B9-Planeta-Hobby/545496968937973"><a href="https://www.facebook.com/pages/%D0%98%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-%D1%80%D0%B0%D0%B4%D0%B8%D0%BE%D1%83%D0%BF%D1%80%D0%B0%D0%B2%D0%BB%D1%8F%D0%B5%D0%BC%D1%8B%D1%85-%D0%BC%D0%BE%D0%B4%D0%B5%D0%BB%D0%B5%D0%B9-Planeta-Hobby/545496968937973">Интернет-магазин радиоуправляемых моделей Planeta Hobby</a></blockquote></div></div>
</div>
<div id="vk" class="socials-container">

    <script type="text/javascript">
        VK.init({apiId: planeta_hobby, onlyWidgets: true});
    </script>

    <!-- Put this div tag to the place, where the Like block will be -->
    <div id="vk_like"></div>
    <script type="text/javascript">
        VK.Widgets.Like("vk_like", {type: "button"});
    </script>
</div>
<div id="tw" class="socials-container">
    tw
</div>
<div id="youtube" class="socials-container">
    <iframe id="fr" style="overflow: hidden; height: 105px; width: 190px; border: 0pt none;" src="http://www.youtube.com/subscribe_widget?p=PlanetaHobbyUA" scrolling="no" frameborder="0"></iframe>
</div>
<div id="lj" class="socials-container">
    live journal
</div>

<script type="text/javascript">
    BIS.SocialsObj = {
        init: function() {
            var self = this;
            var w = $(window);
            var wWidth = w.width();
            var minWidth = 640;
            var isMobile = false;

            self.enableMobileLinks();
        },


        enableMobileLinks: function() {
            var links = $('.ui-icon-social');
            var blocks = $('.socials-container');
            var blockfb = $('#fb');
            var blockvk = $('#vk');
            var blocktw = $('#tw');
            var blocklj = $('#lj');
            var blockyoutube = $('#youtube');

            var dataId;
            var currentBlock;
            var cssActiveLink = 'socials-active';

            blockfb.show();
            blockvk.hide();
            blocktw.hide();
            blockyoutube.hide();
            blocklj.hide();

            links.on('click.mobile', function(e) {
                e.preventDefault();
                blocks.hide();
                links.parent('.social-menu-item').removeClass(cssActiveLink);

                dataId = $(this).data('id');
                currentBlock = $('#'+dataId);

                currentBlock.show();
                $(this).parent('.social-menu-item').addClass(cssActiveLink);
            })
        },
        disableMobileLinks: function() {
            var links = $('.social-menu-item');
            var blocks = $('.socials-container');

            blocks.show();
            links.off('click.mobile');
        }
    }
    $(function() {
        BIS.SocialsObj.init();
    })
</script>