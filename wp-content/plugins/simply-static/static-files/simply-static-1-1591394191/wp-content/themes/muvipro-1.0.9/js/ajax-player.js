/*
 * Copyright (c) 2017 Gian MR
 * Gian MR Theme Custom Javascript
 * Base on open source wp tab widget
 */

function muvipro_loadTabContent( tab_name, container, post_id ) {
    
    var container = jQuery(container);
    var tab_content = container.find('#'+tab_name+'-tab-content');
        
    // only load content if it wasn't already loaded
    var isLoaded = tab_content.data('loaded');
    
    if (!isLoaded) {
        if (!container.hasClass('muvipro-player-loading')) {
            container.addClass('muvipro-player-loading');
            
            tab_content.load(mvpp.ajax_url, {
                    action: 'muvipro_player_content',
                    tab: tab_name,
                    post_id : post_id
                }, function() {
                    container.removeClass('muvipro-player-loading');
                    tab_content.data('loaded', 1).hide().fadeIn().siblings().hide();
                }
            );
        }
    } else {
        tab_content.fadeIn().siblings().hide();
    }
}

jQuery(document).ready(function() {
    jQuery('.muvipro_player_content').each(function() {
        var $this = jQuery(this);
		var post_id = jQuery(this).data('id');
        
        // load tab content on click
        $this.find('.muvipro-player-tabs a').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().addClass('selected').siblings().removeClass('selected');
            var tab_name = jQuery(this).attr('id');
            muvipro_loadTabContent( tab_name , $this, post_id );
        });
        
        // load first tab now
        $this.find('.muvipro-player-tabs a').first().click();
    });
    
});