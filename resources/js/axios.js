import axios from 'axios';

var url = window.location.href;
var arr = url.split("/");
var url_result = arr[0] + "//" + arr[2];

axios.defaults.baseURL = url_result+'/api/';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');