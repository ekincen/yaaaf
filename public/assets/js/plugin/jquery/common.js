// copyright ekin.cen <yijian.cen@gmail.com>
(function($){
	$.extend({
		modal:{
			show:function(opt){
				var setting={
					overlayClass:'',
					wrapper:'',
					onLoad:null
				}
				opt=$.extend(setting,opt);
				var scrollTop=$(window).scrollTop();
				var screenHeight=$(window).height();
				var screenWidth=$(window).width();
				var defaultScrollobj=$('html');
				
				var overlayobj=$('<div class="modal-overlay'+(opt.overlayClass?' '+opt.overlayClass:'')+'"></div>');
				$('body').append(overlayobj);
				var wrapobj=$('<div class="modal-wrapper modal-fixed" style="z-index:100;"></div>');
				$('body').append(wrapobj);

				if(opt.wrapper&&$(opt.wrapper).length>0){
					$(opt.wrapper).removeClass('hidden').appendTo(wrapobj);
					opt.onLoad(wrapobj);
				}

				var offsetTop=(screenHeight-wrapobj.height())/2*0.8;
				var offsetLeft=(screenWidth-wrapobj.width())/2;
				wrapobj.css({'top':offsetTop,'left':offsetLeft});

				//关闭modal
				$('.modal-overlay').unbind('click.closeModal').bind('click.closeModal',function(e){
					if(opt.wrapper){
						var modalPoolId='modal-pool-container';
						if(!$('#'+modalPoolId).length>0){
							$('body').append('<div id="'+modalPoolId+'" class="hidden"></div>');
						}
						wrapobj.find(opt.wrapper).appendTo($('#'+modalPoolId));

					}
					overlayobj.add(wrapobj).remove();
				});
			},
		}
	});
$.fn.extend({
	hoverClass:function(target,className){
		$(this).delegate(target,'mouseenter',function(){
			$(this).addClass(className);
		}).delegate(target,'mouseleave',function(){
			$(this).removeClass(className);
		})
	}
});
})(jQuery);