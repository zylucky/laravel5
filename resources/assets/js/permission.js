import { getPermissionList } from './api/api.js';

let para = {};
getPermissionList(para).then(function(res){
    sessionStorage.removeItem('permission');
    sessionStorage.setItem('permission', JSON.stringify(res.data));
});
Vue.prototype.fun = function (funKey){
    let res = JSON.parse(sessionStorage.getItem('permission'));
    //获取权限列表
    var i = res.length;
    while (i--) {
        if (res[i] === funKey) {
            return true;
        }
    }
}