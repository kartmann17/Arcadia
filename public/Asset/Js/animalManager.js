document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('animalModal');
    const mainContent = document.querySelector('body > *:not(#animalModal)');

    // Écouter l'ouverture du modal
    modal.addEventListener('show.bs.modal', () => {
        
        modal.setAttribute('aria-hidden', 'false');

        mainContent.setAttribute('inert', '');
    });

    // Écouter la fermeture du modal
    modal.addEventListener('hide.bs.modal', () => {

        modal.setAttribute('aria-hidden', 'true');

        mainContent.removeAttribute('inert');
    });

    // Gestion des clics sur les boutons de détails
    const detailButtons = document.querySelectorAll('.show-details');

    detailButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Récupérer les données de l'animal depuis les attributs data-*
            const animalData = {
                id: this.dataset.animalId,
                name: this.dataset.animalName,
                age: this.dataset.animalAge,
                race: this.dataset.animalRace,
                habitat: this.dataset.animalHabitat,
                description: this.dataset.animalDescription
            };

            // Afficher le modal avec les données
            showModal(animalData);

            // Incrémenter le compteur de visites
            incrementVisits(animalData.id);
        });
    });
});

// Fonction pour afficher le modal
function showModal(animalData) {
    const modalElements = {
        'modal-animal-name': animalData.name,
        'modal-animal-age': animalData.age,
        'modal-animal-race': animalData.race,
        'modal-animal-habitat': animalData.habitat,
        'modal-animal-description': animalData.description
    };

    Object.entries(modalElements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    });

    const modal = new bootstrap.Modal(document.getElementById('animalModal'));
    modal.show();
}

// Fonction pour incrémenter les visites
async function incrementVisits(animalId) {
    try {


        const response = await fetch('/Animaux/incrementVisits', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: animalId,

            }),
        });

        const data = await response.json();

        if (!data.success) {
            console.error('Erreur lors de l\'incrémentation des visites :', data.message);
            alert(data.message);
        } else {
            console.log('Visite incrémentée avec succès :', data.message);
        }
    } catch (error) {
        console.error('Erreur réseau lors de l\'incrémentation des visites :', error);
    }

}