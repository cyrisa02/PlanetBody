const userCardTemplate = document.querySelector("[data-user-template]")
const userCardContainer = document.querySelector("[data-user-cards-container]")
const searchInput = document.querySelector("[data-search]")
let users = []
searchInput.addEventListener("input", e => {   
    const value = e.target.value.toLowerCase()
    users.forEach(user => {         
        const isVisible = user.name.toLowerCase().includes(value) || user.city.toLowerCase().includes(value) 
        //console.log(user.element.classList)
        user.element.classList.toggle("d-none", !isVisible )
    })    
})
 fetch('https://cyrisa02-planetbody.herokuapp.com/api/users?page=1')
.then(res => res.json())
.then(data => { return data['hydra:member']})
.then(data1=> {
   users = data1.map(user => {     
        const card = userCardTemplate.content.cloneNode(true).children[0]
         const header = card.querySelector("[data-header]")
         const body = card.querySelector("[data-body]")
           
         
         header.textContent= user.name 
         body.textContent= user.city
        
         
         userCardContainer.append(card)
         return { name: user.name, city: user.city,  element: card}
         })
 })

 // Filter for enable Partner
 //C'est en sécurité si ce script doit être déplacé, ou voir l'attribut defer pour afficher les cartes
 window.onload= () => {
    //pour gérer les interactions, je vais chercher tous les filtres qui sont des balises div
    let filters =  document.querySelectorAll("#filters div");
    //Je boucle sur ces div et j'écoute le clic en uitilsant une nouvelle variable filter
    for(let filter of filters){
        //sur chaque filtre de filters j'ecoute avec addEventlistener le clic
        filter.addEventListener("click", function(){
            // avec function je peux utiliser la variable this pour me référer à filter
            // Je récupère le nom du filtre (=tag)
            // Je dois relier dans le HTML les filtres aux cartes avec les dataset
            let tag = this.id;
            //Comparer les dataset
            //Je vais cherhcer toutes les cartes
            let partners = document.querySelectorAll(".partner");

            //Les cartes sont dans un tableau que je vais boucler
            for(let partner of partners){
                //pour chaque carte je vais dans sa classe liste et je la mets inactive
                partner.classList.replace("active", "inactive");
                //si le tag est dans le dataset, je vais dans sa classeList et je remplace pas active
                // attention on a besoin du || pour afficher l'ensembles des cartes
                if(tag in partner.dataset || tag === "all"){
                    partner.classList.replace("inactive", "active"); 
                }
            }
        });
    }
 }