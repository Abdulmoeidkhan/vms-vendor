// Profile update function

let profileUpdateForm = document.getElementById("userBasicInfo");
profileUpdateForm.addEventListener("submit", getValues);

function getValues(event) {
    event.preventDefault();
    let reqObj;
    for (val of event.target) {
        reqObj = {
            ...reqObj,
            [val["name"]]: val["value"],
        };
    }
    axios
        .post("/updateProfile", reqObj)
        .then(function (response) {
            appendAlert(response.data, "success");
            // console.log(response)
        })
        .catch(function (error) {
            console.log(error);
        });
}

// Password change functionality

let passwordUpdateForm = document.getElementById("userPasswordInfo");
passwordUpdateForm.addEventListener("submit", getPasswords);

function getPasswords(event) {
    event.preventDefault();
    let reqObj;
    for (val of event.target) {
        reqObj = {
            ...reqObj,
            [val["name"]]: val["value"],
        };
    }
    if (reqObj.userInputPassword === reqObj.userInputPasswordConfirm) {
        axios
            .post("/updateProfilePassowrd", reqObj)
            .then(function (response) {
                appendAlert(response.data, "success");
                location.href = "/logout";
                location.reload();
            })
            .catch(function (error) {
                console.log(error);
            });
    } else {
        alert("Password Does not match");
    }
}

function checkPasswordStrength(password) {
    password.reportValidity();
}

// Team and role update functionality

let authorityUpdateForm = document.getElementById("userPermissionAndRolesInfo");
authorityUpdateForm.addEventListener("submit", getAuthority);

function getAuthority(event) {
    event.preventDefault();
    // let reqObj = {'rolesAndPermissionRequest':true};
    // for (val of event.target) {
    //     // console.log(val['checked'])
    //     reqObj = {
    //         ...reqObj,
    //         [val["name"]]: val["value"] == "on" ? val["checked"] : val["value"],
    //     };
    // }
    let permissionsArray = (elementsRecieved) => {
        let permissionArray = []
        for (valuesRecieved in elementsRecieved) {
            let el = elementsRecieved[valuesRecieved];
            el.type === 'checkbox' && el.checked && !permissionArray.includes(el.name) && permissionArray.push(el.name);
        }
        return permissionArray;
    }
    let reqObj = {
        role: authorityUpdateForm.elements["roles"].value,
        uid: authorityUpdateForm.elements["uid"].value,
        permissions: permissionsArray(authorityUpdateForm.elements)
    };
    // console.log(authorityUpdateForm.elements["uid"]);
    // console.log(authorityUpdateForm.elements['create'].name,authorityUpdateForm.elements['create'].checked);
    // console.log(reqObj);
    axios
        .post("/updateAuthority", reqObj)
        .then(function (response) {
            // console.log(response)
            appendAlert(response.data, "success");
        })
        .catch(function (error) {
            console.log(error);
        });
}

// Alert Trigger functionality

const alertPlaceholder = document.getElementById("liveAlertPlaceholder");
const appendAlert = (message, type) => {
    const wrapper = document.createElement("div");
    console.log(message)
    wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible fade show" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        "</div>",
    ].join("");

    alertPlaceholder.append(wrapper);
};
