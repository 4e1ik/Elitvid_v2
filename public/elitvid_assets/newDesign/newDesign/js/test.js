'use strict';

// function httpGet(url){
//     return new Promise((resolve, reject)=>{
//         var xhr = new XMLHttpRequest();
//         xhr.open('get', url, true)
//
//         xhr.onload = function () {
//             if (this.status == 200){
//                 resolve(this.response);
//             } else {
//                 var error = new Error(this.statusText);
//                 error.code = this.status;
//                 reject(error);
//             }
//         }
//
//         xhr.onerror = function () {
//             reject(new Error('Ошибка сети'))
//         }
//
//         xhr.send();
//     });
// }
//
// httpGet('/article/promise/user.json').then(
//     response => alert('Успешно: ' + response),
//     error => alert('Неуспешно: ' + error)
// );
