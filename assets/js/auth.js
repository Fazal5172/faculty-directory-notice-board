function copyText(id,button){

    let text=document.getElementById(id).innerText;
    
    
    navigator.clipboard.writeText(text);
    
    
    button.innerHTML='<i class="fa-solid fa-check"></i>';
    
    
    setTimeout(()=>{
    
    button.innerHTML='<i class="fa-regular fa-copy"></i>';
    
    },1500);
    
    
    }
    
    
    
    function fillDemo(email,password){
    
    document.querySelector('input[name="email"]').value=email;
    
    document.querySelector('input[name="password"]').value=password;
    
    
    }
    