<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Div con Contenuto</title>
</head>
<body>

    <div class="container">
        <h2>Aggiungi un Nuovo Elemento</h2>
        <button class="add-btn" onclick="addDiv()">Aggiungi</button>
        <div id="content" class="dynamic-content">
            <!-- Qui verranno aggiunti i nuovi div -->
        </div>
    </div>

    <script>
        function addDiv() {
            // Seleziona l'elemento in cui aggiungere il nuovo div
            const container = document.getElementById("content");

            // Crea un nuovo div
            const newDiv = document.createElement("div");
            newDiv.classList.add("box");

            // Crea un h1
            const title = document.createElement("h1");
            title.textContent = "Titolo del Div";

            // Crea un paragrafo
            const paragraph = document.createElement("p");
            paragraph.textContent = "Questo è un paragrafo all'interno del div.";

            // Crea un form
            const form = document.createElement("form");

            // Crea un input
            const input = document.createElement("input");
            input.type = "text";
            input.placeholder = "Scrivi qualcosa...";

            // Aggiunge input al form
            form.appendChild(input);

            // Aggiunge tutto al div
            newDiv.appendChild(title);
            newDiv.appendChild(paragraph);
            newDiv.appendChild(form);

            // Aggiunge il div al contenitore
            container.appendChild(newDiv);
        }
    </script>

</body>
</html>
