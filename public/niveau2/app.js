// Niveau 2 : consommer une API REST existante avec fetch.
const API = 'https://jsonplaceholder.typicode.com/posts';

const liste = document.getElementById('liste');
const message = document.getElementById('message');
const form = document.getElementById('form-article');

function afficher(texte, classe) {
  message.textContent = texte;
  message.className = classe;
}

// GET : les 5 premiers articles
async function charger() {
  // TODO 1 : appeler `${API}?_limit=5` avec l'en-tête Accept: application/json.
  const reponse = await fetch(`${API}?_limit=5`, {
    headers: {
      Accept: 'application/json'
    }
  });
  // TODO 2 : si reponse.ok est faux, afficher le code d'erreur et s'arrêter.
  if (!reponse.ok) {
  afficher(`Erreur HTTP : ${reponse.status}`, 'erreur');
  return;
}
  // TODO 3 : vider #liste, puis créer un <li> par article (id et title)
  //          avec un bouton « Supprimer » qui appelle supprimer(article.id).
   const articles = await reponse.json();

  liste.innerHTML = '';

  articles.forEach((article) => {
    const li = document.createElement('li');

    li.textContent = `${article.id} - ${article.title}`;

    const bouton = document.createElement('button');
    bouton.textContent = 'Supprimer';

    bouton.addEventListener('click', () => supprimer(article.id));

    li.appendChild(bouton);
    liste.appendChild(li);
  });
}

// POST : créer un article
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const { title, body } = Object.fromEntries(new FormData(form));
  // TODO 4 : envoyer { title, body, userId: 1 } en JSON (POST, en-tête Content-Type).
  const reponse = await fetch(API, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json'
  },
  body: JSON.stringify({
    title,
    body,
    userId: 1
  })
});
  // TODO 5 : si le statut est 201, afficher l'identifiant attribué puis recharger la liste.
if (reponse.status === 201) {
  const nouvelArticle = await reponse.json();

  afficher(
    `Nouvel article créé avec l'identifiant ${nouvelArticle.id}`,
    'ok'
  );

  await charger();
} else {
  afficher(`Erreur HTTP : ${reponse.status}`, 'erreur');
}
  //          Le nouvel article apparaît-il ? Pourquoi ?
 // =>  non le nouvel article n' apparait pas car JSONPlaceholder simule les créations mais ne les conserve pas
});

// DELETE : supprimer un article
async function supprimer(id) {
  // TODO 6 : envoyer DELETE sur `${API}/${id}` et afficher le code reçu.
   const reponse = await fetch(`${API}/${id}`, {
    method: 'DELETE'
  });

  afficher(`Réponse HTTP : ${reponse.status}`, 'succes');

}

charger();
