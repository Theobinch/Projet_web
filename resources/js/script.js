document.addEventListener('DOMContentLoaded', function () {

    //recupere tous les elements qui pointe vers #student-modal
    const studentButtons = document.querySelectorAll('[data-modal-toggle="#student-modal"]');

    studentButtons.forEach(function (studentButton) {
        studentButton.addEventListener('click', function () {
            //recupere url associé a l'etudiant
            const url = this.getAttribute('data-student');
            //recupere modal par son id
            let modalBody = document.querySelector('#student-modal .modal-body');

            //affiche message de chargement
            modalBody.innerHTML = "Chargement...";

            //débogage
            console.log(url)

            //requete fetch pour recuperer donnée depuis url etudiant
            fetch(url)
                .then(response => {
                    //renvoie en json
                    return response.json();
                })
                .then(data => {
                    //met a jour le modal
                    modalBody.innerHTML = data.html;
                })
        });
    });

    //recupere tous les elements qui pointe vers #teacher-modal
    const teacherButtons = document.querySelectorAll('[data-modal-toggle="#teacher-modal"]');

    teacherButtons.forEach(function (teacherButton) {
        teacherButton.addEventListener('click', function () {
            //recupere url associé a l'enseignant
            const url = this.getAttribute('data-teacher');
            //recupere modal par son id
            let modalBody = document.querySelector('#teacher-modal .modal-body');

            //affiche message de chargement
            modalBody.innerHTML = "Chargement...";

            //débogage
            console.log(url)

            //requete fetch pour recuperer donnée depuis url enseignant
            fetch(url)
                .then(response => {
                    //renvoie en json
                    return response.json();
                })
                .then(data => {
                    //met a jour le modal
                    modalBody.innerHTML = data.html;
                })
        });
    });

    //recupere tous les elements qui pointe vers #cohort-modal
    const cohortButtons = document.querySelectorAll('[data-modal-toggle="#cohort-modal"]');

    cohortButtons.forEach(function (cohortButton) {
        cohortButton.addEventListener('click', function () {
            //recupere url associé a la promo
            const url = this.getAttribute('data-cohort');
            //recupere modal par son id
            let modalBody = document.querySelector('#cohort-modal .modal-body');

            //affiche message de chargement
            modalBody.innerHTML = "Chargement...";

            //débogage
            console.log(url)

            //requete fetch pour recuperer donnée depuis url promo
            fetch(url)
                .then(response => {
                    //renvoie en json
                    return response.json();
                })
                .then(data => {
                    //met a jour le modal
                    modalBody.innerHTML = data.html;
                })
        });
    });
});
