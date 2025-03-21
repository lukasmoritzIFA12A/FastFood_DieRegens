function setStarRating(contestId, rating) {
    const container = document.querySelector(`.ratedStars[data-contest-id="${contestId}"]`);
    if (!container) {
        return;
    }

    const stars = container.querySelectorAll('svg');
    stars.forEach((star, index) => {
        const fillPath = document.getElementById(`star${contestId}_${index + 1}Fill`);
        const emptyPath = document.getElementById(`star${contestId}_${index + 1}Empty`);
        if (index < rating) {
            star.classList.remove('bi-star');
            star.classList.add('bi-star-fill');
            fillPath.style.display = '';
            emptyPath.style.display = 'none';
        } else {
            star.classList.remove('bi-star-fill');
            star.classList.add('bi-star');
            fillPath.style.display = 'none';
            emptyPath.style.display = '';
        }
    });
}