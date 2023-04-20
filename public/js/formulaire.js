let eye = document.querySelector(".fa-eye");
let eyeoff = document.querySelector(".fa-eye-slash");
let passwordInput = document.querySelector("input[type=password]");

eye.addEventListener('click', onClickEye);
eyeoff.addEventListener('click', onClickEyeOff);
eyeoff.style.display = "none";

/**
 * onClickEye()
 */
function onClickEye(){
	if(passwordInput.type === 'password'){
		passwordInput.type = 'text';
		eyeoff.style.display = "block";
		eye.style.display = "none";
	}
}
/**
 * onClickEyeOff()
 */
function onClickEyeOff(){
	if(passwordInput.type === 'text'){
		passwordInput.type = "password";
		eyeoff.style.display = "none";
		eye.style.display = "block";
	}	
}







function setRandomBackground() {
	// On initialise un tableau backgrounds
	let backgrounds = [
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-01.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-02.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-03.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-04.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-05.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-06.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-07.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-08.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-09.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-10.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-11.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/03/CARTES-COLORISEES-AIX-EN-PROVENCE-12.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/05/Place-bellegarde-Aix-01.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/05/Place-bellegarde-Aix-02.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/05/Place-bellegarde-Aix-03.jpg',
	  'https://laixois.fr/wp-content/uploads/2018/05/Place-bellegarde-Aix-04.jpg',
  
	];
  
	// On utilise le random pour chosir une image aléatoire du tableau 
	let background = backgrounds[Math.floor(Math.random() * backgrounds.length)];
  
	//On insere dans le body le backgroundImage 
	document.body.style.backgroundImage = 'url(' + background + ')';
  }

window.onload = setRandomBackground;