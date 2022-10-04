<h2><span class="badge bg-secondary m-3">LOCATIONS</span></h2>

<button class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
    Ajouter Location
</button>

<!-- Modal -->
<form method="post">
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter location</h5>
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
                                <label for="client" class="form-label">Client</label>
                                <select class="form-select mb-3" id="client" name="idClient" required>
                                    <?php
                                    foreach ($clientDAO->getAll() as $client) {
                                        echo "<option value='" . $client->getId() . "'>"
                                            . $client->getNom() . " " . $client->getPrenom()
                                            . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="compteurDebut" class="form-label">Compteur debut</label>
                                <input type="number" class="form-control" id="compteurDebut" name="compteurDebut"
                                       required>
                            </div>
                            <div class="mb-3 col">
                                <label for="compteurFin" class="form-label">Compteur fin</label>
                                <input type="number" class="form-control" id="compteurFin" name="compteurFin" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="dateDebut" class="form-label">Date debut</label>
                                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required>
                            </div>
                            <div class="mb-3 col">
                                <label for="dateFin" class="form-label">Date fin</label>
                                <input type="date" class="form-control" id="dateFin" name="dateFin" required>
                            </div>
                        </div>

                        <?php
                        foreach ($optionDAO->getAll() as $option) { ?>
                            <div>
                                <input type="checkbox" id="<?php echo $option->getId(); ?>" name="options[<?php echo $option->getId(); ?>]" value="<?php echo $option->getId(); ?>">
                                <label for="<?php echo $option->getId(); ?>"><?php echo $option->getLibelle(); ?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="addLocation" value="addLocation">Créer
                        location
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<br>
<!-- Modal - MODIFICATION -->
<form method="post">
    <input type="hidden" id="idLocation" name="idLocation" required>
    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="modele" class="form-label">Modéle</label>
                                <select class="form-select mb-3" name="idModele" id="modele" required>
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
                                <label for="client" class="form-label">Client</label>
                                <select class="form-select mb-3" name="idClient" id="client" required>
                                    <?php
                                    foreach ($clientDAO->getAll() as $client) {
                                        echo "<option value='" . $client->getId() . "'>"
                                            . $client->getNom() . " " . $client->getPrenom()
                                            . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="compteurDebut" class="form-label">Compteur debut</label>
                                <input type="number" class="form-control" id="compteurDebut" name="compteurDebut"
                                       required>
                            </div>
                            <div class="mb-3 col">
                                <label for="compteurFin" class="form-label">Compteur fin</label>
                                <input type="number" class="form-control" id="compteurFin" name="compteurFin" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="dateDebut" class="form-label">Date debut</label>
                                <input type="date" class="form-control" id="dateDebut" name="dateDebut" required>
                            </div>
                            <div class="mb-3 col">
                                <label for="dateFin" class="form-label">Date fin</label>
                                <input type="date" class="form-control" id="dateFin" name="dateFin" required>
                            </div>
                        </div>

                        <?php
                        foreach ($optionDAO->getAll() as $option) { ?>
                            <div>
                                <input type="checkbox" id="<?php echo $option->getId(); ?>" name="options[<?php echo $option->getId(); ?>]" value="<?php echo $option->getId(); ?>">
                                <label for="<?php echo $option->getId(); ?>"><?php echo $option->getLibelle(); ?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="editLocation" value="editLocation">Modifier
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<table class="table table-striped table-dark">
    <thead>
       <tr>
            <th scope="col">Identifiant<br>Location</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Identifiant<br>Client</th>
            <th scope="col">Modele</th>
            <th scope="col">Date début location</th>
            <th scope="col">Date fin location</th>
            <th scope="col">Durée location</th>
            <th scope="col">Km parcourus</th>
            <th scope="col">Prix options</th>
            <th scope="col">Prix (jour)</th>
            <th scope="col">Prix total Location</th>
            <th scope="col">Actuellement<br>en location</th>
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

        foreach ($locationDAO->getAll() as $location) { ?>
            <tr>
                <td><?php echo "N°" . $location->getId(); ?></td>
                <td><?php echo $location->getClient()->getNom(); ?></td>
                <td><?php echo $location->getClient()->getPrenom(); ?></td>
                <td><?php echo "N°" . $location->getClient()->getId(); ?></td>
                <td><?php echo $location->getVoiture()->getModele()->getLibelle(); ?></td>
                <td><?php echo $location->getDateDebut(); ?></td>
                <td><?php echo $location->getDateFin(); ?></td>
                <td><?php echo $location->getDuree() . " jour(s)"; ?></td>
                <td><?php echo $location->getKm() . "km"; ?></td>
                <td><?php echo $location->getPrixAllOptions() . "€"; ?></td>
                <td><?php echo $location->getVoiture()->getModele()->getCategorie()->getPrix() . "€"; ?></td>
                <td><?php echo $location->getPrixLocation() . "€"; ?></td>
                <td><?php echo $location->getDispo(); ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate"
                            onclick="loadUpdateLocationModal(<?php echo $location->getId() ?>)">
                        Modifier
                    </button>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="idLocation" value="<?php echo $location->getId(); ?>">
                        <button class="btn btn-danger" type="submit" name="deleteLocation">X
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    <tbody>
</table>
