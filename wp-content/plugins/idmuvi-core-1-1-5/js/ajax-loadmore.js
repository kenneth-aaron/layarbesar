jQuery(document).ready(function($){
	$( gmr_infiniteload.contentSelector ).infiniteLoad({
			'navSelector':gmr_infiniteload.navSelector,
			'contentSelector':gmr_infiniteload.contentSelector,
			'nextSelector':gmr_infiniteload.nextSelector,
			'itemSelector':gmr_infiniteload.itemSelector,
			'paginationType':gmr_infiniteload.paginationType,
			'loadingImage':gmr_infiniteload.loadingImage,
			'loadingText':gmr_infiniteload.loadingText,
			'loadingButtonLabel':gmr_infiniteload.loadingButtonLabel,
			'loadingButtonClass':gmr_infiniteload.loadingButtonClass,
			'loadingFinishedText':gmr_infiniteload.loadingFinishedText,
		}
	);			
});