function changeImageRace(indice) {
	var src = "modules/Replays/images/race/" + $("#joueur" + indice + "race :selected").val();
	$("#img_race" + indice).html(src ? "<img style='padding-left: 5px;vertical-align: middle;' width='24px' height='24px' src='" + src + "'>" : "");
}

function checkFile() {
	var ext = document.getElementById('copy').value;
	var url = document.getElementById('url').value;
	var index = url.lastIndexOf('/');
	var champ_url;
	if(index == url.length-1) {
		champ_url = false;
	} else {
		champ_url = true;
	}
	if(ext != '') {
      explode = ext.split('.');
      ext = explode[explode.length-1]; // voila :)
      ext = ext.toLowerCase();
		
		if((ext != 'rec') && (ext != 'rep') && (ext != 'sc2replay') && (ext != 'lrf')) {
			alert('Type de fichier invalide');
			document.getElementById('copy').value = '';
			return false;
		} else {
			return true; 
		}
	} else if(!champ_url) {
		alert('Merci de remplir le champ URL ou de choisir un fichier à uploader');
		return false;
	}
}
	
function changeImageMap() {
	var src = "modules/Replays/images/maps/" + $("#map :selected").val();
	$("#img_map").html(src ? "<img width='100px' height='100px' src='" + src + "'>" : "");
}

function changeType() {
	var typeReplay = $("#typeReplay :selected").val();
	if(typeReplay == '1') {
		if($('div#un').is(":hidden")) {
			$('div#deux').hide();
			$('div#trois').hide();
			$('div#quatre').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();				
			$('div#un').fadeIn(2000);
		}
	} else if(typeReplay == '2') {
		if($('div#deux').is(":hidden")) {
			$('div#un').hide();
			$('div#trois').hide();
			$('div#quatre').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();				
			$('div#deux').fadeIn(2000);
		}
	} else if(typeReplay == '3') {
		if($('div#trois').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();				
			$('div#trois').fadeIn(2000);
		}
	} else if(typeReplay == '4') {
		if($('div#quatre').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();			
			$('div#quatre').fadeIn(2000);
		}
	} else if(typeReplay == '5') {
		if($('div#cinq').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();						
			$('div#cinq').fadeIn(2000);
		}		
	} else if(typeReplay == '6') {
		if($('div#six').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();						
			$('div#six').fadeIn(2000);
		}		
	} else if(typeReplay == '7') {
		if($('div#sept').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();				
			$('div#sept').fadeIn(2000);
		}		
	} else if(typeReplay == '8') {
		if($('div#huit').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();							
			$('div#huit').fadeIn(2000);
		}		
	} else if(typeReplay == '9') {
		if($('div#neuf').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#dix').hide();
			$('div#onze').hide();
			$('div#douze').hide();							
			$('div#neuf').fadeIn(2000);
		}		
	} else if(typeReplay == '10') {
		if($('div#dix').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#onze').hide();
			$('div#douze').hide();							
			$('div#dix').fadeIn(2000);
		}		
	} else if(typeReplay == '11') {
		if($('div#onze').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#douze').hide();							
			$('div#onze').fadeIn(2000);
		}		
	} else if(typeReplay == '12') {
		if($('div#douze').is(":hidden")) {
			$('div#un').hide();
			$('div#deux').hide();
			$('div#quatre').hide();
			$('div#trois').hide();
			$('div#cinq').hide();
			$('div#six').hide();
			$('div#sept').hide();
			$('div#huit').hide();
			$('div#neuf').hide();
			$('div#dix').hide();
			$('div#onze').hide();							
			$('div#douze').fadeIn(2000);
		}		
	} 
}