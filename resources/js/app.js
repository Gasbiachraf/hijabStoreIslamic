import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ^^ blogs :
// var quill = new Quill('#editor', {
//     theme: 'snow'
// });

// // On form submit, update hidden input with Quill content
// document.querySelector('form').addEventListener('change', function() {
//     console.log(quill.root.innerHTML());
//     document.querySelector('#quill-content').value = quill.root.innerHTML();
// });
