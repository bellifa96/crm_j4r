<!DOCTYPE html>
<html>
<head>
    <title>Récupération de l'URL avec JavaScript et traitement en PHP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <script>
        // Récupérer la partie de l'URL après le signe dièse (#)
        var hashPart = window.location.hash;

        // Supprimer le signe dièse (#) de la chaîne
        var queryString = hashPart.substring(1); // Supprimer le premier caractère (#)

		// Pour voir si on recupere bien l'url apres le diese
        //var container = document.createElement("div");
        //container.textContent = queryString;
        //document.body.appendChild(container);		
		
		// Créez l'URL avec les paramètres
		var url = '/save-token?' + queryString;		
		window.location.href = url;		
    </script>
</body>
</html>