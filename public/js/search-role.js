let input = '<input type="text" name="" id="kw-role" class="form-control" autofocus="autofocus" placeholder="cari..">';
let ID = 'roles';
let role = {}
let roles = []
let rolesName = []
let rolesInHTML = "";

$(document).ready(function () {
    initRole()
})

function initRole() {
    // $('#' + ID).html(input);

    $.each(document.getElementById(ID).children, function (i, v) {
        role = {}
        rolesName.push(v.textContent.toLowerCase())
        role.name = v.textContent.toLowerCase()
        role.href = v.firstChild.href
        role.el = v.outerHTML
        roles.push(role)
        rolesInHTML += role.el
    })
    $('#' + ID).html(rolesInHTML);

    // .firstChild.href get href
    // textContent get element text

}

$(document).on('keyup', '#kw-role', function () {
    let result = "";
    let kw = $(this).val();
    console.log(kw)
    $.each(roles, function (i, v) {
        if (v.name.includes(kw)) {
            result += v.el;
        } else if (kw == "") {
            result += v.el;
        }
    })

    $('#' + ID).html(result);
    // let result = search("akun")
    // console.log(result)
})