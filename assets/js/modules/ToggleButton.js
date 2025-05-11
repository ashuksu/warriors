export default class ToggleButton {
	static init() {
		document.querySelectorAll('[data-button="toggle"]').forEach(button => {
			button.addEventListener('click', e => {
				button.classList.toggle('active');

				const target = document.getElementById(button.getAttribute('href'));

				if (target) {
					target.classList.toggle('active', button.classList.contains('active'));
					e.preventDefault();
				}
			});
		});
	}
}