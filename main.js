window.addEventListener('load', function () {
    if(getCookie().nighttem == null){
        document.cookie = 'nighttem=0';
    }
    ChengeTem();
})

document.getElementsByName("tem")[0].onclick = function () {
    if(getCookie().nighttem == "0"){
        document.cookie = 'nighttem=1';
    }
    else {
        document.cookie = 'nighttem=0';
    }
    ChengeTem();
}

if(document.getElementsByName("exit")[0]){
    document.getElementsByName("exit")[0].onclick = function () {
        document.getElementById("exitForm").submit();
    }
}

function getCookie() {
    return document.cookie.split('; ').reduce((acc, item) => {
        const [name, value] = item.split('=')
        acc[name] = value
        return acc
    }, {})
}

function ChengeTem(){
    if(getCookie().nighttem == "0"){
        document.getElementsByName("tem")[0].value = "Тёмная тема"
        document.getElementById("style").href = "light.css";
    }
    else{
        document.getElementsByName("tem")[0].value = "Светлая тема"
        document.getElementById("style").href = "night.css";
    }
}

if(document.getElementsByName("register")[0]){
    document.getElementsByName("register")[0].onclick = function () {
        error = "";

        NAME_REGEXP = /^\S{2,15}$/iu;
        SURNAME_REGEXP = /^.{2,15}$/iu;
        EMAIL_REGEXP = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,50})$/iu;
        LOGIN_REGEXP = /^\S{6,50}$/iu;
        PASS_REGEXP = /(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{8,16}$/g;


        if(!NAME_REGEXP.test(document.getElementsByName("name")[0].value)){
            error = error + "Поле Имя введено не корректно\n";
        }
        if(!SURNAME_REGEXP.test(document.getElementsByName("surname")[0].value)){
            error = error + "Поле Фамилия введено не корректно\n";
        }
        if(!EMAIL_REGEXP.test(document.getElementsByName("mail")[0].value)){
            error = error + "Поле E-mail введено не корректно\n";
        }
        if(!LOGIN_REGEXP.test(document.getElementsByName("login")[0].value)){
            error = error + "Поле Логин введено не корректно\n";
        }
        if(!PASS_REGEXP.test(document.getElementsByName("password")[0].value)){
            error = error + "Поле Пароль введено не корректно\n";
        }
        if(document.getElementsByName("passwordСonfirm")[0].value != document.getElementsByName("password")[0].value){
            error = error + "Пароли не совпадают\n";
        }
        if(!document.getElementsByName("agreement")[0].checked){
            error = error + "Вам нужно Принять правила\n";
        }
        if(document.getElementsByName("vozr")[0].value == ""){
            error = error + "Заполните поле Возраст\n";
        }
        if(document.getElementsByName("gender")[0].value == ""){
            error = error + "Выберите Пол\n";
        }
        if(error == ""){
            document.getElementById("regForm").submit();
        }
        else{
            alert(error);
        }
    }
}