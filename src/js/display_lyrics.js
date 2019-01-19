let lyricsDisplayCheckboxes = Array.apply(null, document.querySelectorAll('.lyrics-list__table__row__data__display-lyrics'));
lyricsDisplayCheckboxes.forEach((lyricsDisplayCheckbox) => {
    lyricsDisplayCheckbox.addEventListener('change', function() {
        let lyricsArea = this.parentNode.parentNode.nextElementSibling.children[0];
        if(this.checked) {
            lyricsArea.classList.add('display-lyrics');
        } else {
            lyricsArea.classList.remove('display-lyrics');
        }
    });
});
