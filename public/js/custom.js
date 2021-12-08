async function postData(url = '', data = {}) {
    const response = await fetch(url, {
        headers: {
            'Content-Type': 'application/json'
        },
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(data)
    });
    return response.json();
}

const uploadForm = document.querySelector('#uploadForm');
const base_path = document.getElementById("base_url").value;

uploadForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const agent_id = uploadForm.elements['agent'].value
    const role= uploadForm.elements['role'].value
    const property_id = Array.from(document.querySelectorAll("input[type=checkbox][name=properties]:checked"), e => e.value);

    const form = {
        agent_id: agent_id,
        role: role,
        property_id: property_id
     }

    postData(base_path + '/api/agents/link-properties', form)
        .then(async response => {
            console.log(response); // JSON data parsed by `data.json()` call

            if (!response.success) {
                const err = response.errors
                console.log(err);
                if (err.agent_id) {
                    document.getElementById("agentIdError").innerHTML = err.file1[0];
                }
                if (err.role) {
                    document.getElementById("roleError").innerHTML = err.file2[0];
                }

                if (err.property_id) {
                    document.getElementById("propertyIdError").innerHTML = err.file2[0];
                }

                return;
            }

            clearCheckBox();

            document.getElementById("agentIdError").innerHTML = '';
            document.getElementById("roleError").innerHTML = '';
            document.getElementById("propertyIdError").innerHTML = '';
        });
});

async function getProperties() {
    async function getData(url = '') {
        const response = await fetch(url, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
        });
        return await response.json();
    }

    const properties = await getData(base_path + '/api/properties')
    const agents = await getData(base_path + '/api/agents')

    const propertiesOuterDiv = document.querySelector('#properties')
    const agentSelectParent = document.querySelector('#agent')

    let propertiesHTML = ''
    properties.data.forEach(element => {
        propertiesHTML +=  `<div class="form-group">
            <input class="form-check-input" type="checkbox" name="properties" value="${element.id}" id="${element.id}">
            <label class="form-check-label" for="${element.id}">
                <h4> Name - ${element.name} </h4>
                <h5> Price - ${element.price} </h5>
                <h5> Type - ${element.type} </h5>
            </label>
        </div>`
    });
    propertiesOuterDiv.innerHTML = propertiesHTML

    let agentHTML = ''
    agents.data.forEach(element => {
        agentHTML +=  `<option value="${element.id}">${element.full_name}</option>`
    });
    agentSelectParent.innerHTML = agentHTML
}

function clearCheckBox() {
    var inputs = document.querySelectorAll('input[type=checkbox][name=properties]:checked');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].checked = false;
    }
}

window.onload = function() {
    getProperties();
};