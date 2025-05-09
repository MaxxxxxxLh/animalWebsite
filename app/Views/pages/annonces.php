<?php
$annonces = [
    [
        'date' => '2025-04-22',
        'auteur' => 'Jean Dupont',
        'animal' => 'Rex (Chien)',
        'service' => 'Promenade'
    ],
    [
        'date' => '2025-04-21',
        'auteur' => 'Marie Curie',
        'animal' => 'Minette (Chat)',
        'service' => 'Garde'
    ]
];
?>

<h2>Liste des annonces</h2>

<?php foreach ($annonces as $annonce): ?>
    <p>
        <strong>Service :</strong> <?= $annonce['service'] ?><br>
        <strong>Date :</strong> <?= $annonce['date'] ?><br>
        <strong>Auteur :</strong> <?= $annonce['auteur'] ?><br>
        <strong>Animal :</strong> <?= $annonce['animal'] ?>
    </p>
    <hr>
<?php endforeach; ?>
