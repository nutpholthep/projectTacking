const form = document.querySelector('form');
       
       form.addEventListener('submit', (event) => {
         const projectname = form.querySelector('#projectname');
         const employeesid = form.querySelector('#employeesid');
         const info = form.querySelector('#detail');
         const timeend = form.querySelector('#deadline');
         const dropdown = form.querySelector('#dropdown');
       
         if (!projectname.value) {
           projectname.classList.add('is-invalid');
           event.preventDefault();
         } else {
            projectname.classList.remove('is-invalid');
           projectname.classList.add('is-valid');
         }
       
         if (!employeesid.value) {
           employeesid.classList.add('is-invalid');
           event.preventDefault();
         } else {
           employeesid.classList.remove('is-invalid');
           employeesid.classList.add('is-valid');
         }
         if (!info.value) {
           info.classList.add('is-invalid');
           event.preventDefault();
         } else {
           info.classList.remove('is-invalid');
           info.classList.add('is-valid');
         }
         if (!timeend.value) {
           timeend.classList.add('is-invalid');
           event.preventDefault();
         } else {
           timeend.classList.remove('is-invalid');
           timeend.classList.add('is-valid');
         }
         if (dropdown && !dropdown.value) {
          dropdown.classList.add('is-invalid');
          event.preventDefault();
        } else {
          dropdown.classList.remove('is-invalid');
          dropdown.classList.add('is-valid');
        }
       });

 