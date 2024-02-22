let data=JSON.parse(localStorage.getItem("selectedHotel"))

// console.log(data.rating)
let querry="Calatagan Proper Virac, Catanduanes"

let gmap=document.getElementById("gmap_canvas")
let gmap1=document.getElementById("gmap_canvas1")
gmap.src=`https://api.openweathermap.org/data/2.5/weather?q=${querry}&appid=c5f7cb74d66a1bd017f2be6cb3dde82f`
fetchData()
async function fetchData(){
    try{


        gmap.src=`https://maps.google.com/maps?q=${querry}=&output=embed`
        gmap1.src=`https://maps.google.com/maps?q=${querry}=&output=embed`
       

    }catch(err){
        console.log(err);
    }
}