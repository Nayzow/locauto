<h2><span class="badge bg-secondary m-3">VOITURES</span></h2>

<button class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
    Ajouter Voiture
</button>

<!-- Modal -->
<form method="post">
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Voiture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="modele" class="form-label">Modéle</label>
                                <select class="form-select mb-3" id="modele" name="idModele" required>
                                    <?php
                                    foreach ($modeleDAO->getAll() as $modele) { ?>
                                        <option value="<?php echo $modele->getId() ?>">
                                            <?php echo $modele->getLibelle() ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="immatriculation" class="form-label">Immatriculation</label>
                                <input type="text" class="form-control" id="immatriculation" name="immatriculation"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="compteur" class="form-label">Compteur</label>
                                <input type="number" class="form-control" id="compteur" name="compteur"
                                       required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary" name="addVoiture" value="addVoiture">Ajouter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<br>
<!-- Modal - MODIFICATION -->
<form method="post">
    <input type="hidden" id="idVoiture" name="idVoiture" required>
    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Voiture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="modele" class="form-label">Modéle</label>
                                <select class="form-select mb-3" id="modele" name="idModele" required>
                                    <?php
                                    foreach ($modeleDAO->getAll() as $modele) { ?>
                                        <option value="<?php echo $modele->getId() ?>">
                                            <?php echo $modele->getLibelle() ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3 col">
                                <label for="immatriculation" class="form-label">Immatriculation</label>
                                <input type="text" class="form-control" id="immatriculation" name="immatriculation"
                                       required>
                            </div>
                            <div class="mb-3 col">
                                <label for="compteur" class="form-label">Compteur</label>
                                <input type="number" class="form-control" id="compteur" name="compteur"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="editVoiture" value="editVoiture">
                            Modifier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th scope="col">Identifiant</th>
            <th scope="col">Immatriculation</th>
            <th scope="col">Catégorie</th>
            <th scope="col">Marque</th>
            <th scope="col">Modèle</th>
            <th scope="col">Compteur</th>
            <th scope="col">Prix (jour)</th>
            <th scope="col">Photo</th>
            <th scope="col">Disponibilité</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($locationDAO->getAll()) === 0) {
            echo '<tr>
                    <td colspan="100%">Pas de données</td>
                </tr>';
        }
        ?>

        <?php
        foreach ($voitureDAO->getAll() as $voiture) { ?>
            <tr>
                <td><?php echo "N°" . $voiture->getId(); ?></td>
                <td><?php echo $voiture->getImmatriculation(); ?></td>
                <td><?php echo $voiture->getModele()->getCategorie()->getLibelle(); ?></td>
                <td><?php echo $voiture->getModele()->getMarque()->getLibelle(); ?></td>
                <td><?php echo $voiture->getModele()->getLibelle(); ?></td>
                <td><?php echo $voiture->getCompteur() . "km"; ?></td>
                <td><?php echo $voiture->getModele()->getCategorie()->getPrix() . "€"; ?></td>
                <td><img src="ressources/images/cars/<?php echo $voiture->getModele()->getImage(); ?>"></td>
                <td><?php if ($voitureDAO->getDispo($voiture->getId())) {
                        echo "Disponible";
                    } else {
                        echo "Non disponible";
                    } ?></td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate"
                            onclick="loadUpdateCarModal(<?php echo $voiture->getId(); ?>)">
                        Modifier
                    </button>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="idVoiture" value="<?php echo $voiture->getId(); ?>">
                        <button class="btn btn-danger" type="submit" name="deleteVoiture">
                            X
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    <tbody>
</table>
