<?php
session_start();
require_once("includes/dbh.inc.php");
require_once("base/tutorial.php");
$_SESSION["pages"][]=$_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="it">
    <?php require_once("base/head.php"); head("NxtChef || Tutorial", "tutorial") ?>
    <body>
        <?php require_once("base/navbar.php") ?>
        <main>
            <?php card("Trova la ricetta perfetta", "Non sai cosa cucinare? Usa i filtri avanzati per trovare la ricetta ideale in base agli ingredienti che hai, al tempo a disposizione e al livello di difficoltà. Puoi anche cercare per dieta o calorie, così troverai sempre il piatto perfetto per le tue esigenze!", 1) ?>
            <?php card("Salva e organizza le tue ricette", "Hai trovato una ricetta che ti piace? Salvala nel tuo spazio personale per ritrovarla facilmente quando ne avrai bisogno. Puoi creare una raccolta personalizzata e organizzare le tue ricette preferite in categorie!", 2) ?>
            <?php card("Genera la lista della spesa", "Niente più dimenticanze! Seleziona le ricette che vuoi preparare e NxtChef creerà automaticamente la tua lista della spesa con tutti gli ingredienti necessari. Puoi anche modificare la lista in base a quello che hai già in casa.", 3) ?>
            <?php card("Segui le ricette passo dopo passo", "Con la modalità step-by-step, cucinare diventa semplice! Segui le istruzioni una per una, senza dover scorrere avanti e indietro nella pagina. Ogni passaggio è chiaro e ben organizzato per un'esperienza di cucina senza stress.", 4) ?>
            <?php card("Condividi con un click", "Hai creato una ricetta fantastica? Condividila con i tuoi amici! Con un semplice link o tramite i social media, puoi mostrare le tue creazioni e scoprire nuove idee dai tuoi contatti.", 5) ?>
            <?php card("Crea e personalizza le tue ricette", "Hai una ricetta speciale che vuoi salvare? Su NxtChef puoi creare le tue ricette personalizzate, aggiungendo ingredienti, istruzioni e foto. Scegli se mantenerle private per il tuo uso personale o pubblicarle per condividerle con la community e aiutare altri appassionati di cucina!", 6) ?>
            <?php card("Accedi per un'esperienza completa", "<a href='/login' class='link'>Registrati o accedi al tuo account</a> per sbloccare tutte le funzionalità di NxtChef! Potrai salvare le tue ricette preferite, creare piatti personalizzati, generare liste della spesa e molto altro. Unisciti alla community e porta la tua esperienza culinaria al livello successivo!", 7); ?>
            <div class="main-bar">
                <button class="back">🠔</button>
                <button class="forward">🠖</button>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let currentIndex = 1; // Iniziamo dalla card con id="card-1"
                    
                    const backButton = document.querySelector(".back");
                    const forwardButton = document.querySelector(".forward");

                    const updateCards = (newIndex) => {
                        // Rimuoviamo le classi dalle card precedenti
                        document.querySelectorAll('.card').forEach(card => {
                            card.classList.remove("active", "highlight");
                        });

                        // Aggiungiamo le classi alla card corrente e alla successiva (o precedente)
                        const currentCard = document.getElementById(`card-${newIndex}`);
                        const nextCard = document.getElementById(`card-${newIndex + 1}`);
                        const prevCard = document.getElementById(`card-${newIndex - 1}`);

                        if (currentCard) {
                            currentCard.classList.add("active");
                        }
                        if (nextCard) {
                            nextCard.classList.add("highlight");
                        }
                        if (prevCard) {
                            prevCard.classList.add("highlight");
                        }
                    };

                    // Funzione per andare indietro
                    backButton.addEventListener("click", () => {
                        if (currentIndex > 1) { // Evita di andare oltre la prima card
                            currentIndex--;
                            updateCards(currentIndex);
                        }
                    });

                    // Funzione per andare avanti
                    forwardButton.addEventListener("click", () => {
                        if (document.getElementById(`card-${currentIndex + 1}`)) { // Controlla che la prossima card esista
                            currentIndex++;
                            updateCards(currentIndex);
                        }
                    });

                    // Inizializza la visualizzazione delle card
                    updateCards(currentIndex);
                });
            </script>
        </main>
        <?php require_once("base/footer.php") ?>
    </body>
</html>