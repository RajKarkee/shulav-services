const { default: axios } = require("axios");
const win = require("global");
const { json } = require("stream/consumers");

const cityChoosen_str=localStorage.getItem('cityChoosen');
var cityChoosen=0;

if(cityChoosen!=null){
    cityChoosen=parseInt(cityChoosen_str);
    if(cityChoosen==1){
        var city=JSON.parse(localStorage.getItem("city"));
    }
}else{
    $(document).ready(function () {
        axios.get('chooseCity')
        .then((res)=>{

        });
    });
}

