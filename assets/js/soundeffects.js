  const characterCard = document.querySelectorAll('.character-card');

  const hoverSound = document.getElementById('hover-sound');
  

  characterCard.forEach((card) => {
    card.addEventListener('mouseover', () => {
      hoverSound.play();
    });
  });
