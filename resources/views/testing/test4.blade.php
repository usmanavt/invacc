<!doctype html >
<html lang="en" >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

<style>
    li{cursor: pointer;}
</style>

<head>
    <title>SIDE MENUE BAR CSS</title>
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}


<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<body>

    <input type="text" id="txt">

    <button onclick="addLI()">add</button>
    <button onclick="editLI()">edit</button>
    <button onclick="deleteLI()">delete</button>

    <ul id="list">
        <li> Usman </li>
        <li> Shakoor </li>
        <li> aRehman </li>
        <li> Murad </li>
        <li> Muqeet </li>



    </ul>

    <script>
var inputtext=document.getElementById("txt"),
items=document.querySelectorAll("#list li"),
tab=[],index;

//get the selected li index using array
// populate array with li values

for(var i=0;i<items.length;i++){
	tab.push(items[i].innerHTML);
}



for(var i=0;i<items.length;i++){
	items[i].onclick=function(){
index=tab.indexOf(this.innerHTML);
console.log(this.innerHTML + " INDEX= " + index)
inputtext.value=this.innerHTML;
};
}


function refreshArray()
{
tab.length=0;
items=document.querySelectorAll("#list li");
for(var i=0;i<items.length;i++){
	tab.push(items[i].innerHTML);
}
}




function addLI()
{
  var listNode=document.getElementById("list"),
   	textNode=document.createTextNode(inputtext.value),
	liNode=document.createElement("LI");

    liNode.appendChild(textNode)
    listNode.appendChild(liNode)
    refreshArray();

    liNode.onclick=function(){
index=tab.indexOf(liNode.innerHTML);
console.log(liNode.innerHTML + " INDEX= " + index)
inputtext.value=liNode.innerHTML;
};

}

function editLI(){
items[index].innerHTML=inputtext.value;
}

function deleteLI(){
    refreshArray();
if(items.length > 0){
        items[index].parentNode.removeChild(items[index]);
}
}



</script>

</body>
</html>
