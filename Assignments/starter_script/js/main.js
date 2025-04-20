"use strict";

let names = {};

names.init = function(){
  document.getElementById('addName').addEventListener('click', names.addName);
  document.getElementById('clearNames').addEventListener('click', names.clearNames);
  names.displayNames();
};

names.clearNames = function(){
  document.getElementById('msg').innerHTML = "";
  fetch('php/clearNames.php')
    .then(response => {
      response.clone().text().then(rawText => {
        console.log('Raw Text Response:', rawText);
      });
      return response.json();
    }) 
    .then(json => {
      console.log(json);
      document.getElementById('msg').innerHTML = json.msg;
      document.getElementById('flname').value = "";
      names.displayNames();
    })
    .catch(error => console.error('Error:', error));
};

names.addName = function(){
  let data = {};
  document.getElementById('displayNames').innerHTML = "";
  document.getElementById('msg').innerHTML = "";
  
  if(document.getElementById('flname').value === ""){
    document.getElementById('msg').innerHTML = "You must enter a name";
    return;
  }

  data.name = document.getElementById('flname').value;
  data = JSON.stringify(data);

  fetch('php/addName.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: data
  })
  .then(response => {
    response.clone().text().then(rawText => {
      console.log('Raw Text Response:', rawText);
    });
    return response.json();
  }) 
  .then(json => {
    console.log(json);
    document.getElementById('msg').innerHTML = json.msg;
    document.getElementById('flname').value = "";
    names.displayNames();
  })
  .catch(error => console.error('Error:', error));
};

names.displayNames = function(){
  document.getElementById('msg').innerHTML = "";
  fetch('php/displayNames.php')
    .then(response => {
      response.clone().text().then(rawText => {
        console.log('Raw Text Response:', rawText);
      });
      return response.json();
    }) 
    .then(json => {
      console.log(json);
      document.getElementById('displayNames').innerHTML =
        json.data.length === 0 ? "No names to display" : json.data.join("<br>");
    })
    .catch(error => console.error('Error:', error));
};

names.init();
