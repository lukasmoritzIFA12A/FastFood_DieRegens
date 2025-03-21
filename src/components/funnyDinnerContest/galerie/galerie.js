document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star");
    let rating = 0;

    stars.forEach(star => {
        star.addEventListener("click", function () {
            rating = this.getAttribute("data-value");
            alert(rating);

            // Alle Sterne zurücksetzen
            stars.forEach(s => s.classList.remove("active"));

            // Aktive Sterne färben
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("active");
            }
        });
    });
});

function setupStarRatings() {
    const ratingContainers = document.querySelectorAll('.ratingStars');

    ratingContainers.forEach(container => {
        const contestId = container.getAttribute('data-contest-id');
        const stars = container.querySelectorAll('svg');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const isFilled = star.classList.contains('bi-star-fill');

                stars.forEach((currentStar, currentIndex) => {
                    const fillPath = document.getElementById(`star${contestId}_${currentIndex + 1}Fill`);
                    const emptyPath = document.getElementById(`star${contestId}_${currentIndex + 1}Empty`);

                    if (currentIndex <= index && !isFilled) {
                        currentStar.classList.remove('bi-star');
                        currentStar.classList.add('bi-star-fill');
                        fillPath.style.display = '';
                        emptyPath.style.display = 'none';
                    } else if (currentIndex >= index && isFilled) {
                        currentStar.classList.remove('bi-star-fill');
                        currentStar.classList.add('bi-star');
                        fillPath.style.display = 'none';
                        emptyPath.style.display = '';
                    }
                });
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', setupStarRatings);

function onBewerten(button, kundeId) {
    if (!kundeId) {
        const modal = new bootstrap.Modal(document.getElementById('loginRequiredRatingModal'));
        modal.show();
        return;
    }

    const contestId = button.getAttribute('data-contest-id');
    const ratingContainer = document.querySelector(`.ratingStars[data-contest-id="${contestId}"]`);
    const filledStars = ratingContainer.querySelectorAll('.bi-star-fill').length;

    const formData = new FormData();
    formData.append("id", contestId);
    formData.append("kundeId", kundeId);
    formData.append("rating", filledStars.toString());

    fetch("/FastFood/src/components/funnyDinnerContest/galerie/galerie-rate-handler.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        }) // Antwort als JSON
        .then(data => {
            if (data.success) {
                window.location.href = "galerie.php";
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}