<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
	
	if(document.querySelector('.entry-content') !== null){ // Si la page est un article

	  const infobulleMots = document.querySelectorAll('.infobulle-mot');
	  const parentTag = document.querySelector('.entry-content');
	  const parentTagWidth = parentTag.getBoundingClientRect().width;
	  const parentTagWidthPercent = parentTagWidth * 0.4; //Width de l'infobulle (pourcentage de la longueur de l'article)
	  const margin = 20; // margin avant fin d'extremité d'article

	  infobulleMots.forEach(function(infobulleMot) {
		const infobulleContenu = infobulleMot.querySelector('.infobulle-contenu');

		infobulleMot.addEventListener('mouseenter', function () {

		  const tooltipRect = infobulleContenu.getBoundingClientRect(); //Longueur infobulle 
		  const parentRect = parentTag.getBoundingClientRect(); //Longueur article

			  if (tooltipRect.width > parentTagWidthPercent) { // Si le texte de l'infobulle est trop long

				infobulleContenu.style.whiteSpace = 'normal';
				infobulleContenu.style.width = parentTagWidthPercent+'px';
			}

			//Redéfinir la longueur
		  const newTooltipRect = infobulleContenu.getBoundingClientRect(); //Longueur infobulle 
		  const newParentRect = parentTag.getBoundingClientRect(); //Longueur article

		if (newTooltipRect.right > newParentRect.right - margin){   // Si l'extremité est touché

			infobulleContenu.style.left = 'auto';
			infobulleContenu.style.right = '40%';
			infobulleContenu.style.setProperty('--arrow-left', 'auto');
			infobulleContenu.style.setProperty('--arrow-right', '15px');
		  } else {

			infobulleContenu.style.left = '40%';
			infobulleContenu.style.right = 'left';
			infobulleContenu.style.setProperty('--arrow-left', '15px');
			infobulleContenu.style.setProperty('--arrow-right', 'auto');
		  } 

		});
		  infobulleMot.addEventListener('mouseleave', function () { // Reset

			  infobulleContenu.style.width = 'auto';
			  infobulleContenu.style.maxWidth = 'none';
			  infobulleContenu.style.whiteSpace = 'nowrap';

			  infobulleContenu.style.left = '40%';
			  infobulleContenu.style.right = 'auto';

			  infobulleContenu.style.setProperty('--arrow-left', '50%');
			  infobulleContenu.style.setProperty('--arrow-right', 'auto');

		});
	  });
	}
});
</script>
<!-- end Simple Custom CSS and JS -->
