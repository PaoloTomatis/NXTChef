<header>
    <a href="/" class="logo">
        <img class="logo-img img" src="assets/NxtChefLOGO.png" alt="Logo NxtChef">
        <h2 class="logo-tit">Nxt Chef</h2>
    </a>
    <form action="/search/" method="get" onsubmit="return cleanSearchURL();">
        <input class="search-bar" name="search" id="search" type="text" placeholder="Cerca qui...">
    </form>

    <script>
        function cleanSearchURL() {
            let searchInput = document.getElementById("search").value.trim();
            if (searchInput !== "") {
                window.location.href = "/search/" + encodeURIComponent(searchInput);
                return false; // Evita il submit normale
            }
            return true; // Continua con il submit se vuoto
        }
    </script>

    <?php if(isset($_SESSION["user"])){ ?>
        <a href="account" class="account"><img src="/assets/account.png" alt="account-img img" class="account-img"></a>
    <?php }else{ ?>
        <a href="login" class="cta">Accedi</a>
    <?php } ?>

</header>