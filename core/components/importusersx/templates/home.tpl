<div id="importusersx-panel-home-div">

	<h2>ImportUsersX</h2>
    <div class="x-panel-body">
    <h3>Configuration de ImportUsersX</h3>
    <form method="POST" action="" name="ajax">
    <script>
function submitForm(f)
{ 	
	var req = null; 	
	var groupName = f.groupName.value;
	var adminMailChunkName = f.adminMailChunkName.value;
	var userMailChunkName = f.userMailChunkName.value;
	var csvFilePath = f.csvFilePath.value;
	var adminUsername = f.adminUsername.value;
	if (window.XMLHttpRequest)
	{		
		req = new XMLHttpRequest();	
	}
	else if (window.ActiveXObject)
	{
		try 
		{
			req = new ActiveXObject("Msxml2.XMLHTTP");		
		}
		catch (e)
		{
			try 
			{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}
	req.open("POST", "../core/components/importusersx/elements/snippets/snippet.importusersx.php", true); 	
	req.onreadystatechange = function()
	{ 
		if(req.readyState == 4)
		{
			if(req.status == 200 || req.status == 0)
			{
				f.test.value=req.responseText;
			}
			else
			{
				document.getElementById("test").value="Error: returned status code " + req.status + " " + req.statusText;
			}
		} 	
	};
	req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	var data = 'groupName=' + escape(groupName) + '&csvFilePath=' + escape(csvFilePath) + '&adminMailChunkName=' + escape(adminMailChunkName) + '&userMailChunkName=' + escape(userMailChunkName) + '&adminUsername=' + escape(adminUsername);		
	req.send(data); 
}  
</script>
    	<p>
            <label for="groupName">Nom du groupe : </label>
            <input type="text" id="groupName" name="groupName" title="Nom du groupe dans lequel ajouter les utilisateurs créés"/>
        </p><br/>
        <p>
            <label for="adminMailChunkName">Nom du chunk pour l'email administrateur : </label>
            <input type="text" id="adminMailChunkName" name="adminMailChunkName" title="Nom du chunk pour l'email administrateur"/>
        </p><br/>
        <p>
            <label for="userMailChunkName">Nom du chunk pour l'email utilisateur : </label>
            <input type="text" id="userMailChunkName" name="userMailChunkName" title="Nom du chunk pour l'email utilisateur"/>
        </p><br/>
        <p>
            <label for="csvFilePath">Chemin du fichier CSV : </label>
            <input type="text" id="csvFilePath" name="csvFilePath" title="Chemin du fichier CSV"/>
        </p><br/>
        <p>
            <label for="adminUsername">Nom d'utilisateur de l'administrateur : </label>
            <input type="text" id="adminUsername" name="adminUsername" title="Nom d'utilisateur de l'administrateur"/>
        </p><br/>
        <p>
        	<input type="button" value="Valider" ONCLICK="submitForm(this.form)"/>
        </p><br/>
        <p>
            <textarea rows="10" id="test"></textarea>
        </p><br/>
    </form>
    </div>
</div>