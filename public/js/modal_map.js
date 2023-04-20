// JS FOR MODAL 

    // Récuperation des elements du DOM 
    //Get DOM Elements

    // let modalBtn = <a class="showModal" href="#demo">Lire la suite</a>
    let modalBtn = document.querySelectorAll('.showModal');
    console.log(modalBtn);
    for (let index = 0; index < modalBtn.length; index++) {
      const element = modalBtn[index];
      element.addEventListener('click', openModal);
    }

    // let modal=<div id="my-modal" class="modal">
    let modal = document.querySelector('#my-modal');
    // let closeBtn=<span class="close">&times;</span>
    let closeBtn = document.querySelector('.close');

    // Event
    // modalBtn.addEventListener('click', openModal);
    // Event
    closeBtn.addEventListener('click', closeModal);
    // Event
    window.addEventListener('click', outsideClick);

    /////////////////////////////////////////////////////////////////////////////
    //                   open function
    //
    // au click sur le boutton "lire la suite", le modal s ouvre
    // l element modal (début du modal) apparait en passant 
    //              en style display block
    // 
    //////////////////////////////////////////////////////////////////////////////

    function openModal() {
      modal.style.display = 'block';
      console.log('openModal');
    }


    ///////////////////////////////////////////////////
    //                   Close function
    /////////////////////////////////////////////////// //

    function closeModal() {
      modal.style.display = 'none';
      console.log('closeModal');
    }

    ///////////////////////////////////////////////////
    //          Close If Outside Click function
    /////////////////////////////////////////////////// //

    function outsideClick(e) {
      if (e.target == modal) {
        modal.style.display = 'none';
        console.log('outsideClickIF');
      }
      console.log('outsideClick');
    }