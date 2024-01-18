let access = localStorage.getItem('access');

const words = access.split('.');

let accessData = atob(words[1]);
let json = JSON.parse(accessData);
console.log(json['name']);
console.log("uid - "+json['user_id']);

localStorage.setItem("uid", json['user_id'])

let h1 = document.getElementById('helloH');

h1.innerText = 'Здравствуйте, '+json['name']+" !";




