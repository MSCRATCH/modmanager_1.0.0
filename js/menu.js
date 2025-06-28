const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
  navbarLinks.classList.toggle('active')
})

const dropdownToggle = document.querySelectorAll('.dropdown-toggle');

dropdownToggle.forEach((toggle) => {
  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    const dropdownMenu = toggle.nextElementSibling;
    dropdownMenu.classList.toggle('active');
  });
});
