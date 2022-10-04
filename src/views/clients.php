<h2><span class="badge bg-secondary m-3">CLIENTS</span></h2>

<button class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
    Ajouter Client
</button>

<!-- Modal -->
<form method="post">
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="prenom" class="form-label">Prenom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3 col">
                            <label for="typeClient" class="form-label">Type de client</label>
                            <select class="form-select mb-3" name="typeClient" id="typeClient" required>
                                <?php
                                foreach ($typeClientDAO->getAll() as $typeClient) { ?>
                                    <option name="typeClient" value="<?php echo $typeClient->getId(); ?>">
                                        <?php echo $typeClient->getLibelle(); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary" name="addClient" value="addClient">Ajouter
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
    <input type="hidden" id="idClient" name="idClient" required>
    <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom"
                                       required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="prenom" class="form-label">Prenom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse"
                                       required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="typeClient" class="form-label">Type Client</label>
                                <select class="form-select mb-3" id="typeClient" name="typeClient" required>
                                    <?php
                                    foreach ($typeClientDAO->getAll() as $typeClient) { ?>
                                        <option value="<?php echo $typeClient->getId(); ?>">
                                            <?php echo $typeClient->getLibelle(); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="editClient" value="editClient">
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
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Adresse</th>
            <th scope="col">Type de client</th>
            <th scope="col">Nombre de locations</th>
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
        foreach ($clientDAO->getAll() as $client) { ?>
            <tr>
                <td><?php echo "N°" . $client->getId(); ?></td>
                <td><?php echo $client->getNom(); ?></td>
                <td><?php echo $client->getPrenom(); ?></td>
                <td><?php echo $client->getAdresse(); ?></td>
                <td><?php echo $client->getTypeClient()->getLibelle(); ?></td>
                <td><?php echo $clientDAO->getNbLocationById($client->getId()); ?></td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate"
                            onclick="loadUpdateClientModal(<?php echo $client->getId() ?>)">
                        Modifier
                    </button>
                </td>
                <td>
                    <form method="post">
                        <input type="hidden" name="idClient" value="<?php echo $client->getId(); ?>">
                        <button class="btn btn-danger" type="submit" name="deleteClient">X
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    <tbody>
</table>