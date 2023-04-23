<br>
<div class="container-fluid">
    <div class="row">
        <div class="col graph">
            <div>
                <div class="line-chart">
                    <div class="aspect-ratio">
                        <canvas id="graph2"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col graph">
            <div>
                <div class="line-chart">
                    <div class="aspect-ratio">
                        <canvas id="graph1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function () {
        let GRAPH_1;
        let GRAPH_2;

        const options = {
            // A definir pour l'affichage des graphiques
        };

        // La data et la configuration de chaque graphique
        const data = {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],

            datasets: [{
                label: "Evolution chiffre d'affaire sur l'année",
                backgroundColor: 'rgb(11,94,215)',
                borderColor: 'rgb(11,94,215)',
                data: <?php echo json_encode($locationDAO->getCAbyMonth())?>,
            }]
        };

        const config = {
            type: "line",
            data: data,
            options: options
        };

        const data2 = {
            labels: <?php echo json_encode($modeleDAO->getAllModeleLibelle());?>,
            datasets: [{
                label: "Nombre de locations par modèle",
                backgroundColor: 'rgb(11,94,215)',
                borderColor: 'rgb(11,94,215)',
                data: <?php echo json_encode($locationDAO->getNbLocationsByModele());?>,
            }]
        };

        const config2 = {
            type: "bar",
            data: data2,
            options: options
        };

        GRAPH_1 = new Chart(document.getElementById('graph1'), config);
        GRAPH_2 = new Chart(document.getElementById('graph2'), config2);
    }
</script>