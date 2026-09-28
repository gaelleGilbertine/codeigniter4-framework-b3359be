// Client de recette de l'API bibliothèque (fourni, à ne pas modifier).
// Si votre API respecte le contrat de l'énoncé, ce client fonctionne sans changement.
// Servi depuis public/client/ : même origine que l'API, donc pas de problème CORS.
const API = '/api/livres';

const liste = document.getElementById('liste');
const message = document.getElementById('message');
const form = document.getElementById('form-livre');

function afficherMessage(texte, classe) {
  message.textContent = texte;
  message.className = classe;
}

// Transforme une réponse d'erreur CI4 ({status, error, messages}) en texte lisible.
async function texteErreur(reponse) {
  try {
    const corps = await reponse.json();
    return `${reponse.status} : ${Object.values(corps.messages ?? {}).join(' ')}`;
  } catch {
    return `${reponse.status} ${reponse.statusText}`;
  }
}

// GET : lire la collection
async function chargerLivres() {
  const reponse = await fetch(API, { headers: { Accept: 'application/json' } });
  if (!reponse.ok) {
    afficherMessage(await texteErreur(reponse), 'erreur');
    return;
  }
  const { donnees } = await reponse.json();

  liste.innerHTML = '';
  for (const livre of donnees) {
    const li = document.createElement('li');
    li.textContent = `${livre.titre} – ${livre.auteur}${livre.annee ? ' (' + livre.annee + ')' : ''}`;
    const bouton = document.createElement('button');
    bouton.textContent = 'Supprimer';
    bouton.className = 'suppr';
    bouton.addEventListener('click', () => supprimerLivre(livre.id));
    li.appendChild(bouton);
    liste.appendChild(li);
  }
}

// POST : créer une ressource
form.addEventListener('submit', async (evenement) => {
  evenement.preventDefault();
  const champs = Object.fromEntries(new FormData(form));
  const livre = { titre: champs.titre, auteur: champs.auteur };
  if (champs.annee !== '') livre.annee = champs.annee;

  const reponse = await fetch(API, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify(livre),
  });

  if (reponse.status === 201) {
    afficherMessage(`Livre créé : ${reponse.headers.get('Location')}`, 'ok');
    form.reset();
    chargerLivres();
  } else {
    afficherMessage(await texteErreur(reponse), 'erreur');
  }
});

// DELETE : supprimer une ressource
async function supprimerLivre(id) {
  const reponse = await fetch(`${API}/${id}`, { method: 'DELETE' });
  if (reponse.ok) { // 204 ou 200 : les deux sont acceptés
    afficherMessage(`Livre ${id} supprimé`, 'ok');
    chargerLivres();
  } else {
    afficherMessage(await texteErreur(reponse), 'erreur');
  }
}

chargerLivres();
