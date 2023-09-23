/*function onSignIn(googleUser) {
    let profile = googleUser.getBasicProfile();
    auth("Login", profile);
}

function auth(action, profile){
    let data = {UserAction: action}

    if(profile){
        data = {
            UserName: profile.getGivenName(),
            UserLastName: profile.getFamilyName(),
            UserEmail: profile.getEmail(),
            UserAction: action
        }
    }
    
    let url = "./php/inicia_usuario.php";


    fetch(url, {
        method: "POST",
        body: data,
        mode: "cors",
        success: function(data){
            console.log(data);
        }
    })
    .then(response => response.json())
    .then(data => {

        lista.innerHTML = data;

    })
    .catch(err=> console.log("catch->",err));
}*/