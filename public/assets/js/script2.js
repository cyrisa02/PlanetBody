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





const showEnable = () =>{
    let partners = document.getElementsByClassName("partner");
    
    for (i=0; i < partners.length; i++) {
       
        if (partners[i].classList.contains("active")){
            partners[i].style.display= "block";
        }
        else {
             partners[i].style.display= "none";
        }
    }
}

const showDisable = () =>{
    let partners = document.getElementsByClassName("partner");
    
    for (i=0; i < partners.length; i++) {
       
        if (partners[i].classList.contains("active")){
            partners[i].style.display= "none";
        }
        else {
             partners[i].style.display= "block";
        }
    }
}

const showAll = () =>{
    let partners = document.getElementsByClassName("partner");
    
    for (i=0; i < partners.length; i++) {

        partners[i].style.display= "block";
       
       
    }
}


window.onload= () => {
let buttonEnable = document.getElementById("enable");

buttonEnable.addEventListener("click", showEnable);

let buttonDisable = document.getElementById("disable");

buttonDisable.addEventListener("click", showDisable);

let buttonAll= document.getElementById("all");

buttonAll.addEventListener("click", showAll);

}