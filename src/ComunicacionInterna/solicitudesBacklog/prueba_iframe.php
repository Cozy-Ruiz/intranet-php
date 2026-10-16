<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>


<script>
function changeHeight(iframe)
      {
        try
        {
          var innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;
          if (innerDoc.body.offsetHeight) //ns6 syntax
          {
             iframe.height = innerDoc.body.offsetHeight + 32; //Extra height FireFox
          }
          else if (iframe.Document && iframe.Document.body.scrollHeight) //ie5+ syntax
          {
             iframe.height = iframe.Document.body.scrollHeight;
          }
        }
        catch(err)
        {
          alert(err.message);
        }
      }


</script>
</head>

<body> 





<iframe id="editSectionFrame" src="http://71.144.19.155/INTRANET_GEA/Backlog/manipuladorDocumentosBacklog.php?codigo=GE-B-DF-15-084&usuario=Lizbeth_Guadarrama" frameborder="0"  style="display:block;width:100%"  onLoad="changeHeight(this);"></iframe>

</body>
</html>