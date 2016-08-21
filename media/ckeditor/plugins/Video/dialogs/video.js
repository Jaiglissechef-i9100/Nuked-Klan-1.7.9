function trim(myString){
	return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

var videoWidth = 500;
var videoHeight = 281;
var pluginUrl = CKEDITOR.plugins.getPath('Video');

CKEDITOR.dialog.add('Video',function(a) {
	
	return {
        
		title: "Insérer votre id de vidéo",
		
		onShow:function(){
			this.getContentElement('OngletYoutube','youtube').getInputElement().setValue('');
			this.getContentElement('OngletDailymotion','dailymotion').getInputElement().setValue('');
			//this.getContentElement('OngletVimeo','vimeo').getInputElement().setValue('');
			this.getContentElement('OngletWat','wat').getInputElement().setValue('');
		},		
		onOk: function() {
			var inputYoutube = trim(this.getContentElement('OngletYoutube','youtube').getInputElement().getValue());
			var inputDailymotion = trim(this.getContentElement('OngletDailymotion','dailymotion').getInputElement().getValue());
			var inputVimeo = trim(this.getContentElement('OngletVimeo','vimeo').getInputElement().getValue());
			//var inputWattv = trim(this.getContentElement('OngletWat','wat').getInputElement().getValue());
			var videoWidth = trim(this.getContentElement('Dimensions', 'dimWidth').getInputElement().getValue());
			var videoHeight = trim(this.getContentElement('Dimensions','dimHeight').getInputElement().getValue());
			
			// Youtube
			if (inputYoutube != '') {
				var url = 'https://www.youtube.com/v/';
				var text = '<div style="text-align:center"><object type="application/x-shockwave-flash" width="'+videoWidth+'" height="'+videoHeight+'" data="'+url+inputYoutube+'?version=3&amp;theme=dark&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;autohide=1&amp;iv_load_policy=3"><param name="movie" value="'+url+inputYoutube+'?version=3&amp;theme=dark&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;autohide=1&amp;iv_load_policy=3" /><param name="wmode" value="transparent" /></object></div>';
				this.getParentEditor().insertHtml(text);
			}			
			// Dailymotion
			else if (inputDailymotion != '') {
				var url = 'https://www.dailymotion.com/swf/video/';
				var text = '<div style="text-align:center"><object type="application/x-shockwave-flash" width="'+videoWidth+'" height="'+videoHeight+'" data="'+url+inputDailymotion+'"><param name="movie" value="'+url+inputDailymotion+'" /><param name="wmode" value="transparent" /></object></div>';
				this.getParentEditor().insertHtml(text);
			}			
			// Vimeo
			else if (inputVimeo != '') {
			var url = 'https://vimeo.com/moogaloop.swf?clip_id=';
            var text = '<div style="text-align:center"><object width="'+videoWidth+'" height="'+videoHeight+'" type="application/x-shockwave-flash" data="'+url+inputVimeo+'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="'+url+inputVimeo+'" /></object></div>';				
			this.getParentEditor().insertHtml(text); 
			}					
			// Megavideo
			// Wat TV
			/*else if (inputWattv != '') {
				var url = 'https://www.wat.tv/swf2/';
				var text = '<div style="text-align:center"><object width="'+videoWidth+'" height="'+videoHeight+'"><param name="movie" value="'+url+inputWattv+'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'+url+inputWattv+'" type="application/x-shockwave-flash" width="'+videoWidth+'" height="'+videoHeight+'" allowscriptaccess="always" allowfullscreen="true"></embed></object></div>';
				this.getParentEditor().insertHtml(text);
			}*/	

        },
        contents:[
		{
		    // Youtube
			id: 'OngletYoutube',
			label: '<img src="'+CKEDITOR.getUrl(pluginUrl+'images/youtube.png')+'" /> Youtube',
			elements:[{
				type:'html',
				id:'pasteMsg',
				html:'<div style="margin:0 auto;width:280px"><img src="'+CKEDITOR.getUrl(pluginUrl+'images/youtube_large.jpg')+'" /></div><br /><br /><h2 style="text-align:center;font-size:14px;font-weight:bold">Entrez l\'ID de la vidéo YouTube</h2><p style="text-align:center">( ex. : https://www.youtube.com/watch?v=<span style="color:#f00;font-weight:bold">kXhy7ZsiR50</span> )</p>'
			},{
				type:'html',
				id:'youtube',
				html:'<input size="25" style="border:1px solid gray;background:white;margin-left:220px" />',
				focus:function(){this.getElement().focus()}
			}]		
		},{
			// Dailymotion
			id: 'OngletDailymotion',
			label: '<img src="'+CKEDITOR.getUrl(pluginUrl+'images/dailymotion.gif')+'" /> Dailymotion',
			elements:[{
				type:'html',
				id:'pasteMsg',
				html:'<div style="margin:0 auto;width:280px"><img src="'+CKEDITOR.getUrl(pluginUrl+'images/dailymotion_large.jpg')+'" /></div><br /><br /><h2 style="text-align:center;font-size:14px;font-weight:bold">Entrez l\'ID de la vidéo Dailymotion</h2><p style="text-align:center">( ex. : https://www.dailymotion.com/swf/video/<span style="color:#f00;font-weight:bold">xjc80p</span> )</p>'
			},{
				type:'html',
				id:'dailymotion',
				html:'<input size="25" style="border:1px solid gray;background:white;margin-left:220px">',
				focus:function(){this.getElement().focus()}
			}]			
        },
		{
			// Vimeo
			id: 'OngletVimeo',
			label: '<img src="'+CKEDITOR.getUrl(pluginUrl+'images/vimeo.png')+'" /> Vimeo',
			elements:[{
				type:'html',
				id:'pasteMsg',
				html:'<div style="margin:0 auto;width:280px"><img src="'+CKEDITOR.getUrl(pluginUrl+'images/vimeo_large.jpg')+'" /></div><br /><br /><h2 style="text-align:center;font-size:14px;font-weight:bold">Entrez l\'ID de la vidéo Vimeo</h2><p style="text-align:center">( ex. : https://player.vimeo.com/video/<span style="color:#f00;font-weight:bold">9519939</span> )</p>'
			},{
				type:'html',
				id:'vimeo',
				html:'<input size="25" style="border:1px solid gray;background:white;margin-left:220px">',
				focus:function(){this.getElement().focus()}
			}]			
        },/*
		{
			// Wat TV
			id: 'OngletWat',
			label: '<img src="'+CKEDITOR.getUrl(pluginUrl+'images/wat-tv.png')+'" /> WAT TV',
			elements:[{
				type:'html',
				id:'pasteMsg',
				html:'<div style="margin:0 auto;width:280px"><img src="'+CKEDITOR.getUrl(pluginUrl+'images/wat-tv_large.jpg')+'" /></div><br /><br /><h2 style="text-align:center;font-size:14px;font-weight:bold">Entrez l\'ID de la vidéo Wat TV</h2><p style="text-align:center">( ex. : https://www.wat.tv/swf2/<span style="color:#f00;font-weight:bold">282214nIc0K111446278</span> )</p>'
			},{
				type:'html',
				id:'wat',
				html:'<input size="25" style="border:1px solid gray;background:white;margin-left:220px">',
				focus:function(){this.getElement().focus()}
			}]			
        },*/
		{
			// Dimensions
			id:'Dimensions',
			label:'<img src="'+CKEDITOR.getUrl(pluginUrl+'images/size.png')+'" /> Dimensions',
			elements:[{
				type:'hbox',
				style:'margin:30px auto 0;width:125px;',
				children:[{
						type:'html',
						html:'Largeur&nbsp;:&nbsp;'
					},{
						type:'html',
						id:'dimWidth',
						html:'<input size="4" value="480" style="border:1px solid gray;background:white;text-align:right;">'
					},{
						type:'html',
						html:'px'
					}]
				},{
					type:'hbox',
					style:'margin:5px auto 0;width:125px;',
					children:[{
						type:'html',
						html:'Hauteur&nbsp;:&nbsp;'
					},{
						type:'html',
						id:'dimHeight',
						html:'<input size="4" value="390" style="border:1px solid gray;background:white;text-align:right;">'
					},{
						type:'html',
						html:'px'
				}]
			}]
		}
        ],
        buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton]
    };
});