function filterRegions() {

    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const locationValue = document.getElementById('locationFilter').value;
    const natureValue = document.getElementById('natureFilter').value;
    
    const cards = document.querySelectorAll('.gallery-item-card');

    cards.forEach(card => {
        
        const regionName = card.querySelector('h2').textContent.toLowerCase();
        const tags = card.querySelectorAll('.gallery-tag');
        const cardLocation = tags[0].textContent; 
        const cardNature = tags[1].textContent;  

        const matchesSearch = regionName.includes(searchValue);
        const matchesLocation = locationValue === "" || cardLocation.includes(locationValue);
        const matchesNature = natureValue === "" || cardNature.includes(natureValue);

        if (matchesSearch && matchesLocation && matchesNature) {
            card.style.display = "flex";
        } else {
            card.style.display = "none";
        }
    });
}