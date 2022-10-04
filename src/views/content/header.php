<header id="header">
    <nav class="navbar">
        <div class="navlogo">
            <a href="?choice=home">
                <img src="ressources/images/logo.png" height="56"/>
            </a>
        </div>
        <div class="navlinks">
            <ul>
                <li><a href="?choice=home">Home</a></li>
                <li><a href="?choice=voitures">Voitures</a></li>
                <li><a href="?choice=clients">Clients</a></li>
                <li><a href="?choice=locations">Locations</a></li>
                <li><a href="?choice=statistiques">Statistiques</a></li>
            </ul>
        </div>
    </nav>
</header>

<?php
if(isset($error) && !is_null($error) && $error !== "") {?>
    <div class="alert alert-danger m-4" role="alert">
    <?php echo $error ?>
    </div><?php
}
?>