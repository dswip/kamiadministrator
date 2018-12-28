function cekall(val)
{
	if (document.getElementById('chkselect').checked){ for (i=0;i<val;i++){  document.getElementById("cek"+i).checked=true; } }
	else {	for (i=0;i<val;i++){document.getElementById("cek"+i).checked=false;} }
}

function geturl(val,target='turl')
{
	document.getElementById(target).value = val.toLowerCase()+"/";
   document.getElementById("turl_update").value = val.toLowerCase()+"/";
}

function setnilai(val)
{
	document.getElementById("turl").value = "article/category/"+val.toLowerCase()+"/";
   document.getElementById("turl_update").value = "article/category/"+val.toLowerCase()+"/";
}

function setnews(permalink)
{
	opener.document.getElementById("turl").value = "article/"+permalink+"/";
   opener.document.getElementById("turl_update").value = "article/"+permalink+"/";
	self.close();
}

function setvalue(acc,target)
{
	opener.document.getElementById(target).value = acc;
	self.close();
}

function setpermalink(permalink)
{
	res = permalink.replace(/\s/g, "");
	document.getElementById("tpermalink").value = res;
}

// - ----------------------------------------------------------------------------ajax ----------------------------------------------------------------------

function checkdigit(sText, nid)
{
   var ValidChars = "0123456789.";
   var IsNumber = true;
   var Char;

   for (i = 0; i < sText.length && IsNumber == true;
   i ++ )
   {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == - 1)
      {
         IsNumber = false;
         document.getElementById(nid).value = "0";
         alert("Format text must be numeric");
      }
      else
      {
         document.getElementById(nid).value = sText;
      }
   }
}

function checknumeric(sText, nid)
{
   var ValidChars = "0123456789.";
   var IsNumber = true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true;
   i ++ )
   {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == - 1)
      {
         IsNumber = true;
         document.getElementById(nid).value = sText;
      }
      else
      {
         IsNumber = false;
         alert("Format text salah");
         document.getElementById(nid).value = "";
      }
   }
}

