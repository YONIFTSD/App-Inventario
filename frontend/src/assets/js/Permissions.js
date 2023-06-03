const je = require("json-encrypt");
var Permission = (function() {
    return function Permission(module_permission) {
        let user_permissions = window.localStorage.getItem("user_permissions");
        user_permissions = JSON.parse(JSON.parse(je.decrypt(user_permissions)));
        if (user_permissions.indexOf(module_permission) > -1) {
          return true;
        } else {
          return false;
        }
    };
})();



export default {Permission}