const meals=document.getElementById('.meals')
const favm=document.getElementById("scrollContainer")
async function getmealbyid(id){
 const meal= await fetch("https://www.themealdb.com/api/json/v1/1/lookup.php?i="+id)
}
async function getrandommeal(){
const randommeal= await fetch("https://www.themealdb.com/api/json/v1/1/random.php");
const respo=await randommeal.json()
const rand=respo.meals[0]
addmeal(rand,true)
}
async function getmealbysearch(term){
const meals= await fetch('https://www.themealdb.com/api/json/v1/1/search.php?s='+term)
return meals;
}
function addmeal(mealdata,random=false){
    const meall=document.createElement('li').innerHTML="<img src=" //https://www.themealdb.com/images/category/vegetarian.png" alt=""/><span>vegeterian</span>";
   // favm.append(meall);
}
