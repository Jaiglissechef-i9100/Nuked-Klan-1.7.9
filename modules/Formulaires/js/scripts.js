<script type="text/javascript">
/* <![CDATA[ */

/* inclusion du css dans le head */	
var headID = document.getElementsByTagName("head")[0];         
var cssNode = document.createElement('link');
cssNode.type = 'text/css';
cssNode.rel = 'stylesheet';
cssNode.href = 'modules/Formulaires/css/style.css';
cssNode.media = 'screen';
headID.appendChild(cssNode);
	
function verifChps()
{
	var inputs = document.getElementById('form1').getElementsByTagName('input');
	var texta = document.getElementById('form1').getElementsByTagName('textarea');
	var selec = document.getElementById('form1').getElementsByTagName('select');
	
	for ( i = 0; i < inputs.length; i++)
	{
		if ( inputs[i].value == '' && inputs[i].id.indexOf('_off') == -1  )
		{
			if ( inputs[i].id.indexOf('upld') == -1 )
			{
				alert('<?php echo _REQCHPISNULL; ?>');
				document.getElementById(inputs[i].id).style.borderColor = '#FF0000';
				return false;
			}
			else
			{
				if ( inputs[i].value.constructor.toString().indexOf('Array') == -1 )
				{
					alert('<?php echo _UPLDISNULL; ?>');
					document.getElementById(inputs[i].id).style.borderColor = '#FF0000';
					return false;
				}			
			}
		}
		else if ( isNaN(inputs[i].value) && inputs[i].id.indexOf('numeric') != -1 )
		{				
			alert('<?php echo _CHPISNAN; ?>');
			document.getElementById(inputs[i].id).style.borderColor = '#FF0000';
			return false;
		}
		else if ( inputs[i].id.indexOf('mail') != -1 && ( inputs[i].value.indexOf('@') == -1 || inputs[i].value.indexOf('.') == -1 ) )
		{				
			alert('<?php echo _CHPISNOTMAIL; ?>');
			document.getElementById(inputs[i].id).style.borderColor = '#FF0000';
			return false;
		}
		else if ( inputs[i].id.indexOf('checkbox_on') != -1 && inputs[i].checked == false )
		{				
			alert('<?php echo _CHECKBOXEMPTY; ?>');
			return false;
		}
		else{}		
	}
	
	for ( j = 0; j < texta.length; j++)
	{
		if ( texta[j].value == '' && texta[j].id.indexOf('_off') == -1 )
		{
			alert('<?php echo _TEXTAISNULL; ?>');
			document.getElementById(texta[j].id).style.borderColor = '#FF0000';
			return false;
		}
		else{}		
	}
	
	for ( k = 0; k < selec.length; k++)
	{
		if ( selec[k].value == ' ' && selec[k].id.indexOf('_off') == -1 )
		{
			alert('<?php echo _SELECTISNULL; ?>');
			document.getElementById(selec[k].id).style.borderColor = '#FF0000';
			return false;
		}
		else{}		
	}
}

function blank(from, id)
{	
	document.getElementById(from+'_'+id).style.backgroundColor = '';
}
function yellow(from, id)
{	
	var defaut = document.getElementById(from+'_'+id).value;	
	
	if ( defaut == '' )
	{
		document.getElementById(from+'_'+id).style.backgroundColor = '#ffffc1';
	}
}

function chktype(select, id)
{
	var valeur = select.options[select.selectedIndex].value;
	var defaut = document.getElementById('defaut_'+id).value;	
	
	if ( valeur == 'select' )
	{
		if ( defaut == '' || defaut == '<?php echo _ONOFF; ?>' || document.getElementById('defaut_'+id).value.indexOf(';') == -1 )
		{
			document.getElementById('defaut_'+id).disabled = false;
			document.getElementById('defaut_'+id).value = '<?php echo _DOTVIRG; ?>';
			document.getElementById('defaut_'+id).style.backgroundColor = '#ffffc1';
		}
	}
	else if ( valeur == 'checkbox' )
	{
		if ( defaut == '' || defaut == '<?php echo _DOTVIRG; ?>' || ( defaut != 'on' && defaut != 'off' ) )
		{
			document.getElementById('defaut_'+id).disabled = false;
			document.getElementById('defaut_'+id).value = '<?php echo _ONOFF; ?>';
			document.getElementById('defaut_'+id).style.backgroundColor = '#ffffc1';
		}
	}
	else if ( valeur == 'upld' )
	{
		document.getElementById('defaut_'+id).value = '';
		document.getElementById('defaut_'+id).disabled = true;
	}
	else if ( defaut == '' || defaut == '<?php echo _DOTVIRG; ?>' || defaut == '<?php echo _ONOFF; ?>' )
	{
		document.getElementById('defaut_'+id).disabled = false;
		document.getElementById('defaut_'+id).value = '';
		document.getElementById('defaut_'+id).style.backgroundColor = '';
	}
	else
	{
		document.getElementById('defaut_'+id).disabled = false;
		document.getElementById('defaut_'+id).style.backgroundColor = '';
	}
}

function cfrmDelForm(id)
{
	if ( confirm ("<?php echo _DELCFRM0; ?>"+id+"\r\n\r\n<?php echo _EXPLIC0; ?>\r\n\r\n<?php echo _CONFIRM; ?> ?") )
	{
		document.location.href='index.php?file=Formulaires&page=admin&op=del&id='+id;
	}
}

function cfrmDelResp(id, form, user)
{
	if ( confirm ("<?php echo _DELCFRM1; ?>"+user+" !\r\n\r\n<?php echo _CONFIRM; ?> ?") )
	{
		document.location.href='index.php?file=Formulaires&page=admin&op=del_resp&idform='+form+'&id='+id;
	}
}
/* ]]> */
</script>