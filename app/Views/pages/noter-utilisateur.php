<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}
$annonceId = $_GET['annonceId'] ?? '';
$receveurId = $_GET['userId'] ?? '';
$envoyeurId = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noter l'utilisateur</title>
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/css/header.css"/>
    <link rel="stylesheet" href="/css/footer.css" />
    <link rel="stylesheet" href="/css/pages/noter-utilisateur.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php include(__DIR__ . '/../includes/header.php'); ?>
  <h1>Noter l'utilisateur</h1>
  <form id="formNotation">
    <label for="note">Note (1 à 5) :</label>
    <select id="note" required>
      <option value="">--Choisissez--</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select>

    <label for="commentaire">Commentaire :</label>
    <textarea id="commentaire" rows="4" required></textarea>

    <button type="submit">Envoyer</button>
  </form>
  <div id="message"></div>

  <?php include(__DIR__ . '/../includes/footer.php'); ?>
  <script src="/js/secureFetch.js"></script>
  <script>
    const annonceId  = <?php echo json_encode($annonceId); ?>;
    const receveurId = <?php echo json_encode($receveurId); ?>;
    const envoyeurId = <?php echo json_encode($envoyeurId); ?>;

    document.getElementById('formNotation').addEventListener('submit', async function(e) {
      e.preventDefault();
      const note = parseInt(document.getElementById('note').value);
      const commentaire = document.getElementById('commentaire').value.trim();
      
      const payload = {
        annonceId: annonceId,
        receveurId: receveurId,
        envoyeurId: envoyeurId,
        notes: note,
        commentaire: commentaire
      };
      try {
        const res = await secureFetch('/api/avis', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const msgElem = document.getElementById('message');
        if (res.success) {
          msgElem.textContent = res.message;
          msgElem.className = 'success';
          alert('Merci pour votre notation !');
          document.location.href = '/annonces';
        } else {
          msgElem.textContent = res.message;
          msgElem.className = 'error';
        }
      } catch (err) {
        console.log(err)
      }
    });
  </script>
</body>
</html>
