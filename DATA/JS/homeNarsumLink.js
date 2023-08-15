// const narsumLinks = document.querySelectorAll('.narsum-card-link');
// narsumLinks.forEach(link => {
//     link.addEventListener('click', (e) => {
//     e.preventDefault();
//     const query = link.dataset.keyword;

//     const form = document.createElement('form');
//     form.method = 'POST';
//     form.action = 'related_results.php';

//     const narsumInput = document.createElement('input');
//     narsumInput.type = 'hidden';
//     narsumInput.name = 'narasumber';
//     narsumInput.value = query;

//     form.appendChild(narsumInput);

//     document.body.appendChild(form);
//     form.submit(); // <-- Add parentheses to call the form submission function
//     });
// });