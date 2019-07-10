function http_build_query(jsonObj) {
    const keys = Object.keys(jsonObj);
    const values = keys.map(key => jsonObj[key]);

    return keys
        .map((key, index) => {
            return `${key}=${values[index]}`;
        })
        .join("&");
}

async function sendRequest(url, data = {}, method = "GET") {
    var requestFields = {
        method: method,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    switch (method) {
        case "GET":
            url += '?'+ http_build_query(data);
            break;
        case "POST":
            requestFields['body'] = JSON.stringify(data)
    }
    await fetch(baseUri+url, requestFields)
        .then((response) => {
            if (response.status >= 200 && response.status < 300) {
                return response
            } else {
                var error = new Error(response.statusText);
                error.response = response;
                throw error
            }
        })
        .then((response) => response.json())
        .then((data) => {
            result = data;
            console.log(data);
        }).catch((error) => console.log(error));

    return result;
}